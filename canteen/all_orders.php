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
                        <a class="nav-link collapsed active" href="all_orders">
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

                    <h1 class="mt-4 fw-bold">All Orders</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>

                    <!-- ORDERS LIST -->
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <i class="fas fa-table me-1"></i>
                            <p class="mb-0 fw-bold">Orders Table</p>
                        </div>
                        <div class="card-body">
                        <table id="orders_table" class="table table-striped table-bordered">

                            <thead>
                                <tr>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date Ordered</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $get_orders = mysqli_query($db, "SELECT SUM(quantity) as quantity, SUM(price) as price, u_id, c_id, mop, s_fee, s_address, original_address, status, order_number, date FROM user_orders WHERE c_id = '".$_SESSION['canteen_id']."' GROUP BY u_id, c_id, order_number, mop, s_fee, s_address, original_address, status, date");

                                    if($get_orders) {
                                        while($row = mysqli_fetch_array($get_orders)) {

                                            // $get_user  = mysqli_query($db, "SELECT users.*, user_orders.* FROM users LEFT JOIN user_orders ON users.u_id = user_orders.u_id WHERE user_orders.u_id = '".$row['u_id']."'");
                                            $get_user  = mysqli_query($db, "SELECT users.*, user_orders.* FROM users LEFT JOIN user_orders ON users.u_id = user_orders.u_id WHERE user_orders.u_id = '".$row['u_id']."'");
                                            while($user = mysqli_fetch_assoc($get_user)) {
                                                $fullname = $user['f_name'] . " " . $user["l_name"];
                                                $phone = $user['phone'];
                                                $email = $user['email'];
                                            }
                                ?>
                                        <tr>
                                            <td scope="row"><?=$row['order_number']?></td>
                                            <td><?=$fullname?></td>
                                            <td><?=$row['price']?></td>
                                            <?php
                                            if(empty($row['s_address'])) {
                                            ?>
                                            <td><?=$row['original_address']?></td>
                                            <?php   
                                            } else {
                                            ?>
                                            <td><?=$row['s_address']?></td>
                                            <?php
                                            }
                                            ?>
                                            
                                            <?php 
                                                $status=$row['status'];
                                                if($status=="" or $status=="NULL")
                                                {
                                            ?>
                                                <td class="text-center"><span class="badge bg-warning text-center fw-medium">Queue</span></td>
                                            <?php 
                                                }
                                                if($status=="preparing") {
                                            ?>
                                                <td class="text-center"><span class="badge bg-primary text-center fw-medium">Preparing</span></td>
                                            <?php
                                                }
                                                if($status=="in process")
                                                { 
                                            ?>
                                                <td class="text-center"><span class="badge bg-info text-center fw-medium">On The Way</span></td>
                                            <?php
                                                }
                                                if($status=="closed")
                                                {
                                            ?>
                                                <td class="text-center"><span class="badge bg-success text-center fw-medium">Delivered</span></td>
                                            <?php 
                                                } 
                                            ?>
                                            <?php
                                                if($status=="rejected")
                                                {
                                            ?>
                                                <td class="text-center"><span class="badge bg-danger text-center fw-medium">Cancelled</span></td>
                                            <?php 
                                                } 
                                            ?>

                                            <td><?=$row['date']?></td>

                                            <td class="admin__table-actions text-center">
                                                <a href="#viewModal<?=$row['order_number']?>" data-bs-toggle="modal" data-bs-target="#viewModal<?=$row['order_number']?>"><i class="fas fa-eye"></i></a>
                                                <a href="#deleteModal<?=$row['order_number']?>" data-bs-toggle="modal" data-bs-target="#deleteModal<?=$row['order_number']?>"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>


                                        <!-- VIEW MODAL -->
                                        <div class="modal fade" id="viewModal<?=$row['order_number']?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form id="user_orders">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 fw-bold" id="viewModalLabel">VIEW ORDER</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="order_num" value="<?=$row['order_number']?>">
                                                            <div class="row">
                                                                <div class="col-6 mb-3"><p class="mb-0 fw-bold">NAME</p><p class="mb-0 card p-2"><?=$fullname?></p></div>
                                                                <div class="col-6 mb-3">
                                                                    <p class="mb-0 fw-bold">ADDRESS</p>
                                                                    <p class="mb-0 card p-2">
                                                                    <?php
                                                                    if(empty($row['s_address'])) {
                                                                    ?>
                                                                    <?=$row['original_address']?>
                                                                    <?php   
                                                                    } else {
                                                                    ?>
                                                                    <?=$row['s_address']?>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    </p>
                                                                </div>
                                                                <div class="col-6 mb-3"><p class="mb-0 fw-bold">PHONE</p><p class="mb-0 card p-2"><?=$phone?></p></div>
                                                                <div class="col-6 mb-3"><p class="mb-0 fw-bold">EMAIL</p><p class="mb-0 card p-2"><?=$email?></p></div>
                                                                <div class="col-12 mb-3"><p class="mb-0 fw-bold">DATE ORDERED</p><p class="mb-0 card p-2"><?=$row['date']?></p></div>
                                                                
                                                                <div class="col-12 mb-3">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <p class="mb-2 fw-bold text-dark">ORDERS</p>
                                                                            <?php
                                                                                $get_items = mysqli_query($db, "SELECT * FROM user_orders WHERE order_number='".$row['order_number']."'");
                                                                                while($item = mysqli_fetch_array($get_items)) {
                                                                                    $item_name = $item['title'];
                                                                                    $item_quantity = $item['quantity'];
                                                                            ?>
                                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                                        <p class="mb-0 text-danger fw-semibold"><?=$item_name?></p>
                                                                                        <p class="mb-0 text-danger fw-semibold">x <?=$item_quantity?></p>
                                                                                    </div>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6 mb-3">
                                                                    <p class="mb-0 fw-bold">STATUS</p>
                                                                    <p class="mb-0 card p-2">
                                                                        <?php 
                                                                            $status=$rows['status'];
                                                                            if($status=="" or $status=="NULL")
                                                                            {
                                                                        ?>
                                                                            <span class="badge bg-warning text-center fw-medium">Queue</span>
                                                                        <?php 
                                                                            }
                                                                            if($status=="preparing") {
                                                                        ?>
                                                                            <span class="badge bg-primary text-center fw-medium">Preparing</span>
                                                                        <?php
                                                                            }
                                                                            if($status=="in process")
                                                                            { 
                                                                        ?>
                                                                            <span class="badge bg-info text-center fw-medium">On The Way</span>
                                                                        <?php
                                                                            }
                                                                            if($status=="closed")
                                                                            {
                                                                        ?>
                                                                            <span class="badge bg-success text-center fw-medium">Delivered</span>
                                                                        <?php 
                                                                            } 
                                                                        ?>
                                                                        <?php
                                                                            if($status=="rejected")
                                                                            {
                                                                        ?>
                                                                            <span class="badge bg-danger text-center fw-medium">Cancelled</span>
                                                                        <?php 
                                                                            } 
                                                                        ?>
                                                                        </p>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <p class="mb-0 fw-bold">CHANGE STATUS</p>
                                                                    <select id="order_status" name="order_status" class="form-select order_status-<?=$row['order_number']?>" aria-label="Default select example" required>
                                                                        <option selected value="">Select Status</option>
                                                                        <option value="preparing">Preparing</option>
                                                                        <option value="in process">On The Way</option>
                                                                        <option value="closed">Delivered</option>
                                                                        <option value="rejected">Cancelled</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-12 mb-3">
                                                                    <div class="form-floating">
                                                                        <textarea class="form-control order_remark-<?=$row['order_number']?>" name="remark" id="remark" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                                                        <label for="floatingTextarea2">Message</label>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="action" value="update_status">
                                                            <button type="submit" class="c-btn-3 c-btn-sm update_status" id="update_status" order-id="<?=$row['order_number']?>" data-bs-dismiss="modal">Update Status</button>
                                                            <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- DELETE MODAL -->
                                        <div class="modal fade" id="deleteModal<?=$row['order_number']?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form id="user_orders">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 fw-bold" id="deleteModalLabel">VIEW ORDER</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="order_num" value="<?=$row['order_number']?>">
                                                            <h5 class="text-center fw-bold mb-0 py-4">Are you sure you want to delete this order?</h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="action" value="update_status">
                                                            <button type="button" class="c-btn-3 c-btn-sm delete_order" id="delete_order" data-order="<?=$row['order_number']?>" data-bs-dismiss="modal">Delete Order</button>
                                                            <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        }
                                    } else {
                                ?>
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
        document.title = "All Orders | Food Jaguar"
    </script>

<script>
    jQuery(function($) {
        $(document).ready(function () {
            $('#orders_table').DataTable();

            // DELETE ORDER
            $('.delete_order').on('click', function(e) {
                e.preventDefault();
                var orderId = $(this).data('order');
                // FIRST FUNCTION
                $.ajax({
                    type: "POST",
                    url: "../admin/action.php",
                    data: {orderId: orderId, action: 'delete_order'},
                    success: function (response) {
                        if(response == 'success') {

                            // DISPLAY NEW ITEMS IN TABLE
                            getOrders();

                            // SHOW STATUS
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Order Deleted!'
                            })

                        } 
                        else {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable to Delete Order!',
                                'error'
                            );
                        }
                    }
                });
            })

            // CHANGE ORDER STATUS
            $('.update_status').on('click', function(e) {
                e.preventDefault();
                var orderId = $(this).attr('order-id');
                var status = $('select.order_status-'+orderId).val();
                var remark = $('textarea.order_remark-'+orderId).val();
                $.ajax({
                    type: "POST",
                    url: "../admin/action.php",
                    data: {orderId: orderId, order_status: status, remark: remark, action: 'update_status'},
                    success: function (response) {
                        if(response == 'success') {
                            getOrders();

                            // SHOW STATUS
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Order Status Has Benn Updated!'
                            })
                        }
                        else {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable to Update Order Status.',
                                'error'
                            );
                        }
                    }
                });
            })


        })

        // GET ORDER TABLE FUNCTION
        function getOrders() {
            $.ajax({
                type: "GET",
                url: "get_orders.php",
                success: function (response) {
                    $('#orders_table').empty().html(response);
                }
            });
        }
    })
</script>