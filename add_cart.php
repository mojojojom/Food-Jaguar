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

        // CHECKOUT ORDER
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
            if(!empty($_SESSION['check_cart_item'])) {
                // INCLUDE CONNECTION
                include('connection/connect.php');
                
                $current_date = date("Y-m-d H:i:s");

                // generate a new order number for each iteration
                $query = mysqli_query($db, "SELECT MAX(order_number) as max_order_number, MAX(date) as max_date FROM user_orders");
                $row = mysqli_fetch_assoc($query);
                if($row['max_date'] != $current_date) {
                    $order_number = 1;
                }
                else {
                    $order_number = $row['max_order_number'] + 1;
                }

                foreach($_SESSION['check_cart_item'] as $item) {

                    $get_dish = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='".$item['id']."'");

                    if(mysqli_num_rows($get_dish) > 0) {

                        while($dish = mysqli_fetch_array($get_dish)) {
                            $mop = 'deliver';
                            $query = mysqli_query($db, "INSERT INTO user_orders (u_id, title, quantity, price, mop, status, order_number, date) VALUES ('".$_SESSION["user_id"]."', '".$dish['title']."', '".$item['quantity']."', '".$dish['price']."', '$mop', '', '$order_number', '$current_date')");
        
                            // Check if the insertion was successful
                            if($query) {
                                echo 'success';
                                unset($_SESSION["check_cart_item"]);

                            } else {
                                echo 'error' . mysqli_error($db);
                            }
                        }
                    }
                }
            }
            else {
                echo 'error' . mysqli_error($db);
            }
        }

        // ORDERS
        if($_POST['action'] == 'cancel_order') {
            $id = $_POST['id'];
            // CONNECTION
            include('connection/connect.php');
            $check_order = mysqli_query($db, "SELECT * FROM user_orders WHERE o_id='$id'");
            if(mysqli_num_rows($check_order) > 0) {
                $update = mysqli_query($db, "UPDATE user_orders SET status='rejected' WHERE o_id='$id'");
                if($update) {
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


    }