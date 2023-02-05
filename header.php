<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="title" content="Food Jaguar">
        <meta name="description" content="Food Jaguar is a website application that let the students from President Ramon Magsaysay State University to order their foods from this web app.">
        <meta name="keywords" content="food, food ordering system, online food, student meal, students">
        <meta name="robots" content="noindex, nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">

        <link rel="icon" href="#">
        <title>Food Jaguar</title>
        <!-- FONTS -->
        <link rel="stylesheet" href="fonts/BebasNeue-Regular.ttf">
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <!-- FONTAWESOME -->
        <link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
        <!-- SLICK CAROUSEL -->
        <link rel="stylesheet" href="node_modules/slick-carousel/slick/slick.css">
        <!-- ANIMSITION -->
        <link href="css/animsition.min.css" rel="stylesheet">
        <!-- ANIMATE -->
        <link href="css/animate.css" rel="stylesheet">
        <!-- SLICK -->
        <link rel="stylesheet" href="css/slick.css">
        <!-- SWEET ALERT -->
        <link href="sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <!-- MAIN CSS -->
        <link href="style/style.min.css" rel="stylesheet">
        <!-- JQUERY -->
        <script src="js/jquery.min.js"></script>
        <!-- SITE ICON -->
        <link rel="apple-touch-icon" sizes="180x180" href="site_icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="site_icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="site_icon/favicon-16x16.png">
        <link rel="manifest" href="site_icon/site.webmanifest">


    </head>
    <body>
        <!-- HEADER -->
        <header class="site__nav navbar-expand-lg navbar-dark py-2 py-sm-2 py-md-2 py-lg-1 header-scroll fixed-top headrom" id="header">
            <nav class="container-lg" id="nav">
                <a class="navbar-brand d-block d-lg-none" href="#">
                    <img src="images/icon.png" height="50" />
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class=" collapse navbar-collapse" id="navbarNavDropdown">

                    <ul class="navbar-nav mx-auto gap-1 gap-sm-1 gap-md-1 gap-lg-5">
                        <li class="nav-item"> <a class="nav-link mx-2" href="index">Home <span class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link mx-2" href="about">About <span class="sr-only"></span></a> </li>
                        <li class="nav-item"> <a class="nav-link mx-2" href="menu">Menu <span class="sr-only"></span></a> </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link mx-2" href="index">
                            <?php 
                                $site_logo = mysqli_query($db, "SELECT site_logo FROM site_settings"); 
                                $sl = mysqli_fetch_assoc($site_logo);
                            ?>
                                <img src="admin/images/<?=$sl['site_logo']?>" height="100" />
                            </a>
                        </li>
                        <?php
                            if(empty($_SESSION["user_id"]))
                            {
                            ?>
                                <li class="nav-item"><a href="login" class="nav-link mx-2">Login</a> </li>
                                <li class="nav-item"><a href="register" class="nav-link mx-2">Register</a> </li>
                            <?php
                            }
                            else
                            {
                            ?>
                                <li class="nav-item"><a href="your_order" class="nav-link mx-2">Orders</a> </li>
                                <!-- <li class="nav-item"><a href="logout" class="nav-link mx-2">Logout</a> </li> -->
                                <?php
                                    $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id='".$_SESSION['user_id']."'");
                                    if(mysqli_num_rows($get_user) > 0) {
                                        $user = mysqli_fetch_array($get_user);
                                        $username = $user['username'];
                                    }
                                ?>
                                <li class="nav-item">
                                    <div class="dropdown">
                                        <button class="btn btn-link text-decoration-none nav-link mx-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?=$username?>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- <li><a href="profile" class="dropdown-item">Profile</a></li> -->
                                            <li><a href="#faveList" class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#faveList" aria-controls="#faveList">Favorites</a></li>
                                            <li><a href="logout" class="dropdown-item">Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                            <li class="nav-item">
                                <div class="m__menu-header-cart-wrap">
                                    <a class="m__menu-header-cart nav-link mx-2 position-relative p-font" data-bs-toggle="offcanvas" href="#cartSideMenu" role="button" aria-controls="cartSideMenu">
                                        <i class="fa-solid fa-cart-shopping position-relative">
                                            <span id="cart_num" class="cart_num position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger m__menu-header-order fw-semibold">
                                                0
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </i>
                                    </a>
                                </div>
                            </li>
                    </ul>

                </div>
            </nav>
        </header>