<?php
	include("connection/connect.php");
	error_reporting(0);
	session_start();

    include('action.php');

    $email = $_SESSION['email'];
    if($email == false)
    {
        header('Location: login');
    }

    include('header.php');
?>
    <!-- BANNER SECTION -->
    <section class="fj__banner-wrap">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <div class="fj__banner-content-wrap text-center">
                <h1 class="fj__banner-heading s-font">RESET PASSWORD</h1>
            </div>
        </div>
    </section>

    <!-- PAGE WRAPPER -->
    <section class="r__reset-wrap sec-pad-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-4"></div>
                
                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                    <div class="r__reset-inner-wrap">
                        <form id="reset_form">
                            <div class="row">

                                <div class="card my-2">
                                    <div class="card-body p-2 py-4">
                                        <div class="col-12">
                                            <div class="fj-input-wrap mb-3">
                                                <label for="password">Password</label>
                                                <!-- <input type="password" name="password" class="fj-input" placeholder="Password" required> -->
                                                <div class="position-relative">
                                                    <input type="password" class="fj-input password_input" name="password" placeholder="Password" required>
                                                    <i class="fa-solid fa-eye show-password-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="fj-input-wrap mb-3">
                                                <label for="repeatPassword">Repeat Password</label>
                                                <input type="password" name="r_password" class="fj-input" placeholder="Repeat Password" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="r__reset-btn-wrap d-flex align-items-center justify-content-center gap-2">
                                                <input type="hidden" name="action" value="new_pass" />
                                                <input class="c-btn-3" id="reset_btn" type="submit" name="reset" value="Reset" />
                                                <!-- <a href="./" class="c-btn-2">Cancel</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-12 col-sm-12 col-md-12 col-lg-4"></div>
            </div>
        </div>
    </section>

    <script>
        document.title = "Reset Password | Food Jaguar"
    </script>


<?php
    include('footer.php');
?>

<script>
    jQuery(function($) {
        $(document).ready(function() {

            $('#reset_form').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "post",
                    url: "action.php",
                    data: formData,
                    beforeSend: function() {
                        $('input#reset_btn').val('Please Wait');
                        $('input#reset_btn').addClass('disabled');
                        $('input#reset_btn').prop('disabled', true);
                    },
                    success: function (response) {
                        if(response == 'success') 
                        {
                            $('input#reset_btn').val('Success');
                            $('input#reset_btn').addClass('disabled');
                            $('input#reset_btn').prop('disabled', true);
                            
                            const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Password Has Been Changed!'
                            })

                            setTimeout(' window.location.href = "login"; ', 1500);
                        }
                        else if(response == 'error_update')
                        {
                            $('input#reset_btn').val('Reset');
                            $('input#reset_btn').removeClass('disabled');
                            $('input#reset_btn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'Password Reset Failed!',
                                'error'
                            );
                        }
                        else if(response == "error_pw_short") 
                        {
                            $('input#reset_btn').val('Reset');
                            $('input#reset_btn').removeClass('disabled');
                            $('input#reset_btn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'Password Must Be At Least 8 Characters Long!',
                                'error'
                            );
                        }
                        else
                        {
                            $('input#reset_btn').val('Reset');
                            $('input#reset_btn').removeClass('disabled');
                            $('input#reset_btn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'Password Doesn\'t Match!',
                                'error'
                            );
                        }
                    }
                });

            })

        })
    })
</script>