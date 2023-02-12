<?php
    include("../connection/connect.php");
    error_reporting(0);
    session_start();
    include('session_expire.php');
    if(empty($_SESSION["adm_id"]))
    {
        header('location:index');
    }
    else
    {
        $query = mysqli_query($db, "SELECT * FROM admin WHERE adm_id='".$_SESSION['adm_id']."'");
        while($row = mysqli_fetch_array($query)) {
        include('header.php');
    ?>

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="dashboard"><b>
        <?php 
            $site_name = mysqli_query($db, "SELECT site_name FROM site_settings"); 
            $sn = mysqli_fetch_assoc($site_name);
            echo $sn['site_name'];
        ?>
        </b></a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="hidden" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary d-none" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="profile">Profile</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="site_settings">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-globe"></i></div>
                            Site
                        </a>
                        <a class="nav-link" href="canteen">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                            Canteen
                        </a>
                        <a class="nav-link active" href="reviews">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-quote-left"></i></div>
                            Reviews
                        </a>
                        <div class="sb-sidenav-menu-heading">Log</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Menu
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="all_menu">
                                    All Menu
                                </a>
                                <a class="nav-link" href="add_category">
                                    Add Category
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="all_orders">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Orders
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?=$row['username']?>
                </div>
            </nav>
        </div>

        <!-- CONTENT -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 fw-bold">Reviews</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">User Testimonials</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>

                    <div class="row" id="review_list">

                        <?php
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

                    </div>

                </div>
            </main>

            
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; <b>
                        <?php 
                            $site_name = mysqli_query($db, "SELECT site_name FROM site_settings"); 
                            $sn = mysqli_fetch_assoc($site_name);
                            echo $sn['site_name'];
                        ?>
                        </b> <?= date('Y')?></div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- END OF CONTENT -->

    </div>

    <script>
        document.title = "Site Settings | Food Jaguar"
    </script>

<?php
        }
    }
    include('footer.php');
?>


<script>


jQuery(function($) {
		
    $(document).ready(function() {

        // APPROVE TESTI
        $('body').on('click', '.testi_approved', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "action.php",
                data: {id:id, action: 'approve_testi'},
                success: function (response) {
                    if(response == 'success') {
                        $.ajax({
                            type: "GET",
                            url: "get_reviews.php",
                            success: function (response) {
                                $('#review_list').empty().html(response);
                            }
                        });
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'User Review Has Been Approved!'
                        })
                    } else {
                        Swal.fire(
                            'Something Went Wrong!',
                            'Unable To Approve This Review.',
                            'error'
                        );
                    }
                }
            });
        });

        // DELETE TESTI
        $('body').on('click', '.testi_delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "action.php",
                data: {id:id, action: 'delete_testi'},
                success: function (response) {
                    if(response == 'success') {
                        $.ajax({
                            type: "GET",
                            url: "get_reviews.php",
                            success: function (response) {
                                $('#review_list').empty().html(response);
                            }
                        });
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Review Has Been Deleted!'
                        })
                    } else {
                        Swal.fire(
                            'Something Went Wrong!',
                            'Unable To Delete This Review.',
                            'error'
                        );
                    }
                }
            })
        })

        // RESET TESTI
        $('body').on('click', '.testi_reset', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "action.php",
                data: {id:id, action: 'testi_reset'},
                success: function (response) {
                    if(response == 'success') {
                        $.ajax({
                            type: "GET",
                            url: "get_reviews.php",
                            success: function (response) {
                                $('#review_list').empty().html(response);
                            }
                        });
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Review Approval Has Been Reset!'
                        })
                    } else {
                        Swal.fire(
                            'Something Went Wrong!',
                            'Unable To Reset Approval For This Review.',
                            'error'
                        );
                    }
                }
            });
        });

    })
})


</script>