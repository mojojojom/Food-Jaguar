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
                <!-- <h1 class="fj__banner-heading s-font">LOGIN</h1> -->
            </div>
        </div>
    </section>

    <!-- LOGIN SECTION -->
    <section class="l__login-wrap">
        <div class="row w-100 m-0">

            <div class="col-12 col-sm-12 col-md-8 col-lg-6 p-0 d-flex justify-content-center align-items-center order-2 order-sm-2 order-md-1">
                <div class="l__login-form-wrap">
                    <h1 class="l__login-heading s-font">Welcome Back!</h1>
                    <p class="l__login-sub-heading s-font">Please enter your details.</p>
                        <?= $message?>
                    <div class="l__login-inner-wrap">

                        <form id="login_form">
                            <div class="l__login-username-wrap mb-3">
                                <label class="mb-1" for="username">Username/Email</label>
                                <input class="l__login-username" type="text" placeholder="Username" name="username" required>
                            </div>
                            <div class="l__login-password-wrap mb-3">
                                <label class="mb-1" for="password">Password</label>
                                <div class="position-relative">
                                    <input class="l__login-password password_input" type="password" placeholder="Password" name="password" required>
                                    <i class="fa-solid fa-eye show-password-icon"></i>
                                </div>
                            </div>
                            <div class="l__login-btn-wrap mb-4">
                                <input id="action" type="hidden" name="action" value="user_login">
                                <input class="c-btn-3 l__login-btn" id="l__login-btn" type="submit" name="submit" value="Login" />
                            </div>
                        </form>

                        <div class="l__login-signup-wrap text-center">
                            <p class="l__login-signup">Don't have an account? <a href="register">Sign up</a></p>
                            <p class="l__login-signup"><a href="#resetModal" data-bs-toggle="modal" data-bs-target="#resetModal">Forgot Password?</a></p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-4 col-lg-6 p-0 order-1 order-sm-1 order-md-2">
                <div class="l__login-right-wrap">
                    <?php 
                        $site_logo = mysqli_query($db, "SELECT site_logo FROM site_settings"); 
                        $sl = mysqli_fetch_assoc($site_logo);
                    ?>
                    <img src="admin/images/<?=$sl['site_logo']?>" class="fj__logo-overlay"/>
                    <div class="fj__overlay"></div>
                    <img src="imgs/login-bg.jpg" class="l__login-right-img" alt="">
                </div>
            </div>

        </div>
    </section>

    <!-- PASSWORD RESET MODAL -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="resetForm">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="resetModalLabel">RESET PASSWORD</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="fj-input-wrap p-3">
                            <?=$modal_message?>
                            <label for="resetEmail">Email</label>
                            <input type="email" class="fj-input resetEmail" id="resetEmail" name="resetEmail" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="action" type="hidden" name="action" value="reset_pass">
                        <input class="c-btn-3 resetBtn" type="submit" name="resetBtn" value="Send Reset Link" />
                        <button type="button" class="c-btn-2" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- PAGE TITLE -->
    <script>
        document.title = "Login | Food Jaguar"
    </script>

<?php
    include('footer.php');
?>


<!-- AJAX -->
<script>
    jQuery(function($) {
        $(document).ready(function() {

            // LOGIN
            $('#login_form').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: 'action.php',
                    data: formData,
                    beforeSend: function() {
                        $('input.l__login-btn').val('Logging In');
                        $('input.l__login-btn').addClass('disabled');
                        $('input.l__login-btn').prop('disabled', true);
                    },
                    success: function(response)
                    {
                        if(response == "success")
                        {
                            $('input.l__login-btn').val('Please Wait');
                            $('input.l__login-btn').addClass('disabled');
                            $('input.l__login-btn').prop('disabled', true);

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Signed in successfully'
                            })

                            setTimeout(' window.location.href = "index"; ', 1500);
                        }
                        else if(response == "error_xpass")
                        {
                            $('input.l__login-btn').val('Login');
                            $('input.l__login-btn').removeClass('disabled');
                            $('input.l__login-btn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'Incorrect Password!',
                                'error'
                            );
                        }
                        else if(response == "error_verify") 
                        {
                            $('input.l__login-btn').val('Login');
                            $('input.l__login-btn').removeClass('disabled');
                            $('input.l__login-btn').prop('disabled', false);

                            Swal.fire({
                                title: 'Something went wrong!',
                                text: "Please Verify Your Account!",
                                icon: 'error',
                                showCancelButton: true,
                                allowOutsideClick: true,
                                allowEscapeKey: true,
                                confirmButtonColor: '#02006d',
                                cancelButtonColor: 'rgb(186, 22, 22)',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "user-otp";
                                }
                            })
                        }
                        else
                        {
                            $('input.l__login-btn').val('Login');
                            $('input.l__login-btn').removeClass('disabled');
                            $('input.l__login-btn').prop('disabled', false);
                            Swal.fire(
                                'Login Failed!',
                                'User Doesn\'t Exists!!',
                                'error'
                            );
                            alert(response);
                        }
                    }
                });

            })

            // RESET PASSWORD
            $('#resetForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: 'action.php',
                    data: formData,
                    beforeSend: function() {
                        $('input.resetBtn').val('Please Wait');
                        $('input.resetBtn').addClass('disabled');
                        $('input.resetBtn').prop('disabled', true);
                    },
                    success: function(response)
                    {
                        if(response == "success")
                        {
                            $('input.resetBtn').val('Success');
                            $('input.resetBtn').removeClass('disabled');
                            $('input.resetBtn').prop('disabled', false);

                            Swal.fire({
                                title: 'CODE SENT!',
                                text: "Reset Code was sent to your email.",
                                icon: 'success',
                                showCancelButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: '#02006d',
                                cancelButtonColor: 'rgb(186, 22, 22)',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "password-reset";
                                }
                            })

                        }
                        else if(response == "error_send") 
                        {
                            $('input.resetBtn').val('Send Reset Link');
                            $('input.resetBtn').removeClass('disabled');
                            $('input.resetBtn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'Unable to send Reset Code!',
                                'error'
                            );
                        }
                        else if(response == "error_code") 
                        {
                            $('input.resetBtn').val('Send Reset Link');
                            $('input.resetBtn').removeClass('disabled');
                            $('input.resetBtn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'Password Reset Failed!',
                                'error'
                            );
                        }
                        else
                        {
                            $('input.resetBtn').val('Send Reset Link');
                            $('input.resetBtn').removeClass('disabled');
                            $('input.resetBtn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'Unable To Send Request!',
                                'error'
                            );
                        }
                    }
                });

            });

        })
    })
</script>