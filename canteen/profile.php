<?php
    include("../connection/connect.php");
    error_reporting(0);
    session_start();
    if(empty($_SESSION["canteen_id"])) 
    {
        header('location: ../admin/index');
    }
    else
    {
        $query = mysqli_query($db, "SELECT * FROM canteen_table WHERE id='".$_SESSION['canteen_id']."'");
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
                    <li><a class="dropdown-item active" href="profile">Profile</a></li>
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
                    <?=$row['c_user']?>
                </div>
            </nav>
        </div>

        <!-- CONTENT -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 fw-bold">Profile</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Canteen's Profile</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>

                    <!-- FORM -->
                    <div class="card" id="profile_card">
                        <?php
                            $canteen_profile = mysqli_query($db, "SELECT * FROM canteen_table WHERE id = '".$_SESSION['canteen_id']."'");
                            $row = mysqli_fetch_array($canteen_profile);
                        ?>
                        <div class="card-header bg-unset d-flex align-items-center justify-content-between">
                            <h4 class="fw-bold text-uppercase mb-0"><?=$row['canteen_name']?>'S PROFILE</h4>
                            <input type="button" class="c-btn-sm c-btn-3 open_form" value="EDIT PROFILE">
                        </div>

                        <div class="card-body profile_view">
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
                        </div>

                        <div class="card-body profile_edit">
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
                        </div>

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

<?php
        }
    }
    include('footer.php');
?>

    <!-- PAGE TITLE -->
    <script>
        document.title = "Canteen Profile | Food Jaguar"
    </script>

<script>
    jQuery(function($) {
        $(document).ready(function () {
            $('.profile_edit').hide();
            $('#profile_card').on('click', '.open_form', function() {
                $(this).hide();
                $('.profile_view').hide();
                $('.profile_edit').show();
            })
            $('.cancel_btn').on('click', function() {
                $('.profile_view').show();
                $('.profile_edit').hide();
                $('.open_form').show();
            })

            $('.profile_edit').on('submit', '#edit_profile', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "../admin/action.php",
                    data: formData,
                    success: function (response) {
                        if(response == 'success') {
                            
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Profile Has Been Edited!'
                            })

                            $('.profile_view').show();
                            $('.profile_edit').hide();
                            $('.open_form').show();

                            // UPDATE PROFLE
                            $.ajax({
                                type: "GET",
                                url: "get_profile.php",
                                success: function (response) {
                                    $('.profile_view').empty().html(response);
                                }
                            });

                            // UPDATE FORMS
                            $.ajax({
                                type: "GET",
                                url: "get_profile_form.php",
                                success: function (response) {
                                    $('.profile_edit').empty().html(response);
                                }
                            });

                        } else if(response == 'err_update') {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable To Edit Profile.',
                                'error'
                            );
                        } else {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable To Edit Profile.',
                                'error'
                            );
                        }
                    }
                })

            })

        })
    })
</script>