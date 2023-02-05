<?php
    session_start();
    if(isset($_POST['action'])) {

        // CHECK QUANTITY
        if (isset($_POST['quantity'])) {
            $quantity = htmlspecialchars($_POST['quantity']);
        } else {
            $quantity = '';
        }
        // CHECK PRODUCT ID
        if (isset($_POST['dish_id'])) {
            $productId = htmlspecialchars($_POST['dish_id']);
        } else {
            $productId = '';
        }

        /****************** FUNCTIONS ******************/
        // ADD TO CART - AJAX - FINAL
        if($_POST['action'] == 'add_cart') 
        {

            if(!empty($quantity))
            {
                // DATABASE CONNECTION
                include('connection/connect.php');
                $get_order = mysqli_query($db, "SELECT * FROM dishes WHERE d_id= '$productId'");

                $fetch = mysqli_fetch_object($get_order);
                $itemArray = array(
                                    $fetch->d_id=>array(
                                                        'title'=>$fetch->title,
                                                        'd_id'=>$fetch->d_id,
                                                        'quantity'=>$quantity,
                                                        'price'=>$fetch->price,
                                                        'img'=>$fetch->img)
                            );
                if(!empty($_SESSION['cart_item']))
                {
                    if(array_key_exists($fetch->d_id,$_SESSION['cart_item']))
                    {
                        foreach($_SESSION['cart_item'] as $key => $value)
                        {
                            if($fetch->d_id == $key)
                            {
                                if(empty($_SESSION['cart_item'][$key]['quantity']))
                                {
                                    $_SESSION['cart_item'][$key]['quantity'] = 0;
                                }
                                $_SESSION['cart_item'][$key]['quantity'] += $quantity;
                                echo 'success';
                            }
                        }
                    }
                    else
                    {
                        $_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
                        echo 'success';
                    }
                }
                else
                {
                    $_SESSION['cart_item'] = $itemArray;
                    echo 'success';
                }
            }

        }

        // REMOVE FROM CART - AJAX - FINAL
        if($_POST['action'] == 'remove')
        {
            $productId = $_POST['productId'];
            if(!empty($_SESSION['cart_item']))
            {
                unset($_SESSION['cart_item'][$productId]);
                echo 'success';
            }
            else
            {
                echo 'error_cart';
            }
        }

        // EMPTY CART - AJAX - FINAL
        if($_POST['action'] == 'empty')
        {
            if(!empty($_SESSION['cart_item']))
            {
                unset($_SESSION['cart_item']);
                echo 'success';
            }
            else
            {
                echo 'error_cart';
            }
        }

        // CHECKOUT - AJAX - WORKING
        if($_POST['action'] == 'check')
        {
            // header('Location: checkout');
            $cart_qty = htmlspecialchars($_POST['cart_qty']);
            $cart_dish_id = htmlspecialchars($_POST['cart_dish_id']);
            if(!empty($cart_qty))
            {
                // DATABASE CONNECTION
                include('connection/connect.php');
                $get_order = mysqli_query($db, "SELECT * FROM dishes WHERE d_id= '$cart_dish_id'");

                $fetch = mysqli_fetch_object($get_order);
                $orig_price = $fetch->price;
                $item_price = $orig_price*$cart_qty;
                $itemArray = array(
                                    $fetch->d_id=>array(
                                                        'title'=>$fetch->title,
                                                        'd_id'=>$fetch->d_id,
                                                        'quantity'=>$cart_qty,
                                                        'price'=>$item_price,
                                                        'img'=>$fetch->img)
                            );
                if(!empty($_SESSION['check_cart_item']))
                {
                    if(array_key_exists($fetch->d_id,$_SESSION['check_cart_item']))
                    {
                        foreach($_SESSION['check_cart_item'] as $key => $value)
                        {
                            if($fetch->d_id == $key)
                            {
                                if(empty($_SESSION['check_cart_item'][$key]['quantity']))
                                {
                                    $_SESSION['check_cart_item'][$key]['quantity'] = 0;
                                }
                                $_SESSION['check_cart_item'][$key]['quantity'] += $cart_qty;
                                echo 'success';
                            }
                        }
                    }
                    else
                    {
                        $_SESSION["check_cart_item"] = $_SESSION["check_cart_item"] + $itemArray;
                        echo 'success';
                    }
                }
                else
                {
                    $_SESSION['check_cart_item'] = $itemArray;
                    echo 'success';
                }
            }
            else
            {
                echo 'error';
            }
        }

        // CHECKOUT ORDER - AJAX - WORKING
        if($_POST['action'] == 'checkOutOrder') 
        {
            if(empty($_SESSION['user_id'])) {
                echo 'error_login';
            }
            else
            {
                $itemArray = json_decode($_POST['selectedItems'], true);
                if(!isset($_SESSION['check_cart_item']))
                {
                    $_SESSION['check_cart_item'] = array();
                }
                foreach ($itemArray as $item) {
                    array_push($_SESSION['check_cart_item'], $item);
                }
                unset($_SESSION['cart_item']['selectedItems']);
                echo 'success';
            }
        }          

        // UNSET CART SESSION
        if($_POST['action'] == 'unset') {
                unset($_SESSION['check_cart_item']);
                echo 'success';
        }

        // PLACE ORDER
        if($_POST['action'] == 'place_order') {
            $mop = $_POST['ship'];
            $last_order_number = 1;

            // CHECK SESSION
            if(!empty($_SESSION['check_cart_item'])) {
                // INCLUDE CONNECTION
                include('connection/connect.php');
                
                // DATE AND ORDER NUMBER
                $current_date = date("Y-m-d H:i:s");
                $order_number = $last_order_number;
                $last_order_number++;

                // GET THE MAX ORDER NUMBER
                $query = mysqli_query($db, "SELECT MAX(order_number) as max_order_number FROM user_orders");
                $row = mysqli_fetch_assoc($query);
                
                $last_order_number = $row['max_order_number'];
                $order_number = $last_order_number + 1;

                // GET ITEMS FROM THE SESSION
                foreach($_SESSION['check_cart_item'] as $item) {

                    // GET ITEMS FROM THE DISHES DB
                    $get_dish = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='".$item['id']."'");

                    // GET SHIPPING FEE
                    $s_fee = mysqli_query($db, "SELECT s_fee FROM shipping_settings"); 
                    $sf = mysqli_fetch_assoc($s_fee);

                    // SHIPPING FEE
                    $sfee = 0;
                    if($mop == 'deliver') {
                        $sfee = $sf['s_fee'];
                    } else {
                        $sfee = 0;
                    }

                    // ADD ADDRESS
                    if($_POST['new_address'] === "") {
                        $new_address = null;
                    } else {
                        $new_address = $_POST['new_address'];
                    }

                    // CHECK IF THE DISH EXISTS
                    if(mysqli_num_rows($get_dish) > 0) {
                        while($dish = mysqli_fetch_array($get_dish)) {
                            $total_price = $item['quantity']*$dish['price'];
                            $get_address = mysqli_query($db, "SELECT address from users WHERE u_id='".$_SESSION['user_id']."'");
                            $get = mysqli_fetch_assoc($get_address);
                            $orig_address = $get['address'];

                            $query = mysqli_query($db, "INSERT INTO user_orders (u_id, title, quantity, price, original_price, mop, s_fee, s_address, original_address, status, order_number, date) VALUES ('".$_SESSION["user_id"]."', '".$dish['title']."', '".$item['quantity']."', '".$total_price."', '".$dish['price']."', '$mop', '$sfee', '$new_address', '$orig_address', '', '$order_number', '$current_date')");
                            if($query) {
                                $update_stock = mysqli_query($db, "UPDATE dishes SET d_stock = d_stock - ".$item['quantity']." WHERE d_id='".$item['id']."'");
                                if($update_stock) {

                                    $items_cart = array_column($_SESSION['cart_item'], 'd_id');
                                    $checkout_cart = array_column($_SESSION['check_cart_item'], 'id');
                                    
                                    $common = array_intersect($items_cart, $checkout_cart);
                                    foreach($common as $id) {
                                        foreach ($_SESSION['cart_item'] as $key => $item) {
                                            if ($item['d_id'] == $id) {
                                                unset($_SESSION['cart_item'][$key]);
                                                break;
                                            }
                                        }
                                        foreach ($_SESSION['check_cart_item'] as $key => $item) {
                                            if ($item['id'] == $id) {
                                                unset($_SESSION['check_cart_item'][$key]);
                                                break;
                                            }
                                        }
                                    }
                                    echo 'success';
                                } else {
                                    // echo 'error' . mysqli_error($db);
                                    echo 'error';
                                }
                            } else {
                                echo 'error';
                            }
                        }
                    } else {
                        echo 'error';
                    }
                }
            }
            else {
                echo 'error';
            }
        }

        // CANCEL ORDER
        if($_POST['action'] == 'cancel_order') {
            $id = $_POST['id'];
            // CONNECTION
            include('connection/connect.php');
            $check_order = mysqli_query($db, "SELECT * FROM user_orders WHERE o_id='$id'");
            if(mysqli_num_rows($check_order) > 0) {
                $cancel = mysqli_query($db, "UPDATE user_orders SET status='rejected' WHERE o_id='$id'");
                if($cancel) {
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            else {
                echo 'error';
            }
        }


        // ADD TO FAVORITE
        if($_POST['action'] == 'add_to_fave') {
            include('connection/connect.php');
            $d_id = mysqli_escape_string($db, $_POST['d_id']);
            $u_id = mysqli_escape_string($db, $_POST['u_id']);

            if(isset($_SESSION['user_id'])) {
                $check_fave = mysqli_query($db, "SELECT * FROM fave_table WHERE d_id='$d_id' AND u_id='$u_id'");
                if(mysqli_num_rows($check_fave) > 0) {
                    $delete_fave = mysqli_query($db, "DELETE FROM fave_table WHERE d_id='$d_id' AND u_id='$u_id'");
                    if($delete_fave) {
                        echo 'removed';
                    } else {
                        echo 'error';
                    }
                } else {
                    $insert_fave = mysqli_query($db, "INSERT INTO fave_table (u_id, d_id) VALUES('$u_id','$d_id')");
                    if($insert_fave) {
                        echo 'success';
                    } else {
                        echo 'error';
                    }
                }
            } else {
                echo 'error_login';
            }

        }

        // REMOVE TO FAVORITE
        if($_POST['action'] == 'remove_to_fave') {
            include('connection/connect.php');
            $d_id = mysqli_escape_string($db, $_POST['d_id']);
            $remove_fave = mysqli_query($db, "DELETE FROM fave_table WHERE u_id = '".$_SESSION['user_id']."' AND d_id = '$d_id'");

            if($remove_fave) {
                echo 'success';
            }
            else {
                echo 'error'.mysqli_error($db);
            }
        }


        // ADD REVIEW
        if($_POST['action'] == 'add_testi') {
            include('connection/connect.php');
            $testi = mysqli_escape_string($db, $_POST['review']);

            if(isset($_SESSION['user_id'])) {
                $check_review = mysqli_query($db, "SELECT * FROM user_testimonials WHERE u_id = '".$_SESSION['user_id']."'");
                if(mysqli_num_rows($check_review) > 0) {
                    echo 'error_exists';
                } else {
                    $add_review = mysqli_query($db, "INSERT INTO user_testimonials(u_id, u_testi) VALUES('".$_SESSION['user_id']."', '$testi')");
                    if($add_review) {
                        echo 'success';
                    }
                    else
                    {
                        echo 'error';
                    }
                }
            } else {
                echo 'error_login';
            }

        }

    }