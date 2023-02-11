<?php
    session_start();
    include('../connection/connect.php');
    $canteen_profile = mysqli_query($db, "SELECT * FROM canteen_table WHERE id = '".$_SESSION['canteen_id']."'");
    $row = mysqli_fetch_array($canteen_profile);
?>
    <form method="POST" id="edit_profile">
        <div class="row">
            <input type="hidden" name="id" value="<?=$_SESSION['canteen_id']?>">
            <div class="fj-input-wrap col-md-6 mb-3">
                <label for="name">Canteen Name</label>
                <input type="text" name="name" class="fj-input" value="<?=$row['canteen_name']?>">
            </div>
            <div class="fj-input-wrap col-md-6 mb-3">
                <label for="owner">Canteen Owner/Manager</label>
                <input type="text" name="owner" class="fj-input" value="<?=$row['c_oname']?>">
            </div>
            <div class="fj-input-wrap col-md-6 mb-3">
                <label for="username">Canteen Username</label>
                <input type="text" name="username" class="fj-input" value="<?=$row['c_user']?>">
            </div>
            <div class="fj-input-wrap col-md-6 mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="fj-input" value="" placeholder="********">
            </div>
            <div class="fj-input-wrap col-md-6 mb-3">
                <label for="email">Canteen Email</label>
                <input type="email" name="email" class="fj-input" value="<?=$row['c_email']?>">
            </div>
            <div class="fj-input-wrap col-md-6 mb-3">
                <label for="phone">Canteen Phone</label>
                <input type="number" name="phone" class="fj-input" value="<?=$row['c_phone']?>">
            </div>
            <div class="fj-input-wrap col-12 mb-3">
                <label for="address">Canteen Address/Location</label>
                <textarea name="address" rows="3" class="fj-input"><?=$row['c_address']?></textarea>
            </div>
            <div class="text-center col mb-3 d-flex align-items-center justify-content-center gap-2 border-0">
                <input type="hidden" name="action" value="edit_canteen_profile">
                <input type="submit" class="c-btn-sm c-btn-3" value="SAVE">
                <input type="button" class="c-btn-sm c-btn-6 cancel_btn" value="CANCEL">
            </div>
        </div>
    </form>