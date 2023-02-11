<?php
    session_start();
    include('../connection/connect.php');
    $get_testi = mysqli_query($db, "SELECT * FROM user_testimonials INNER JOIN users ON user_testimonials.u_id = users.u_id");
    if(mysqli_num_rows($get_testi) > 0) {
        while($testi = mysqli_fetch_assoc($get_testi)) {
            $id = $testi['u_id'];
            $get_review = mysqli_query($db, "SELECT substring(u_testi, 1 , 50) as excerpt FROM user_testimonials WHERE u_id='$id'");
            $review = mysqli_fetch_array($get_review);
?>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    
                    <?php
                        if($testi['testi_approval'] == 'Yes') {
                    ?>
                            <div class="card-header bg-success d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 text-white"><?=$testi['username']?></h6>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="#" class="testi_reset" data-id="<?=$testi['u_id']?>"><i class="fa-solid fa-rotate-right text-white"></i></a>
                                    <a href="#" class="testi_delete" data-id="<?=$testi['u_id']?>"><i class="fa-solid fa-xmark text-white"></i></a>
                                </div>
                            </div>
                    <?php
                        } else {
                    ?>
                            <div class="card-header bg-danger d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 text-white"><?=$testi['username']?></h6>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="#" class="testi_approved" data-id="<?=$testi['u_id']?>"><i class="fa-solid fa-check text-white"></i></a>
                                    <a href="#" class="testi_delete" data-id="<?=$testi['u_id']?>"><i class="fa-solid fa-xmark text-white"></i></a>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                    <div class="card-body">
                        <p class="mb-0" style="min-height: 50px;"><?=$review['excerpt']?>... <a href="readMoreModal<?=$testi['u_id']?>" class="text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#readMoreModal<?=$testi['u_id']?>" style="font-size: 12px;">READ MORE</a></p>
                    </div>
                </div>
            </div>


            <!-- READ MORE MODAL -->
            <div class="modal fade" id="readMoreModal<?=$testi['u_id']?>" tabindex="-1" aria-labelledby="readMoreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="readMoreModalLabel"><?=$testi['username']?>'s Review</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0"><?=$testi['u_testi']?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

<?php
        }
    } else {
?>
    <span class="alert alert-danger d-flex align-items-center justify-content-center fw-bold">NO USER REVIEWS AVAILABLE</span>
<?php
    }
?>