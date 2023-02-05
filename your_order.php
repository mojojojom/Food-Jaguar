<?php
	include("connection/connect.php");
	error_reporting(0);
	session_start();

	if(empty($_SESSION['user_id']))  
	{
		header('location:login');
	}
	else
	{
	include('action.php');
	include('header.php');
?>
    <!-- BANNER SECTION -->
    <section class="fj__banner-wrap">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <div class="fj__banner-content-wrap text-center">
                <p class="fj__banner-sub-heading s-font">Check Out</p>
                <h1 class="fj__banner-heading s-font">YOUR ORDERS</h1>
            </div>
        </div>
    </section>

    <!-- ORDERS -->
    <section class="o__order-wrap sec-pad">
        <div class="container">

            <div class="row">

                <!-- ORDERS -->
                <div class="col-6">
                    <div class="card p-2">
                        <div class="o__order-card-heading-wrap">
                            <h3 class="o__order-card-heading">OVERVIEW</h3>
                        </div>
                        <div class="card-body" id="list_of_orders">

                            <?php
                            $get_orders = mysqli_query($db, "SELECT SUM(quantity) as quantity,SUM(price) as price, mop, s_fee, s_address, original_address, status, order_number FROM user_orders WHERE u_id='".$_SESSION['user_id']."' AND status != 'rejected' GROUP BY order_number , mop, s_fee,s_address, original_address, status");
                            if(!mysqli_num_rows($get_orders) > 0) {
                                echo '<span class="alert alert-danger text-center fw-bold d-flex align-items-center justify-content-center">No orders found.</span>';
                            }else {
                                while($row = mysqli_fetch_assoc($get_orders)) {
                                    $total_price = $row['price']+$row['s_fee'];
                            ?>
                                    <div class="card mb-3">
                                        <?php
                                            if($row['mop'] == 'deliver') {
                                        ?>
                                        <div class="card-header bg-success d-flex align-items-center justify-content-between">
                                            <p class="mb-0 text-uppercase fw-bold text-white">
                                                <?=$row['mop']?>
                                            </p>
                                            <?php
											$status = $row['status'];
											if($status=="" or $status=="NULL")
											{
											?>
												<span class="badge bg-warning">Queue</span>
											<?php 
											}
                                            if($status=="preparing") {
                                            ?>
                                                <span class="badge bg-primary">Preparing</span>
                                            <?php
                                            }
											if($status=="in process")
											{ ?>
												<span class="badge bg-info">On The Way!</span>
											<?php
											}
											if($status=="closed")
											{
											?>
												<span class="badge bg-secondary">Delivered</span>
											<?php 
											} 
											?>
											<?php
											if($status=="rejected")
											{
											?>
												<span class="badge bg-danger">Cancelled</span>
											<?php 
											} 
											?>
                                        </div>
                                        <?php
                                            }else {
                                        ?>
                                        <div class="card-header bg-info d-flex align-items-center justify-content-between">
                                            <p class="mb-0 text-uppercase fw-bold text-white">
                                                <?=$row['mop']?>
                                            </p>
                                            <?php
											$status = $row['status'];
											if($status=="" or $status=="NULL")
											{
											?>
												<span class="badge bg-warning">Queue</span>
											<?php 
											}
                                            if($status=="preparing") {
                                            ?>
                                                <span class="badge bg-primary">Preparing</span>
                                            <?php
                                            }
											if($status=="in process")
											{ ?>
												<span class="badge bg-info">On The Way!</span>
											<?php
											}
											if($status=="closed")
											{
											?>
												<span class="badge bg-secondary">Delivered</span>
											<?php 
											} 
											?>
											<?php
											if($status=="rejected")
											{
											?>
												<span class="badge bg-danger">Cancelled</span>
											<?php 
											} 
											?>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="o__order-card-num-wrap">
                                                <a class="fs-5 fw-bold text-body-emphasis" href="#order_modal<?=$row['order_number']?>" data-bs-toggle="modal" data-bs-target="#order_modal<?=$row['order_number']?>">ORDER #<?=$row['order_number']?></a>
                                            </div>
                                            <div class="o__order-card-price-wrap">
                                                <p class="mb-0">DELIVERY FEE : <span>₱<?=$row['s_fee']?></span></p>
                                                <p class="mb-0">TOTAL PRICE : <span>₱<?=$total_price?></span></p>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ORDER MODAL -->
                                    <div class="modal fade order_modal-wrap" id="order_modal<?=$row['order_number']?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">ORDER #<?=$row['order_number']?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="">
                                                    <input type="hidden" value="<?=$row['order_number']?>">
                                                    <?php
                                                        $get_single = mysqli_query($db,'SELECT user_orders.*, (SELECT SUM(price) FROM user_orders WHERE status != "rejected" AND order_number="'.$row['order_number'].'") as total_price, original_price FROM user_orders WHERE u_id="'.$_SESSION["user_id"].'" AND order_number="'.$row['order_number'].'" AND status != "rejected"');
                                                        if(!mysqli_num_rows($get_single) > 0) {
                                                    ?>
                                                        <span class="alert alert-danger text-center fw-bold">No orders found.</span>
                                                    <?php
                                                        } else {
                                                            $total_price= 0;
                                                            while($dish = mysqli_fetch_assoc($get_single)) {
                                                                $total_price = $dish['total_price'];
                                                    ?>

                                                                <div class="card mb-3">
                                                                    <div class="card-body">
                                                                        <div class="modal__checkout-wrap">
                                                                            <div class="row">
                                                                                <div class="modal__checkout-item-desc-wrap col-11">
                                                                                    <p class="modal__checkout-item-name mb-1 fs-5"><?=$dish["title"]?></p>
                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                        <p class="modal__checkout-item-price mb-0">₱<?=$dish['original_price']?></p>
                                                                                        <p class="modal__checkout-item-qty mb-0">x<?=$dish['quantity']?></p>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-1 d-flex align-items-center">
                                                                                    <div class="d-flex align-items-center justify-content-center">
                                                                                        <a href="#" id="cancel_order" data-date="<?=$dish['date']?>" data-id="<?=$dish['o_id']?>" data-num="<?=$row['order_number']?>" class="o__order-card-item-cancel mb-0 cancel_order"><i class="fa-solid fa-square-xmark fs-5"></i></a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <p class="mb-0">DELIVERY ADDRESS : <?=$row['original_address']?></p>
                                                            <p class="mb-0">ADDED DELIVERY ADDRESS : <?=$row['s_address']?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="download.php?id=<?=$row['order_number']?>" target="_blank" class="c-btn-sm c-btn-4 text-decoration-none">RECEIPT</a>
                                                    <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">CLOSE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>

                <!-- PROFILE -->
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <?= $message ?>
                            <div class="o__profile-card-heading-wrap">
                                <h3 class="o__profile-card-heading mb-0">
                                    PROFILE
                                </h3>

                                <?php
                                    $query_self = mysqli_query($db, "SELECT * FROM users WHERE u_id='".$_SESSION['user_id']."'");
                                    if(mysqli_num_rows($query_self) > 0) {
                                        while($print = mysqli_fetch_array($query_self)) {

                                        $fname = $print['f_name'];
                                        $lname = $print['l_name'];
                                        $fullname = $fname . " " . $lname;
                                ?>

                                <a href="#editProfileModal<?=$print['u_id']?>" class="o__profile-card-edit-btn c-btn-2 c-btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal<?=$print['u_id']?>">EDIT PROFILE</a>

                            </div>

                                <p class="o__profile-username o__profile-title mb-0">USERNAME : <span><?= $print['username']?></span></p>
                                <p class="o__profile-name o__profile-title mb-0">NAME : <span><?=$fullname?></span></p>
                                <p class="o__profile-email o__profile-title mb-0">EMAIL : <span><?=$print['email']?></span></p>
                                <p class="o__profile-phone o__profile-title mb-0">MOBILE NUMBER : <span><?=$print['phone']?></span></p>
                                <hr>
                                <p class="o__profile-address-title o__profile-title mb-0">DELIVERY ADDRESS : <?=$print['address']?></p>


                                <!-- EDIT PROFILE MODAL -->
                                <div class="modal fade" id="editProfileModal<?=$print['u_id']?>" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="action.php" id="profile_form">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5 fw-bold" id="editProfileModalLabel">EDIT PROFILE</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="user_id" value="<?=$print['u_id']?>">
                                                    <div class="row">
                                                        <div class="col-12 fj-input-wrap mb-3">
                                                            <label for="username" class="mb-1 s-font">Username</label>
                                                            <input type="text" class="fj-input" name="u_username" value="<?= $print['username'] ?>" min="3" placeholder="Username">
                                                        </div>
                                                        <div class="col-6 fj-input-wrap mb-3">
                                                            <label for="firstName" class="mb-1 s-font">First Name</label>
                                                            <input type="text" class="fj-input" name="u_firstname" value="<?= $print['f_name'] ?>" placeholder="First Name">
                                                        </div>
                                                        <div class="col-6 fj-input-wrap mb-3">
                                                            <label for="lastName" class="mb-1 s-font">Last Name</label>
                                                            <input type="text" class="fj-input" name="u_lastname" value="<?= $print['l_name'] ?>" placeholder="Last Name">
                                                        </div>
                                                        <div class="col-6 fj-input-wrap mb-3">
                                                            <label for="email" class="mb-1 s-font">Email Address</label>
                                                            <input type="email" class="fj-input" name="u_email" value="<?= $print['email'] ?>" placeholder="Email Address">
                                                        </div>
                                                        <div class="col-6 fj-input-wrap mb-3">
                                                            <label for="phone" class="mb-1 s-font">Mobile Number</label>
                                                            <input type="text" class="fj-input" name="u_phone" value="<?= $print['phone'] ?>" placeholder="Mobile Number">
                                                        </div>
                                                        <div class="col-12 fj-input-wrap mb-3">
                                                            <label for="password" class="mb-1 s-font">Password</label>
                                                            <div class="position-relative">
                                                                <input type="password" class="fj-input password_input" name="u_password" value="" placeholder="Password" autocomplete="current-password">
                                                                <i class="fa-solid fa-eye show-password-icon"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 fj-input-wrap mb-3">
                                                            <label for="address" class="mb-1 s-font d-block">Delivery Address</label>
                                                            <textarea name="u_address" rows="3" placeholder="Address"><?= $print['address'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input id="action" type="hidden" name="action" value="editprofile">
                                                    <input type="submit" name="submit" class="c-btn-sm c-btn-3" value="Confirm">
                                                    <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>




    <script>
        document.title = "Your Orders | Food Jaguar"
    </script>


<?php
	include('footer.php');
}
?>

<script>

	jQuery(function($) {
		$(document).ready(function () {
			// $('.modal__checkout-wrap').on('click', '.cancel_order',function(e) {
			$('.order_modal-wrap').on('click', '.cancel_order',function(e) {
				e.preventDefault();
				var id = $(this).data('id');
                var num = $(this).data('num');

				$.ajax({
					type: "POST",
					url: "add_cart.php",
					data: {id: id, action: 'cancel_order'},
					success: function (response) {
						if(response == 'success') {

                            update_order_list(num);
                            update_order_modal(num);
                            $('#order_modal'+num).modal('hide');

							// SHOW STATUS
							const Toast = Swal.mixin({
								toast: true,
								position: 'top-end',
								showConfirmButton: false,
								timer: 1000,
								timerProgressBar: true
							})
							Toast.fire({
								icon: 'success',
								title: 'Order Cancelled!'
							})

                            $.ajax({
                                type: "GET",
                                url: "get_modal-orders.php",
                                success: function (response) {
                                    $('#order_modal'+num).empty().html(response);
                                }
                            });

						} else {
							Swal.fire(
								'Something Went Wrong!',
								'Unable to Cancel Your Order.',
								'error'
							);
						}
					}
				});

			})
		})

        // UPDATE ORDER MODAL
        function update_order_modal(num) {
            $.ajax({
                type: "GET",
                url: "get_modal-orders.php",
                success: function (response) {
                    $('#order_modal'+num).empty().html(response);
                }
            });
        }

        // UPDATE ORDER LIST
        function update_order_list(num) {
            $.ajax({
                type: "GET",
                url: "get_order-list.php",
                success: function (response) {
                    $('#list_of_orders').empty().html(response);
                }
            });
        }

	})

</script>

