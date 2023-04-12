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
        <header class="site__nav navbar-expand-lg navbar-dark header-scroll fixed-top headrom" id="header">
            <div class="container-lg">
                <nav class="navbar">
                    <a class="navbar-brand" href="/">
                        <?php 
                        $site_logo = mysqli_query($db, "SELECT site_logo FROM site_settings"); 
                        $sl = mysqli_fetch_assoc($site_logo);
                        ?>
                        <img class="site__nav-logo" src="admin/images/<?=$sl['site_logo']?>" />
                    </a>
                    <a href="#" class="navbar-toggler text-light border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation"><i class="fa-solid fa-bars-staggered"></i></a>
                    <div class="collapse navbar-collapse" id="nav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 pe-0 pe-lg-3">
                            <li class="nav-item">
                                <a class="nav-link" href="index">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="menu">Menu</a>
                            </li>
                        </ul>
                        <form class="d-none d-lg-flex site__nav-search-form w-50 bottom-0 position-relative w-100" method="POST" action="search">
                            <input type="text" name="search" class="fj-input nav-search-bar" style="font-size: 16px;z-index:1;" placeholder="Search Dish">
                            <button class="site__nav-search-btn position-relative" type="submit"><i class="fa-solid fa-magnifying-glass" style="position: absolute; top: 50%; right:0;transform:translateY(-50%);z-index:2;"></i></button>
                        </form>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ps-0 ps-lg-3">
                            <?php
                                if(empty($_SESSION["user_id"])) {
                            ?>
                                <li class="nav-item">
                                    <a href="login" class="nav-link">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a href="register" class="nav-link">Register</a>
                                </li>
                            <?php
                                } else {
                            ?>
                                <?php
                                $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id='".$_SESSION['user_id']."'");
                                if(mysqli_num_rows($get_user) > 0) {
                                    $user = mysqli_fetch_array($get_user);
                                    $username = $user['username'];
                                }
                                ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $username; ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item" href="dashboard">Dashboard</a></li>
                                        <li><a class="dropdown-item" href="logout">Logout</a></li>
                                    </ul>
                                </li>

                                <li class="nav-item text-center">
                                    <a href="#faveList" class="dropdown-item nav-link text-light" data-bs-toggle="offcanvas" data-bs-target="#faveList" aria-controls="#faveList"><i class="fa-solid fa-heart"></i></a>
                                </li>

                            <?php
                                }
                            ?>
                            <li class="nav-item">
                                <div class="m__menu-header-cart-wrap">
                                    <a class="m__menu-header-cart nav-link mx-2 position-relative p-font text-light" data-bs-toggle="offcanvas" href="#cartSideMenu" role="button" aria-controls="cartSideMenu">
                                        <i class="fa-solid fa-bag-shopping position-relative">
                                            <span id="cart_num" class="cart_num position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger m__menu-header-order fw-semibold">
                                                0
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <form class="d-inline d-lg-none justify-content-center site__nav-search-form bottom-0 position-relative w-100" method="POST" action="search">
                            <input type="text" name="search" class="fj-input nav-search-bar" style="font-size: 16px;z-index:1;" placeholder="Search Dish">
                            <button class="site__nav-search-btn position-relative" type="submit"><i class="fa-solid fa-magnifying-glass" style="position: absolute; top: 50%; right:0;transform:translateY(-50%);z-index:2;"></i></button>
                        </form>
                    </div>
                </nav>
            </div>
        </header> 