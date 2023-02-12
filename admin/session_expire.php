<?php
session_start();
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    session_unset();
    session_destroy();
    header('Location: index');
    exit;
}

$_SESSION['last_activity'] = time();
?>
