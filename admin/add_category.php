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

        if(isset($_POST['submit'] ))
        {
            if(empty($_POST['f_catname']))
            {
                $error = '<div class="alert alert-danger alert-dismissible fade show text-center">
                            <strong>Field Required!</strong>
                        </div>';
            }
            else
            {
                $check_cat= mysqli_query($db, "SELECT f_catname FROM food_category where f_catname = '".$_POST['f_catname']."' ");
                if(mysqli_num_rows($check_cat) > 0)
                {
                    $error = '<div class="alert alert-danger alert-dismissible fade show text-center">
                                <strong>Category already exist!</strong>
                            </div>';
                }
                else{
                    $mql = "INSERT INTO food_category(f_catname) VALUES('".$_POST['f_catname']."')";
                    mysqli_query($db, $mql);
                    $success = 	'<div class="alert alert-success alert-dismissible fade show text-center">
                                    New Category Added Successfully.</br>
                                </div>';
                }
            }
        }
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
                                <a class="nav-link" href="all_menu">
                                    All Menu
                                </a>
                                <a class="nav-link" href="add_menu">
                                    Add Menu
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
                    <h1 class="mt-4">Add Category</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                    <div class="row">
                        <?php  
                            echo $error;
                            echo $success; 
                        ?>
                        <div class="col-lg-12 mb-5">
                            <div class="card p-5 card-outline-primary">
                                <form action='' method='post' >
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="control-label">Category Name</label>
                                                    <input type="text" name="f_catname" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <input type="submit" name="submit" class="c-btn-sm c-btn-3" value="Save"> 
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
                                        <table id="myTable" class="table table-bordered table-hover table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Category Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql="SELECT * FROM food_category order by f_catid desc";
                                                    $query=mysqli_query($db,$sql);
                                                        if(!mysqli_num_rows($query) > 0 )
                                                        {
                                                            echo '<td colspan="7"><center>No Categories-Data!</center></td>';
                                                        }
                                                        else
                                                        {				
                                                            while($rows=mysqli_fetch_array($query))
                                                            {
                                                ?>
                                                                <tr>
                                                                    <td><?=$rows['f_catname']?></td>
                                                                    <td class="text-center">
                                                                        <a href="update_category.php?cat_upd=<?=$rows['f_catid']?>" class="mx-2"><i class="fa-solid fa-pen-to-square"></i></i></a>
                                                                        <a href="delete_category.php?cat_del=<?=$rows['f_catid']?>" class="mx-2"><i class="fa-solid fa-trash text-danger"></i></a> 
                                                                    </td>
                                                                </tr>
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
        })
    })
</script>