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

        if(isset($_POST['submit']))          
        {
            if(empty($_POST['d_name'])||empty($_POST['about'])||$_POST['price']==''||$_POST['f_catname']=='')
            {	
                $error = 	'<div class="alert alert-danger alert-dismissible fade show text-center">
                                <strong>All fields Must be Fillup!</strong>
                            </div>';
            }
            else
            {
                $fname = $_FILES['file']['name'];
                $temp = $_FILES['file']['tmp_name'];
                $fsize = $_FILES['file']['size'];
                $extension = explode('.',$fname);
                $extension = strtolower(end($extension));  
                $fnew = uniqid().'.'.$extension;
                $store = "Res_img/dishes/".basename($fnew);                    
        
                if($extension == 'jpg'||$extension == 'png'||$extension == 'gif'||$extension == 'jpeg' )
                {       
                    if($fsize>=1000000)
                    {
                        $error = 	'<div class="alert alert-danger alert-dismissible fade show text-center">
                                        <strong>Max Image Size is 1024kb!</strong> Try different Image.
                                    </div>';
                    }
                    else
                    {
                        $sql = "INSERT INTO dishes(rs_id,title,slogan,price,img) VALUE('".$_POST['f_catname']."','".$_POST['d_name']."','".$_POST['about']."','".$_POST['price']."','".$fnew."')";  // store the submited data ino the database :images
                        mysqli_query($db, $sql); 
                        move_uploaded_file($temp, $store);

                        $success = 	    '<div class="alert alert-success alert-dismissible fade show text-center">
                                            New Item Added Successfully.
                                        </div>';
                                        header('Location: all_menu');
                    }
                }
                elseif($extension == '')
                {
                    $error = 	'<div class="alert alert-danger alert-dismissible fade show text-center">
                                    <strong>select image</strong>
                                </div>';
                }
                else
                {
                    $error = 	'<div class="alert alert-danger alert-dismissible fade show text-center">
                                    <strong>invalid extension!</strong>png, jpg, Gif are accepted.
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
                                <a class="nav-link active" href="add_menu">
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
                    <h1 class="mt-4">Add Menu</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>

                    <div class="card">
                        <div class="card-body">

                            <?php  
                                echo $error;
                                echo $success; 
                            ?>
                            <form action='' method='post'  enctype="multipart/form-data">
                                <div class="form-body">
                                    <!-- <hr> -->

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="control-label">Item Name</label>
                                                <input type="text" name="d_name" class="form-control" >
                                            </div>
                                        </div>
                                
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="control-label">Select Category</label>
                                                <select name="f_catname" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
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

                                    </div>
                            
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="control-label">Price </label>
                                                <input type="text" name="price" class="form-control" placeholder="₱">
                                            </div>
                                        </div>
                            
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Image</label>
                                                <input type="file" name="file"  id="lastName" class="form-control form-control-danger" placeholder="12n">
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group has-danger">
                                                <label class="control-label">Description</label>
                                                <!-- <input type="text" name="about" class="form-control form-control-danger" > -->
                                                <textarea name="about" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="form-actions">
                                    <input type="submit" name="submit" class="c-btn-sm c-btn-3" value="Save"> 
                                    <a href="all_menu" class="c-btn-sm c-btn-6 text-decoration-none">Cancel</a>
                                </div>
                            </form>

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

            // ADD DISH
            // $('#add_menu').submit(function(e) {
            //     e.preventDefault();
            //     var formData = $(this).serialize();
            //     var img = $('input[name="dish_img"]').val();
            //     var dish_name = $('input[name="dish_name"]').val();
            //     var dish_price = $('input[name="dish_price"]').val();
            //     var dish_desc = $('textarea[name="dish_desc"]').val();
            //     var dish_cat = $('select[name="dish_cat"]').val();

            //     // console.log(img);
            //     // console.log(dish_name);
            //     // console.log(dish_price);
            //     // console.log(dish_desc);
            //     // console.log(dish_cat);

            //     $.ajax({
            //         type: "POST",
            //         url: "action.php",
            //         data: formData,
            //         // data: {
            //         //     dish_name: dish_name, 
            //         //     dish_img:img,
            //         //     dish_price: dish_price,
            //         //     dish_desc: dish_desc,
            //         //     dish_cat: dish_cat,
            //         //     action: 'add_dish'
            //         // },
            //         success: function (response) {
            //             if(response == 'success') 
            //             {
            //                 alert('success');
            //             } 
            //             else if(response == 'error_exists') 
            //             {
            //                 Swal.fire(
            //                     'Unable To Add Item!',
            //                     'Item Already Exists!',
            //                     'error'
            //                 );
            //             }
            //             else 
            //             {
            //                 alert(response);
            //             }
            //         }
            //     });

            // })



        })
    })
</script>