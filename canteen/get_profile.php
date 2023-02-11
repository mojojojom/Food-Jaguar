<?php
    session_start();
    include('../connection/connect.php');
    $canteen_profile = mysqli_query($db, "SELECT * FROM canteen_table WHERE id = '".$_SESSION['canteen_id']."'");
    $row = mysqli_fetch_array($canteen_profile);
?>
<div class="row">
    <div class="fj-input-wrap col-md-6 mb-3">
        <label for="name">Canteen Name</label>
        <div class="fj-input"><?=$row['canteen_name']?></div>
    </div>
    <div class="fj-input-wrap col-md-6 mb-3">
        <label for="owner">Canteen Owner/Manager</label>
        <div class="fj-input"><?=$row['c_oname']?></div>
    </div>
    <div class="fj-input-wrap col-md-6 mb-3">
        <label for="email">Canteen Email</label>
        <div class="fj-input"><?=$row['c_email']?></div>
    </div>
    <div class="fj-input-wrap col-md-6 mb-3">
        <label for="phone">Canteen Phone</label>
        <div class="fj-input"><?=$row['c_phone']?></div>
    </div>
    <div class="fj-input-wrap col mb-3">
        <label for="address">Canteen Address/Location</label>
        <div class="fj-input"><?=$row['c_address']?></div>
    </div>
</div>