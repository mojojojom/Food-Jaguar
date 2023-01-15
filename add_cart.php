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



        // ADD TO CART - AJAX - FINAL
        if($_POST['action'] == 'add_cart') 
        {

            if(!empty($quantity))
            {
                // DATABASE CONNECTION
                include('connection/connect.php');
                $get_order = mysqli_query($db, "SELECT * FROM dishes WHERE d_id= '$productId'");

                $fetch = mysqli_fetch_object($get_order);
                $orig_price = $fetch->price;
                // $item_price = $orig_price*$quantity;
                $itemArray = array(
                                    $fetch->d_id=>array(
                                                        'title'=>$fetch->title,
                                                        'd_id'=>$fetch->d_id,
                                                        'quantity'=>$quantity,
                                                        // 'price'=>$item_price,
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

        // REMOVE FROM CART - AJAX - FINAL - NOT CLEARING CAR
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

        // EMPTY CART - AJAX - FINAL - NOT CLEARING CART
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

        // CHECK THE ARRAY
        // $selectedItems = $_POST['selectedItems'];
        // if(isset($selectedItems)) {
        //     if($_POST['action'] == 'checkOutOrder') {
        //         foreach($selectedItems as $dishId) {
        //             // DATABASE CONNECTION
        //             include('connection/connect.php');
        //             $idString = implode(",", $selectedItems);
        //             $checkDish = mysqli_query($db, "SELECT * FROM dishes WHERE d_id IN ('$idString')");

        //             $cartQty = htmlspecialchars($_POST['cart_qty']);

        //             $fetch = mysqli_fetch_object($checkDish);
        //             $orig_price = $fetch->price;
        //             $item_price = $orig_price*$cartQty;
        //             $itemArray = array(
        //                 $fetch->d_id=>array(
        //                     'title'=>$fetch->title,
        //                     'd_id'=>$fetch->d_id,
        //                     'quantity'=>$cartQty,
        //                     'price'=>$item_price,
        //                     'img'=>$fetch->img
        //                 )
        //             );
        //             if(!empty($_SESSION['check_cart_item']))
        //             {
        //                 if(array_key_exists($fetch->d_id,$_SESSION['check_cart_item']))
        //                 {
        //                     foreach($_SESSION['check_cart_item'] as $key => $value)
        //                     {
        //                         if($fetch->d_id == $key)
        //                         {
        //                             if(empty($_SESSION['check_cart_item'][$key]['quantity']))
        //                             {
        //                                 $_SESSION['check_cart_item'][$key]['quantity'] = 0;
        //                             }
        //                             $_SESSION['check_cart_item'][$key]['quantity'] += $cart_qty;
        //                             echo 'success';
        //                         }
        //                     }
        //                 }
        //                 else
        //                 {
        //                     $_SESSION["check_cart_item"] = $_SESSION["check_cart_item"] + $itemArray;
        //                     echo 'success';
        //                 }
        //             }
        //             else
        //             {
        //                 $_SESSION['check_cart_item'] = $itemArray;
        //                 echo 'success';
        //             }
        //         }
        //     }
        //     else {
        //         echo 'error';
        //     }
        // }
        // else {
        //     echo 'error';
        // }
        // if($_POST['action'] == 'checkOutOrder') {
        //     $selectedItems = json_decode($_POST['selectedItems'], true);
        //     $itemIds = array_column($selectedItems, 'id');
        //     $idString = implode(",", $itemIds);
        //     // foreach($selectedItems as $item) {
        //         // $dishId = $item['id'];
        //         // $quantity = $item['quantity'];

        //         // DATABASE CONNECTION
        //         include('connection/connect.php');
        //         $checkDish = mysqli_query($db, "SELECT d_id FROM dishes WHERE d_id IN ('$idString')");

        //         $validItems = [];
        //         while($row = mysqli_fetch_assoc($checkDish)) {
        //             $validItems[] = $row['d_id'];
        //         }
        //         $invalidItems = array_diff($itemIds, $validItems);

        //         if (count($invalidItems) > 0) {
        //             echo "The following items are not found in the database: " . implode(',', $invalidItems);
        //             echo 'error';
        //         } else {
        //             echo "success";
        //         }
        // }
        // else {
        //     echo 'error';
        // }

        // if($_POST['action'] == 'checkOutOrder') 
        // {
        //     $selectedItems = json_decode($_POST['selectedItems'], true);
        //     $itemIds = array_column($selectedItems, 'id');
        //     $idString = implode(",", $itemIds);
        
        //     // DATABASE CONNECTION
        //     include('connection/connect.php');
        //     $checkDish = mysqli_query($db, "SELECT d_id, title, price, img FROM dishes WHERE d_id IN ('$idString')");

        //     $fetch = mysqli_fetch_object($checkDish);
        //     $quantity = $selectedItems[array_search($dishId, array_column($selectedItems, 'id'))]['quantity'];
        //     $orig_price = $fetch->price;
        //     $item_price = $orig_price*$quantity;
        //     $itemArray = array(
        //                         $fetch->d_id=>array(
        //                                             'title'=>$fetch->title,
        //                                             'd_id'=>$fetch->d_id,
        //                                             'quantity'=>$quantity,
        //                                             'price'=>$item_price,
        //                                             'img'=>$fetch->img)
        //                 );
        //     if(!empty($_SESSION['check_cart_item']))
        //     {
        //         // if(array_key_exists($fetch->d_id,$_SESSION['check_cart_item']))
        //         // {
        //         //     foreach($_SESSION['check_cart_item'] as $key => $value)
        //         //     {
        //         //         if($fetch->d_id == $key)
        //         //         {
        //         //             if(empty($_SESSION['check_cart_item'][$key]['quantity']))
        //         //             {
        //         //                 $_SESSION['check_cart_item'][$key]['quantity'] = 0;
        //         //             }
        //         //             $_SESSION['check_cart_item'][$key]['quantity'] += $quantity;
        //         //             echo 'success';
        //         //         }
        //         //     }
        //         // }
        //         // else
        //         // {
        //         //     $_SESSION["check_cart_item"] = $_SESSION["check_cart_item"] + $itemArray;
        //         //     echo 'success';
        //         // }
        //         echo 'error_x_empty';
        //     }
        //     else
        //     {
        //         $_SESSION['check_cart_item'] = $itemArray;
        //         echo 'success';
        //     }
        // }

    if($_POST['action'] == 'checkOutOrder') 
    {
        $selectedItems = json_decode($_POST['selectedItems'], true);
        $itemIds = array_column($selectedItems, 'id');
        $idString = implode(",", $itemIds);

        // DATABASE CONNECTION
        include('connection/connect.php');
        $checkDish = mysqli_query($db, "SELECT d_id, title, price, img FROM dishes WHERE d_id IN ('$idString')");

        // init session variable
        if(!isset($_SESSION['check_cart_item'])) {
            $_SESSION['check_cart_item'] = array();
        }
        while($row = mysqli_fetch_assoc($checkDish)) {
            $dishId = $row['d_id'];
            $quantity = $selectedItems[array_search($dishId, array_column($selectedItems, 'id'))]['quantity'];
            $orig_price = $row['price'];
            $item_price = $orig_price*$quantity;
            $itemArray = array(
                $dishId=>array(
                    'title'=>$row['title'],
                    'd_id'=>$dishId,
                    'quantity'=>$quantity,
                    'price'=>$item_price,
                    'img'=>$row['img']
                )
            );
            // $_SESSION['check_cart_item'] = $_SESSION["check_cart_item"] + $itemArray;
            // unset($_SESSION['cart_item'][$idString]);
            // echo 'success';
            if(empty($_SESSION['user_id'])) {
                echo 'error_login';
            }
            else {
                $_SESSION['check_cart_item'] = $_SESSION["check_cart_item"] + $itemArray;
                unset($_SESSION['cart_item'][$idString]);
                echo 'success';
            }
        }
    }

        


    }





                    // // init session variable
            // if(!isset($_SESSION['check_cart_item'])) {
            //     $_SESSION['check_cart_item'] = array();
            // }
            // while($row = mysqli_fetch_assoc($checkDish)) {
            //     $dishId = $row['d_id'];
            //     $quantity = $selectedItems[array_search($dishId, array_column($selectedItems, 'id'))]['quantity'];
            //     $orig_price = $row['price'];
            //     $item_price = $orig_price*$quantity;
            //     $itemArray = array(
            //         $dishId=>array(
            //             'title'=>$row['title'],
            //             'd_id'=>$dishId,
            //             'quantity'=>$quantity,
            //             'price'=>$item_price,
            //             'img'=>$row['img']
            //         )
            //     );

            //     if(!empty($_SESSION['cart_items']))
            //     {
            //         if(array_key_exists($dishId,$_SESSION['cart_items']))
            //         {
            //             foreach($_SESSION['cart_items'] as $key => $value)
            //             {
            //                 if($dishId == $key)
            //                 {
            //                     if(empty($_SESSION['check_cart_item'][$key]['quantity'])) 
            //                     {
            //                         $_SESSION['check_cart_item'][$key]['quantity'] = 0;
            //                     }
            //                     $_SESSION['check_cart_item'][$key]['quantity'] += $cart_qty;
            //                     echo 'success';
            //                 }
            //             }
            //         }
            //         else
            //         {
            //             $_SESSION["check_cart_item"] = $_SESSION["check_cart_item"] + $itemArray;
            //             echo 'success';
            //         }
            //     }
            //     else
            //     {
            //         $_SESSION['check_cart_item'] = $itemArray;
            //         echo 'success';
            //     }
            // }