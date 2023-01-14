<?php
    include("connection/connect.php");  
    error_reporting(0);  
    session_start(); 
    include('header.php');
?>

    <!-- BANNER SECTION -->
    <section class="fj__banner-wrap">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <div class="fj__banner-content-wrap text-center">
                <p class="fj__banner-sub-heading s-font">About</p>
                <h1 class="fj__banner-heading s-font">FOOD JAGUAR</h1>
            </div>
        </div>
    </section>

    <script>
        document.title = "About | Food Jaguar"
    </script>

<?php
    include('footer.php');
?>