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
                <h1 class="fj__banner-heading s-font pass_reset_heading">CODE VERIFICATION</h1>
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

                        <div class="v_code-heading-wrap py-2 text-center" style="background: unset;">
                            <p class="mb-0 v_code-heading alert alert-success">We've sent the Reset Code to your email - <?= $_SESSION['email'] ?></p>
                        </div>

                        <form id="r_code_verify_form">
                            <div class="row">

                                <div class="card my-2">
                                    <div class="card-body p-2 py-4">

                                        <div class="col-12">
                                            <div class="fj-input-wrap mb-3">
                                                <label for="r_code">Reset Code</label>
                                                <input type="text" name="r_code" class="fj-input" placeholder="Enter Code" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="r__reset-btn-wrap d-flex align-items-center justify-content-center gap-2">
                                                <input type="hidden" name="action" value="reset_code" />
                                                <input class="c-btn-3 reset_code_btn" id="reset_code_btn" type="submit" name="reset" value="Submit" />
                                                <a href="login" class="c-btn-2 reset_cancel-btn">Cancel</a>
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
        document.title = "Verify Code | Food Jaguar"
    </script>


<?php
    include('footer.php');
?>

<script>
    jQuery(function($) {
        $(document).ready(function() {

            $('#r_code_verify_form').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "post",
                    url: "action.php",
                    data: formData,
                    beforeSend: function() {
                        $('input.reset_code_btn').val('Please Wait');
                        $('input.reset_code_btn').addClass('disabled');
                        $('input.reset_code_btn').prop('disabled', true);
                    },
                    success: function (response) {
                        if(response == 'success') 
                        {
                            $('input.reset_code_btn').val('Success');
                            $('input.reset_code_btn').addClass('disabled');
                            $('input.reset_code_btn').prop('disabled', true);
                            
                            const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: 'Reset Code Verified!'
                            })

                            setTimeout(' window.location.href = "new-password"; ', 1500);
                        }
                        else
                        {
                            $('input.reset_code_btn').val('Send Reset Link');
                            $('input.reset_code_btn').removeClass('disabled');
                            $('input.reset_code_btn').prop('disabled', false);
                            Swal.fire(
                                'Something went wrong!',
                                'You\'ve Entered Incorrect Code!',
                                'error'
                            );
                        }
                    }
                });

            })

        })
    })
</script>