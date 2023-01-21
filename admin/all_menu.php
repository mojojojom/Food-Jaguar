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
                    <h1 class="mt-4">All Menu</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>

                    <!-- ORDERS LIST -->
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center">
                            <i class="fas fa-table me-1"></i>
                            <p class="mb-0 fw-bold">Menu Table</p>
                        </div>
                        <div class="card-body">
                        <table id="menu_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Category</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get_menu = mysqli_query($db, "SELECT * FROM dishes ORDER BY d_id desc");
                                    if(mysqli_num_rows($get_menu) > 0) {
                                        while($rows = mysqli_fetch_array($get_menu)){
                                            $single_dish = mysqli_query($db, "SELECT * FROM food_category WHERE f_catid='".$rows['rs_id']."'");
                                            $fetch = mysqli_fetch_array($single_dish);
                                ?>
                                            <tr>
                                                <td scope="row"><?=$fetch['f_catname']?></td>
                                                <td><?= $rows['title']?></td>
                                                <td><?= $rows['slogan']?></td>
                                                <td><?= $rows['price']?></td>
                                                <td>
                                                    <div class="col-12">
                                                        <center><img src="Res_img/dishes/<?= $rows['img']?>" class="img-thumbnail" style="height:75px; width: 100%; object-fit: cover;" alt=""></center>
                                                    </div>
                                                </td>
                                                <td class="admin__table-actions text-center">
                                                    <a href="#editModal<?php echo htmlentities($rows['d_id']); ?>"data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlentities($rows['d_id']);?>"><i class="fas fa-pen"></i></a>
                                                    <a href="#" id="delete_order" class="delete_order" data-order="<?=$rows['o_id']?>" class="delete"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>

                                            <!------------------------------- MODALS ------------------------------->

                                            <!-- EDIT MODAL -->
                                            <div class="modal fade" id="editModal<?php echo htmlentities($rows['d_id']);?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form id="dish_form" enctype="multipart/form-data">
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
                                                                        <input class="form-control" name="dish_img" type="file" id="formFile">
                                                                    </div>
                                                                    <div class="mb-3 col-6">
                                                                        <label for="formFile" class="form-label">Item Category</label>
                                                                        <select class="form-select" name="dish_cat" aria-label="Default select example">
                                                                            <option selected><?=$fetch['f_catname']?></option>
                                                                            <?php
                                                                                $get_category = mysqli_query($db, "SELECT * FROM food_category");
                                                                                if(mysqli_num_rows($get_category) > 0) {
                                                                                    while($cat = mysqli_fetch_array($get_category)) {
                                                                            ?>
                                                                                        <option><?=$cat['f_catname']?></option>
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
                                                                <button type="button" class="c-btn-5 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>



                                <?php
                                        }
                                    } else {
                                ?>
                                    <td colspan="9" class="text-center fw-bold text-danger">No Orders</td>
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
            $('#menu_table').DataTable();


            // EDIT ITEM
            $('.edit_dish').on('click', function(e) {
                e.preventDefault();
                var formData = $('#dish_form').serialize();
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: formData,
                    success: function (response) {
                        if(response == 'success') {
                            alert(response);
                        } else {
                            alert(response);
                        }
                    }
                });
            })


            // DELETE ITEM


        })
    })
</script>