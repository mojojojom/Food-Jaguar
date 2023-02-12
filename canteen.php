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
        <div class="container">
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
                    while($dishes = mysqli_fetch_array($get_dishes)) {
                    ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="h__menu-list-card">
                                <div class="h__menu-card-img-wrap">
                                    <img class="h__menu-card-img" src="admin/Res_img/dishes/<?=$dishes['img']?>" alt="Menu">
                                </div>
                                <div class="h__menu-card-inner-wrap p-4">
                                    <div class="h__menu-card-name-wrap">
                                        <h1 class="h__menu-card-name s-font"><?=$dishes['title']?></h1>
                                    </div>
                                    <div class="h__menu-card-price-wrap">
                                        <h4 class="h__menu-card-price s-font">₱<?=$dishes['price']?></h4>
                                    </div>
                                    <div class="h__menu-card-desc-wrap">
                                        <p class="h__menu-card-desc s-font"><?=$dishes['slogan']?></p>
                                    </div>
                                    <input type="hidden" class="m__menu-qty" id="menu_qty" type="number" name="quantity"  value="1" size="2" />
                                    <div class="h__menu-card-btn-wrap">
                                        <button href="#qtyModal<?=htmlentities($dishes['d_id'])?>" class="h__menu-card-btn addCartBtn" data-bs-toggle="modal" data-bs-target="#qtyModal<?=htmlentities($dishes['d_id'])?>"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- QUANTITY MODAL -->
                        <div class="modal fade quantity_modal-<?=htmlentities($dishes['d_id'])?>" id="qtyModal<?=htmlentities($dishes['d_id'])?>" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <form id="menu_form">
                                        <div class="modal-header">
                                            <h4 class="modal-title fw-bold" id="qtyModalLabel">QUANTITY</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <input type="hidden" class="add__cart-dish-id" data-product-id="<?=$dishes['d_id']?>" value="<?= $dishes['d_id']?>">
                                            <div class="card py-2">
                                                <div class="card-body">
                                                    <div class="add__cart-dish-name-wrap mb-4">
                                                        <h1 class="add__cart-dish-name"><?=$dishes['title']?></h1>
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
                                                $check_stock = mysqli_query($db, "SELECT d_stock FROM dishes WHERE d_id='".$dishes['d_id']."'");
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
                                            <input type="submit" name="submit" class="c-btn-3 add_cart_btn" data-action-id="add_cart" data-dish-id="<?= $dishes['d_id']?>" value="Add to Cart" data-bs-dismiss="modal">
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
                <span class="alert alert-danger fw-bold text-center d-flex justify-content-center align-items-center mb-0">NO MENU AVAILABLE</span>
                <?php
                }
                ?>
            <?php
            } else {
            ?>
            <span class="alert alert-danger d-flex align-items-center justify-content-center fw-bold text-center text-uppercase"><?=$_GET['canteen']?> IS CLOSE.</span>
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
                        url: "get_cart.php",
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
</script>