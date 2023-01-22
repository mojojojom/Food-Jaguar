        <!-- CHECKOUT POPUP -->
        <div class="modal fade" id="checkoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="checkoutModalLabel">Checkout</h1>
                    </div>
                    <div class="modal-body checkout_modal-wrap">
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
                        <div class="modal__checkout-orders-wrap" id="modal__checkout-orders-wrap">
                            <?php
                            session_start();
                            if(empty($_SESSION['check_cart_item'])){
                            ?>

                                <div class="w-100 d-flex align-items-center justify-content-center">
                                    <span class="alert alert-danger text-center w-100 fw-bold">YOUR CART IS EMPTY!</span>
                                </div>

                            <?php
                            }
                            else {
                            ?>
                                <!-- ORDERS -->
                                <div class="modal__checkout-cart-item-heading-wrap">
                                    <p class="modal__checkout-address-title mb-1"><i class="fa-solid fa-cart-shopping"></i> Your Orders</p>
                                </div>
                                <?php
                                    if(isset($_SESSION['check_cart_item'])) 
                                    {
                                        $total_price = 0;
                                        $total_quantity = 0;
                                        foreach($_SESSION['check_cart_item'] as $item) 
                                        {
                                            $total_price += ($item['price']*$item['quantity']);
                                            $get_menu = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='".$item['id']."'");
                                            if(mysqli_num_rows($get_menu) > 0) {
                                                while($menu = mysqli_fetch_array($get_menu)) {
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
                                <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            ?>
                        </div>

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
                    </div>

                    <div class="modal-body">
                        <hr class="modal__checkout-divider">

                        <div class="modal__checkout-mop-wrap">
                            <label for="shippingOption">Select Shipping Option</label>
                            <select class="form-select shipping_option" aria-label="Default select example" required>
                                <option value="deliver"selected>Delivery (₱5.00)</option>
                                <option value="pick-up">Pick-up</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <form id="place_order">
                            <input type="submit" class="c-btn-4" id="place_order-btn" value="Place Order">
                        </form>
                        <form id="unset_form">
                            <input type="hidden" name="action" value="unset">
                        </form>
                        <button type="button" class="c-btn-2" id="unset_btn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CART SIDEBAR -->
        <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="cartSideMenu" aria-labelledby="cartSideMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold" id="offcanvasExampleLabel">YOUR CART</h5>
                <!-- <button type="button" class="btn-close text-light" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
                <button type="button" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-square-xmark text-white"></i></button>
            </div>

            <div class="offcanvas-body">
                <?php
                    if(empty($_SESSION['cart_item'])) {
                ?>
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <span class="alert alert-danger text-center mb-0 w-100 fw-bold">YOUR CART IS EMPTY!</span>
                </div>
                <?php
                    } else {
                ?>
                <!-- DELETE ALL BUTTON -->
                <div class="mb-3 empty_btn-wrap">
                    <div class="card-body">
                        <!-- CLEAR CART BUTTON -->
                        <form method="POST" id="empty_form" class="d-flex justify-content-end">
                            <?php
                                foreach($cart as $rows) {
                            ?>
                            <input type="hidden" name="dish_id" value="<?= $rows['d_id']?>">
                            <?php
                                }
                            ?>
                            <input type="hidden" name="action" data-action-id="empty" value="empty">
                            <input type="button" name="submit" id="empty-cart" class="m__cart-empty-btn d-block py-1 px-2" value="Empty Cart">
                        </form>

                    </div>
                </div>
                <?php
                    if(isset($_SESSION['cart_item'])) 
                    {
                        $item_total = 0;
                        foreach($_SESSION['cart_item'] as $item)
                        {
                            $item_total = $item['quantity']*$item['price'];
                ?>
                <!-- CART -->
                    <div id="cart-items-product-<?=$item['d_id']?>-<?=$item['title']?>" class="cart-items-product" data-product-id="<?=$item['d_id']?>">
                        <div class="card mb-2 product-card-wrap">
                            <div class="card-body">
                                <div class="cart__item-wrap">
                                    <label for="cart-checkbox-<?=$item['d_id']?>-<?=$item['title']?>">
                                        <div class="cart__item-checkbox-wrap">
                                            <input type="checkbox" id="cart__item-checkbox-<?=$item['d_id']?>-<?=$item['title']?>" class="cart__item-checkbox" data-check="check-box" data-id="<?=$item['d_id']?>" data-price="<?=$item['price']?>">
                                            <input type="hidden" name="qyt_hidden" data-qty-id="cart_qty_val-<?=$item['quantity']?>" value="<?=$item['quantity']?>">
                                            <label for="cbx" class="cbx"></label>
                                        </div>
                                        <div class="cart__item-inner-wrap">
                                            <div class="cart__item-img-wrap">
                                                <img src="admin/Res_img/dishes/<?=$item['img']?>" alt="" class="img-thumbnail cart__item-img">
                                            </div>
                                            <div class="cart__item-info-wrap">
                                                <p class="cart__item-title"><?=$item['title']?></p>
                                                <p class="cart__item-price">₱ <?=$item['price']?></p>
                                                <p class="cart__item-qty text-center"><?=$item['quantity']?></p>
                                            </div>
                                        </div>
                                        <div class="cart__item-remove-wrap">
                                            <button type="submit" name="submit" class="remove-item" product-id="<?=$item['d_id']?>"><i class="fa-solid fa-square-xmark"></i></button>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    } 
                }
                ?>
                <form id="cart_checkout">
                    <?php
                        session_start();
                        $cart = $_SESSION['cart_item'];
                        if(isset($cart)) 
                        {
                            $item_total = 0;
                            foreach($cart as $item)
                            {
                        ?>
                        <input type="hidden" data-qty-id="cart_qty_val-<?=$item['d_id']?>" name="cart_qty" value="<?=$item['quantity']?>">
                        <input type="hidden" name="cart_dish_id" value="<?=$item['d_id']?>">
                        <?php
                            }
                        }
                    ?>
                    <input type="hidden" name="action" value="checkOutOrder">
                </form>
            </div>

            <div class="offcanvas-footer d-flex align-items-center justify-content-between">
                <div class="cart__item-footer-all-wrap d-flex align-items-center gap-2 ps-2">
                    <input type="checkbox" id="cart__item-footer-checkbox" class="cart__item-footer-checkbox">
                    <label for="cart__item-checkbox">All</label>
                </div>
                <div class="cart__item-footer-btn-wrap d-flex align-items-center gap-2">
                    <p class="total-price mb-0 fw-semibold">₱0.00</p>
                    <!-- <input type="submit" class="cart__item-footer-btn border-0" data-action-id="check_user" id="cart__item-footer-btn" value="Checkout(0)"> -->
                    <input type="submit" class="cart__item-footer-btn border-0" data-action-id="check_user" id="cart__item-btn" value="Checkout(0)">
                </div>
            </div>
        </div>
        
        <!-- FOOTER SECTION -->
        <footer class="fj__footer bottom-0">
            <div class="container">
                <div class="fj__inner-wrap row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 fj__footer-img-wrap text-start d-flex align-items-center justify-content-center justify-content-sm-center justify-content-md-start">
                        <img src="images/icon.png" alt="">
                        <a href="./" class="fj__footer-site-title p-font mb-0 mt-2 ms-3">FOOD JAGUAR</a>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 fj__footer-links-wrap d-flex align-items-center justify-content-center py-4 py-sm-4 py-md-0 py-lg-0">
                        <ul class="mx-auto gap-5 d-flex mb-0">
                            <li> <a class="fj__footer-links s-font" href="index">Home</a> </li>
                            <li> <a class="fj__footer-links s-font" href="about">About</a> </li>
                            <li> <a class="fj__footer-links s-font" href="menu">Menu</a> </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 fj__footer-sm-wrap d-flex align-items-center justify-content-center justify-content-sm-center justify-content-md-center justify-content-lg-end">
                        <ul class=" gap-3 d-flex mb-0">
                            <li><a class="fj__footer-sm-links" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a class="fj__footer-sm-links" href="#"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a class="fj__footer-sm-links" href="#"><i class="fa-brands fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="fj__copyright-wrap pt-4">
                    <p class="s-font fj__copyright mb-0">Copyright © <?= date('Y') ?> <a href="./">Food Jaguar</a></p>
                </div>
            </div>
        </footer>

        <!-- CART AJAX SCRIPT -->
        <script>
            jQuery(function($) {
                $(document).ready(function () {
                    var emptyBtn = document.getElementById('empty-cart');
                    var removeBtn = document.querySelector('.remove-item');
                    var allCheck = document.getElementById('cart__item-footer-checkbox');
                    var checkout = $('#cart__item-footer-btn');
                    var cartBtn = $('#cart__item-btn');

                    // NEWWWW EMPTY ACTION
                    $('.offcanvas-body').on('click', '.m__cart-empty-btn', function(e) {
                        e.preventDefault();
                        var emptyForm = $('#empty_form').serialize();
                        var action = $('input[data-action-id="empty"]').val();
                        // FIRST SECTION
                        $.ajax({
                            type: "POST",
                            url: "add_cart.php",
                            data: {emptyForm, action: 'empty'},
                            success: function (response) {
                                if(response == 'success') 
                                {
                                    
                                    // UPDATE THE CART
                                    updateCartItems();

                                    // SHOW STATUS
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 1000,
                                        timerProgressBar: true
                                    })
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Cart Cleared!'
                                    })

                                    // CHANGE THE CHECKBOX
                                    $('.cart__item-checkbox').change();
                                    $('#cart__item-footer-checkbox').prop('checked', false);

                                    // SECOND SECTION - DISPLAY THE NEW ITEMS IN CART
                                    $.ajax({
                                        type: "GET",
                                        url: "get_cart.php",
                                        success: function (response) {
                                            $('.offcanvas-body').empty().html(response);
                                        }
                                    });

                                    // UPDATE CART NUMBER
                                    setInterval(updateCart, 1000);
                                    // updateCart();
                                }
                                else if(response == 'error_cart') 
                                {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Cart Is Already Empty!',
                                        'info'
                                    );
                                }
                                else
                                {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Unable To Clear Cart!',
                                        'warning'
                                    );
                                }
                            }
                        });
                    })

                    // NEWWWWW REMOVE ACTION
                    $('.offcanvas-body').on('click', '.remove-item', function(e) {
                        e.preventDefault();
                        var productId = $(this).attr('product-id');
                        // console.log(productId);
                        // FIRST FUNCTION
                        $.ajax({
                            type: "POST",
                            url: "add_cart.php",
                            data: {productId: productId, action: 'remove'},
                            success: function (response) {
                                if(response == 'success') {

                                    // UPDATE THE CART
                                    updateCartItems();

                                    // SHOW STATUS
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 1000,
                                        timerProgressBar: true
                                    })
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Item Removed!'
                                    })

                                    // CHANGE THE CHECKBOX
                                    $('.cart__item-checkbox').change();
                                    $('#cart__item-footer-checkbox').prop('checked', false);

                                    // SECOND FUNCTION - DISPLAY NEW ITEMS IN CART
                                    $.ajax({
                                        type: "GET",
                                        url: "get_cart.php",
                                        success: function (response) {
                                            $('.offcanvas-body').empty().html(response);
                                        }
                                    });

                                    // UPDATE CART NUMBER
                                    setInterval(updateCart, 1000);
                                    // updateCart();
                                } 
                                else {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Unable to Remove Item!',
                                        'error'
                                    );
                                }
                            }
                        });
                    })

                    // CHECK ALL
                    $('#cart__item-footer-checkbox').change(function() {
                        if($('.cart__item-checkbox').length == 0) {
                            Swal.fire(
                                'Your Cart is Empty!',
                                'Please Add Items to the Cart.',
                                'warning'
                            );
                        }
                        else
                        {
                            $('.cart__item-checkbox').prop('checked', $(this).prop('checked'));
                            var checkedNum = $('.cart__item-checkbox:checked').length;
                            $('.cart__item-footer-btn').val('Checkout('+checkedNum+')');
                            var totalPrice = 0;
                            if(checkedNum > 0) {
                                $('.cart__item-checkbox:checked').each(function() {
                                    var dish_id = $(this).data('id');
                                    var item_price = $(this).data('price');
                                    var item_qty = $('input[data-qty-id="cart_qty_val-'+dish_id+'"]').val();
                                    totalPrice += item_price*item_qty;
                                });
                                $('.total-price').text('₱'+totalPrice.toFixed(2));
                            } else {
                                $('.total-price').text('₱0.00');
                            }
                        }
                    });

                    // CHECK SINGLE ITEM
                    $(document).on('change', '.cart__item-checkbox', function() {
                        var checkedNum = $('.cart__item-checkbox:checked').length;
                        $('.cart__item-footer-btn').val('Checkout('+checkedNum+')');
                        var totalPrice = 0;
                        if(checkedNum > 0) {
                            $('.cart__item-checkbox:checked').each(function() {
                                var dish_id = $(this).data('id');
                                var item_price = $(this).data('price');
                                var item_qty = $('input[data-qty-id="cart_qty_val-'+dish_id+'"]').val();
                                totalPrice += item_price*item_qty;
                            });
                            $('.total-price').text('₱'+totalPrice.toFixed(2));
                        } else {
                            $('.total-price').text('₱0.00');
                        }
                    });

                    $(cartBtn).on('click', function(e) {
                        e.preventDefault();
                        var cartForm = $('#cart_checkout').serialize();
                        $.ajax({
                            type: "GET",
                            url: "check_session.php",
                            data: {session: 'cart_item'},
                            success: function (response) {
                                if(response == 'success') 
                                {
                                    // NEWWWWW CHECKBOX FUNCTION
                                    var selectedItems = [];
                                    $('.cart__item-checkbox:checked').each(function() {
                                        var dish_id = $(this).data('id');
                                        var items_qty = $('input[data-qty-id="cart_qty_val-'+dish_id+'"]').val();
                                        selectedItems.push({
                                            'id': $(this).data('id'),
                                            'quantity': items_qty
                                        });
                                    });
                                    if(selectedItems.length > 0) 
                                    {
                                        let selectedItemsJson = JSON.stringify(selectedItems);
                                        checkOutOrders(selectedItemsJson, 'checkOutOrder');
                                        console.log(selectedItemsJson);
                                    } 
                                    else 
                                    {
                                        Swal.fire(
                                            'Unable To Checkout!',
                                            'Please Select an Item to Checkout.',
                                            'warning'
                                        );
                                    }
                                }
                                else
                                {
                                    Swal.fire(
                                        'Your Cart is Empty!',
                                        'Please Add Items to the Cart.',
                                        'warning'
                                    );
                                }
                            }
                        });
                    })

                    function checkOutOrders(selectedItemsJson) {
                        $.ajax({
                            type: "POST",
                            url: "add_cart.php",
                            data: {selectedItems: selectedItemsJson, action: 'checkOutOrder'},
                            success: function (response) {
                                if(response == 'success') 
                                {
                                    // UPDATE THE CART
                                    updateCartItems();

                                    // UPDATE CHECKOUT MODAL
                                    updateCheckout();
                                    
                                    // SHOW CHECKOUT MODAL
                                    $('#checkoutModal').modal('show');

                                    // REMOVE CHECK
                                    $('.cart__item-footer-checkbox').prop('checked', false);

                                    // UPDATE CART NUMBER
                                    setInterval(updateCart, 1000);
                                    // updateCart();

                                }
                                else if(response == 'cart_empty') {
                                    Swal.fire(
                                        'Unable To Checkout!',
                                        'Please Add Items to the Cart.',
                                        'info'
                                    );
                                }
                                else if(response == 'error_login') {
                                    let timerInterval
                                    Swal.fire({
                                    title: 'Unable To Checkout!',
                                    html: 'Please Login Before Checking Out!<br><b class="text-danger">Redirecting You To Login Form.</b><br>Please Wait.',
                                    timer: 3000,
                                    timerProgressBar: false,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    willClose: () => {
                                        clearInterval(timerInterval)
                                    }
                                    }).then((result) => {
                                        if (result.dismiss === Swal.DismissReason.timer) {
                                            window.location.href = 'login';
                                        }
                                    })
                                }
                                else
                                {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Unable To Checkout!',
                                        'error'
                                    );
                                }
                            }
                        });
                    }

                    // CANCEL BUTTON
                    $('#unset_btn').on('click', function(e) {
                        e.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "add_cart.php",
                            data: {action: 'unset'},
                            success: function (response) {
                                if(response == 'success') {
                                    // window.location.href='menu';
                                    $('#checkoutModal').modal('hide');
                                }
                                else
                                {
                                    console.log(response);
                                }
                            }
                        });

                    })

                    // PLACE ORDER
                    $('#place_order-btn').on('click', function(e) {
                        e.preventDefault();
                        var ship = $('select.shipping_option').val();
                        $.ajax({
                            type: "GET",
                            url: "checkout_session.php",
                            data: {session: 'check_cart_item'},
                            success: function (response) 
                            {
                                if(response == 'success') 
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: "add_cart.php",
                                        data: {ship: ship, action: 'place_order'},
                                        success: function (response) {
                                            if(response == 'success') 
                                            {
                                                // SHOW STATUS
                                                const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: 'top-end',
                                                    showConfirmButton: false,
                                                    timer: 1500,
                                                    timerProgressBar: true
                                                })
                                                Toast.fire({
                                                    icon: 'success',
                                                    title: 'Your Order Has Been Placed!'
                                                })

                                                setTimeout(() => {
                                                    window.location.href='your_order';
                                                }, 1500);
                                            }
                                            else {
                                                Swal.fire(
                                                    'Something Went Wrong!',
                                                    'Unable To Place Order!',
                                                    'error'
                                                );
                                            }
                                        }
                                    });
                                }
                                else 
                                {
                                    console.log('Failed!');
                                }
                            }
                        })
                    })

                    $(window).on('beforeunload', function(){
                        $.ajax({
                            type: "POST",
                            url: "unset_session.php",
                            data: {check_cart_item: 'check_cart_item'},
                            async: false
                        });
                    });
                    $(document).ready(function () {
                        $.ajax({
                            type: "POST",
                            url: "unset_session.php",
                            data: {check_cart_item: 'check_cart_item'},
                            success: function(response) {
                                console.log("Session unset");
                            }
                        });
                    });

                    updateCart();
                })
            })

            // UPDATE CART NUMBER
            function updateCart() {
                $.ajax({
                    type: "POST",
                    url: "get_cart_num.php",
                    success: function (response) {
                        $('.cart_num').html(response);
                        localStorage.setItem('cartNumber', response);
                    }
                });
            }
            // check if cartNumber exists in localStorage
            if (localStorage.getItem('cartNumber')) {
                // retrieve the cartNumber
                var cartNumber = localStorage.getItem('cartNumber');
                // update the cart number
                $('.cart_num').html(cartNumber);
            }

            // NEW FUNCTION
            function updateCartItems() {
                $.ajax({
                    type: "GET",
                    url: "get_cart.php",
                    success: function (response) {
                        $('.offcanvas-body').empty().html(response);
                    }
                });
            }

            function updateCheckout() {
                $.ajax({
                    type: "GET",
                    url: "get_checkout.php",
                    success: function (response) {
                        $('.checkout_modal-wrap').empty().html(response);
                    }
                });
            }

        </script>

    <!-- JAVASCRIPT FILES -->
        <script src="js/tether.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="js/animsition.min.js"></script>
        <script src="js/bootstrap-slider.min.js"></script>
        <script src="js/jquery.isotope.min.js"></script>
        <script src="js/headroom.js"></script>
        <script src="js/foodpicky.min.js"></script>
        <script src="sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="js/app.js"></script>
        <script src="js/clear_local_storage.js"></script>
    <!-- END OF JAVASCRIPT FILEs -->

    </body>

</html>