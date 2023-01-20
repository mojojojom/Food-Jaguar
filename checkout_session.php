<?php
session_start();
if(empty($_SESSION['check_cart_item'])) {
    echo 'empty';
} else {
    echo 'success';
}
?>