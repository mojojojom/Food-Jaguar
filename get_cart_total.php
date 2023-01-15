<?php
session_start();
$totalPrice = 0;
if(!empty($_SESSION['cart_item'])) {
    $cart_items = $_SESSION['cart_item'];
    foreach ($cart_items as $item) {
        $totalPrice += $item['quantity'] * $item['price'];
    }
}
echo $totalPrice;
?>