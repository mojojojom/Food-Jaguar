<?php
session_start();
if(isset($_POST['action'])) {

    // ADMIN PROFILE
    if($_POST['action'] == 'admin_edit')
    {
        include('../connection/connect.php');
        $user = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $pass = mysqli_real_escape_string($db, $_POST['password']);

        if(empty($pass)) {
            $update_user_profile = mysqli_query($db, "UPDATE admin SET username='$user', email='$email' WHERE adm_id='".$_SESSION['adm_id']."'");
            if($update_user_profile) {
                echo 'success';
            } else {
                echo 'err_edit';
            }
        } else {
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            $query = mysqli_query($db, "UPDATE admin SET username='$user', email='$email', password='$hashedPass' WHERE adm_id='".$_SESSION['adm_id']."'");
    
            if($query) {
                echo 'success';
            } else {
                echo 'err_edit';
            }
        }

    }

    // LOGIN - working
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
            $checkAdmin = mysqli_query($db, "SELECT * FROM admin WHERE (BINARY username = '$username' OR BINARY email = '$username')");
            if(mysqli_num_rows($checkAdmin) > 0) {
                $fetch = mysqli_fetch_assoc($checkAdmin);
                $fetch_user = $fetch['username'];
                $fetch_pass = $fetch['password'];
                $fetch_email = $fetch['email'];
                if(password_verify($password, $fetch_pass)) {
                    $_SESSION["adm_id"] = $fetch['adm_id'];
                    echo 'success';
                } else {
                    echo 'error_pass';
                }
            } else {
                $checkCanteen = mysqli_query($db, "SELECT * FROM canteen_table WHERE (BINARY c_email = '$username' OR BINARY c_user = '$username')");
                if(mysqli_num_rows($checkCanteen) > 0) {
                    $check_verify = mysqli_query($db, "SELECT c_verify FROM canteen_table WHERE (BINARY c_email = '$username' OR BINARY c_user = '$username')");
                    $row = mysqli_fetch_array($check_verify);
                    $verify = $row['c_verify'];
                    if($verify === 'Yes') {

                        $fetch = mysqli_fetch_assoc($checkCanteen);
                        $fetch_user = $fetch['c_user'];
                        $fetch_pass = $fetch['c_pass'];
                        $fetch_email = $fetch['c_email'];
                        if(password_verify($password, $fetch_pass)) {
                            $_SESSION["canteen_id"] = $fetch['id'];
                            $update_status = mysqli_query($db, "UPDATE canteen_table SET c_status = '1' AND c_email_sent = '' WHERE id='".$fetch['id']."'");
                            if($update_status) {
                                echo 'canteen_login';
                            }
                        } else {
                            echo 'error_pass';
                        }
                    } else {
                        echo 'error_verify';
                    }

                } else {
                    echo 'error_user';
                }
            }
            
        }

    }

    // ORDERS

    // DELETE ORDER - working - ajax - FINAL
    if($_POST['action'] == 'delete_order') {
        $order = $_POST['orderId'];
        // INCLUDE DATABASE CONNECTION
        include('../connection/connect.php');
        $get_order = mysqli_query($db, "SELECT * FROM user_orders WHERE order_number='$order' AND c_id='".$_SESSION['canteen_id']."'");
        if(mysqli_num_rows($get_order) > 0) {
            // echo 'success';
            $delete_order = mysqli_query($db, "DELETE FROM user_orders WHERE order_number='$order' AND c_id='".$_SESSION['canteen_id']."'");
            if($delete_order) {
                echo 'success';
            }
            else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }

    // UPDATE ORDER STATUS - working - ajax - FINAL
    if($_POST['action'] == 'update_status') {
        // INCLUDE DATABASE CONNECTION
        include('../connection/connect.php');
        $orderId = $_POST['orderId'];
        $status = $_POST['order_status'];
        $remark = $_POST['remark'];

        $insert_order = mysqli_query($db, "INSERT INTO remark(c_id, frm_id, status, remark) VALUES('".$_SESSION['canteen_id']."','$orderId', '$status', '$remark')");
        $update_status = mysqli_query($db, "UPDATE user_orders SET status='$status' WHERE order_number='$orderId' AND c_id = '".$_SESSION['canteen_id']."'");

        if($update_status) {
            echo 'success';
        }
        else {
            echo 'error';
        }
    }


    // MENU 

    // ADD ITEM - working - not ajax - FINAL
    if($_POST['action'] == 'add_item') {
        include('../connection/connect.php');
        $d_name = mysqli_real_escape_string($db, $_POST['d_name']);
        $d_price = mysqli_real_escape_string($db, $_POST['d_price']);
        $d_desc = mysqli_real_escape_string($db, $_POST['d_desc']);
        $d_cat = mysqli_real_escape_string($db, $_POST['d_cat']);
        $d_stock = mysqli_real_escape_string($db, $_POST['d_stock']);
        $d_stat = mysqli_real_escape_string($db, $_POST['d_stat']);

        $img_name = $_FILES['d_img']['name'];
        $img_temp = $_FILES['d_img']['tmp_name'];
        $img_size = $_FILES['d_img']['size'];
        $extension = explode('.',$img_name);
        $extension = strtolower(end($extension));
        $new_img = uniqid().'.'.$extension;

        $store = "Res_img/dishes/".basename($new_img);

        $check_item = mysqli_query($db, "SELECT * FROM dishes WHERE title='$d_name' AND c_id = '".$_SESSION['canteen_id']."'");
        if(mysqli_num_rows($check_item) > 0) {
            $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                ITEM ALREADY EXISTS!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        } else {
            if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') 
            {
                if($img_size>=1000000) 
                {
                    $_SESSION['message'] = '
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        INVALID IMAGE SIZE!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                    header('Location: ../canteen/all_menu');
                    exit();
                }
                else 
                {
                    $insert_item = mysqli_query($db, "INSERT INTO dishes (c_id, rs_id, title, slogan, price, img, d_stock, d_status) VALUES ('".$_SESSION['canteen_id']."','$d_cat', '$d_name', '$d_desc', '$d_price', '$new_img', '$d_stock', '$d_stat')");
                    if($insert_item) {
                        move_uploaded_file($img_temp, $store);
                        $_SESSION['message'] = '
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            ITEM HAS BEEN ADDED.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                        header('Location: ../canteen/all_menu');
                        exit();
                    } else {
                        $_SESSION['message'] = '
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            UNABLE TO ADD ITEM!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                        header('Location: ../canteen/all_menu');
                        exit();
                    }
                }
            } 
            else 
            {
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    INVALID IMAGE TYPE
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
                header('Location: ../canteen/all_menu');
                exit();
            }
        }
        
    }

    // EDIT ITEM - working - not ajax - FINAL
    if($_POST['action'] == 'edit_dish') {
        // INCLUDE DATABASE CONNECTION
        include('../connection/connect.php');

        $dish_name = mysqli_real_escape_string($db, $_POST['dish_name']);
        $dish_price = mysqli_real_escape_string($db, $_POST['dish_price']);
        $dish_desc = mysqli_real_escape_string($db, $_POST['dish_desc']);
        $dish_cat = mysqli_real_escape_string($db, $_POST['dish_cat']);
        $dish_id = mysqli_real_escape_string($db, $_POST['dish_id']);
        $dish_stock = mysqli_real_escape_string($db, $_POST['dish_stock']);
        $dish_status = mysqli_real_escape_string($db, $_POST['d_status']);

        $img_name = $_FILES['dish_img']['name'];
        $img_temp = $_FILES['dish_img']['tmp_name'];
        $img_size = $_FILES['dish_img']['size'];
        $extension = explode('.',$img_name);
        $extension = strtolower(end($extension));
        $new_img = uniqid().'.'.$extension;

        $store = "Res_img/dishes/".basename($new_img);

        if($_FILES['dish_img']['error'] === 4) 
        {
            $update_dish = mysqli_query($db, "UPDATE dishes SET rs_id='$dish_cat', title='$dish_name', slogan='$dish_desc', price='$dish_price', d_stock='$dish_stock', d_status='$dish_status' WHERE d_id='$dish_id' AND c_id = '".$_SESSION['canteen_id']."'");
            if($update_dish) 
            {
                header('Location: ../canteen/all_menu');
                $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    ITEM HAS BEEN EDITED!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            } 
            else 
            {
                header('Location: ../canteen/all_menu');
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    UNABLE TO EDIT ITEM!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        } 
        else 
        {
            if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') 
            {
                if($img_size>=1000000) 
                {
                    header('Location: ../canteen/all_menu');
                    $_SESSION['message'] = '
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        INVALID IMAGE SIZE!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                }
                else 
                {
                    $update_dish = mysqli_query($db, "UPDATE dishes SET rs_id='$dish_cat',title='$dish_name',slogan='$dish_desc',price='$dish_price', img='$new_img', d_stock='$dish_stock', d_status='$dish_status' WHERE d_id='$dish_id' AND c_id = '".$_SESSION['canteen_id']."'");
                    move_uploaded_file($img_temp, $store);
                    if($update_dish) {
                        header('Location: ../canteen/all_menu');
                        $_SESSION['message'] = '
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            ITEM HAS BEEN EDITED.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                    } else {
                        header('Location: ../canteen/all_menu');
                        $_SESSION['message'] = '
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            UNABLE TO EDIT ITEM!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                    }
                }
            } 
            else 
            {
                header('Location: ../canteen/all_menu');
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    INVALID IMAGE TYPE!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }

    }

    // DELETE ITEM - working - not ajax - FINAL
    if($_POST['action'] == 'delete_item') {
        // echo 'success';
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);

        $image = mysqli_query($db, "SELECT img FROM dishes WHERE d_id='$id' AND c_id = '".$_SESSION['canteen_id']."'");
        $row = mysqli_fetch_assoc($image);

        $delete_item = mysqli_query($db, "DELETE FROM dishes WHERE d_id='$id' AND c_id = '".$_SESSION['canteen_id']."'");

        if(isset($id)) {
            if($delete_item) {
                $image = $row['img'];
                unlink("../admin/Res_img/dishes/$image");
                mysqli_query($db, "COMMIT");
                header('Location: ../canteen/all_menu');
                $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    ITEM HAS BEEN DELETED.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
            else {
                mysqli_query($db, "ROLLBACK");
                header('Location: ../canteen/all_menu');
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    UNABLE TO DELETE ITEM!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        } else {
            header('Location: ../canteen/all_menu');
            $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                UNABLE TO DELETE ITEM!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }

    }


    // CATEGORY

    // EDIT CATEGORY - working - ajax
    if($_POST['action'] == 'edit_category') {
        // CONNECTION
        include('../connection/connect.php');
        $id = $_POST['id'];
        $newCat = $_POST['cat'];

        $check_cat = mysqli_query($db, "SELECT * FROM food_category WHERE f_catid = '$id'");
        if(mysqli_num_rows($check_cat) > 0) {
            $update_cat = mysqli_query($db, "UPDATE food_category SET f_catname='".$newCat."' WHERE f_catid='".$id."'");
            if($update_cat) {
                echo 'success';
            }
        } else {
            echo 'error';
        }

    }

    // ADD CATEGORY - working - ajax - has minor issues
    if($_POST['action'] == 'add_category') {
        // CONNECTION
        include('../connection/connect.php');
        $newCat = $_POST['cat'];

        $check_cat = mysqli_query($db, "SELECT f_catname FROM food_category WHERE f_catname = '$newCat'");
        if(mysqli_num_rows($check_cat) > 0) {
            echo 'error_exists';
        } else {
            $add_cat = mysqli_query($db, "INSERT INTO food_category(f_catname) VALUES('".$newCat."')");
            if($add_cat) {
                echo 'success';
            }
        }

    }

    // DELETE CATEGORY - working - ajax
    if($_POST['action'] == 'delete_category') {
        // CONNECTION
        include('../connection/connect.php');
        $id = $_POST['id'];

        $delete_cat = mysqli_query($db, "DELETE FROM food_category WHERE f_catid='$id'");
        if($delete_cat) {
            echo 'success';
        } else {
            echo 'error';
        }

    }


    // ADMIN ONLY

    // USERS

    // EDIT USER - working - not ajax
    if($_POST['action'] == 'edit_user') {
        // INCLUDE DATABASE
        include('../connection/connect.php');
        $fname = $_POST['f_name'];
        $lname = $_POST['l_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $id = $_POST['u_id'];

        $update_user = mysqli_query($db, "UPDATE users SET f_name = '$fname', l_name = '$lname', email = '$email', phone = '$phone', address = '$address' WHERE u_id = '$id'");
        if($update_user) {
            header('Location: dashboard');
            $_SESSION['message'] = '
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                USER HAS BEEN EDITED.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        } else {
            // echo 'error';
            header('Location: dashboard');
            $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                UNABLE OT EDIT USER!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }

    }

    // DELETE USER - working - not ajax
    if($_POST['action'] == 'delete_user') {
        // CONNECTION
        include('../connection/connect.php');

        $id = $_POST['id'];
        if(empty($id)) {
            echo 'error';
        } else {
            $delete_user = mysqli_query($db, "DELETE FROM users WHERE u_id='".$id."'");
            if($delete_user) {
                header('Location: dashboard');
                $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    USER HAS BEEN DELETED!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            } else {
                header('Location: dashboard');
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    UNABLE TO DELETE USER!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
    }


    // SITE

    // SITE SETTINGS - working - not ajax
    if($_POST['action'] == 'save_setting') {
        // connection
        include('../connection/connect.php');
        $site_name = mysqli_real_escape_string($db, $_POST['site_name']);
        $site_tag = mysqli_real_escape_string($db, $_POST['site_tag']);
        $site_desc = mysqli_real_escape_string($db, $_POST['site_desc']);
        $site_email = mysqli_real_escape_string($db, $_POST['site_email']);
        $site_phone = mysqli_real_escape_string($db, $_POST['site_phone']);
        $site_best = mysqli_real_escape_string($db, $_POST['site_best']);

        $img_name = $_FILES['site_logo']['name'];
        $img_temp = $_FILES['site_logo']['tmp_name'];
        $img_size = $_FILES['site_logo']['size'];
        $extension = explode('.',$img_name);
        $extension = strtolower(end($extension));
        $site_logo = uniqid().'.'.$extension;

        $store = "images/".basename($site_logo);
        
        if($_FILES['site_logo']['error'] === 4) 
        {
            $update_site = mysqli_query($db, "UPDATE site_settings SET site_name ='$site_name', site_tag = '$site_tag', site_about = '$site_desc', site_email = '$site_email', site_phone = '$site_phone', site_best = '$site_best'");
            if($update_site) {
                $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    SITE SETTINGS HAS BEEN EDITED.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
                header('Location: site_settings');
                exit();
            } else {
                header('Location: site_settings');
                exit();
            }
        } 
        else 
        {
            if($extension == 'jpg' || $extension == 'png' || $extension == 'gif') 
            {
                if($img_size>=1000000) 
                {
                    $_SESSION['message'] = '
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        INVALID IMAGE SIZE!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                    header('Location: site_settings');
                    exit();
                }
                else 
                {
                    $get_old_logo = mysqli_query($db, "SELECT site_logo FROM site_settings");
                    $old_logo = mysqli_fetch_assoc($get_old_logo)['site_logo'];
                    $update_site = mysqli_query($db, "UPDATE site_settings SET site_name = '$site_name', site_tag = '$site_tag', site_about = '$site_desc', site_email = '$site_email', site_phone = '$site_phone', site_best = '$site_best', site_logo = '$site_logo'");
                    if($update_site) {
                        if(file_exists("images/".$old_logo)) {
                            unlink("images/".$old_logo);
                            move_uploaded_file($img_temp, $store);
                            $_SESSION['message'] = '
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                                SITE SETTINGS HAS BEEN EDITED.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            ';
                            header('Location: site_settings');
                            exit();
                        }
                    } else {
                        $_SESSION['message'] = '
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            SITE SETTINGS CANNOT BE EDITED.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                        header('Location: site_settings');
                        exit();
                    }
                }
            } 
            else 
            {
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    INVALID IMAGE TYPE!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
                header('Location: site_settings');
                exit();
            }
        }


    }

    // ADD SETTING IF THERE IS NO SETTINGS - working - not ajax
    if($_POST['action'] == 'add_setting') {
        // connection
        include('../connection/connect.php');
        $site_name = mysqli_real_escape_string($db, $_POST['site_name']);
        $site_tag = mysqli_real_escape_string($db, $_POST['site_tag']);
        $site_desc = mysqli_real_escape_string($db, $_POST['site_desc']);
        $site_email = mysqli_real_escape_string($db, $_POST['site_email']);
        $site_phone = mysqli_real_escape_string($db, $_POST['site_phone']);

        $img_name = $_FILES['site_logo']['name'];
        $img_temp = $_FILES['site_logo']['tmp_name'];
        $img_size = $_FILES['site_logo']['size'];
        $extension = explode('.',$img_name);
        $extension = strtolower(end($extension));
        $site_logo = uniqid().'.'.$extension;

        $store = "images/".basename($site_logo);
        
        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif') 
        {
            if($img_size>=1000000) 
            {
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    INVALID IMAGE SIZE!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
                header('Location: site_settings');
                exit();
            }
            else 
            {
                $add = mysqli_query($db, "INSERT INTO site_settings(site_name, site_tag, site_about, site_email, site_phone, site_best, site_logo) VALUES('$site_name','$site_tag', '$site_desc', '$site_email', '$site_phone', '$site_best', '$site_logo')");
                if($add) {
                    move_uploaded_file($img_temp, $store);
                    $_SESSION['message'] = '
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        SITE SETTINGS HAS BEEN EDITED.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                    header('Location: site_settings');
                    exit();
                } else {
                    $_SESSION['message'] = '
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        SITE SETTINGS CANNOT BE EDITED!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    ';
                    header('Location: site_settings');
                    exit();
                }
            }
        } 
        else 
        {
            $_SESSION['message'] = '
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                INVALID IMAGE TYPE!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
            header('Location: site_settings');
            exit();
        }

    }


    // CANTEEN
    if($_POST['action'] == 'edit_canteen') {
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);
        $canteen_name = mysqli_real_escape_string($db, $_POST['c_name']);
        $c_oname = mysqli_real_escape_string($db, $_POST['c_oname']);
        $c_phone = mysqli_real_escape_string($db, $_POST['c_phone']);
        $c_email = mysqli_real_escape_string($db, $_POST['c_email']);
        $c_verify = mysqli_real_escape_string($db, $_POST['c_verify']);
        $c_address = mysqli_real_escape_string($db, $_POST['address']);

        $get_canteen = mysqli_query($db, "SELECT * FROM canteen_table WHERE id = '$id'");
        if(mysqli_num_rows($get_canteen) > 0) {
            
            $check_if_verify = mysqli_query($db, "SELECT c_verify FROM canteen_table WHERE id = '$id'");
            $is_verify = mysqli_fetch_array($check_if_verify);
            if($is_verify['c_verify'] === 'Yes') 
            {
                $update_details = mysqli_query($db, "UPDATE canteen_table SET canteen_name = '$canteen_name', c_oname = '$c_oname', c_phone='$c_phone', c_email='$c_email', c_address = '$c_address', c_verify = '$c_verify' WHERE id='$id'");
                if($update_details) {
                    $_SESSION['message'] ='
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            CANTEEN HAS BEEN EDITED.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                    header('Location: canteen');
                    exit();
                } else {
                    $_SESSION['message'] ='
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            UNABLE TO EDIT CANTEEN.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                    header('Location: canteen');
                    exit();
                }
            }
            else
            {
                $update_verify = mysqli_query($db, "UPDATE canteen_table SET c_verify='$c_verify' WHERE id='$id'");
                if($update_verify) {
                    function generatePassword($length = 8) {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < $length; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                        return $randomString;
                    }
                    $password = generatePassword();
                    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    
                    $update_details = mysqli_query($db, "UPDATE canteen_table SET canteen_name = '$canteen_name', c_oname = '$c_oname', c_phone='$c_phone', c_email='$c_email', c_pass = '$hashedPass', c_address = '$c_address' WHERE id='$id'");
                    if($update_details) {
    
                        $to = $c_email;
                        $subject = 'Canteen Verified!';
                        $message = '<h3>WELCOME TO FOOD JAGUAR!</h3><br><p>Your Password is: "'.$password.'"</p><br><p>You can change your password once you logged in.</p>';
                        $headers = 'From: Food Jaguar' . "\r\n" .
                                'Reply-To: foodjaguar@gmail.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();

                        mail($to, $subject, $message, $headers);
    
                        if(!mail($to, $subject, $message, $headers)) {
                            $_SESSION['message'] ='
                                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                                    UNABLE TO VERIFY CANTEEN.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            ';
                            header('Location: canteen');
                            exit();
                        } else {
                            $_SESSION['message'] ='
                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                                    CANTEEN HAS BEEN VERIFIED.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            ';
                            header('Location: canteen');
                            exit();
                        }
                        
                    } else {
                        $_SESSION['message'] ='
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                                UNABLE TO VERIFY CANTEEN.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        ';
                        header('Location: canteen');
                        exit();
                    }
                } else {
                    $_SESSION['message'] ='
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            UNABLE TO VERIFY CANTEEN.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                    header('Location: canteen');
                    exit();
                }
            }

        } else {
            $_SESSION['message'] ='
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    UNABLE TO EDIT CANTEEN.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
            header('Location: canteen');
            exit();
        }

    }

    if($_POST['action'] == 'delete_canteen') {
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);
        
        $delete_canteen = mysqli_query($db, "DELETE FROM canteen_table WHERE id='$id'");
        if($delete_canteen) {
            $_SESSION['message'] ='
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    CANTEEN HAS BEEN DELETED.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
            header('Location: canteen');
            exit();
        } else {
            $_SESSION['message'] ='
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    UNABLE TO DELETE THIS CANTEEN.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
            header('Location: canteen');
            exit();
        }

    }

    // RESEND EMAIL - CANTEEN
    if($_POST['action'] == 'resend_email') {
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);

        $get_canteen = mysqli_query($db, "SELECT * FROM canteen_table WHERE id='$id'");
        $get = mysqli_fetch_assoc($get_canteen);
        $c_email = $get['c_email'];
        $email_sent = $get['c_email_sent'];

        // CHECK IF ID IS EMPTY
        if(!empty($id)) {

            // PASSWORD GENERATOR
            function generatePassword($length = 8) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
            $password = generatePassword();
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);

            $change_pass = mysqli_query($db, "UPDATE canteen_table SET c_pass = '$hashedPass', c_email_sent = '', c_verify = 'Yes' WHERE id='$id'");
            if($change_pass) {
                $to = $c_email;
                $subject = 'Canteen Verified!';
                $message = '<h3>WELCOME TO FOOD JAGUAR!</h3><br><p>Your Password is: "'.$password.'"</p><br><p>You can change your password once you logged in.</p>';
                $headers = 'From: Food Jaguar' . "\r\n" .
                        'Reply-To: foodjaguar.prmsu@gmail.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
    
                mail($to, $subject, $message, $headers);
    
                if(!mail($to, $subject, $message, $headers)) {
                    $_SESSION['message'] ='
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            UNABLE TO RESEND VERIFICATION EMAIL.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                    header('Location: canteen');
                    exit();
                } else {
                    $_SESSION['message'] ='
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                            VERIFICATION EMAIL HAS BEEN SENT.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    ';
                    header('Location: canteen');
                    exit();
                }
            } else {
                $_SESSION['message'] ='
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        UNABLE TO RESEND VERIFICATION EMAIL.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
                header('Location: canteen');
                exit();
            }

        } else {
            $_SESSION['message'] ='
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    UNABLE TO RESEND VERIFICATION EMAIL.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
            header('Location: canteen');
            exit();
        }

    }


    // EDIT CANTEEN PROFILE
    if($_POST['action'] == 'edit_canteen_profile') {
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $owner = mysqli_real_escape_string($db, $_POST['owner']);
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $phone = mysqli_real_escape_string($db, $_POST['phone']);
        $address = mysqli_real_escape_string($db, $_POST['address']);

        if(!isset($id)) 
        {
            echo 'error';
        } 
        else 
        {
            
            $get_canteen = mysqli_query($db, "SELECT * FROM canteen_table WHERE id='$id'");
            if(mysqli_num_rows($get_canteen) > 0) {
                $profile = mysqli_fetch_assoc($get_canteen);
                
                if(empty($password)) {

                    $update_profile = mysqli_query($db, "UPDATE canteen_table SET canteen_name = '$name', c_oname='$owner', c_phone = '$phone', c_email = '$email', c_user='$username', c_address = '$address' WHERE id='$id'");
                    if($update_profile) {
                        echo 'success';
                    } else {
                        echo 'err_update'.mysqli_error($db);
                    }

                } else {
                    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                    $update_profile = mysqli_query($db, "UPDATE canteen_table SET canteen_name = '$name', c_oname='$owner', c_phone = '$phone', c_email = '$email', c_user='$username', c_pass = '$hashedPass', c_address = '$address' WHERE id='$id'");
                
                    if($update_profile) {
                        echo 'success';
                    } else {
                        echo 'err_update'.mysqli_error($db);
                    }
                }

            } else {
                echo 'error'.mysqli_error($db);
            }

        }

    }


    // APPROVE USER REVIEW
    if($_POST['action'] == 'approve_testi') {
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);
        if(isset($id)) {

            $approve = mysqli_query($db, "UPDATE user_testimonials SET testi_approval = 'Yes' WHERE u_id = '$id'");
            if($approve) {
                echo 'success';
            } else {
                echo 'error';
            }

        } else {
            echo 'error';
        }
    }

    // RESET USER REVIEW APPROVAL
    if($_POST['action'] == 'testi_reset') {
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);
        if(isset($id)) {

            $reset = mysqli_query($db, "UPDATE user_testimonials SET testi_approval = 'No' WHERE u_id = '$id'");
            if($reset) {
                echo 'success';
            } else {
                echo 'error';
            }

        } else {
            echo 'error';
        }
    }

    // DELETE USER REVIEW
    if($_POST['action'] == 'delete_testi') {
        include('../connection/connect.php');
        $id = mysqli_real_escape_string($db, $_POST['id']);
        if(isset($id)) {

            $delete = mysqli_query($db, "DELETE FROM user_testimonials WHERE u_id = '$id'");
            if($delete) {
                echo 'success';
            } else {
                echo 'error';
            }

        } else {
            echo 'error';
        }
    }

    // ADD CANTEEN
    if($_POST['action'] == 'add_canteen') {
        include('../connection/connect.php');
        $c_name = mysqli_real_escape_string($db, $_POST['c_name']);
        $c_owner = mysqli_real_escape_string($db, $_POST['c_owner_name']);
        $c_contact = mysqli_real_escape_string($db, $_POST['c_contact']);
        $c_email = mysqli_real_escape_string($db, $_POST['c_email']);
        $c_address = mysqli_real_escape_string($db, $_POST['c_address']);
        $c_type = "canteen";
        $c_status = 0;
        $set_pass = $c_owner;
        $c_pass = password_hash($set_pass, PASSWORD_DEFAULT);
        $new_cname = strtolower($c_name);
        $c_user = preg_replace('/\s+/', '_', $new_cname);
        $c_verify = "Yes";

        $check_canteen = mysqli_query($db, "SELECT * FROM canteen_table WHERE canteen_name = '$c_name' OR c_oname = '$c_owner'");
        if(mysqli_num_rows($check_canteen) > 0) {
            $_SESSION['message'] ='
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                    CANTEEN ALREADY EXISTS.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
            header('Location: canteen');
            exit();
        } else {
            $insert_canteen = mysqli_query($db, "INSERT INTO canteen_table(`canteen_name`, `c_oname`, `c_phone`, `c_email`, `c_user`, `c_pass`, `c_address`, `type`, `c_status`, `c_verify`, `c_email_sent`) VALUES ('$c_name', '$c_owner', '$c_contact', '$c_email', '$c_user','$c_pass','$c_address', '$c_type', '$c_status', '$c_verify', '')");
            if($insert_canteen) {
                $_SESSION['message'] ='
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        CANTEEN HAS BEEN ADDED
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
                header('Location: canteen');
                exit();
            } else {
                $_SESSION['message'] ='
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center fw-bold" role="alert">
                        UNABLE TO ADD CANTEEN.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
                header('Location: canteen');
                exit();
            }
        }
    }


}