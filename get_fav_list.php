<?php
    session_start();
    include('connection/connect.php');
    $get_faves = mysqli_query($db, "SELECT * FROM fave_table INNER JOIN dishes ON fave_table.d_id = dishes.d_id WHERE u_id='".$_SESSION['user_id']."'");

    if(mysqli_num_rows($get_faves) > 0) 
    {
        while($dish = mysqli_fetch_assoc($get_faves)) 
        {
            $check_stock = mysqli_query($db, "SELECT d_stock FROM dishes WHERE d_id='".$dish['d_id']."'");
            while($get_stock = mysqli_fetch_array($check_stock)) {
                $stocks = $get_stock['d_stock'];
            }
?>
<div class="card mb-3 position-relative">
    <form method="post" id="add_cart">
        <div class="row no-gutters p-2">
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <img src="admin/Res_img/dishes/<?=$dish['img']?>" class="card-img img-thumbnail" alt="Product Image">
            </div>
            <div class="col-md-8 ps-0">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="card-body p-0">
                        <a href="#" type="button" class="position-absolute delete_fave" product-id="<?=$dish['d_id']?>" style="right: 10px; top: 10px;"><i class="fa-solid fa-square-xmark text-danger"></i></a>
                        <h6 class="card-title mb-0 fw-bold"><?=$dish['title']?></h6>
                        <p class="card-text mb-0 fw-semibold">₱<?=$dish['price']?></p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fj-input-wrap d-flex align-items-center mb-0 gap-2" style="max-width: 65px">
                                <label for="quantity" style="font-size: 14px;">Qty:</label>
                                <input type="number" class="w-100" id="quantity" style="padding: 0 2px;" data-product-qty="quantity" name="quantity" size="2" min="1" value="1" placeholder="1" required>
                            </div>
                            <?php
                                if($stocks <= 0) {
                            ?>
                                <button type="button" class="c-btn-3 c-btn-sm addCartBtn disabled" disabled style="font-size: 12px;" data-action-id="add_cart" data-dish-id="<?= $dish['d_id']?>"><i class="fa-solid fa-cart-shopping"></i></button>
                            <?php
                                } else {
                            ?>
                                <input type="hidden" name="action" value="add_cart">
                                <button type="submit" class="c-btn-3 c-btn-sm addCartBtn fave_add_cart_btn" style="font-size: 12px;" data-action-id="add_cart" data-dish-id="<?= $dish['d_id']?>"><i class="fa-solid fa-cart-shopping"></i></button>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
        }
    } 
    else 
    {
        echo '<span class="alert alert-danger text-center d-flex align-items-center justify-content-center fw-bold">NO ITEMS IN YOUR FAVORITE</span>';
    }
?>