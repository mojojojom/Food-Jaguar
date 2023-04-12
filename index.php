<?php
    include("connection/connect.php");  
    error_reporting(0);  
    session_start();
    include('header.php');
?>

    <!-- BANNER SECTION -->
    <section class="h__banner-wrap">
        <div class="container h-100 d-flex align-items-center">
            <div class="h__banner-content-wrap text-center">
                <h1 class="h__banner-heading p-font">
                    WELCOME TO                         
                    <?php 
                        $site_name = mysqli_query($db, "SELECT site_name FROM site_settings"); 
                        $sn = mysqli_fetch_assoc($site_name);
                    ?>
                    <?=$sn['site_name']?>!
                </h1>
                <p class="h__banner-sub-heading s-font">
                    <?php
                    $site_tag = mysqli_query($db, "SELECT site_tag FROM site_settings");
                    $st = mysqli_fetch_assoc($site_tag);
                    ?>
                    <?=$st['site_tag']?>
                </p>
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
                            <h1 class="h__about-content-heading p-font ls-1 mb-0">
                            <?php 
                                $site_name = mysqli_query($db, "SELECT site_name FROM site_settings"); 
                                $sn = mysqli_fetch_assoc($site_name);
                            ?>
                            <?=$sn['site_name']?>
                            </h1>
                            <p class="h__about-content-desc s-font mb-4">
                            <?php 
                                $site_desc = mysqli_query($db, "SELECT site_about FROM site_settings"); 
                                $sd = mysqli_fetch_assoc($site_desc);
                            ?>
                            <?=$sd['site_about']?>
                            </p>
                            <a href="about" class="c-btn-3 h__about-content-btn">LEARN MORE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <?php
            $fetch_canteens = mysqli_query($db, "SELECT * FROM canteen_table WHERE c_verify = 'Yes'");
            if(mysqli_num_rows($fetch_canteens) > 0) {
        ?>
    <!-- CANTEENS SECTION -->
    <section class="h__canteens-wrap sec-pad">
        <div class="container">
            <p class="h__menu-sub-heading mb-0 ls-1 p-font text-center">JAGUAR'S PARTNERS</p>
            <h1 class="fw-bold text-center mb-4">Our Canteens</h1>
            <div id="canteen_slick" class="h__canteens-slider-wrap">
                <?php
                while($canteen = mysqli_fetch_assoc($fetch_canteens)) {
                ?>
                
                <a href="canteen.php?id=<?=$canteen['id']?>&canteen=<?=$canteen['canteen_name']?>" data-id="<?=$canteen['id']?>" class="card h__canteens-inner-wrap mx-1 shadow-sm">
                    <div class="h__canteens-bg-img"></div>
                    <div class="card-body text-center h-100 d-flex align-items-center justify-content-center position-relative">
                        <?php
                        if($canteen['c_status'] == '0') {
                        ?>
                        <span class="badge bg-danger position-absolute" style="top: 10px; right: 10px;">CLOSE</span>
                        <?php
                        } else {
                        ?>
                        <span class="badge bg-success position-absolute" style="top: 10px; right: 10px;">OPEN</span>
                        <?php
                        }
                        ?>
                        <h4 class="mb-0 p-2"><?=$canteen['canteen_name']?></h4>
                    </div>
                </a>

                <?php
                }
                ?>
            </div>
        </div>
    </section>
        <?php
            }
        ?>

    
    <!-- SPECIAL MENU SECTION -->
    <section class="h__menu-wrap sec-pad" id="menu">
        <div class="container">
            <div class="h__menu-content-wrap">
                <div class="h__menu-heading-wrap">
                    <p class="h__menu-sub-heading mb-0 ls-1 p-font">JAGUAR'S BEST</p>
                    <h1 class="h__menu-heading s-font">Our Best Sellers</h1>
                </div>
                <div class="h__menu-divider-wrap pb-4">
                    <span class="h__menu-divider"></span>
                </div>
                <div class="h__menu-list-wrap">
                    <div class="row d-flex justify-content-center best-food-list">

                        <?php
                            $get_site_setting = mysqli_query($db, "SELECT * FROM site_settings");
                            $fj_site = mysqli_fetch_assoc($get_site_setting);
                            // GET THE CATEGROY
                            $display_cat = $fj_site['site_best'];
                            $get_cats = mysqli_query($db, "SELECT * FROM food_category WHERE f_catname = '$display_cat'");
                            $cat = mysqli_fetch_assoc($get_cats);
                            $chosen_cat = $cat['f_catid'];
                            // GET THE DISHES
                            $get_dishes = mysqli_query($db, "SELECT dishes.*, canteen_table.id AS canteen_id, canteen_table.canteen_name FROM dishes INNER JOIN canteen_table ON dishes.c_id = canteen_table.id WHERE canteen_table.c_status = '1' AND dishes.d_status = 'Post' AND rs_id = '$chosen_cat' LIMIT 8");
                            if(mysqli_num_rows($get_dishes) > 0)
                            {
                                while($row = mysqli_fetch_array($get_dishes))
                                {
                                    $cname = $row['canteen_name'];
                                    $cid = $row['canteen_id'];
                        ?>

                                    <!-- DISH CARD -->
                                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 home-food-item mb-3">
                                        <div class="h__menu-list-box card">

                                            <div class="card-body">
                                                <!-- TITLE -->
                                                <div class="h__menu-list-box-name-wrap text-center">
                                                    <h1 class="h__menu-list-box-name"><?=$row['title']?></h1>
                                                </div>

                                                <!-- IMAGE -->
                                                <div class="h__menu-list-box-img-wrap">
                                                    <img src="admin/Res_img/dishes/<?=$row['img']?>" alt="Menu" class="h__menu-list-box-img">
                                                </div>

                                                <!-- ADD TO CART BUTTON -->
                                                <input type="hidden" class="m__menu-qty" id="menu_qty" type="number" name="quantity"  value="1" size="2" />
                                                <div class="h__menu-list-btn-wrap d-flex align-items-center justify-content-center gap-2 mt-3">
                                                    <button href="#qtyModal<?=htmlentities($row['d_id'])?>" class="h__menu-list-btn addCartBtn" data-bs-toggle="modal" data-bs-target="#qtyModal<?=htmlentities($row['d_id'])?>">ADD TO CART</button>
                                                    <div class="h__menu-list-fave-wrap">
                                                        <?php
                                                            if(isset($_SESSION['user_id'])) 
                                                            {
                                                                $check_fave = mysqli_query($db, "SELECT * FROM fave_table WHERE d_id = '".$row['d_id']."' AND u_id = '".$_SESSION['user_id']."'");
                                                                if(mysqli_num_rows($check_fave) > 0) 
                                                                {
                                                        ?>
                                                                    <a href="#" class="h__menu-list-fave-btn fave_btn active" data-canteen="<?=$row['c_id']?>" data-item="<?=$row['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart text-danger"></i></a>
                                                        <?php
                                                                } 
                                                                else 
                                                                {
                                                        ?>
                                                                    <a href="#" class="h__menu-list-fave-btn fave_btn" data-canteen="<?=$row['c_id']?>" data-item="<?=$row['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                                                        <?php
                                                                }
                                                            } 
                                                            else 
                                                            {
                                                        ?>
                                                                <a href="#" class="h__menu-list-fave-btn fave_btn" data-canteen="<?=$row['c_id']?>" data-item="<?=$row['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="/canteen.php?id=<?=$cid?>&canteen=<?=$cname?>" class="menu__canteen-name-wrap">
                                                <span class="menu__canteen-name">
                                                    <?=$cname?>
                                                </span>
                                            </a>

                                        </div>
                                    </div>

                                    <!-- QUANTITY MODAL -->
                                    <div class="modal fade quantity_modal-<?=htmlentities($row['d_id'])?>" id="qtyModal<?=htmlentities($row['d_id'])?>" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <form id="menu_form">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title fw-bold" id="qtyModalLabel">QUANTITY</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body py-4">
                                                        <input type="hidden" class="add__cart-dish-id" data-product-id="<?=$row['d_id']?>" value="<?= $row['d_id']?>">
                                                        <div class="card py-2">
                                                            <div class="card-body">
                                                                <div class="add__cart-dish-name-wrap mb-4">
                                                                    <h1 class="add__cart-dish-name"><?=$row['title']?></h1>
                                                                    <h5 class="fw-bold text-center"><?=$row['price']?>/order</h5>
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
                                                            $check_stock = mysqli_query($db, "SELECT d_stock FROM dishes WHERE d_id='".$row['d_id']."'");
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
                                                        <input type="submit" name="submit" class="c-btn-3 add_cart_btn" data-action-id="add_cart" data-dish-id="<?= $row['d_id']?>" value="Add to Cart" data-bs-dismiss="modal">
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
                            }
                            else
                            {
                        ?>
                                <span class="alert alert-danger d-flex align-items-center justify-content-center fw-bold text-center">NO AVAILABLE DISHES</span>
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

    <!-- TESTIMONIAL SECTION -->
    <section class="h__testi-wrap sec-pad">
        <!-- <img class="accent_img" src="/images/footer_pattern.png" alt="">
        <img class="accent_img-2" src="/images/city.png" alt=""> -->
        <div class="container">
            <div class="row">

                <div class="col-lg-6 d-flex align-items-center mb-5 mb-lg-0">
                    <div class="h__testi-headings-wrap text-center text-lg-start">
                        <h1 class="fw-bold">Our Customers Love What We Make</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sint necessitatibus facilis odio eos. Necessitatibus debitis at tempore cum nemo iusto est beatae quae, accusamus voluptate voluptatum sit cumque atque?</p>
                        <a href="#testiModal" class="c-btn-3 d-inline-flex" data-bs-toggle="modal" data-bs-target="#testiModal">ADD REVIEW</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    
                    <div class="testimonial-slider">

                        <?php
                            $get_reviews = mysqli_query($db, "SELECT * FROM user_testimonials INNER JOIN users ON user_testimonials.u_id = users.u_id WHERE user_testimonials.testi_approval = 'Yes'");
                            if(mysqli_num_rows($get_reviews) > 0) {
                                while($testi = mysqli_fetch_assoc($get_reviews)) {
                                    $fullname = $testi['f_name']. ' ' .$testi['l_name'];
                        ?>
                                    <div class="h__testi-inner-wrap my-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="h__testi-img-wrap">
                                                    <i class="fa-solid fa-quote-left"></i>
                                                </div>
                                                <div class="h__testi-info-wrap">
                                                    <p class="mb-2 mt-2"><?=$testi['u_testi']?></p>
                                                    <h5><?=$fullname?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            } else {
                                echo '<span class=" alert alert-danger d-flex align-items-center justify-content-center fw-bold">NO REVIEWS FOUND</span>';
                            }
                        ?>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ADD REVIEW MODAL -->
    <div class="modal fade" id="testiModal" tabindex="-1" aria-labelledby="testiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="testi_form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="testiModalLabel">CREATE REVIEW</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="fj-input-wrap">
                            <label for="review">Your Review</label>
                            <textarea class="fj-input testi_review" name="review" rows="5" maxlength = "300" required></textarea>
                            <p class="mb-0">Characters remaining: <span id="char-count">300</span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="add_testi">
                        <button type="submit" class="c-btn-3 c-btn-sm">POST</button>
                        <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ADD CANTEEN PROMO SECTION -->
    <section class="h__canteen-wrap sec-pad">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center text-center">
                <div class="h__canteen-inner-wrap">
                    <h1 class="mb-2 fw-bold">Do you own a Canteen?</h1>
                    <?php
                        $get_site = mysqli_query($db, "SELECT * FROM site_settings");
                        while ($row = mysqli_fetch_array($get_site))
                        {
                            $site_email = $row['site_email'];
                            $site_phone = $row['site_phone'];
                        }
                    ?>
                    <h5 class="mb-4" style="line-height: 1.5em;">Let us know by Emailing us at <a href="maito:<?=$site_email?>" class="t-secondary text-decoration-underline"><?=$site_email?></a> ,<br> Call us at <a href="tel:<?=$site_phone?>" class="t-secondary text-decoration-underline"><?=$site_phone?></a> or Register your canteen now!</h5>
                    <a href="#addCanteenModal" class="c-btn-sm c-btn-4" data-bs-toggle="modal" data-bs-target="#addCanteenModal">REGISTER NOW</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ADD CANTEEN MODAL -->
    <div class="modal fade" id="addCanteenModal" tabindex="-1" aria-labelledby="addCanteenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="canteen_form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="addCanteenModalLabel">ADD CANTEEN</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="c_name">Canteen Name</label>
                                    <input type="text" class="fj-input" name="c_name" placeholder="Enter your canteen name" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="c_name">Canteen Owner's Name</label>
                                    <input type="text" class="fj-input" name="c_owner_name" placeholder="Enter canteen owner's name" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="c_contact">Contact Number</label>
                                    <input type="number" class="fj-input" name="c_contact" placeholder="Enter contact number" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="c_email">Email</label>
                                    <input type="email" class="fj-input" name="c_email" placeholder="Enter email" required>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="c_address">Address/Location</label>
                                    <textarea class="fj-input" rows="3" name="c_address" placeholder="Enter canteen address/location" required></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="add_canteen">
                        <button type="submit" class="c-btn-3 c-btn-sm">REGISTER</button>
                        <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
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

        // ADD TO CART
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

        // SLIDERS AND SOME OTHER FUNCTIONS
        $(document).ready(function(){
            // CANTEEN SLIDER
            $('#canteen_slick').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 0,
                dots: false,
                arrows: false,
                infinite: true,
                speed: 5000,
                fade: false,
                cssEase: 'linear',
                pauseOnHover: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            // TESTIMONIAL SLIDER
            $('.testimonial-slider').slick({
                vertical: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 3000,
                easing: 'linear',
                pauseOnHover: true,
                nextArrow: '<i class="fa-solid fa-circle-up custom-next"></i>',
                prevArrow: '<i class="fa-solid fa-circle-down custom-prev"></i>',
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            vertical: false,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            // ADD TESTI 
            $('#testi_form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "add_cart.php",
                    data: formData,
                    success: function (response) {
                        if(response == 'success') 
                        {
                            $('#testiModal').modal('hide');
                            $('.testi_review').val('');
                            Swal.fire(
                                'Thank You!',
                                'Your Submission Has Been Sent.',
                                'success'
                            );

                            $.ajax({
                                type: "GET",
                                url: "get_testi.php",
                                success: function (response) {
                                    $('.testimonial-slider').empty().html(response);
                                    $('.testimonial-slider').slick('unslick');
                                    $('.testimonial-slider').slick({
                                        vertical: true,
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                        autoplay: false,
                                        autoplaySpeed: 3000,
                                        easing: 'linear',
                                        pauseOnHover: true,
                                        nextArrow: '<i class="fa-solid fa-circle-up custom-next"></i>',
                                        prevArrow: '<i class="fa-solid fa-circle-down custom-prev"></i>'
                                    });
                                }
                            });

                        } 
                        else if(response == 'error_login')
                        {
                            let timerInterval
                            Swal.fire({
                            title: 'Unable To Add Review!',
                            html: 'Please Login Before Adding Review!<br><b class="text-danger">Redirecting You To Login Form.</b><br>Please Wait.',
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
                        else if(response == 'error_exists')
                        {
                            Swal.fire(
                                'Unable to Add Review!',
                                'You already made a review!',
                                'info'
                            );
                        }
                        else 
                        {
                            // alert(response);
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable to Add Review',
                                'error'
                            );
                        }
                    }
                });

            })

            // CHARACTER LIMIT
            $('.testi_review').on('input', function() {
                var charCount = 300 - $(this).val().length;
                $('#char-count').html(charCount);
            })

            // ADD CANTEEN
            $('#canteen_form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "add_cart.php",
                    data: formData,
                    success: function (response) {
                        if(response == 'success') {
                            Swal.fire(
                                'Registration Successful!',
                                'We\'ll send you an email once your registration has been verified.',
                                'success'
                            );
                            $('#addCanteenModal').modal('toggle');
                        } 
                        else if(response == 'err_exists') {
                            Swal.fire(
                                'Registration Failed!',
                                'This Canteen Is Already Registered',
                                'error'
                            );
                        }
                        else {    
                            // alert(response);
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable to Register Canteen',
                                'error'
                            );
                        }
                    }
                });

            })

        });

        // DISPLAY 8 ITEMS ONLY
        $(document).ready(function () {
            var items = $('.home-food-list .home-food-item');
            items.slice(8).hide();
        });

    })
</script>