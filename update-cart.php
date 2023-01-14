<?php
session_start();
$itemId = $_POST['itemId'];
$checked = $_POST['checked'];

foreach ($_SESSION['cart_item'] as $key => $value) {
    if($value['id'] == $itemId) {
        $_SESSION['cart_item'][$key]['checked'] = $checked;
    }
}