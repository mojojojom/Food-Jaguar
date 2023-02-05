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
                <h1 class="fj__banner-heading s-font">REGISTER</h1>
            </div>
        </div>
    </section>

    <!-- REGISTRATION FORM -->
    <div class="r__register-wrap">
        <div class="row w-100 m-0">

            <div class="col-12 col-sm-12 col-md-8 col-lg-6 p-0 d-flex justify-content-center align-items-center order-2 order-sm-2 order-md-1">
                <div class="r__register-form-wrap">
                    <h1 class="r__register-heading s-font">Create an Account</h1>
                    <p class="r__register-sub-heading s-font">Please fill all fields.</p>
                    <!-- <?= $message ?> -->
                    <div class="r__register-inner-wrap">

                        <form id="register_form">
                            <div class="row">
                                <div class="col-12 fj-input-wrap mb-3">
                                    <label for="username" class="mb-1 s-font">Username</label>
                                    <input type="text" class="fj-input" name="username" placeholder="Username" min="3" required>
                                </div>
                                <div class="col-xs-12 col-sm-6 fj-input-wrap mb-3">
                                    <label for="firstName" class="mb-1 s-font">First Name</label>
                                    <input type="text" class="fj-input" name="firstname" placeholder="First Name" required>
                                </div>
                                <div class="col-xs-12 col-sm-6 fj-input-wrap mb-3">
                                    <label for="lastName" class="mb-1 s-font">Last Name</label>
                                    <input type="text" class="fj-input" name="lastname" placeholder="Last Name" required>
                                </div>
                                <div class="col-xs-12 col-sm-6 fj-input-wrap mb-3">
                                    <label for="email" class="mb-1 s-font">Email Address</label>
                                    <input type="email" class="fj-input" name="email" placeholder="Email Address" required>
                                </div>
                                <div class="col-xs-12 col-sm-6 fj-input-wrap mb-3">
                                    <label for="phone" class="mb-1 s-font">Mobile Number</label>
                                    <input type="text" class="fj-input" name="phone" placeholder="Mobile Number" required>
                                </div>
                                <div class="col-xs-12 col-sm-6 fj-input-wrap mb-3">
                                    <label for="password" class="mb-1 s-font">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="fj-input password_input" name="password" placeholder="Password" required>
                                        <i class="fa-solid fa-eye show-password-icon"></i>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 fj-input-wrap mb-3">
                                    <label for="cpassword" class="mb-1 s-font">Confirm Password</label>
                                    <input type="password" class="fj-input" name="cpassword" placeholder="Confirm Password" required>
                                </div>
                                <div class="col-12 fj-input-wrap mb-3">
                                    <label for="address" class="mb-1 s-font d-block">Delivery Address</label>
                                    <textarea name="address" rows="3" placeholder="Address" required></textarea>
                                </div>
                            </div>
                            <div class="r__register-btn-wrap mb-3">
                                <input id="action" type="hidden" name="action" value="user_register">
                                <input type="submit" value="Register" name="submit" class="c-btn-3 r__register-btn" id="r__register-btn">
                            </div>
                        </form>
                        <div class="l__login-signup-wrap text-center">
                            <p class="l__login-signup">Already have an account? <a href="login">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-4 col-lg-6 p-0 order-1 order-sm-1 order-md-2 p-0">
                <div class="r__register-right-wrap">
                    <?php 
                        $site_logo = mysqli_query($db, "SELECT site_logo FROM site_settings"); 
                        $sl = mysqli_fetch_assoc($site_logo);
                    ?>
                    <img src="admin/images/<?=$sl['site_logo']?>" class="fj__logo-overlay"/>
                    <div class="fj__overlay"></div>
                    <img src="imgs/login-bg.jpg" class="r__register-right-img" alt="">
                </div>
            </div>

        </div>
    </div>

    <!-- PAGE TITLE -->
    <script>
        document.title = "Register | Food Jaguar"
    </script>
        
<?php
    include('footer.php');
?>

<script>
    jQuery(function($) {
        // REGISTER
        $('#register_form').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: 'action.php',
                data: formData,
                beforeSend: function() {
                    $('input.r__register-btn').val('Please Wait');
                    $('input.r__register-btn').addClass('disabled');
                    $('input.r__register-btn').prop('disabled', true);
                },
                success: function(response)
                {
                    if(response == "success")
                    {
                        $('input.r__register-btn').val('Success');
                        $('input.r__register-btn').addClass('disabled');
                        $('input.r__register-btn').prop('disabled', true);

                        Swal.fire({
                            title: 'CODE SENT!',
                            text: "Verification Code was sent to your email.",
                            icon: 'success',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonColor: '#02006d',
                            cancelButtonColor: 'rgb(186, 22, 22)',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "user-otp";
                            }
                        })
                    }
                    else if(response == "error_user")
                    {
                        $('input.r__register-btn').val('Register');
                        $('input.r__register-btn').removeClass('disabled');
                        $('input.r__register-btn').prop('disabled', false);
                        Swal.fire(
                            'Something went wrong!',
                            'Username Already Exists!',
                            'error'
                        );
                    }
                    else if(response == "error_email") 
                    {
                        $('input.r__register-btn').val('Register');
                        $('input.r__register-btn').removeClass('disabled');
                        $('input.r__register-btn').prop('disabled', false);
                        Swal.fire(
                            'Something went wrong!',
                            'User Email Already Exists!',
                            'error'
                        );
                    }
                    else if(response == "error_send") 
                    {
                        $('input.r__register-btn').val('Register');
                        $('input.r__register-btn').removeClass('disabled');
                        $('input.r__register-btn').prop('disabled', false);
                        Swal.fire(
                            'Something went wrong!',
                            'Verification Code Cannot Be Send!',
                            'error'
                        );
                    }
                    else if(response == "error_num") 
                    {
                        $('input.r__register-btn').val('Register');
                        $('input.r__register-btn').removeClass('disabled');
                        $('input.r__register-btn').prop('disabled', false);
                        Swal.fire(
                            'Something went wrong!',
                            'User Number Already Exists!',
                            'error'
                        );
                    }
                    else if(response == "error_not_match") 
                    {
                        $('input.r__register-btn').val('Register');
                        $('input.r__register-btn').removeClass('disabled');
                        $('input.r__register-btn').prop('disabled', false);
                        Swal.fire(
                            'Something went wrong!',
                            'Password Doesn\'t Match!',
                            'error'
                        );
                    }
                    else if(response == "error_pw_short") 
                    {
                        $('input.r__register-btn').val('Register');
                        $('input.r__register-btn').removeClass('disabled');
                        $('input.r__register-btn').prop('disabled', false);
                        Swal.fire(
                            'Something went wrong!',
                            'Password Must Be At Least 8 Characters Long!',
                            'error'
                        );
                    }
                    else
                    {
                        $('input.r__register-btn').val('Register');
                        $('input.r__register-btn').removeClass('disabled');
                        $('input.r__register-btn').prop('disabled', false);
                        Swal.fire(
                            'Something went wrong!',
                            'Registration Failed!',
                            'error'
                        );
                    }
                }
            });

        })
    })
</script>