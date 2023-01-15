<?php
    session_start(); 
    // session_unset();
    // session_destroy(); 
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);
    $url = 'login';
    header('Location: ' . $url); 
?>