                        <!-- USER DETAILS -->
                        <?php
                            // INCLUDE DATABASE
                            include('connection/connect.php');
                            session_start();
                            $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id = '".$_SESSION['user_id']."'");
                            if(mysqli_num_rows($get_user) > 0) {
                                $row = mysqli_fetch_assoc($get_user);
                                $fullname = $row['f_name'] . " " . $row['l_name'];
                        ?>
                            <div>
                                <ul>
                                    <li class="modal__checkout-address-wrap">
                                        <p class="modal__checkout-address-title mb-1"><i class="fa-sharp fa-solid fa-location-dot"></i> Delivery Address</p>
                                        <p class="mb-0 ps-3"><?=$fullname?> | <?=$row['phone']?></p>
                                        <p class="mb-0 ps-3"><?=$row['address']?></p>
                                    </li>
                                </ul>
                            </div>
                            <hr class="modal__checkout-divider">
                        <?php
                            }
                        ?>

                        <!-- ORDERS -->
                        <div class="modal__checkout-cart-item-heading-wrap">
                            <p class="modal__checkout-address-title mb-1"><i class="fa-solid fa-cart-shopping"></i> Your Orders</p>
                        </div>                    
                    
                    <?php
                        if(empty($_SESSION['check_cart_item'])){
                        ?>

                            <div class="w-100 d-flex align-items-center justify-content-center">
                                <span class="alert alert-danger text-center w-100 fw-bold">YOUR CART IS EMPTY!</span>
                            </div>

                        <?php
                        }
                        else {
                    ?>
                        <?php
                            if(isset($_SESSION['check_cart_item'])) 
                            {
                                $total_price = 0;
                                $total_quantity = 0;
                                // foreach($selectedItems as $item) 
                                foreach($_SESSION['check_cart_item'] as $item) 
                                {
                                    $get_menu = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='".$item['id']."'");
                                    if(mysqli_num_rows($get_menu) > 0) {
                                        while($menu = mysqli_fetch_array($get_menu)) {
                                    // $total_price += ($item['price']*$item['quantity']);
                        ?>
                                    <div class="modal__checkout-wrap card p-2 mb-2 ms-3">
                                        <div class="row w-100">
                                            <div class="modal__checkout-item-img-wrap col-3 pe-0">
                                                <img src="admin/Res_img/dishes/<?=$menu["img"]?>" class="modal__checkout-item-img img-thumbnail" alt="Item">
                                            </div>
                                            <div class="modal__checkout-item-desc-wrap col-9">
                                                <p class="modal__checkout-item-name mb-1"><?=$menu["title"]?></p>
                                                <?php
                                                    $get_desc = mysqli_query($db, "SELECT substring(slogan, 1 , 80) as excerpt FROM dishes WHERE d_id='".$item['id']."'");
                                                    if(mysqli_num_rows($get_desc) > 0) {
                                                        while($row = mysqli_fetch_assoc($get_desc)) {
                                                    ?>
                                                    <p class="modal__checkout-item-desc mb-2"><?=$row['excerpt']?>...</p>
                                                    <?php
                                                        }
                                                    } else {
                                                    ?>
                                                    <p class="modal__checkout-item-desc mb-2">No Description Available.</p>
                                                    <?php
                                                    }
                                                ?>
                                                <div class="modal__checkout-item-price-qty-wrap">
                                                    <p class="modal__checkout-item-price mb-0">₱<?=$menu['price']?></p>
                                                    <p class="modal__checkout-item-qty mb-0">x<?=$item['quantity']?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <hr class="modal__checkout-divider">
                        <?php
                                        }
                                    }
                                }
                            }
                        }
                    ?>
                        <div class="modal__checkout-total-wrap">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <?php 
                                        $item_count = count($_SESSION['check_cart_item']);
                                    ?>
                                    <p class="mb-0">Order Total(<?=$item_count?>)</p>
                                    <!-- <p class="mb-0">₱<?=$total_price?></p> -->
                                </div>
                            </div>
                        </div>