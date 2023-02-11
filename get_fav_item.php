<?php
    session_start();
    include('connection/connect.php');
    $menu = mysqli_query($db, "SELECT * FROM dishes");
    while($rows=mysqli_fetch_array($menu))
    {
        $query = mysqli_query($db, 'SELECT * FROM food_category WHERE f_catid="'.$rows['rs_id'].'"');
        $product = mysqli_fetch_array($query);

        $check_stock = mysqli_query($db, "SELECT d_stock FROM dishes WHERE d_id='".$rows['d_id']."'");
        while($get_stock = mysqli_fetch_array($check_stock)) {
            $stocks = $get_stock['d_stock'];
        }
?>

<div class="col-12 col-sm-12 col-md- 12 col-lg-6 all <?=$product['f_catname']?>">

    <form id="menu_form" method="POST">
        <div class="m__menu-list-card">
            <input type="hidden" name="dish_id" data-product-id="<?=$rows['d_id']?>" value="<?= $rows['d_id']?>">

            <div class="m__menu-list-name-wrap">
                <img class="m__menu-list-img" src="admin/Res_img/dishes/<?=$rows['img']?>" alt="">
                <div>
                    <h1 class="m__menu-list-name s-font"><?=$rows['title']?></h1>
                    <h1 class="m__menu-price s-font">₱<?=$rows['price']?></h1>
                </div>
            </div>

            <div class="m__menu-price-wrap text-end">
                <div class="m__menu-fav-wrap">
                    <?php
                        if(isset($_SESSION['user_id'])) {
                            $check_fave = mysqli_query($db, "SELECT * FROM fave_table WHERE d_id = '".$rows['d_id']."' AND u_id = '".$_SESSION['user_id']."'");
                            if(mysqli_num_rows($check_fave) > 0) {
                    ?>
                            <a href="#" class="m__menu-fav fave_btn active" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart text-danger"></i></a>
                    <?php
                            } else {
                    ?>
                            <a href="#" class="m__menu-fav fave_btn" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                    <?php
                            }
                        } else {
                    ?>
                            <a href="#" class="m__menu-fav fave_btn" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                    <?php
                        }
                    ?>
                </div>
                <div class="m__menu-qty-wrap">
                    <p class="m__menu-qty-name mb-0 me-2">Qty: </p>
                    <input class="m__menu-qty" type="number" data-product-qty="quantity" name="quantity" size="2" min="1" value="1" placeholder="1" required/>
                </div>
                <div class="m__menu-cart-wrap text-center">
                <?php
                    if($stocks <= 0) {
                ?>
                <input type="button" class="c-btn-3 c-btn-sm addCartBtn add_cart_btn disabled" disabled value="UNAVAILABLE" />
                <?php
                    } else {
                ?>
                    <input type="hidden" name="action" value="add_cart">
                    <input type="submit" class=" c-btn-3 c-btn-sm addCartBtn add_cart_btn" name="submit" data-action-id="add_cart" data-dish-id="<?= $rows['d_id']?>" value="Add To Cart" />
                <?php
                    }
                ?>
                </div>
            </div>

        </div>
    </form>

</div>

<?php
    }
?>