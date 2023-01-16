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
                <!-- CART -->
                    <div id="cart-items-product-<?=$item['d_id']?>-<?=$item['title']?>" class="cart-items-product" data-product-id="<?=$item['d_id']?>">
                        <div class="card mb-2 product-card-wrap">
                            <div class="card-body">
                                <div class="cart__item-wrap">
                                    <label for="cart-checkbox-<?=$item['d_id']?>-<?=$item['title']?>">
                                        <div class="cart__item-checkbox-wrap">
                                            <input type="checkbox" id="cart__item-checkbox-<?=$item['d_id']?>-<?=$item['title']?>" class="cart__item-checkbox" data-check="check-box" data-id="<?=$item['d_id']?>">
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
                <div class="cart__item-footer-btn-wrap d-flex align-items-center gap-2">
                    <p class="total-price mb-0 fw-semibold">₱0</p>
                    <form id="cart_checkout">
                        <?php
                        if(isset($_SESSION['cart_item'])) 
                        {
                            $item_total = 0;
                            foreach($_SESSION['cart_item'] as $item)
                            {
                        ?>
                        <input type="hidden" data-qty-id="cart_qty_val-<?=$item['d_id']?>" name="cart_qty" value="<?=$item['quantity']?>">
                        <input type="hidden" name="cart_dish_id" value="<?=$item['d_id']?>">
                        <?php
                            }
                        }
                        ?>
                        <!-- <input type="hidden" name="action" value="check"> -->
                        <input type="hidden" name="action" value="checkOutOrder">
                        <input type="submit" class="cart__item-footer-btn border-0" data-action-id="check_user" id="cart__item-footer-btn" value="Checkout(0)">
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
                    // var checkout = document.getElementById('cart__item-footer-btn');
                    var checkout = $('#cart__item-footer-btn');

                    // ALL CHECKBOX - WORKING
                    // allCheck.addEventListener('click', function() {
                    //     var checkStatus = $(this).is(':checked');
                    //     $('.cart__item-checkbox').prop('checked', checkStatus);
                    //     var checkedNum = $('.cart__item-checkbox:checked').length;
                    //     $('.cart__item-footer-btn').val('Checkout('+checkedNum+')');

                    //     // UPDATE TOTAL OF CHECKED ITEMS
                    //     $('.cart__item-checkbox').on('change', function() {
                    //         var totalPrice = 0;
                    //         $('.cart__item-checkbox:checked').each(function() {
                    //             var checkedNum = $('.cart__item-checkbox:checked').length;
                    //             $('.cart__item-footer-btn').val('Checkout('+checkedNum+')');
                    //             var itemPrice = $(this).closest('.cart__item-wrap').find('.cart__item-price').text();
                    //             totalPrice += parseFloat(itemPrice.substring(1));
                    //         });
                    //         $('.total-price').text('₱'+totalPrice);
                    //         // $.ajax({
                    //         //     type: "POST",
                    //         //     url: "get_cart_total.php",
                    //         //     dataType: "json",
                    //         //     success: function (response) {
                    //         //         totalPrice += response.totalPrice;
                    //         //         $('.total-price').text('₱'+totalPrice);
                    //         //         alert(totalPrice);
                    //         //     }
                    //         // });
                    //     });
                    // })
                    // $(allCheck).on('click', function() {
                    //     var checkStatus = $(this).is(':checked');
                    //     $('.cart__item-checkbox').prop('checked', checkStatus);
                    //     var checkedNum = $('.cart__item-checkbox:checked').length;
                    //     $('.cart__item-footer-btn').val('Checkout('+checkedNum+')');

                    //     // CHECK CART
                    //     $.ajax({
                    //         type: "GET",
                    //         url: "check_session.php",
                    //         data: {session: 'cart_item'},
                    //         success: function (response) {
                    //             if(response == 'success') 
                    //             {
                    //                 // UPDATE TOTAL OF CHECKED ITEMS
                    //                 $('.cart__item-checkbox').on('change', function() {
                    //                     var totalPrice = 0;
                    //                     $('.cart__item-checkbox:checked').each(function() {
                    //                         var checkedNum = $('.cart__item-checkbox:checked').length;
                    //                         $('.cart__item-footer-btn').val('Checkout('+checkedNum+')');
                    //                         var itemPrice = $(this).closest('.cart__item-wrap').find('.cart__item-price').text();
                    //                         totalPrice += parseFloat(itemPrice.substring(1));
                    //                     });
                    //                     $('.total-price').text('₱'+totalPrice);
                    //                     // $.ajax({
                    //                     //     type: "POST",
                    //                     //     url: "get_cart_total.php",
                    //                     //     dataType: "json",
                    //                     //     success: function (response) {
                    //                     //         totalPrice += response.totalPrice;
                    //                     //         $('.total-price').text('₱'+totalPrice);
                    //                     //         alert(totalPrice);
                    //                     //     }
                    //                     // });
                    //                 });
                    //             }
                    //             else
                    //             {
                    //                 Swal.fire(
                    //                     'Something Went Wrong!',
                    //                     'Your Cart is Empty!',
                    //                     'error'
                    //                 );
                    //             }
                    //         }
                    //     });

                    // })

                    // NEWWWW EMPTY ACTION
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
                                    etInterval(updateCartItems, 1500);
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
                                            // $('.cart-items-product').empty().html(response);
                                            $('.offcanvas-body').empty().html(response);
                                        }
                                    });
                                    setInterval(updateCart, 1500);
                                    // updateCartPrice();
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

                    // NEWWWWW REMOVE ACTION
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
                                    setInterval(updateCartItems, 1500);
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
                                            $('.offcanvas-body').empty().html(response); 
                                        }
                                    });
                                    setInterval(updateCart, 1500);
                                    // setInterval(updateCartPrice, 1500);
                                } 
                                else {
                                    alert('error');
                                }
                            }
                        });
                    })
                    
                    // CHECKOUT SESSION - working
                    $(checkout).on('click', function(e) {
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
                                    if(selectedItems.length > 0) {
                                        let selectedItemsJson = JSON.stringify(selectedItems);
                                        console.log(selectedItemsJson);
                                        checkOutOrders(selectedItemsJson, 'checkOutOrder');
                                    } else {
                                        Swal.fire(
                                            'Something Went Wrong!',
                                            'Unable To Checkout!<br><b>Please select an item to checkout.</b>',
                                            'error'
                                        );
                                    }
                                }
                                else
                                {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Your Cart is Empty!',
                                        'error'
                                    );
                                }
                            }
                        });
                    })
                    // CHECKOUT ACTION - working
                    function checkOutOrders(selectedItemsJson) {
                        $.ajax({
                            type: "POST",
                            url: "add_cart.php",
                            data: {selectedItems: selectedItemsJson, action: 'checkOutOrder'},
                            success: function (response) {
                                if(response == 'success') 
                                {
                                    setInterval(updateCartItems, 1500);
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
                                    setInterval(updateCart, 1500);
                                    // setInterval(updateCartPrice, 1500);
                                    setTimeout(' window.location.href = "checkout"; ', 1500);
                                }
                                else if(response == 'cart_empty') {
                                    Swal.fire(
                                        'Something Went Wrong!',
                                        'Unable To Checkout!<br><b>Empty!</b>',
                                        'error'
                                    );
                                }
                                else if(response == 'error_login') {
                                    // Swal.fire({
                                    //     title: 'Unable To Checkout!',
                                    //     html: 'Please Login Before Checking Out!<br><b>Redirecting You To Login Form.</b><br>Please Wait.',
                                    //     timer: 3000,
                                    //     showCancelButton: false,
                                    //     showConfirmButton: false
                                    //     }).then(
                                    //     function () {},
                                    //     function (dismiss) {
                                    //         if (dismiss === 'timer') {
                                    //             window.location.href = 'login';
                                    //         }
                                    //     }
                                    // )

                                    let timerInterval
                                    Swal.fire({
                                    title: 'Unable To Checkout!',
                                    html: 'Please Login Before Checking Out!<br><b>Redirecting You To Login Form.</b><br>Please Wait.',
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

                                    // setTimeout(' window.location.href = "login"; ', 2000);
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

                    updateCart();
                    // updateCartPrice();
                    // setInterval(updateCart, 1500);
                    // setInterval(updateCartPrice, 1500);
                    // setInterval(updateCartItems, 1500);
                })
            })

            // UPDATE CART PRICE
            // function updateCartPrice()
            // {
            //     $.ajax({
            //         type: "GET",
            //         url: "get_cart_total.php",
            //         success: function (response) {
            //             $('.total-price').text('₱'+response);
            //         }
            //     });
            // }
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