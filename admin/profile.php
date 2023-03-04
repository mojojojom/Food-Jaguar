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
                        <a class="nav-link" href="site_settings">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-globe"></i></div>
                            Site
                        </a>
                        <a class="nav-link" href="canteen">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                            Canteen
                        </a>
                        <a class="nav-link" href="reviews">
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
                    <h1 class="mt-4 fw-bold">Profile</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>

                    <!-- PROFILE -->
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" id="edit_admin_profile">

                                <?php
                                $query = mysqli_query($db, "SELECT * FROM admin WHERE adm_id='".$_SESSION['adm_id']."'");
                                while($row = mysqli_fetch_assoc($query)) {
                                ?>

                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="username">Username</label>
                                            <input type="text" class="fj-input admin-user" name="username" disabled="true" value="<?=$row['username']?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="username">Email</label>
                                            <input type="email" class="fj-input admin-email" name="email" disabled="true" value="<?=$row['email']?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="username">Password</label>
                                            <input type="text" class="fj-input admin-pass" name="password" disabled="true" value="" placeholder="********">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-center">
                                            <input type="hidden" name="action" value="admin_edit">
                                            <button class="c-btn-3 c-btn-sm admin_profile-btn"><i class="fa-solid fa-pen-to-square"></i> EDIT</button>
                                            <button type="submit" class="c-btn-3 c-btn-sm admin_profile-save-btn"><i class="fa-solid fa-floppy-disk"></i> SAVE</button>
                                            <button class="c-btn-6 c-btn-sm admin_profile-back-btn"><i class="fa-solid fa-arrow-left-long"></i> BACK</button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>

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

    <script>
        document.title = "Admin Dashboard | Food Jaguar"
    </script>

<?php
        }
    }
    include('footer.php');
?>

<script>
    jQuery(function($) {

        $(document).ready(function () {
            // Hide buttons initially
            $('.admin_profile-save-btn, .admin_profile-back-btn').hide();
            
            // Function to enable/disable input fields and show/hide buttons
            function toggleEdit() {
                $('input.admin-user, input.admin-email, input.admin-pass').prop('disabled', function (i, val) {
                return !val;
                });
                $('.admin_profile-save-btn, .admin_profile-back-btn, .admin_profile-btn').toggle();
                // $('.admin_profile-save-btn').toggle($('input.admin-user, input.admin-email, input.admin-pass').prop('disabled'));
            }

            // Click event handler for the edit button
            $('.admin_profile-btn').click(function(e) {
                e.preventDefault();
                toggleEdit();
            });

            // Click event handler for the back button
            $('.admin_profile-back-btn').click(function(e) {
                e.preventDefault();
                toggleEdit();
            });

            // EDIT FUNCTION
            $('#edit_admin_profile').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: formData,
                    success: function (response) {
                        if(response === 'success')
                        {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Your Profile Has Been Updated!'
                            })
                            setTimeout(toggleEdit(), 1000);
                        }
                        else
                        {
                            alert(response);
                        }
                    }
                });

            })


        });


    })
</script>