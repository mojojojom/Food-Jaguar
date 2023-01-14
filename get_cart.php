<?php
session_start();
if(!empty($_SESSION['cart_item'])) {
    $cart_items = $_SESSION['cart_item'];
    foreach($cart_items as $item) {
        $item_total = $item['quantity']*$item['price'];
?>
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
} else {
    echo '<div class="w-100 d-flex align-items-center justify-content-center"><span class="alert alert-danger text-center w-100 fw-bold">YOUR CART IS EMPTY!</span></div>';
}