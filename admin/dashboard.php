<?php
    include("../connection/connect.php");
    error_reporting(0);
    session_start();
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
        <a class="navbar-brand ps-3" href="dashboard"><b>FOOD JAGUAR</b></a>
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
                                <a class="nav-link" href="add_menu">
                                    Add Menu
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <i class="fa-solid fa-utensils fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $sql="select * from dishes";
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
                                    <i class="fa-solid fa-users fs-1"></i>
                                    <div class="dashboard__info-wrap">
                                        <h5 class="fs-2 mb-0 text-end">
                                            <?php
                                                $sql="select * from users";
                                                $result=mysqli_query($db,$sql); 
                                                $rws=mysqli_num_rows($result);
                                                echo $rws;
                                            ?>
                                        </h5>
                                        <p class="mb-0 fw-bold">USERS</p>
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
                                                $sql="select * from user_orders";
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
                                                $sql="select * from user_orders WHERE status = 'in process' ";
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
                                                $sql="select * from user_orders WHERE status = 'closed' ";
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
                                                $sql="select * from user_orders WHERE status = 'rejected' ";
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
                                                $result = mysqli_query($db, 'SELECT SUM(price) AS value_sum FROM user_orders WHERE status = "closed"'); 
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
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <i class="fas fa-table me-1"></i>
                            <p class="mb-0 fw-bold">Users Table</p>
                        </div>
                        <div class="card-body">
                        <table id="users_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get_users = mysqli_query($db, "SELECT * FROM users ORDER BY u_id desc");
                                    $count = 1;
                                    if(mysqli_num_rows($get_users) > 0) {
                                        while($rows = mysqli_fetch_array($get_users)){
                                            $fullname = $rows['f_name'] . " " . $rows["l_name"];
                                ?>
                                            <tr>
                                                <td scope="row"><?=$count?></td>
                                                <td><?=$fullname?></td>
                                                <td><?= $rows['username']?></td>
                                                <td><?= $rows['email']?></td>
                                                <td><?= $rows['phone']?></td>
                                                <td><?= $rows['address']?></td>
                                                <td class="d-flex justify-content-around admin__table-actions">
                                                    <a href="#viewModal<?php echo htmlentities($rows['u_id']);?>" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo htmlentities($rows['u_id']);?>"><i class="fas fa-eye"></i></a>
                                                    <a href="#editModal<?php echo htmlentities($rows['u_id']); ?>" data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlentities($rows['u_id']);?>"><i class="fas fa-pen"></i></a>
                                                    <a href="" class="delete"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>


                                            <!-- VIEW MODAL -->
                                            <div class="modal fade" id="viewModal<?php echo htmlentities($rows['u_id']);?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
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
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- EDIT MODAL -->
                                            <div class="modal fade" id="editModal<?php echo htmlentities($rows['u_id']);?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form metho="POST" id="edit_user">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">EDIT USER DETAILS</h1>
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
                                                                        <label for="name">First Name</label>
                                                                        <input type="text" name="f_name" class="fj-input" value="<?=$fetch['f_name']?>">
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Last Name</label>
                                                                        <input type="text" name="l_name" class="fj-input" value="<?=$fetch['l_name']?>">
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Email</label>
                                                                        <input type="email" name="email" class="fj-input" value="<?=$fetch['email']?>">
                                                                    </div>
                                                                    <div class="col-6 mb-3 fj-input-wrap">
                                                                        <label for="name">Phone Number</label>
                                                                        <input type="text" name="phone" class="fj-input" value="<?=$fetch['phone']?>">
                                                                    </div>
                                                                    <div class="col-12 mb-3 fj-input-wrap">
                                                                        <label for="address">Address</label>
                                                                        <textarea name="address" rows="3" class="fj-input"><?=$fetch['address']?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="c-btn-3 c-btn-sm" data-bs-dismiss="modal">Save</button>
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
                                    <td colspan="7" class="text-center fw-bold text-danger">No Users Availabe</td>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; <b>Food Jaguar</b> <?= date('Y')?></div>
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

<script>
    jQuery(function($) {
        $(document).ready(function () {
            $('#users_table').DataTable();
            // $('#users_table_previous').html('<i class="fa-solid fa-angle-left"></i>');
            // $('#users_table_next').html('<i class="fa-solid fa-angle-right"></i>');
        })
    })
</script>