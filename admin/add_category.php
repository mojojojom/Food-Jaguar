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
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-globe"></i></i></div>
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
                        <a class="nav-link collapsed active" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Menu
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="all_menu">
                                    All Menu
                                </a>
                                <a class="nav-link active" href="add_category">
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
                    <h1 class="mt-4 fw-bold">Add Category</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Category</li>
                    </ol>

                    <!-- MESSAGE -->
                    <?php
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                    ?>

                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="card p-5 card-outline-primary">
                                <form action='' method='post' >
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="control-label">Category Name</label>
                                                    <input type="text" title="Category" name="f_catname" class="form-control new_cat" placeholder="Enter Category">
                                                    <div class="invalid-feedback d-flex">
                                                    Category Name should be separated by "-" only.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <input type="button" name="submit" class="c-btn-sm c-btn-3 add_cat" value="Save"> 
                                            <a href="all_menu" class="c-btn-sm c-btn-6 text-decoration-none">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Listed Categories</h4>
                                    <div class="table-responsive m-t-40">
                                        <table id="catTable" class="table table-bordered table-hover table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Category Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cat_list">
                                                <?php
                                                    $sql="SELECT * FROM food_category order by f_catid desc";
                                                    $query=mysqli_query($db,$sql);
                                                        if(!mysqli_num_rows($query) > 0 )
                                                        {
                                                            echo '<td colspan="7"><center>No Categories Data!</center></td>';
                                                        }
                                                        else
                                                        {				
                                                            while($rows=mysqli_fetch_array($query))
                                                            {
                                                ?>
                                                                <tr>
                                                                    <td><?=$rows['f_catname']?></td>
                                                                    <td class="text-center">
                                                                        <a href="#edit_cat<?=$rows['f_catid']?>" class="mx-2" data-bs-toggle="modal" data-bs-target="#edit_cat<?=$rows['f_catid']?>"><i class="fa-solid fa-pen-to-square"></i></i></a>
                                                                        <a href="#delete_cat<?=$rows['f_catid']?>" class="mx-2" data-bs-toggle="modal" data-bs-target="#delete_cat<?=$rows['f_catid']?>"><i class="fa-solid fa-trash text-danger"></i></a> 
                                                                    </td>
                                                                </tr>


                                                                <!-- EDIT MODAL -->
                                                                <div class="modal fade edit_modal" id="edit_cat<?=$rows['f_catid']?>" tabindex="-1" aria-labelledby="edit_catLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <form method="POST">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5" id="edit_catLabel">Update Category</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="card">
                                                                                            <div class="card-body">
                                                                                                <?php 
                                                                                                    $ssql ="select * from food_category where f_catid='".$rows['f_catid']."'";
                                                                                                    $res=mysqli_query($db, $ssql); 
                                                                                                    $row=mysqli_fetch_array($res);
                                                                                                    ?>

                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label">Category</label>
                                                                                                        <input type="text" name="f_catname" data-name="new_cat" value="<?=$row['f_catname']?>" class="form-control cat_input<?=$row['f_catid']?>" placeholder="Category Name" required>
                                                                                                    </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="c-btn-sm c-btn-3 edit_cat-btn" data-id="<?=$row['f_catid']?>">Save changes</button>
                                                                                        <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                </div>

                                                                <!-- DELETE MODAL -->
                                                                <div class="modal fade delete_modal" id="delete_cat<?=$rows['f_catid']?>" tabindex="-1" aria-labelledby="edit_catLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <form method="POST">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5" id="edit_catLabel">Delete Category</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="card">
                                                                                            <div class="card-body text-center">
                                                                                                <h6 class="mb-0">Are you sure you want to delete this category?</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="c-btn-sm c-btn-3 delete_cat-btn" data-id="<?=$row['f_catid']?>">Confirm</button>
                                                                                        <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">Cancel</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                <?php
                                                            }	
                                                        }
                                                ?>
                                            </tbody>
                                        </table>
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

    <script>
        document.title = "Add Category | Food Jaguar"
    </script>

<?php
        }
    }
    include('footer.php');
?>

<script>
    jQuery(function($) {
        $(document).ready(function () {
            // $('#catTable').DataTable();

            $("input.new_cat").keyup(function() {
                $(this).val($(this).val().trim());
            });


            // ADD CATEGORY
            $('.add_cat').on('click', function(e) {
                e.preventDefault();
                var new_cat = $('input.new_cat').val();
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: {cat: new_cat, action:'add_category'},
                    success: function (response) {
                        if(response == 'success') {
                            $.ajax({
                                type: "GET",
                                url: "get_cat.php",
                                success: function (response) {
                                    $('#cat_list').empty().html(response);
                                }
                            });

                            $('input.new_cat').val("");
                            
                            Swal.fire(
                                'Success!',
                                'Category Has Been Added.',
                                'success'
                            );
                        }else if(response == 'error_exists') {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Category Already Exists',
                                'error'
                            ); 
                        }else {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable To Add Category.',
                                'error'
                            );
                        }
                    }
                });
            })

            // EDIT CATEGORY
            $('.edit_modal').on('click', '.edit_cat-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var cat = $(".cat_input"+id).val();
                $('#edit_cat'+id).modal();

                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: {id:id, cat:cat, action: 'edit_category'},
                    success: function (response) {
                        if(response == 'success') {

                            $.ajax({
                                type: "GET",
                                url: "get_cat.php",
                                success: function (response) {
                                    $('#cat_list').empty().html(response);
                                }
                            });

                            $('.edit_modal').modal('hide');
                            
                            Swal.fire(
                                'Success!',
                                'Category Has Been Changed.',
                                'success'
                            );
                        }
                        else {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable To Edit Category.',
                                'error'
                            );
                        }
                    }
                });

            })

            // DELETE CATEGORY
            // $('.delete_cat-btn').on('click', function(e) {
            $('.delete_modal').on('click', '.delete_cat-btn', function(e) {
            // $('#menu_table').on('click', '.delete_cat-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#delete_cat'+id).modal();

                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: {id:id, action: 'delete_category'},
                    success: function (response) {
                        if(response == 'success') {

                            $.ajax({
                                type: "GET",
                                url: "get_cat.php",
                                success: function (response) {
                                    $('#cat_list').empty().html(response);
                                }
                            });

                            $('.delete_modal').modal('hide');
                            
                            Swal.fire(
                                'Success!',
                                'Category Has Been Deleted.',
                                'success'
                            );
                        }
                        else {
                            Swal.fire(
                                'Something Went Wrong!',
                                'Unable To Delete Category.',
                                'error'
                            );
                        }
                    }
                });

            })

        })
    })
</script>