<?php
    include("../connection/connect.php"); 
    error_reporting(0); 
    session_start(); 
    include('header.php');
    if(isset($_SESSION['user_id'])) {
        header('Location: ../index');
    }
    if(isset($_SESSION['adm_id']) || isset($_SESSION['canteen_id'])) {
        header('Location: dashboard');
    }
?>

<!-- LOGIN FORM -->
<section class="container">
    <div class="admin__login-wrap">
        <div class="admin__login-inner-wrap">
            <div class="card">
                <div class="card-body p-4">
                    <div class="admin__login-logo-wrap">
                        <?php 
                            $site_logo = mysqli_query($db, "SELECT site_logo FROM site_settings"); 
                            $sl = mysqli_fetch_assoc($site_logo);
                        ?>
                        <img src="images/<?=$sl['site_logo']?>" class="admin__login-logo" alt="">
                    </div>
                    <div class="admin__login-header">
                        <?php 
                            $site_name = mysqli_query($db, "SELECT site_name FROM site_settings"); 
                            $sn = mysqli_fetch_assoc($site_name);
                        ?>
                        <p class="admin__login-header-heading mb-0">Welcome to <?=$sn['site_name']?>!👋</p>
                        <p class="admin__login-header-sub">Please sign in with your account. </p>
                    </div>
                    <form id="admin_login" method="POST">
                        <div class="admin_login-input-wrap mb-3">
                            <label class="mb-1 admin__login-input-label" for="username">EMAIL OR USERNAME</label>
                            <input class="l__login-username admin__login-input" type="text" placeholder="Username" name="username" autofocus>
                        </div>
                        <div class=" mb-3">
                            <label class="mb-1 admin__login-input-label" for="password">PASSWORD</label>
                            <!-- <input class="l__login-password admin__login-input" type="password" placeholder="Password" name="password"> -->
                            <div class="position-relative">
                                <input type="password" class="l__login-password admin__login-input password_input" name="password" placeholder="Password">
                                <i class="fa-solid fa-eye show-password-icon"></i>
                            </div>
                        </div>
                        <div class=" mb-4">
                            <input id="action" type="hidden" name="action" value="admin_login">
                            <input class="c-btn-3 l__login-btn admin__login-btn" id="admin_login_btn" type="submit" name="submit" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    include('footer.php');
?>

<script>
    jQuery(function($) {
        $(document).ready(function () {

            // SHOW PASSWORD 
            $('.show-password-icon').on('click', function() {
                var inputType = $("input.password_input").attr("type") === "text" ? "password" : "text";
                $("input.password_input").attr("type", inputType);
                $(this).toggleClass("fa-eye-slash fa-eye");
            })

            $('#admin_login').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: formData,
                    beforeSend: function() 
                    {
                        $('#admin_login_btn').val('Logging In');
                        $('#admin_login_btn').addClass('disabled');
                        $('#admin_login_btn').prop('disabled', true);
                    },
                    success: function(response)
                    {
                        if(response == 'success')
                        {
                            $('#admin_login_btn').val('Logging In');
                            $('#admin_login_btn').addClass('disabled');
                            $('#admin_login_btn').prop('disabled', true);

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Signed in successfully!'
                            })

                            setTimeout(' window.location.href = "dashboard"; ', 1000);
                        }
                        else if(response == 'canteen_login') {
                            $('#admin_login_btn').val('Logging In');
                            $('#admin_login_btn').addClass('disabled');
                            $('#admin_login_btn').prop('disabled', true);

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Signed in successfully!'
                            })

                            setTimeout(' window.location.href = "../canteen/dashboard"; ', 1000);
                        }
                        else if(response == 'error_pass')
                        {
                            $('#admin_login_btn').val('Login');
                            $('#admin_login_btn').removeClass('disabled');
                            $('#admin_login_btn').prop('disabled', false);
                            Swal.fire(
                                'Unable to Login!',
                                'Wrong Password!',
                                'error'
                            );
                        }
                        else if(response == 'empty_fields')
                        {
                            $('#admin_login_btn').val('Login');
                            $('#admin_login_btn').removeClass('disabled');
                            $('#admin_login_btn').prop('disabled', false);
                            Swal.fire(
                                'Empty Fields!',
                                'Please Fill All Fields!',
                                'error'
                            );
                        }
                        else if(response == 'empty_username')
                        {
                            $('#admin_login_btn').val('Login');
                            $('#admin_login_btn').removeClass('disabled');
                            $('#admin_login_btn').prop('disabled', false);
                            Swal.fire(
                                'Empty Fields!',
                                'Please Enter Your Email or Username!',
                                'error'
                            );
                        }
                        else if(response == 'empty_password')
                        {
                            $('#admin_login_btn').val('Login');
                            $('#admin_login_btn').removeClass('disabled');
                            $('#admin_login_btn').prop('disabled', false);
                            Swal.fire(
                                'Empty Fields!',
                                'Please Enter Your Password!',
                                'error'
                            );
                        }
                        else if(response == 'error_verify')
                        {
                            $('#admin_login_btn').val('Login');
                            $('#admin_login_btn').removeClass('disabled');
                            $('#admin_login_btn').prop('disabled', false);
                            Swal.fire(
                                'Unable To Login!',
                                'Your canteen is not verified yet. <br>Please Contact us to verify.',
                                'info'
                            );
                        }
                        else
                        {
                            $('#admin_login_btn').val('Login');
                            $('#admin_login_btn').removeClass('disabled');
                            $('#admin_login_btn').prop('disabled', false);
                            Swal.fire(
                                'Unable To Login!',
                                'User Doesn\'t Exists!',
                                'error'
                            );
                        }
                    }
                });
            })

        })
    })
</script>