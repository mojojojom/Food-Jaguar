<?php
    session_start();
    include('../connection/connect.php');
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
        $change_status = mysqli_query($db, "UPDATE canteen_table SET c_status = '0' WHERE id='".$_SESSION['canteen_id']."'");
        if($change_status) {
            session_unset();
            session_destroy();
            $url = '../admin/index';
            header('Location: ' . $url);
            exit;
        } else {
            echo 'Error: '.mysqli_error($db);
        }
    }

    $_SESSION['last_activity'] = time();
?>