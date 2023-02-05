<?php
    include('connection/connect.php');
    $get_reviews = mysqli_query($db, "SELECT * FROM user_testimonials INNER JOIN users ON user_testimonials.u_id = users.u_id");
    if(mysqli_num_rows($get_reviews) > 0) {
        while($testi = mysqli_fetch_assoc($get_reviews)) {
            $fullname = $testi['f_name']. ' ' .$testi['l_name'];
?>
            <div class="h__testi-inner-wrap my-1">
                <div class="card">
                    <div class="card-body">
                        <div class="h__testi-img-wrap">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>
                        <div class="h__testi-info-wrap">
                            <p class="mb-2 mt-2"><?=$testi['u_testi']?></p>
                            <h5><?=$fullname?></h5>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    } else {
        echo '<span class=" alert alert-danger d-flex align-items-center justify-content-center fw-bold">NO REVIEWS FOUND</span>';
    }
?>