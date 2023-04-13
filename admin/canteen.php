<?php
    include("../connection/connect.php");
    error_reporting(0);
    session_start();
    include('session_expire.php');
    if(empty($_SESSION["adm_id"])) {
        header('location: login.php');
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
                        <a class="nav-link active" href="canteen">
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
                    <h1 class="mt-4 fw-bold">Canteen</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Canteen List</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>

                    <!-- CANTEEN TABLE -->
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between py-3">
                            <div class="canteen_table-title-wrap d-flex align-items-center">
                                <i class="fas fa-table me-1"></i>
                                <p class="mb-0 fw-bold">Canteen Table</p>
                            </div>

                            <div class="add_canteen-btn-wrap">
                                <a href="#addCanteenModal" class="c-btn-sm c-btn-4 text-decoration-none" data-bs-toggle="modal" data-bs-target="#addCanteenModal">ADD CANTEEN</a>
                            </div>

                        </div>
                        <div class="card-body">
                        <table id="canteen_table" class="table table-striped table-responsive table-bordered canteen_table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Canteen Name</th>
                                    <th scope="col">Canteen Owner/Manager</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Verification</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get_canteen = mysqli_query($db, "SELECT * FROM canteen_table ORDER BY id desc");
                                    $count = 1;
                                    if(mysqli_num_rows($get_canteen) > 0) {
                                        while($rows = mysqli_fetch_array($get_canteen)){

                                ?>
                                            <tr>
                                                <td scope="row"><?=$count?></td>
                                                <td><?=$rows['canteen_name']?></td>
                                                <td><?= $rows['c_oname']?></td>
                                                <td><?= $rows['c_address']?></td>
                                                <td><?= $rows['c_phone']?></td>
                                                <td><?= $rows['c_email']?></td>
                                                <td>
                                                    <?php
                                                    if($rows['c_status'] === '1') {
                                                    ?>
                                                    <span class="badge bg-success">OPEN</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <span class="badge bg-danger">CLOSE</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if($rows['c_verify'] === 'Yes') {
                                                    ?>
                                                    <span class="badge bg-success">VERIFIED</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <span class="badge bg-danger">FOR VERIFICATION</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="admin__table-actions-col">
                                                    <div class="d-flex justify-content-around admin__table-actions">
                                                        <!-- <a href="#viewModal<?=$rows['id']?>" data-bs-toggle="modal" data-bs-target="#viewModal<?=$rows['id']?>"><i class="fas fa-eye"></i></a> -->
                                                        <a href="#editModal<?=$rows['id']?>" data-bs-toggle="modal" data-bs-target="#editModal<?=$rows['id']?>"><i class="fas fa-pen"></i></a>
                                                        <a href="#deleteModal<?=$rows['id']?>" class="delete delete_user-btn text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?=$rows['id']?>" data-id="<?=$rows['id']?>"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>


                                            <!-- VIEW MODAL -->
                                            <div class="modal fade" id="viewModal<?=$rows['id']?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content view_user-modal">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 fw-bold" id="viewModalLabel">VIEW CANTEEN</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                                $canteen = mysqli_query($db, "SELECT * FROM canteen_table WHERE id='".$rows['id']."'");
                                                                $fetch = mysqli_fetch_array($canteen);
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-6 mb-3 fj-input-wrap">
                                                                    <label for="name">Canteen Name</label>
                                                                    <div class="fj-input cursor-default"><?=$fetch['canteen_name']?></div>
                                                                </div>
                                                                <div class="col-6 mb-3 fj-input-wrap">
                                                                    <label for="name">Owner/Manager</label>
                                                                    <div class="fj-input cursor-default"><?=$fetch['c_oname']?></div>
                                                                </div>
                                                                <div class="col-6 mb-3 fj-input-wrap">
                                                                    <label for="name">Phone Number</label>
                                                                    <div class="fj-input cursor-default"><?=$fetch['c_phone']?></div>
                                                                </div>
                                                                <div class="col-6 mb-3 fj-input-wrap">
                                                                    <label for="name">Email</label>
                                                                    <div class="fj-input cursor-default"><?=$fetch['c_email']?></div>
                                                                </div>
                                                                <div class="col-6 mb-3 fj-input-wrap">
                                                                    <label for="name">Canteen Status</label>
                                                                    <?php
                                                                    if($fetch['c_status'] == '1') {
                                                                    ?>
                                                                    <div class="fj-input cursor-default bg-success text-light">Open</div>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                    <div class="fj-input cursor-default bg-danger text-light">Close</div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-6 mb-3 fj-input-wrap">
                                                                    <label for="name">Verification Status</label>
                                                                    <?php
                                                                    if($fetch['c_verify'] == 'Yes') {
                                                                    ?>
                                                                    <div class="fj-input cursor-default bg-success text-light">Verified</div>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                    <div class="fj-input cursor-default bg-danger text-light">For Verification</div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <label for="address">Address/Location</label>
                                                                    <div class="fj-input"><?=$fetch['c_address']?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="c-btn-3 c-btn-sm" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- EDIT MODAL -->
                                            <div class="modal fade" id="editModal<?=$rows['id']?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form method="POST" action="action.php" id="edit_canteen" class="edit_canteen">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">EDIT CANTEEN DETAILS</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                    $edit_canteen = mysqli_query($db, "SELECT * FROM canteen_table WHERE id='".$rows['id']."'");
                                                                    $fetch = mysqli_fetch_array($edit_canteen);
                                                                ?>
                                                                <div class="row">
                                                                    <input type="hidden" name="c_id" value="<?=$rows['id']?>">
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Canteen Name</label>
                                                                        <input type="text" name="c_name" class="fj-input f_name" value="<?=$fetch['canteen_name']?>">
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Owner/Manager</label>
                                                                        <input type="text" name="c_oname" class="fj-input l_name" value="<?=$fetch['c_oname']?>">
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Phone Number</label>
                                                                        <input type="text" name="c_phone" class="fj-input phone" value="<?=$fetch['c_phone']?>">
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Email</label>
                                                                        <input type="email" name="c_email" class="fj-input email" value="<?=$fetch['c_email']?>">
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Canteen Status</label>
                                                                        <?php
                                                                        if($fetch['c_status'] == '1') {
                                                                        ?>
                                                                        <div class="fj-input cursor-default bg-success text-light">Open</div>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                        <div class="fj-input cursor-default bg-danger text-light">Close</div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Verification Status</label>
                                                                        <select name="c_verify" class="fj-input">
                                                                            <?php
                                                                                if($fetch['c_verify'] === 'Yes') {
                                                                            ?>
                                                                                    <option selected value="<?=$fetch['c_verify']?>">Verified</option>
                                                                                    <option value="No">For Verification</option>
                                                                            <?php
                                                                                } else {
                                                                            ?>
                                                                                    <option selected value="<?=$fetch['c_verify']?>">For Verification</option>
                                                                                    <option value="Yes">Verified</option>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 mb-3 fj-input-wrap">
                                                                        <label for="address">Address/Location</label>
                                                                        <textarea name="address" rows="3" class="fj-input address"><?=$fetch['c_address']?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="<?=$rows['id']?>">
                                                                <input type="hidden" name="action" value="edit_canteen">
                                                                <button type="submit" class="c-btn-3 c-btn-sm edit_user-btn" data-id="<?=$rows['id']?>">Save</button>
                                                                <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- DELETE MODAL -->
                                            <div class="modal fade" id="deleteModal<?=$rows['id']?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content view_user-modal">
                                                        <form action="action.php" method="POST">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 fw-bold" id="viewModalLabel">DELETE CANTEEN</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-center">Are you sure you want to delete this canteen?</p>
                                                                <input type="hidden" name="id" value="<?=$rows['id']?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="action" value="delete_canteen">
                                                                <button type="submit" class="c-btn-3 c-btn-sm">Confirm</button>
                                                                <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- RESEND EMAIL MODAL -->
                                            <div class="modal fade" id="resendModal<?=$rows['id']?>" tabindex="-1" aria-labelledby="resendModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content view_user-modal">
                                                        <form action="action.php" method="POST">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 fw-bold" id="resendModalLabel">RESEND VERIFICATION EMAIL</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-center">You are about to resend a verification email to <b><?=$rows['c_email']?></b></p>
                                                                <input type="hidden" name="id" value="<?=$rows['id']?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="action" value="resend_email">
                                                                <button type="submit" class="c-btn-3 c-btn-sm">Confirm</button>
                                                                <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                <?php
                                    $count = $count+1;
                                        }
                                    } else {
                                ?>
                                    <td colspan="7" class="text-center fw-bold text-danger">No Canteen Availabe</td>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </main>

            <!-- ADD CANTEEN MODAL -->
            <div class="modal fade" id="addCanteenModal" tabindex="-1" aria-labelledby="addCanteenModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" id="canteen_form" action="action.php">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bold" id="addCanteenModalLabel">ADD CANTEEN</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-12 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="c_name">Canteen Name</label>
                                            <input type="text" class="fj-input" name="c_name" placeholder="Enter your canteen name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="c_name">Canteen Owner's Name</label>
                                            <input type="text" class="fj-input" name="c_owner_name" placeholder="Enter canteen owner's name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="c_contact">Contact Number</label>
                                            <input type="number" class="fj-input" name="c_contact" placeholder="Enter contact number" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="c_email">Email</label>
                                            <input type="email" class="fj-input" name="c_email" placeholder="Enter email" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="fj-input-wrap">
                                            <label for="c_address">Address/Location</label>
                                            <textarea class="fj-input" rows="3" name="c_address" placeholder="Enter canteen address/location" required></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="action" value="add_canteen">
                                <button type="submit" class="c-btn-3 c-btn-sm">REGISTER</button>
                                <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">CANCEL</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


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
        document.title = "Canteens List | Food Jaguar"
    </script>

<?php
        }
    }
    include('footer.php');
?>

<script>
    jQuery(function($) {
        $(document).ready(function () {
            $('#canteen_table').DataTable();
        })

        function get_users() {
            $.ajax({
                type: "GET",
                url: "get_users.php",
                success: function (response) {
                    $('.users_table').empty().html(response);
                }
            });
        }

        function get_view_user() {
            $.ajax({
                type: "GET",
                url: "get_view_user.php",
                success: function (response) {
                    $('.view_user-modal').empty().html(response);
                }
            });
        }

    })

</script>