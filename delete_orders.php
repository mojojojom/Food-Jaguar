<?php
    include("connection/connect.php"); // DATABASE CONNECTION
    error_reporting(0);
    session_start();

    // SENDING QUERY
    mysqli_query($db,"DELETE FROM users_orders WHERE o_id = '".$_GET['order_del']."'"); 
    header("location:your_orders"); 
?>
