<?php
    include("connection/connect.php");  
    error_reporting(0);  
    session_start();
    include('/product-action.php');
    include('header.php');
?>


    <!-- BANNER SECTION -->
    <section class="h__banner-wrap">
        <div class="container h-100 d-flex align-items-center">
            <div class="h__banner-content-wrap text-center">
                <h1 class="h__banner-heading p-font">WELCOME TO FOOD JAGUAR!</h1>
                <p class="h__banner-sub-heading s-font">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad libero accusamus, velit magni cum voluptatum ea repudiandae ipsa voluptates nihil labore enim laborum ullam expedita provident commodi aliquam. Laboriosam, beatae?</p>
                <a href="#menu" class="h__banner-btn c-btn-1 s-font">ORDER NOW</a>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section class="h__about-wrap sec-pad">
        <div class="container">
            <div class="h__about-content-wrap">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 d-flex align-items-center">
                        <div class="h__about-img-wrap">
                            <img src="imgs/about-bg.png" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="h__about-inner-content-wrap">
                            <p class="h__about-content-sub-heading p-font mb-0 ls-1">ABOUT</p>
                            <h1 class="h__about-content-heading p-font ls-1 mb-0">FOOD JAGUAR</h1>
                            <p class="h__about-content-desc s-font mb-4">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis tempora minus vitae officiis harum fugit! Illum facilis in quo eaque dicta asperiores laboriosam provident fugiat accusantium architecto blanditiis, inventore ex!
                            Incidunt quis unde odit harum, quo facilis culpa delectus voluptates ex impedit libero distinctio recusandae itaque ipsum assumenda provident quam, dolorem, numquam cum corporis! Illum eum cum adipisci voluptatem nihil!
                            Quia debitis dolorum itaque molestiae, neque sequi vitae nobis voluptatibus minus omnis iusto corrupti inventore nihil temporibus iure mollitia dolore reprehenderit ab id excepturi autem impedit? Accusantium quis ut incidunt.
                            Illo suscipit magni ratione. Facilis cumque, hic voluptatum quo numquam quis dolor debitis neque, iure necessitatibus officia, ipsum modi aut. Perferendis dicta neque explicabo labore quas autem blanditiis nam! Eos!
                            Reprehenderit dolorum delectus, tempore expedita cum culpa illo non magni quas qui tenetur laboriosam ipsum aut, odio, fugiat sint nobis corrupti repudiandae sed commodi. Culpa officiis consequatur soluta beatae odit?</p>
                            <a href="about" class="c-btn-3 h__about-content-btn">LEARN MORE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SPECIAL MENU SECTION -->
    <section class="h__menu-wrap sec-pad" id="menu">
        <div class="container">
            <div class="h__menu-content-wrap">
                <div class="h__menu-heading-wrap">
                    <p class="h__menu-sub-heading mb-0 ls-1 p-font">JAGUAR'S BEST</p>
                    <h1 class="h__menu-heading s-font">Choose & Enjoy</h1>
                </div>
                <div class="h__menu-divider-wrap pb-4">
                    <span class="h__menu-divider"></span>
                </div>
                <div class="h__menu-list-wrap">
                    <div class="row">
                        <?php
                            $menu = mysqli_query($db, "SELECT * FROM dishes WHERE rs_id = 1 LIMIT 6");
                            while($rows=mysqli_fetch_array($menu))
                            {
                        ?>

                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-4">
                            <div class="h__menu-list-card">
                                <div class="h__menu-card-img-wrap">
                                    <img class="h__menu-card-img" src="admin/Res_img/dishes/<?=$rows['img']?>" alt="Menu">
                                </div>
                                <div class="h__menu-card-inner-wrap p-4">
                                    <div class="h__menu-card-name-wrap">
                                        <h1 class="h__menu-card-name s-font"><?=$rows['title']?></h1>
                                    </div>
                                    <div class="h__menu-card-price-wrap">
                                        <h4 class="h__menu-card-price s-font">₱<?=$rows['price']?></h4>
                                    </div>
                                    <div class="h__menu-card-desc-wrap">
                                        <p class="h__menu-card-desc s-font"><?=$rows['slogan']?></p>
                                    </div>
                                    <input type="hidden" class="m__menu-qty" id="menu_qty" type="number" name="quantity"  value="1" size="2" />
                                    <div class="h__menu-card-btn-wrap">
                                        <button href="#qtyModal<?=htmlentities($rows['d_id'])?>" class="h__menu-card-btn addCartBtn" data-bs-toggle="modal" data-bs-target="#qtyModal<?=htmlentities($rows['d_id'])?>"><i class="fa-solid fa-plus"></i></button>
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
                                                    </div>

                                                    <div class="add__cart-dish-qty-wrap d-block text-center">
                                                        <input class="add__cart-dish-qty pe-0" type="number" data-product-qty="quantity" name="quantity" size="2" min="1" value="1" placeholder="1" required/>
                                                        <p class="mb-0 mt-2">ENTER QUANTITY</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="action" class="add_action" value="add_cart">
                                            <input type="submit" name="submit" class="c-btn-3 add_cart_btn" data-action-id="add_cart" data-dish-id="<?= $rows['d_id']?>" value="Add to Cart">
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <?php
                            }
                        ?>

                    </div>

                    <div class="h__menu-list-btn-wrap pt-5 d-flex justify-content-center">
                        <a href="menu" class="c-btn-2 s-font">VIEW MENU</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <?php
            // if(isset($_SESSION['cart_item'])) {
            //     foreach($_SESSION['cart_item'] as $item) {
            session_start();
            if(isset($_SESSION['check_cart_item'])) {
                foreach($_SESSION['check_cart_item'] as $item) {
        ?>
                <p><?=$item['title']?></p>
                <p><?=$item['d_id']?></p>
                <p><?=$item['quantity']?></p>
                <p><?=$item['price']?></p>
        <?php
                }
            }
        ?>
    </div>

    <script>
        document.title = "Food Jaguar"
    </script>
<?php
    include('footer.php');
?>

<script>
    // ADD TO CART ORIGINAL
    jQuery(function($) {

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
                    $('input.add_cart_btn').val('Adding to Cart');
                    $('input.add_cart_btn').addClass('disabled');
                    $('input.add_cart_btn').prop('disabled', true);
                },
                success: function (response) {
                    if(response == 'success') 
                    {
                        // SECOND SECTION

                        // UPDATE THE CART
                        updateCartItems();

                        // SHOW STATUS
                        $('input.add_cart_btn').val('Add to Cart');
                        $('input.add_cart_btn').removeClass('disabled');
                        $('input.add_cart_btn').prop('disabled', false);
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
                        $('input.add_cart_btn').val('Add to Cart');
                        $('input.add_cart_btn').removeClass('disabled');
                        $('input.add_cart_btn').prop('disabled', false);
                        Swal.fire(
                            'Something Went Wrong!',
                            'Can\'t Add to Cart!',
                            'error'
                        );
                    }
                }
            });
        })
    })


</script>