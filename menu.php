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
                <p class="fj__banner-sub-heading s-font">Check Out</p>
                <h1 class="fj__banner-heading s-font">OUR MENU</h1>
            </div>
        </div>
    </section>

    <!-- MENU SECTION -->
    <section class="m__menu-wrap sec-pad">
        <div class="container">

            <div class="m__menu-header-wrap">
                <div class="m__menu-heading-wrap">
                    <h1 class="m__menu-heading mb-0">Taste the best!</h1>
                </div>
                <div class="m__menu-header-cart-wrap">
                    <a href="#cartModal" type="button" class="c-btn-3 m__menu-header-cart position-relative p-font" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fa-solid fa-cart-shopping"></i>
                        <span id="cart_num" class="cart_num position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="m__menu-content-wrap">

                <div class="m__menu-cat-wrap">
                    <div class="m__menu-filter-wrap">
                        <nav class="primary">
                            <ul class="m__menu-filter-list">
                                <li class="py-4 m__menu-filter-item"><a href="#" class="selected m__menu-filter-link" data-filter="*">all</a> </li>
                                <?php 
                                $food= mysqli_query($db,"select * from food_category");
                                    while($row=mysqli_fetch_array($food))
                                    {
                                        echo '<li class="py-4 m__menu-filter-item"><a href="#" class="m__menu-filter-link" data-filter=".'.$row['f_catname'].'"> '.$row['f_catname'].'</a> </li>';
                                    }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="m__menu-list-wrap">

                    <div class="row food-listing">

                    <?php
                        $menu = mysqli_query($db, "SELECT * FROM dishes");
                        while($rows=mysqli_fetch_array($menu))
                        {
                            $query = mysqli_query($db, 'SELECT * FROM food_category WHERE f_catid="'.$rows['rs_id'].'"');
                            $product = mysqli_fetch_array($query);
                    ?>

                        <div class="col-12 col-sm-12 col-md- 12 col-lg-6 all <?=$product['f_catname']?>">

                            <form id="menu_form" method="POST">
                            <!-- <form method="post" action='menu?res_id=<?php echo $_GET['res_id'];?>&action=add&id=<?php echo $rows['d_id']; ?>'> -->
                                <div class="m__menu-list-card">
                                    <input type="hidden" name="cat_id" value="<?= $rows['res_id']?>">
                                    <input type="hidden" name="dish_id" value="<?= $rows['d_id']?>">

                                    <div class="m__menu-list-name-wrap">
                                        <img class="m__menu-list-img" src="admin/Res_img/dishes/<?=$rows['img']?>" alt="">
                                        <div>
                                            <h1 class="m__menu-list-name s-font"><?=$rows['title']?></h1>
                                            <h1 class="m__menu-price s-font">₱<?=$rows['price']?></h1>
                                        </div>
                                    </div>

                                    <div class="m__menu-price-wrap text-end">
                                        <div class="m__menu-qty-wrap">
                                            <p class="m__menu-qty-name mb-0 me-2">Qty: </p>
                                            <input class="m__menu-qty" type="number" name="quantity"  value="1" size="2" min="1"/>
                                        </div>
                                        <div class="m__menu-cart-wrap text-center">
                                            <input type="hidden" name="action" value="add_cart">
                                            <!-- <input type="hidden" name="action" value="add"> -->
                                            <input type="submit" class="m__menu-cart-btn addCartBtn" name="submit" data-action-id="add_cart" data-dish-id="<?= $rows['d_id']?>" value="Add To Cart" />
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    <?php
                        }
                    ?>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <script>
        document.title = "Our Menu | Food Jaguar"
    </script>
<?php
    include('footer.php');
?>

<script>
    // ADD TO CART
    jQuery(function($) {
        $(document).on('submit', '#menu_form', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "add_cart.php",
                data: formData,
                beforeSend: function() {
                    $('input.add_cart_btn').val('Adding to Cart');
                    $('input.add_cart_btn').addClass('disabled');
                    $('input.add_cart_btn').prop('disabled', true);
                },
                success: function (response) {
                    if(response == 'success') 
                    {
                        $('input.add_cart_btn').val('Add to Cart');
                        $('input.add_cart_btn').removeClass('disabled');
                        $('input.add_cart_btn').prop('disabled', false);

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Added to cart!'
                        })
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
                        alert(response);
                    }
                }
            });
        })
    })
</script>