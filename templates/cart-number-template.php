<?php
session_start();
if(isset($_SESSION['cart_item'])) {
    $count = count($_SESSION['cart_item']);
    echo $count;
} else {
    $count = 0;
    echo $count;
}