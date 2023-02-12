<?php
    include("../connection/connect.php");
    error_reporting(0);
    session_start();
    include('session_expire.php');
    if(empty($_SESSION["canteen_id"])) 
    {
        header('location: ../admin/index');
    }
    else
    {
        $query = mysqli_query($db, "SELECT * FROM canteen_table WHERE id='".$_SESSION['canteen_id']."'");
        while($row = mysqli_fetch_array($query)) {
        include('header.php');


        // SHIPPING
        if($_POST['action'] == 'set_sfee') {
            $s_fee = $_POST['s_fee'];
            $insert_fee = mysqli_query($db, "INSERT INTO shipping_settings (c_id, s_fee) VALUES ('".$_SESSION['canteen_id']."','$s_fee')");
            if($insert_fee) {
                $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show fw-bold text-center d-flex align-items-center justify-content-center" role="alert">
                    SHIPPING FEE HAS BEEN SET.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            } else {
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show fw-bold text-center d-flex align-items-center justify-content-center" role="alert">
                    SHIPPING FEE CANNOT BE SET!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
        if($_POST['action'] == 'update_sfee') {
            $s_fee = $_POST['s_fee'];
            $insert_fee = mysqli_query($db, "UPDATE shipping_settings SET s_fee = '$s_fee'");
            if($insert_fee) {
                $_SESSION['message'] = '
                <div class="alert alert-success alert-dismissible fade show fw-bold text-center d-flex align-items-center justify-content-center" role="alert">
                    SHIPPING FEE HAS BEEN SET.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            } else {
                $_SESSION['message'] = '
                <div class="alert alert-danger alert-dismissible fade show fw-bold text-center d-flex align-items-center justify-content-center" role="alert">
                    SHIPPING FEE CANNOT BE SET!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
        }
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
                        <a class="nav-link active" href="dashboard">
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
                    <h1 class="mt-4 fw-bold">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>
                    <!-- SHIPPING FEE -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="fj-input-wrap">
                                    <?php
                                        $sfee = mysqli_query($db, "SELECT s_fee FROM shipping_settings WHERE c_id = '".$_SESSION['canteen_id']."'"); 
                                        $sf = mysqli_fetch_assoc($sfee);
                                    ?>
                                    <label for="s_fee">Shipping Fee</label>
                                    <input type="number" name="s_fee" class="fj-input" min="1" required value="<?=$sf['s_fee']?>">
                                </div>
                                <?php
                                $check_fee = mysqli_query($db, "SELECT * FROM shipping_settings WHERE c_id = '".$_SESSION['canteen_id']."'");
                                if(mysqli_num_rows($check_fee) > 0) {
                                ?>
                                    <input type="hidden" name="action" value="update_sfee">
                                    <button type="submit" class="c-btn-3 c-btn-sm mt-2">SET</button>
                                <?php
                                } else {
                                ?>
                                    <input type="hidden" name="action" value="set_sfee">
                                    <button type="submit" class="c-btn-3 c-btn-sm mt-2">SET</button>
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>

                    <!-- CARDS -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <i class="fa-solid fa-utensils fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $sql="select * from dishes WHERE c_id = '".$_SESSION['canteen_id']."'";
                                                $result=mysqli_query($db,$sql); 
                                                $rws=mysqli_num_rows($result);
                                                echo $rws;
                                            ?>
                                        </h5>
                                        <p class="mb-0 fw-bold">DISHES</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <i class="fa-solid fa-cart-shopping fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $sql="select * from user_orders WHERE c_id = '".$_SESSION['canteen_id']."'";
                                                $result=mysqli_query($db,$sql); 
                                                $rws=mysqli_num_rows($result);
                                                echo $rws;
                                            ?>
                                        </h5>
                                        <p class="mb-0 fw-bold">TOTAL ORDERS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <i class="fa-solid fa-spinner fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $sql="select * from user_orders WHERE status = 'in process' AND c_id = '".$_SESSION['canteen_id']."'";
                                                $result=mysqli_query($db,$sql); 
                                                $rws=mysqli_num_rows($result);
                                                echo $rws;
                                            ?>
                                        </h5>
                                        <p class="mb-0 fw-bold">PROCESSING ORDERS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <i class="fa-solid fa-list-check fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $sql="select * from user_orders WHERE status = 'closed' AND c_id = '".$_SESSION['canteen_id']."'";
                                                $result=mysqli_query($db,$sql); 
                                                $rws=mysqli_num_rows($result);
                                                echo $rws;
                                            ?>
                                        </h5>
                                        <p class="mb-0 fw-bold">DELIVERED ORDERS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <i class="fa-solid fa-xmark fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $sql="select * from user_orders WHERE status = 'rejected' AND c_id = '".$_SESSION['canteen_id']."'";
                                                $result=mysqli_query($db,$sql); 
                                                $rws=mysqli_num_rows($result);
                                                echo $rws;
                                            ?>
                                        </h5>
                                        <p class="mb-0 fw-bold">CANCELLED ORDERS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <i class="fa-solid fa-peso-sign fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $result = mysqli_query($db, "SELECT SUM(price) AS value_sum FROM user_orders WHERE status = 'closed' AND c_id = '".$_SESSION['canteen_id']."'"); 
                                                $row = mysqli_fetch_assoc($result); 
                                                $sum = $row['value_sum'];
                                                if($sum == '') {
                                                    echo '0';
                                                } else {
                                                    echo $sum;
                                                }
                                            ?>
                                        </h5>
                                        <p class="mb-0 fw-bold">TOTAL EARNINGS</p>
                                    </div>
                                </div>
                            </div>
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
        document.title = "Canteen Dashboard | Food Jaguar"
    </script>