<?php
session_start();
if(empty($_SESSION['cart_item'])) {
?>
<div class="w-100 d-flex align-items-center justify-content-center">
    <span class="alert alert-danger text-center w-100 fw-bold">YOUR CART IS EMPTY!</span>
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
                $cart = $_SESSION['cart_item'];
                foreach($cart as $rows) 
                {
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
    {   $item_total = 0;
        foreach ($_SESSION['cart_item'] as $item) 
        {
            $item_total = $item['quantity']*$item['price'];
?>
        <!-- CART -->
        <div id="cart-items-product-<?=$item['d_id']?>-<?=$item['title']?>" class="cart-items-product" data-product-id="<?=$item['d_id']?>">
            <div class="card mb-2 product-card-wrap">
                <div class="card-body">
                    <div class="cart__item-wrap">
                        <label for="cart-checkbox<?=$item['d_id']?>-<?=$item['title']?>">
                            <div class="cart__item-checkbox-wrap">
                                <input type="checkbox" id="cart__item-checkbox<?=$item['d_id']?>-<?=$item['title']?>" class="cart__item-checkbox" data-id="<?=$item['d_id']?>">
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