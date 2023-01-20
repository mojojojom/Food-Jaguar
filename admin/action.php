<?php
if(isset($_POST['action'])) {
    if($_POST['action'] == 'admin_login')
    {
        // INCLUDE DATABASE CONNECTION
        include('../connection/connect.php');

        $username = mysqli_real_escape_string($db,$_POST['username']);
        $password = mysqli_real_escape_string($db,$_POST['password']);

        if(empty($username) && empty($password)) {
            echo 'empty_fields';
        }
        elseif(empty($username)) {
            echo 'empty_username';
        }
        elseif(empty($password)) {
            echo 'empty_password';
        }
        else {
            $checkAdmin = mysqli_query($db, "SELECT * FROM admin WHERE (BINARY username='$username' OR BINARY email='$username')") or die(mysql_error());

            if(mysqli_num_rows($checkAdmin) > 0) {
                $fetch = mysqli_fetch_assoc($checkAdmin);
                $fetch_user = $fetch['username'];
                $fetch_pass = $fetch['password'];
                $fetch_email = $fetch['email'];
                if(password_verify($password, $fetch_pass)) {
                    session_start();
                    $_SESSION["adm_id"] = $fetch['adm_id'];
                    echo 'success';
                }
                else {
                    echo 'error_pass';
                }
            }   
            else
            {
                echo 'error';
            }
        }

    }
}