<?php
    include("connection/connect.php");  
    error_reporting(0);  
    session_start(); 
    include('header.php');
?>

    <!-- BANNER SECTION -->
    <section class="fj__banner-wrap">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <div class="fj__banner-content-wrap text-center">
                <h1 class="fj__banner-heading s-font">
                    <?=$_GET['canteen']?>'s Menu
                </h1>
            </div>
        </div>
    </section>

    <section class="c__canteen-wrap sec-pad">
        <div class="container-lg canteen-food-listing d-flex justify-content-center">
            <?php
            $check_status = mysqli_query($db, "SELECT c_status FROM canteen_table WHERE id = '".$_GET['id']."'");
            $stat = mysqli_fetch_assoc($check_status);

            if($stat['c_status'] == '1') {
            ?>
                <?php
                $get_dishes = mysqli_query($db, "SELECT * FROM dishes WHERE c_id = '".$_GET['id']."' AND dishes.d_status = 'Post'");
                if(mysqli_num_rows($get_dishes) > 0) {
                ?>
                <div class="row d-flex justify-content-center">
                    <?php
                    while($rows = mysqli_fetch_array($get_dishes)) {
                    ?>
                        
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                            <div class="h__menu-list-box card">
                                
                                <div class="card-body">
                                    <!-- TITLE -->
                                    <div class="h__menu-list-box-name-wrap text-center">
                                        <h1 class="h__menu-list-box-name"><?=$rows['title']?></h1>
                                    </div>

                                    <!-- IMAGE -->
                                    <div class="h__menu-list-box-img-wrap">
                                        <img src="admin/Res_img/dishes/<?=$rows['img']?>" alt="Menu" class="h__menu-list-box-img">
                                    </div>

                                    <!-- ADD TO CART BUTTON -->
                                    <input type="hidden" class="m__menu-qty" id="menu_qty" type="number" name="quantity"  value="1" size="2" />
                                    <div class="h__menu-list-btn-wrap d-flex align-items-center justify-content-center gap-2 mt-3">
                                        <button href="#qtyModal<?=htmlentities($rows['d_id'])?>" class="h__menu-list-btn addCartBtn" data-bs-toggle="modal" data-bs-target="#qtyModal<?=htmlentities($rows['d_id'])?>">ADD TO CART</button>
                                        <div class="h__menu-list-fave-wrap">
                                            <?php
                                                if(isset($_SESSION['user_id'])) {
                                                    $check_fave = mysqli_query($db, "SELECT * FROM fave_table WHERE d_id = '".$rows['d_id']."' AND u_id = '".$_SESSION['user_id']."'");
                                                    if(mysqli_num_rows($check_fave) > 0) {
                                            ?>
                                                    <a href="#" class="h__menu-list-fave-btn fave_btn active" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart text-danger"></i></a>
                                            <?php
                                                    } else {
                                            ?>
                                                    <a href="#" class="h__menu-list-fave-btn fave_btn" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                                            <?php
                                                    }
                                                } else {
                                            ?>
                                                    <a href="#" class="h__menu-list-fave-btn fave_btn" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- QUANTITY MODAL -->
                        <div class="modal fade quantity_modal-<?=htmlentities($rows['d_id'])?>" id="qtyModal<?=htmlentities($rows['d_id'])?>" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <form id="menu_form">
                                        <div class="modal-header">
                                            <h4 class="modal-title fw-bold" id="qtyModalLabel">QUANTITY</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <input type="hidden" class="add__cart-dish-id" data-product-id="<?=$rows['d_id']?>" value="<?= $rows['d_id']?>">
                                            <div class="card py-2">
                                                <div class="card-body">
                                                    <div class="add__cart-dish-name-wrap mb-4">
                                                        <h1 class="add__cart-dish-name"><?=$rows['title']?></h1>
                                                        <h5 class="fw-bold text-center"><?=$rows['price']?>/order</h5>
                                                    </div>

                                                    <div class="add__cart-dish-qty-wrap d-block text-center">
                                                        <input class="add__cart-dish-qty pe-0" type="number" data-product-qty="quantity" name="quantity" size="2" min="1" value="1" placeholder="1" required/>
                                                        <p class="mb-0 mt-2">ENTER QUANTITY</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <?php
                                                $check_stock = mysqli_query($db, "SELECT d_stock FROM dishes WHERE d_id='".$rows['d_id']."'");
                                                while($get_stock = mysqli_fetch_array($check_stock)) {
                                                    $stocks = $get_stock['d_stock'];
                                                }
                                                
                                                if($stocks <= 0) {
                                            ?>
                                            <input type="button" class="c-btn-3 disabled" disabled value="OUT OF STOCK">
                                            <?php
                                                } else {
                                            ?>
                                            <input type="hidden" name="action" class="add_action" value="add_cart">
                                            <input type="submit" name="submit" class="c-btn-3 add_cart_btn" data-action-id="add_cart" data-dish-id="<?= $rows['d_id']?>" value="Add to Cart" data-bs-dismiss="modal">
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                } else {
                ?>
                <span class="alert alert-danger fw-bold text-center d-flex justify-content-center align-items-center mb-0 w-100">NO MENU AVAILABLE</span>
                <?php
                }
                ?>
            <?php
            } else {
            ?>
            <span class="alert alert-danger d-flex align-items-center justify-content-center fw-bold text-center text-uppercase w-100"><?=$_GET['canteen']?> IS CLOSE.</span>
            <?php
            }
            ?>
        </div>
    </section>

    <script>
        document.title = "<?=$_GET['canteen']?> | Food Jaguar";
    </script>

<?php
    include('footer.php');
?>

<script>
    // NEWWWWW
    $(document).on('click', '.add_cart_btn', function(e) {
        e.preventDefault();
        var quantity = $(this).closest('form').find('input[data-product-qty="quantity"]').val();
        var productId = $(this).attr('data-dish-id');
        // FIRST SECTION
        $.ajax({
            type: "POST",
            url: "add_cart.php",
            data: {quantity: quantity, dish_id: productId, action: 'add_cart'},
            beforeSend: function() {
                $(this).val('Adding to Cart');
                $(this).addClass('disabled');
                $(this).prop('disabled', true);
            },
            success: function (response) {
                if(response == 'success') 
                {
                    // SECOND SECTION
                    // UPDATE THE CART
                    updateCartItems();

                    // SHOW STATUS  
                    $(this).val('Add to Cart');
                    $(this).removeClass('disabled');
                    $(this).prop('disabled', false);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    })
                    Toast.fire({
                        icon: 'success',
                        title: 'Added to Cart!'
                    })

                    // CHANGE THE CHECKBOX
                    $('.cart__item-checkbox').change();
                    // $('#cart__item-footer-checkbox').change();

                    // SECOND FUNCTION - DISPLAY NEW ITEMS IN CART
                    $.ajax({
                        type: "GET",
                        url: "/templates/cart-bar-template.php",
                        success: function (response) {
                            $('.offcanvas-body').empty().html(response);
                        }
                    });

                    // UPDATE CART NUMBER
                    setInterval(updateCart, 1000);
                }
                else
                {
                    $(this).val('Add to Cart');
                    $(this).removeClass('disabled');
                    $(this).prop('disabled', false);
                    Swal.fire(
                        'Something Went Wrong!',
                        'Can\'t Add to Cart!',
                        'error'
                    );
                }
            }
        });
    })

    jQuery(function($) {
        $(document).ready(function () {
            // ADD TO FAVE
            $('.canteen-food-listing').on('click','.fave_btn', function(e) {
                e.preventDefault();
                var d_id = $(this).data('item'); 
                var u_id = $(this).data('user'); 
                var c_id = $(this).data('canteen');
                $(this).toggleClass('active');

                $.ajax({
                    type: "POST",
                    url: "add_cart.php",
                    data: {d_id: d_id, u_id: u_id, c_id: c_id, action: 'add_to_fave'},
                    success: function (response) {
                        if(response == 'success') 
                        {
                            updateFave();
                            updateFaveList();

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Added To Favorite'
                            })
                        } 
                        else if(response == 'removed')
                        {
                            updateFave();
                            updateFaveList()

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Removed From Favorite'
                            })
                        }
                        else if(response == 'error_login'){
                            let timerInterval
                            Swal.fire({
                            title: 'Unable To Add Item to Favorites!',
                            html: 'Please Login Before Adding to Favorites!<br><b class="text-danger">Redirecting You To Login Form.</b><br>Please Wait.',
                            timer: 3500,
                            timerProgressBar: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
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
                                'Unable to Add Item to Favorites.',
                                'error'
                            );
                        }
                    }
                });

            })
        })
    })

    // UPDATE MENU
    function updateFave() {
        $.ajax({
            type: "GET",
            url: "/templates/canteen-page-template.php",
            success: function (response) {
                $('.canteen-food-listing').empty().html(response);
            }
        });
    }
</script>