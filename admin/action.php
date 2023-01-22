<?php
if(isset($_POST['action'])) {
    // LOGIN
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

    // DELETE ORDER
    if($_POST['action'] == 'delete_order') {
        $order = $_POST['orderId'];
        // INCLUDE DATABASE CONNECTION
        include('../connection/connect.php');
        $get_order = mysqli_query($db, "SELECT * FROM user_orders WHERE o_id='$order'");
        if(mysqli_num_rows($get_order) > 0) {
            // echo 'success';
            $delete_order = mysqli_query($db, "DELETE FROM user_orders WHERE o_id='$order'");
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

    // UPDATE ORDER STATUS
    if($_POST['action'] == 'update_status') {
        // INCLUDE DATABASE CONNECTION
        include('../connection/connect.php');
        $orderId = $_POST['orderId'];
        $status = $_POST['order_status'];
        $remark = $_POST['remark'];

        $insert_order = mysqli_query($db, "INSERT INTO remark(frm_id, status, remark) VALUES('$orderId', '$status', '$remark')");
        $update_status = mysqli_query($db, "UPDATE user_orders SET status='$status' WHERE o_id='$orderId'");

        if($update_status) {
            echo 'success';
        }
        else {
            echo 'error'.mysqli_error();
        }
        // echo 'success';
    }

    // EDIT DISH
    if($_POST['action'] == 'edit_dish') {
        // INCLUDE DATABASE CONNECTION
        include('../connection/connect.php');

        $dish_name = mysqli_real_escape_string($db, $_POST['dish_name']);
        $dish_price = mysqli_real_escape_string($db, $_POST['dish_price']);
        $dish_desc = mysqli_real_escape_string($db, $_POST['dish_desc']);
        $dish_cat = mysqli_real_escape_string($db, $_POST['dish_cat']);
        $dish_id = mysqli_real_escape_string($db, $_POST['dish_id']);

        $img_name = $_FILES['dish_img']['name'];
        $img_temp = $_FILES['dish_img']['tmp_name'];
        $img_size = $_FILES['dish_img']['size'];
        $extension = explode('.',$img_name);
        $extension = strtolower(end($extension));
        $new_img = uniqid().'.'.$extension;

        $store = "Res_img/dishes/".basename($new_img);

        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            if($img_size>=1000000) {
                echo 'error_size'.mysqli_error();
            }
            else {
                $update_dish = mysqli_query($db, "UPDATE dishes SET rs_id='$dish_cat',title='$dish_name',slogan='$dish_desc',price='$dish_price', img='$new_img' WHERE d_id='$dish_id'");
                move_uploaded_file($img_temp, $store);
                echo 'success';
            }
        }

    }

    // ADD DISH
    // if($_POST['action'] == 'add_dish') {
    //     // CONNECTION
    //     include('../connection/connect.php');
    //     $dish_name = mysqli_real_escape_string($db,$_POST['dish_name']);
    //     $dish_price = mysqli_real_escape_string($db,$_POST['dish_price']);
    //     $dish_desc = mysqli_real_escape_string($db,$_POST['dish_desc']);
    //     $dish_cat = $_POST['dish_cat'];

    //     $image = $_FILES['dish_img']['name'];
    //     $type = $_FILES['dish_img']['type'];
    //     $temp = $_FILES['dish_img']['tmp_name'];
    //     $size = $_FILES['dish_img']['size'];

    //     $ImageExt = explode('.',$image);
    //     $AllowExt = strtolower(end($ImageExt));
    //     $Allow = array('jpg', 'jpeg', 'png', 'webp');
    //     $Target = "Res_img/dishes/".$image;



    //     $check_dish = mysqli_query($db, "SELECT * FROM dishes WHERE title='$dish_name'");

    //     if(mysqli_num_rows($check_dish)>0) {
    //         echo 'error_exists';
    //     }
    //     else {
    //         if(in_array($AllowExt, $Allow)) {
    //             if($size < 1000000) {
    //                 $query = mysqli_query($db, "INSERT INTO dishes(rs_id,title,slogan,price,img) VALUE('$dish_cat', '$dish_name','$dish_desc','$dish_price', '$image')");
    //                 if($query) {
    //                     move_uploaded_file($temp, $Target);
    //                     echo 'success';
    //                 }
    //             } else {
    //                 echo 'error_size';
    //             }
    //         } else {
    //             echo 'error_type';
    //         }
    //     }
    //     // echo 'success';
    // }

    // EDIT CATEGORY
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

    // ADD CATEGORY
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

    // DELETE CATEGORY
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

}