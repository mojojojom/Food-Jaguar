<?php
    session_start();
    session_destroy();
    $url = 'index';
    header('Location: ' . $url);
?>