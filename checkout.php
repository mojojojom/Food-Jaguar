<?php
    include("connection/connect.php");
    error_reporting(0);
    session_start();

    if(empty($_SESSION["user_id"]))
    {
        header('location:login');
    }
    else if(empty($_SESSION['check_cart_item'])) {
        header('Location: menu');
    }
    else{
        foreach ($_SESSION["check_cart_item"] as $item) 
        {
            $dfee = 5;
            $item_fee += ($item["price"]*$item["quantity"]);
            $item_total = $item_fee + $dfee;

            if($_POST['submit'])
            {
                $SQL="INSERT INTO users_orders(u_id,title,quantity,price, mop) VALUES('".$_SESSION["user_id"]."','".$item["title"]."','".$item["quantity"]."','".$item["price"]."','".$_POST["mode"]."')";
                mysqli_query($db,$SQL);

                unset($_SESSION["check_cart_item"]);
                unset($item["title"]);
                unset($item["quantity"]);
                unset($item["price"]);
                header('Location: your_orders');
            }
        }
    // else if(empty($_SESSION['cart_item'])) {
    //     header('Location: menu');
    // }
    // else{
        // foreach ($_SESSION["cart_item"] as $item) 
        // {
        //     $dfee = 5;
        //     $item_fee += ($item["price"]*$item["quantity"]);
        //     $item_total = $item_fee + $dfee;

        //     if($_POST['submit'])
        //     {
        //         $SQL="INSERT INTO users_orders(u_id,title,quantity,price, mop) VALUES('".$_SESSION["user_id"]."','".$item["title"]."','".$item["quantity"]."','".$item["price"]."','".$_POST["mode"]."')";
        //         mysqli_query($db,$SQL);

        //         unset($_SESSION["cart_item"]);
        //         unset($item["title"]);
        //         unset($item["quantity"]);
        //         unset($item["price"]);
        //         header('Location: your_orders');
        //     }
        // }

    include('header.php');
?>

    <!-- BANNER SECTION -->
    <section class="fj__banner-wrap">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <div class="fj__banner-content-wrap text-center">
                <h1 class="fj__banner-heading s-font">CHECK OUT</h1>
            </div>
        </div>
    </section>

    <!-- PAGE WRAPPER -->
    <section class="checkout__wrap sec-pad">

        <div class="container">

            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-8 order-2 order-sm-2 order-md-2 order-lg-1">
                    <div class="checkout__details-wrap">

                        <div class="checkout__order-wrap">
                            <div class="checkout__order-wrap">
                                <p class="checkout__order-heading mb-0 c-title b-b-solid">YOUR ORDERS</p>
                            </div>

                        
                            <?php
                                foreach ($_SESSION["check_cart_item"] as $item)  
                                {
                            ?>	
                            <div class="checkout__cart-wrap b-b-solid">
                                <div class="checkout__cart-name-wrap">
                                    <div class="checkout__cart-img-wrap">
                                        <img class="img-thumbnail" src="admin/Res_img/dishes/<?=$item["img"]?>" alt="">
                                    </div>
                                    <p class="checkout__cart-name mb-0"><?=$item["title"]?></p>
                                </div>
                                <div class="checkout__qty-wrap">
                                    <p class="checkout__qty mb-0"><?=$item["quantity"]?></p>
                                </div>
                                <div class="checkout__price-wrap">
                                    <p class="checkout__price mb-0 fw-bold">₱<?=$item["price"]?></p>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                        <form method="post" action="#">

                            <div class="row">


                                <div class="col-12 col-sm-12 col-md-6">

                                    <p class="checkout__payment-heading c-title mb-0 b-b-solid">PAYMENT DETAILS</p>
                                    
                                    <div class="checkout__mode-wrap">
                                        <div class="checout__mode-option-wrap">
                                            <ul class="list-unstyled d-flex align-items-center justify-content-center mb-0 gap-4">
                                                <li>
                                                    <label class="custom-control custom-radio mb-0 ps-0">
                                                        <input name="mode" type="radio" class="custom-control-input mode__pickup o__order-mode" value="pick-up">
                                                        <span class=""></span> 
                                                        <span class="">Pick Up</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-control custom-radio mb-0 ps-0">
                                                        <input name="mode" type="radio" class="custom-control-input mode__deliver o__order-mode" value="deliver">
                                                        <span class=""></span> 
                                                        <span class="">Deliver</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <hr class="m-0">

                                    <div class="checkout__payment-wrap">

                                        <div class="payment-option">
                                            <ul class=" list-unstyled">
                                                <li>
                                                    <label class="custom-control custom-radio m-b-20 ps-0">
                                                        <input type="hidden" name="m_o_p" value="p_i_s">
                                                        <input name="mop" type="radio" class="custom-control-input p_i_s mop" value="0">
                                                        <span class=""></span> 
                                                        <span class="">Pay in store</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="custom-control custom-radio  m-b-20 ps-0">
                                                        <input type="hidden" name="m_o_p" value="c_o_d">
                                                        <input name="mop" value="<?=$dfee?>" type="radio" class="custom-control-input c_o_d mop"> 
                                                        <span class=""></span> 
                                                        <span class="">Cash on Delivery</span>
                                                    </label>
                                                </li>
                                                <!-- <li>
                                                    <label class="custom-control custom-radio  m-b-10 ps-0">
                                                        <input type="hidden" name="m_o_p" value="g_cash">
                                                        <input name="mop"  type="radio" value="gcash" class="custom-control-input g_cash">
                                                        <span class=""></span> 
                                                        <span class="">Gcash <img src="images/gcash.png" class="rounded" alt="" height="40"></span> 
                                                    </label>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="checkout__total-wrap">
                                    <p class="checkout__payment-heading c-title mb-0 b-b-solid">TOTAL PAYMENT</p>
                                        <div class="checkout-inner">
                                            <div class="subtotal-wrap d-flex align-items-center justify-content-between">
                                                <p class="subtotal-title fw-semibold mb-2">Subtotal</p>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <span class="fw-semibold mb-2">₱</span><input type="text" id="s-total" class="subtotal-num fw-bold mb-2" value="<?=$item_fee?>" disabled>
                                                </div>
                                            </div>
                                            <div class="delivery-wrap d-flex align-items-center justify-content-between">
                                                <p class="delivery-title fw-semibold mb-2">Shipping</p>
                                                
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <span class="fw-semibold mb-2">₱</span><input type="text" id="d-fee" class="delivery-num fw-bold mb-2" value="0" disabled>
                                                </div>
                                            </div>
                                            <div class="total-wrap d-flex align-items-center justify-content-between">
                                                <p class="total-title fw-semibold mb-2 pt-1">Total</p>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <span class="fw-semibold mb-2">₱</span><input type="text" id="total-num" name="total-items" class="total-num fw-bold mb-2" value="0" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="checkout__btn-wrap gap-2">
                                <input type="submit" name="submit"  class="btn checkout__btn disabled" value="CHECKOUT">
                                <a href="menu" class="c-btn-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-4 order-1 order-sm-1 order-md-1 order-lg-2">
                    <div class="checkout__shipping-wrap">
                        <p class="checkout__shipping-heading c-title mb-0 b-b-solid">SHIPPING DETAILS</p>
                        <?php
                            $query = mysqli_query($db, "SELECT * FROM users WHERE u_id='".$_SESSION['user_id']."'");
                            if(mysqli_num_rows($query) > 0) {
                                $row = mysqli_fetch_assoc($query);
                                $fullname = $row['f_name'] . " " . $row['l_name'];
                        ?>
                        <div class="checkout__details-inner-wrap">
                            <p class="checkout__details-title text-capitalize"><span class="checkout__details-title-span">Name : </span><?= $fullname ?></p>
                            <p class="checkout__details-title"><span class="checkout__details-title-span">Email : </span><?= $row['email'] ?></p>
                            <p class="checkout__details-title"><span class="checkout__details-title-span">Phone : </span><?= $row['phone'] ?></p>
                            <p class="checkout__details-title"><span class="checkout__details-title-span">Shipping Address : </span><?= $row['address'] ?></p>
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
        document.title = "Checkout | Food Jaguar"
    </script>

<?php
    include('footer.php');
    }
?>

<script>

    jQuery(function($) {
        $(document).ready(function () {
            const $input = $('#d-fee');
            const $opts = $('input.mop');
            const $tnum = $('input.total-num');
            const $mode_opts = $('input.o__order-mode');

            $('input.c_o_d').attr('disabled', true);
            $('input.p_i_s').attr('disabled', true);
            $('input.g_cash').attr('disabled', true);

            $mode_opts.change(function() {
                const $mode_selected = $(this).val();
                if($mode_selected == 'pick-up') {
                    $('input.c_o_d').attr('disabled', true);
                    $('input.c_o_d').prop('checked', false);
                    $('input.p_i_s').attr('disabled', false);
                    $('input.p_i_s').prop('checked', true);
                    $('input.g_cash').attr('disabled', false);
                    $('input.checkout__btn').removeClass('disabled');
                    $('input.delivery-num').val(0);
                    var a = parseFloat($('input.delivery-num').val()), b = parseFloat($('input.subtotal-num').val());
                    const $total = a + b;
                    $tnum.val($total);
                } else if($mode_selected == 'deliver'){
                    $('input.p_i_s').attr('disabled', true);
                    $('input.p_i_s').prop('checked', false);
                    $('input.c_o_d').attr('disabled', false);
                    $('input.c_o_d').prop('checked', true);
                    $('input.g_cash').attr('disabled', false);
                    $('input.checkout__btn').removeClass('disabled');
                    $('input.delivery-num').val(5);
                    var a = parseFloat($('input.delivery-num').val()), b = parseFloat($('input.subtotal-num').val());
                    const $total = a + b;
                    $tnum.val($total);
                } else {
                    $('input.checkout__btn').addClass('disabled');
                }
            })
        })
    })
</script>