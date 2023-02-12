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
                        <a class="nav-link collapsed active" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Menu
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link active" href="all_menu">
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
                    <h1 class="mt-4 fw-bold">All Menu</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Menu</li>
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
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-table me-1"></i>
                                <p class="mb-0 fw-bold">Menu Table</p>
                            </div>
                            <div>
                                <a href="#add_menu_modal" class="text-decoration-none c-btn-3 c-btn-sm" data-bs-toggle="modal" data-bs-target="#add_menu_modal">ADD MENU</a>
                            </div>
                        </div>
                        <div class="card-body">
                        <table id="menu_table" class="table table-hover table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get_menu = mysqli_query($db, "SELECT * FROM dishes WHERE c_id='".$_SESSION['canteen_id']."' ORDER BY d_id desc");
                                    if(mysqli_num_rows($get_menu) > 0) {
                                        while($rows = mysqli_fetch_array($get_menu)){
                                            $single_dish = mysqli_query($db, "SELECT * FROM food_category WHERE f_catid='".$rows['rs_id']."'");
                                            $fetch = mysqli_fetch_array($single_dish);
                                ?>
                                            <tr>
                                                <td scope="row">
                                                    <?php
                                                    if($rows['d_status'] === 'Post') {
                                                    ?>
                                                    <div class="badge bg-success">POSTED</div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <div class="badge bg-info">DRAFT</div>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?=$fetch['f_catname']?></td>
                                                <td><?= $rows['title']?></td>
                                                <td><?= $rows['slogan']?></td>
                                                <td><?= $rows['price']?></td>
                                                <td><?= $rows['d_stock']?></td>
                                                <td>
                                                    <div class="col-12">
                                                        <center><img src="../admin/Res_img/dishes/<?= $rows['img']?>" class="img-thumbnail" style="height:80px; width: 80px; object-fit: cover;" alt=""></center>
                                                    </div>
                                                </td>
                                                <td class="admin__table-actions text-center">
                                                    <a href="#editModal<?=$rows['d_id'] ?>"data-bs-toggle="modal" data-bs-target="#editModal<?=$rows['d_id']?>"><i class="fas fa-pen"></i></a>
                                                    <a href="#deleteModal<?=$rows['d_id']?>" data-bs-toggle="modal" data-bs-target="#deleteModal<?=$rows['d_id']?>" data-item="<?=$rows['d_id']?>"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <!------------------------------- MODALS ------------------------------->

                                            <!-- EDIT MODAL -->
                                            <div class="modal fade" id="editModal<?=$rows['d_id']?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form id="dish_form" method="POST" action="../admin/action.php" enctype="multipart/form-data">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">Edit Item</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="dish_id" value="<?=$rows['d_id']?>">
                                                                <div class="row">
                                                                    <div class="mb-3 col-6">
                                                                        <label for="exampleFormControlInput1" class="form-label">Item Name</label>
                                                                        <input type="text" name="dish_name" class="form-control" placeholder="<?=$rows['title']?>" value="<?=$rows['title']?>">
                                                                    </div>
                                                                    <div class="mb-3 col-6">
                                                                        <label for="exampleFormControlInput1" class="form-label">Item Price</label>
                                                                        <input type="text" name="dish_price" class="form-control" placeholder="<?=$rows['price']?>" value="<?=$rows['price']?>">
                                                                    </div>
                                                                    <div class="mb-3 col-12">
                                                                        <label for="exampleFormControlTextarea1" class="form-label">Item Description</label>
                                                                        <textarea class="form-control" name="dish_desc" id="exampleFormControlTextarea1" rows="3"><?=$rows['slogan']?></textarea>
                                                                    </div>
                                                                    <div class="mb-3 col-6">
                                                                        <label for="formFile" class="form-label">Item Image</label>
                                                                        <input class="form-control" name="dish_img" type="file" id="dish_img">
                                                                        <img class="img-thumbnail" src="../admin/Res_img/dishes/<?=$rows['img']?>" alt="item image">
                                                                    </div>
                                                                    <div class="mb-3 col-6">
                                                                        <label for="formFile" class="form-label">Item Category</label>
                                                                        <select class="form-select" name="dish_cat" aria-label="Default select example">
                                                                            <option selected value="<?=$fetch['f_catid']?>"><?=$fetch['f_catname']?></option>
                                                                            <?php
                                                                                $get_category = mysqli_query($db, "SELECT * FROM food_category");
                                                                                if(mysqli_num_rows($get_category) > 0) {
                                                                                    while($cat = mysqli_fetch_array($get_category)) {
                                                                            ?>
                                                                                        <option value="<?=$cat['f_catid']?>"><?=$cat['f_catname']?></option>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3 col-6">
                                                                        <label for="stock" class="form-label">Stocks</label>
                                                                        <input class="form-control" type="number" name="dish_stock" value="<?=$rows['d_stock']?>">
                                                                    </div>
                                                                    <div class="mb-3 col-6">
                                                                        <label for="formFile" class="form-label">Item Status</label>
                                                                        <select class="form-select" name="d_status" aria-label="Default select example">
                                                                            <option selected value="<?=$rows['d_status']?>"><?=$rows['d_status']?></option>
                                                                            <?php
                                                                                $get_stat = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='".$rows['d_id']."'");
                                                                                if(mysqli_num_rows($get_stat) > 0) {
                                                                                    while($stat = mysqli_fetch_array($get_stat)) {
                                                                            ?>
                                                                                        <option value="<?=$stat['d_status']?>"><?=$stat['d_status']?></option>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="action" value="edit_dish">
                                                                <button type="submit" class="c-btn-3 c-btn-sm edit_dish" id="edit_dish" dish-id="<?=$rows['d_id']?>">Save</button>
                                                                <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- DELETE MODAL -->
                                            <div class="modal fade" id="deleteModal<?=$rows['d_id']?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content view_user-modal">
                                                        <form action="../admin/action.php" method="POST">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 fw-bold" id="deleteModalLabel">DELETE ITEM</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-center">Are you sure you want to delete this item?</p>
                                                                <input type="hidden" name="id" value="<?=$rows['d_id']?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="action" value="delete_item">
                                                                <button type="submit" class="c-btn-3 c-btn-sm delete_dish-btn" data-id="<?=$rows['d_id']?>">Confirm</button>
                                                                <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>



                                <?php
                                        }
                                    } else {
                                ?>
                                    <td colspan="9" class="text-center fw-bold text-danger">No Items in the Menu</td>
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

    <!-- ADD MENU MODAL -->
    <div class="modal fade" id="add_menu_modal" tabindex="-1" aria-labelledby="add_menu_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="../admin/action.php" method="POST" id="add_item_form" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="add_menu_modalLabel">ADD ITEM TO THE MENU</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <div class=" fj-input-wrap">
                                    <label for="item_name">Item Name</label>
                                    <input type="text" name="d_name" class=" fj-input" placeholder="Enter Item Name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class=" fj-input-wrap">
                                    <label for="item_name">Item Price</label>
                                    <input type="number" name="d_price" class=" fj-input" placeholder="Enter Item Price" required>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="d_desc">Item Description</label>
                                    <textarea name="d_desc" rows="3" class="fj-input" placeholder="Enter Item Description"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="d_img">Item Image</label>
                                    <input type="file" name="d_img" class=" fj-input" placeholder="12n" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class=" fj-input-wrap">
                                    <label for="cat_name">Item Category</label>
                                    <select name="d_cat" class="fj-input" data-placeholder="Choose a Category" tabindex="1" required>
                                        <option>Select Category</option>
                                        <?php 
                                            $ssql ="select * from food_category";
                                            $res=mysqli_query($db, $ssql); 
                                            while($row=mysqli_fetch_array($res))  
                                            {
                                                echo' <option value="'.$row['f_catid'].'">'.$row['f_catname'].'</option>';;
                                            }
                                        ?> 
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="fj-input-wrap">
                                    <label for="d_stock">Item Stock</label>
                                    <input type="number" name="d_stock" class="fj-input" placeholder="Enter Item Stock" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class=" fj-input-wrap">
                                    <label for="d_stat">Item Status</label>
                                    <select name="d_stat" class="fj-input" data-placeholder="Choose a Category" tabindex="1" required>
                                        <option>Select Status</option>
                                        <option value="Post">Post</option>
                                        <option value="Draft">Draft</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="add_item">
                        <button type="submit" class="c-btn-sm c-btn-3">ADD</button>
                        <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
        }
    }
    include('footer.php');
?>

    <!-- PAGE TITLE -->
    <script>
        document.title = "All Menu | Food Jaguar"
    </script>

<script>
    jQuery(function($) {
        $(document).ready(function () {
            $('#menu_table').DataTable();
        })
    })
</script>