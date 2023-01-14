        <!-- CART SIDEBAR -->
        <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold" id="offcanvasExampleLabel">SHOPPING CART</h5>
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
                    <div id="cart-items-product-<?=$item['d_id']?>-<?=$item['title']?>" class="cart-items-product" data-product-id="<?=$item['d_id']?>">
                        <div class="card mb-2 product-card-wrap">
                            <div class="card-body">
                                <div class="cart__item-wrap">
                                    <label for="cart-checkbox<?=$item['d_id']?>-<?=$item['title']?>">
                                        <div class="cart__item-checkbox-wrap">
                                            <input type="checkbox" id="cart__item-checkbox-<?=$item['d_id']?>-<?=$item['title']?>" class="cart__item-checkbox" data-id="<?=$item['d_id']?>">
                                            <label for="cbx" class="cbx"></label>
                                        </div>
                                        <div class="cart__item-inner-wrap">
                                            <div class="cart__item-img-wrap">
                                                <img src="admin/Res_img/dishes/<?=$item['img']?>" alt="" class="img-thumbnail cart__item-img">
                                            </div>
                                            <div class="cart__item-info-wrap">
                                                <p class="cart__item-title"><?=$item['title']?></p>
                                                <p class="cart__item-price">₱ <?=$item['price']?></p>
                                                <input class="cart__item-qty" type="number" min="1" step="1" value="<?=$item['quantity']?>">
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
            </div>

            <div class="offcanvas-footer d-flex align-items-center justify-content-between">
                <div class="cart__item-footer-all-wrap d-flex align-items-center gap-2 ps-2">
                    <?php
                    if(empty($_SESSION['cart_item'])) {
                    ?>
                        <input type="checkbox" id="cart__item-footer-checkbox disabled" disabled class="cart__item-footer-checkbox">
                    <?php
                    } else {
                    ?>
                        <input type="checkbox" id="cart__item-footer-checkbox" class="cart__item-footer-checkbox">
                    <?php
                    }
                    ?>
                    <label for="cart__item-checkbox">All</label>
                </div>
                <div class="cart__item-footer-btn-wrap">
                    <form id="cart_checkout">
                        <?php
                        if(isset($_SESSION['cart_item'])) 
                        {
                            $item_total = 0;
                            foreach($_SESSION['cart_item'] as $item)
                            {
                        ?>
                        <input type="hidden" name="cart_qty" value="<?=$item['quantity']?>">
                        <input type="hidden" name="cart_dish_id" value="<?=$item['d_id']?>">
                        <?php
                            }
                        }
                        ?>
                        <input type="hidden" name="action" value="check">
                        <?php
                        if(empty($_SESSION['cart_item'])) {
                        ?>
                            <input type="submit" class="cart__item-footer-btn border-0 disabled" disabled data-action-id="check" id="cart__item-footer-btn" value="Checkout">
                        <?php
                        } else {
                        ?>
                            <input type="submit" class="cart__item-footer-btn border-0" data-action-id="check" data-item-id="check" id="cart__item-footer-btn" value="Checkout">
                        <?php
                        }
                        ?>
                    </form>
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
                    var checkout = document.getElementById('cart__item-footer-btn');

                    // ALL CHECKBOX - WORKING
                    allCheck.addEventListener('click', function() {
                        var checkStatus = $(this).is(':checked');
                        $('.cart__item-checkbox').prop('checked', checkStatus);
                        var checkedNum = $('.cart__item-checkbox:checked').length();
                        $('.cart__item-footer-btn').val(checkedNum);
                    })

                    // EMPTY CART -WORKING
                    // emptyBtn.addEventListener('click', function(e) {
                    //     e.preventDefault();
                    //     var emptyForm = $('#empty_form').serialize();
                    //     var action = $('input[data-action-id="empty"]').val();
                    //     emptyCart(emptyForm, action);
                    // })
                    // EMPTY CART FUNCTION - WORKING
                    // function emptyCart(emptyForm) {
                    //     $.ajax({
                    //         type: "POST",
                    //         url: "add_cart.php",
                    //         data: {emptyForm, action: 'empty'},
                    //         success: function (response) {
                    //             if(response == 'success') 
                    //             {
                    //                 const Toast = Swal.mixin({
                    //                     toast: true,
                    //                     position: 'top-end',
                    //                     showConfirmButton: false,
                    //                     timer: 1000,
                    //                     timerProgressBar: true
                    //                 })
                    //                 Toast.fire({
                    //                     icon: 'success',
                    //                     title: 'Cart Cleared!'
                    //                 })
                    //                 updateCart()
                    //             }
                    //             else if(response == 'error_cart') 
                    //             {
                    //                 Swal.fire(
                    //                     'Something Went Wrong!',
                    //                     'Cart Is Already Empty!',
                    //                     'error'
                    //                 );
                    //             }
                    //             else
                    //             {
                    //                 Swal.fire(
                    //                     'Something Went Wrong!',
                    //                     'Unable To Clear Cart!',
                    //                     'error'
                    //                 );
                    //             }
                    //         }
                    //     });
                    // }
                    // NEWWWW
                    $(document).on('click', '.m__cart-empty-btn', function(e) {
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
                                    $.ajax({
                                        type: "GET",
                                        url: "get_cart.php",
                                        success: function (response) {
                                            $('.cart-items-product').empty().html(response);
                                        }
                                    });
                                    updateCart()
                                }
                                else if(response == 'error_cart') 
                                {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Cart Is Already Empty!',
                                        'error'
                                    );
                                }
                                else
                                {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Unable To Clear Cart!',
                                        'error'
                                    );
                                }
                            }
                        });
                    })

                    // REMOVE ITEM - WORKING
                    // removeBtn.addEventListener('click', function(e) {
                    //     e.preventDefault();
                    //     var productId = $(this).attr('product-id');
                    //     removeItem(productId);
                    // });
                    // NEWWWWW
                    $('.cart-items-product').on('click', '.remove-item', function(e) {
                        e.preventDefault();
                        var productId = $(this).attr('product-id');
                        // FIRST FUNCTION
                        $.ajax({
                            type: "POST",
                            url: "add_cart.php",
                            data: {productId: productId, action: 'remove'},
                            success: function (response) {
                                if(response == 'success') {
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
                                    // SECOND FUNCTION
                                    $.ajax({
                                        type: "GET",
                                        url: "get_cart.php",
                                        success: function (response) {
                                            $('.cart-items-product').empty().html(response);
                                        }
                                    });
                                    updateCart();
                                } else {
                                    alert('error');
                                }
                            }
                        });
                    })
                    //REMOVE ITEM ACTION - WORKING
                    // function removeItem(productId) {
                    //     $.ajax({
                    //         type: "POST",
                    //         url: "add_cart.php",
                    //         data: {productId: productId, action: 'remove'},
                    //         success: function (response) {
                    //         if(response == 'success') 
                    //             {
                    //                 const Toast = Swal.mixin({
                    //                     toast: true,
                    //                     position: 'top-end',
                    //                     showConfirmButton: false,
                    //                     timer: 1000,
                    //                     timerProgressBar: true
                    //                 })
                    //                 Toast.fire({
                    //                     icon: 'success',
                    //                     title: 'Item Removed!'
                    //                 })
                    //                 setInterval(updateCart(), 1000);
                    //             }
                    //             else if(response == 'error_cart')
                    //             {
                    //                 Swal.fire(
                    //                     'Something Went Wrong!',
                    //                     'Error',
                    //                     'error'
                    //                 );
                    //             }
                    //             else
                    //             {
                    //                 Swal.fire(
                    //                     'Something Went Wrong!',
                    //                     'Unable To Remove Item From Your Cart!',
                    //                     'error'
                    //                 );
                    //             }
                    //         }
                    //     });
                    // }
                    
                    // CHECKOUT SESSION - working
                    checkout.addEventListener('click', function(e) {
                        e.preventDefault();
                        var cartForm = $('#cart_checkout').serialize();
                        var action = $('input[data-action-id="check"]').val();
                        checkOutOrders(cartForm, action);
                    })

                    // CHECKOUT ACTION - working
                    function checkOutOrders(cartForm) {
                        $.ajax({
                            type: "POST",
                            url: "add_cart.php",
                            data: cartForm,
                            success: function (response) {
                                if(response == 'success') 
                                {
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true
                                    })
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Redirecting you to Checkout Form!'
                                    })
                                    setTimeout(' window.location.href = "checkout"; ', 1500);
                                }
                                else
                                {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Unable To Checkout!',
                                        'error'
                                    );
                                    alert(response);
                                }
                            }
                        });
                    }

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
        </script>

    <!-- JAVASCRIPT FILES -->
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
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