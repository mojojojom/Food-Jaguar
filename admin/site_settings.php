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
                        <a class="nav-link active" href="site_settings">
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
                    <h1 class="mt-4 fw-bold">
                        <?php 
                            $site_name = mysqli_query($db, "SELECT site_name FROM site_settings"); 
                            $sn = mysqli_fetch_assoc($site_name);
                            echo $sn['site_name'];
                        ?>
                    </h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Site Settings</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>


                    <div class="card mb-3">
                        <div class="card-header py-2">
                            <h6 class="fw-bold mb-0">Customize your site</h6>
                        </div>
                        <div class="card-body">

                            <?php
                                $get_site = mysqli_query($db, "SELECT * FROM site_settings");
                                $site = mysqli_fetch_array($get_site)
                            ?>

                            <form action="action.php" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="fj-input-wrap">
                                                    <label for="site_name">Site Name</label>
                                                    <input type="text" name="site_name" class="fj-input" placeholder="Enter your site name" value="<?=$site['site_name']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="fj-input-wrap">
                                                    <label for="site_tag">Site Tagline</label>
                                                    <input type="text" name="site_tag" class="fj-input" placeholder="Enter your site tagline" value="<?=$site['site_tag']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="fj-input-wrap">
                                                    <label for="site_email">Site Email</label>
                                                    <input type="email" name="site_email" class="fj-input" placeholder="Enter your site email" value="<?=$site['site_email']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="fj-input-wrap">
                                                    <label for="site_email">Site Email</label>
                                                    <input type="text" name="site_phone" class="fj-input" placeholder="Enter your site mobile number" value="<?=$site['site_phone']?>" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="fj-input-wrap">
                                                    <label for="site_desc">About Site</label>
                                                    <textarea class="fj-input" name="site_desc" rows="5" placeholder="About your site" required><?=$site['site_about']?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BEST SELLERS SECTION -->
                                        <div class="card">
                                            <div class="card-header py-2">
                                                <h6 class="fw-bold mb-0">Choose what to display as "Best Sellers"</h6>
                                            </div>

                                            <div class="card-body">
                                                <select class="form-select" name="site_best" aria-label="Default select example">
                                                    <option selected><?=$site['site_best']?></option>
                                                    <?php
                                                    $get_cats = mysqli_query($db, 'SELECT * FROM food_category');
                                                    while($cat = mysqli_fetch_assoc($get_cats))
                                                    {
                                                    ?>
                                                    <option value="<?=$cat['f_catname']?>"><?=$cat['f_catname']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-4 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="site_logo">Site Logo</label>
                                            <?php
                                            if(empty($site['site_logo'])) {
                                            ?>
                                            <input type="file" name="site_logo" class="fj-input mb-3" title="site_logo" placeholder="Select an Image" required>
                                            <?php
                                            } else {
                                            ?>
                                            <input type="file" name="site_logo" class="fj-input mb-3" title="site_logo" placeholder="Select an Image">
                                            <?php
                                            }
                                            ?>
                                            <div class="site_logo-wrap d-flex">
                                                <?php
                                                    if(empty($site['site_logo'])) {
                                                ?>
                                                    <span class="alert alert-danger fw-bold text-center w-100">NO IMAGE AVAILABLE</span>
                                                <?php
                                                    } else {
                                                ?>
                                                    <img class="img-thumbnail" style="height: 150px;" src="./images/<?=$site['site_logo']?>" alt="site_logo">
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <?php
                                    if(mysqli_num_rows($get_site) > 0) {
                                ?>
                                    <div class="col-12 site_btn-wrap">
                                        <input type="hidden" name="action" value="save_setting">
                                        <button class="c-btn-sm c-btn-3" type="submit">Save Settings</button>
                                    </div>
                                <?php
                                    } else {
                                ?>
                                    <div class="col-12 site_btn-wrap">
                                        <input type="hidden" name="action" value="add_setting">
                                        <button class="c-btn-sm c-btn-3" type="submit">Save Settings</button>
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
        document.title = "Site Settings | Food Jaguar"
    </script>

<?php
        }
    }
    include('footer.php');
?>