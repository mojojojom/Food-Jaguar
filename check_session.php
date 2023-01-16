<?php
session_start();
if(empty($_SESSION['cart_item'])) {
    echo 'empty';
} else {
    echo 'success';
}
?>