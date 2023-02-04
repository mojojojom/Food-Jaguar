<?php
    include('../connection/connect.php');
    $get_users = mysqli_query($db, "SELECT * FROM users ORDER BY u_id desc");
    $count = 1;
    if(mysqli_num_rows($get_users) > 0) {
        while($rows = mysqli_fetch_array($get_users)){
            $fullname = $rows['f_name'] . " " . $rows["l_name"];
?>
<div class="modal-header">
    <h1 class="modal-title fs-5 fw-bold" id="viewModalLabel">VIEW USER</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <?php
        $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id='".$rows['u_id']."'");
        $fetch = mysqli_fetch_array($get_user);
        $full_name = $fetch['f_name'].' '.$fetch['l_name'];
    ?>
    <div class="row">
        <div class="col-6 mb-3 fj-input-wrap">
            <label for="name">Name</label>
            <div class="fj-input cursor-default"><?=$full_name?></div>
        </div>
        <div class="col-6 mb-3 fj-input-wrap">
            <label for="name">Username</label>
            <div class="fj-input cursor-default"><?=$fetch['username']?></div>
        </div>
        <div class="col-6 mb-3 fj-input-wrap">
            <label for="name">Phone Number</label>
            <div class="fj-input cursor-default"><?=$fetch['phone']?></div>
        </div>
        <div class="col-6 mb-3 fj-input-wrap">
            <label for="name">Verification Status</label>
            <?php
            if($fetch['u_verify'] == 'Yes') {
            ?>
            <div class="fj-input cursor-default bg-success text-light">Verified</div>
            <?php
            } else {
            ?>
            <div class="fj-input cursor-default bg-danger text-light">Not Verified</div>
            <?php
            }
            ?>
        </div>
        <div class="col-12 mb-3">
            <label for="address">Address</label>
            <div class="fj-input"><?=$fetch['address']?></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="c-btn-3 c-btn-sm" data-bs-dismiss="modal">Close</button>
</div>
<?php
        }
    }
?>