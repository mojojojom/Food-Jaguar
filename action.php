<?php
    require __DIR__.'/vendor/phpmailer/phpmailer/src/Exception.php';
    require __DIR__.'/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require __DIR__.'/vendor/phpmailer/phpmailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;


if(isset($_POST['action'])) {

    // LOGIN -AJAX - FINAL
    if($_POST['action'] == 'user_login') {

        // INCLUDE DATABASE CONNECTION
        include('connection/connect.php');

        $username = mysqli_real_escape_string($db,$_POST['username']);
        $password = mysqli_real_escape_string($db,$_POST['password']);

        $checkUser = mysqli_query($db, "SELECT * FROM users WHERE (BINARY username='$username' OR BINARY email='$username')") or die(mysql_error());

        if(mysqli_num_rows($checkUser) > 0) 
        {
            $fetch = mysqli_fetch_assoc($checkUser);
            $fetch_pass = $fetch['password'];
            $fetch_email = $fetch['email'];
            
            if(password_verify($password,$fetch_pass))
            {
                $fetch_status = $fetch['u_verify'];
                if($fetch_status == "Yes")
                {
                    session_start();
                    $_SESSION['user_id'] = $fetch['u_id'];
                    echo 'success';
                }
                else
                {
                    session_start();
                    $_SESSION['email'] = $fetch_email; 
                    echo 'error_verify';
                }
            }
            else
            {
                echo 'error_xpass';
            }
        }
        else
        {
            echo 'error';
        }
    }

    // REGISTER - AJAX - FINAL
    if($_POST['action'] == 'user_register') {

        // INCLUDE DATABASE CONNECTION
        include('connection/connect.php');

        $username = mysqli_real_escape_string($db,$_POST['username']);
        $fname = mysqli_real_escape_string($db,$_POST['firstname']);
        $lname = mysqli_real_escape_string($db,$_POST['lastname']);
        $email = mysqli_real_escape_string($db,$_POST['email']);
        $phone = mysqli_real_escape_string($db,$_POST['phone']);
        $password = mysqli_real_escape_string($db,$_POST['password']);
        $cpassword = mysqli_real_escape_string($db,$_POST['cpassword']);
        $address = mysqli_real_escape_string($db,$_POST['address']);

        $checkUser = mysqli_query($db, "SELECT * FROM users WHERE username='$username'") or die(mysql_error());
        $checkEmail = mysqli_query($db, "SELECT * FROM users WHERE email='$email'") or die(mysql_error());
        $checkNum= mysqli_query($db, "SELECT * FROM users WHERE phone='$phone'") or die(mysql_error());

        if(mysqli_num_rows($checkUser) > 0) 
        {
            echo 'error_user';
        } 
        else if(mysqli_num_rows($checkEmail) > 0) 
        {
            echo 'error_email';
        }
        else if(mysqli_num_rows($checkNum) > 0) 
        {
            echo 'error_num';
        }
        else
        {
            if($password == $cpassword)
            {
                if(strlen($password) <= 7)
                {
                    echo 'error_pw_short';
                }
                else
                {
                    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

                    $u_vcode = rand(999999, 111111);
                    $u_verify = "No";
                    $query = mysqli_query($db, "INSERT INTO users(username,f_name,l_name,email,phone,password,address,u_vcode,u_verify) VALUES('$username', '$fname','$lname', '$email', '$phone', '$hashedPass', '$address', '$u_vcode','$u_verify')");
                    if($query) {

                        $to = $email;
                        $subject = 'OTP';
                        $message = '<p>Your OTP : "'.$u_vcode.'"</p>';
                        $headers = 'From: Food Jaguar' . "\r\n" .
                                'Reply-To: foodjaguar@gmail.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();
    
                        mail($to, $subject, $message, $headers);

                        session_start();
                        $_SESSION['email'] = $email;

                        echo 'success';
                    } else {
                        echo 'error';
                    }
                }
            }
            else
            {
                echo 'error_not_match';
            }
        }

    }

    // REGISTRATION VERIFICATION - AJAX - FINAL
    if($_POST['action'] == 'verify_user') {
        // INCLUDE DATABASE CONNECTION
        include('connection/connect.php');

        $otp_code = mysqli_real_escape_string($db, $_POST['v_code']);
        $check_code = mysqli_query($db, "SELECT * FROM users WHERE u_vcode = '$otp_code'");

        if(mysqli_num_rows($check_code) > 0)
        {
            $fetch_data = mysqli_fetch_assoc($check_code);
            $fetch_code = $fetch_data['u_vcode'];
            $fetch_uid = $fetch_data['u_id'];
            $email = $fetch_data['email'];

            $code = 0;
            $status = 'Yes';

            $update_code = mysqli_query($db, "UPDATE users SET u_vcode = '$code', u_verify = '$status' WHERE u_vcode = '$fetch_code' ");
            if($update_code) {
                session_start();
                $_SESSION['user_id'] = $fetch_uid;
                echo 'success';
            }
            else
            {
                echo 'error';
            }
        }
        else
        {
            echo 'error';
        }

    }

    // RESET REQUEST FUNCTION - FINAL
    if($_POST['action'] == 'reset_pass') {

        // INCLUDE DATABASE CONNECTION
        include('connection/connect.php');

        $resetEmail = mysqli_real_escape_string($db, $_POST['resetEmail']);
        $checkEmail = mysqli_query($db,"SELECT * FROM users WHERE BINARY email = '".$resetEmail."'") or die(mysql_error());

        // $row = mysqli_fetch_assoc($checkEmail);

        if(mysqli_num_rows($checkEmail) > 0)
        {
            $r_code = rand(999999, 111111);
            $insert_rcode = mysqli_query($db, "UPDATE users SET u_vcode = '$r_code' WHERE email = '$resetEmail'");

            if($insert_rcode)
            {

                // $mail = new PHPMailer(true);
                // $mail->IsSMTP();

                // // SENDINBLUE
                // $mail->SMTPAuth = true;
                // $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_SMTPS';
                // $mail->Host = "";
                // $mail->Port = 587;
                // $mail->IsHTML(true);
                // $mail->Username = "";
                // $mail->Password = "";

                // $mail->SetFrom("foodjaguar.prmsu@gmail.com");
                // $mail->Subject = "Reset Code";
                // $mail->Body = 'Your Password Reset Code : "'.$r_code.'"';
                // $mail->AddAddress($resetEmail);
            
                // if(!$mail->Send()) {
                //     echo "error_send";
                // } else {
                //     session_start();
                //     $_SESSION['email'] = $resetEmail;
                //     echo "success";
                // }

                // FOR TESTING
                $to = $resetEmail;
                $subject = 'OTP';
                $message = 'Your Password Reset Code : "'.$r_code.'"';
                $headers = 'From: Food Jaguar' . "\r\n" .
                        'Reply-To: foodjaguar@gmail.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);

                session_start();
                $_SESSION['email'] = $resetEmail;
                echo 'success';
            }
            else
            {
                echo 'error_code';
            }
        }
        else
        {
            echo 'error';
        }

        // if($row['email'] == $resetEmail) {
        //     $u_vcode = rand(999999, 111111);
        //     // $expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

        //     $insert_query = mysqli_query($db, "INSERT INTO reset_pass (v_code,v_email,v_expire) VALUES('$token', '$resetEmail','$expiry')");
        //     if($insert_query)
        //     {
        //         $reset_link = "'.$url.'password-reset.php?token='.$token.'&email='.$resetEmail.'";

        //         $to = $resetEmail;
        //         $subject = 'OTP';
        //         $message = 'To verify your account, Please click on this <a href="'.$reset_link.'"><b>LINK</b></a>';
        //         $headers = 'From: Food Jaguar' . "\r\n" .
        //                 'Reply-To: foodjaguar@gmail.com' . "\r\n" .
        //                 'X-Mailer: PHP/' . phpversion();

        //         mail($to, $subject, $message, $headers);

        //         echo 'success';
        //     } 
        //     else 
        //     {
        //         echo 'errors';
        //     }
        // } else {
        //     echo 'error';
        // }

    }

    // RESET PASSWORD CODE - AJAX - FINAL
    if($_POST['action'] == 'reset_code') {
        
        // INCLUDE DATABASE CONNECTION
        include('connection/connect.php');
        
        $r_code = mysqli_real_escape_string($db, $_POST['r_code']);
        $check_code = mysqli_query($db, "SELECT * FROM users WHERE u_vcode = '$r_code'");
        
        if(mysqli_num_rows($check_code) > 0)
        {
            $fetch = mysqli_fetch_assoc($check_code);
            $email = $fetch['email'];
            session_start();
            $_SESSION['email'];
            echo'success';
        }
        else
        {
            echo 'error';
        }
        
    }

    // RESET PASSWORD - AJAX - FINAL
    if($_POST['action'] == 'new_pass') {

        // INCLUDE DATABASE CONNECTION
        include('connection/connect.php');

        $pass = mysqli_escape_string($db, $_POST['password']);
        $r_pass = mysqli_escape_string($db, $_POST['r_password']);

        if($pass == $r_pass)
        {
            if(strlen($pass) <= 7)
            {
                echo 'error_pw_short';
            }
            else
            {
                $code = 0;
                session_start();
                $email = $_SESSION['email'];
                $new_pass = password_hash($pass, PASSWORD_DEFAULT);
                
                $update_pass = mysqli_query($db, "UPDATE users SET u_vcode='$code', password='$new_pass' WHERE email='$email'");
                if($update_pass)
                {
                    echo 'success';
                }
                else
                {
                    echo 'error_update';
                }
            }
        }
        else
        {
            echo 'error';
        }

    }

    // EDIT
    if($_POST['action'] == 'editprofile') {
        include('connection/connect.php');
        $edit = mysqli_real_escape_string($db,$_POST['user_id']);
        $u_username = mysqli_real_escape_string($db,$_POST['u_username']);
        $u_fname = mysqli_real_escape_string($db,$_POST['u_firstname']);
        $u_lname = mysqli_real_escape_string($db,$_POST['u_lastname']);
        $u_email = mysqli_real_escape_string($db,$_POST['u_email']);
        $u_phone = mysqli_real_escape_string($db,$_POST['u_phone']);
        $u_password = mysqli_real_escape_string($db,$_POST['u_password']);
        $u_address = mysqli_real_escape_string($db,$_POST['u_address']);

        if(empty($u_password)) {
            $update_user_profile = mysqli_query($db, "UPDATE users SET username='$u_username', f_name='$u_fname', l_name='$u_lname', email='$u_email', phone='$u_phone', address='$u_address' WHERE u_id='$edit'");
            if($update_user_profile) {
                header('Location: your_order');
                exit();
            } else {
                // echo mysqli_error($db);
                header('Location: your_order');
                exit();
            }
        } else {
            $hashedPass = password_hash($u_password, PASSWORD_DEFAULT);

            $query = mysqli_query($db, "UPDATE users SET username='$u_username', f_name='$u_fname', l_name='$u_lname', email='$u_email', phone='$u_phone', password='$hashedPass', address='$u_address' WHERE u_id='$edit'");
    
            if($query) {
                $message = '<div class="alert alert-success alert-dismissible text-center" role="alert">UPDATED SUCCESSFULLY!</div>';
                $_SESSION['message'] = $message;
                header('Location: your_order');
            } else {
                $message = '<div class="alert alert-danger alert-dismissible text-center" role="alert">UPDATE FAILED!</div>';
                $_SESSION['message'] = $message;
                header('Location: your_order');
            }
        }
    } 


    // SEARCH ITEM
    if($_POST['action'] == 'search_dish')
    {
        include('connection/connect.php');
        $search = mysqli_real_escape_string($db, $_POST['searchInput']);
        echo 'success';
    }

}
?>


