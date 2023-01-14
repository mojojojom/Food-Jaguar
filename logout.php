<?php
    session_start(); 
    session_unset();
    session_destroy(); 
    $url = 'login';
    header('Location: ' . $url); 
?>