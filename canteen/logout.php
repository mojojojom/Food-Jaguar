<?php
    session_start();
    include('../connection/connect.php');
    $change_status = mysqli_query($db, "UPDATE canteen_table SET c_status = '0' WHERE id='".$_SESSION['canteen_id']."'");
    if($change_status) {
        session_destroy();
        $url = '../admin/index';
        header('Location: ' . $url);
    } else {
        echo 'Error: '.mysqli_error($db);
    }
?>