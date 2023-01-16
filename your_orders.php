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

	<!-- ORDERS SECTIONS -->
	<section class="o__order-wrap sec-pad">
		<div class="container">

			<div class="o__order-content-wrap">

				<div class="row">

					<div class="col-12 col-sm-12 col-md-12 col-lg-8">

						<div class="card">
							<div class="card-body">

								<div class="o__order-card-heading-wrap">
									<h3 class="o__order-card-heading">Overview</h3>
								</div>
									
								<table class="table">
									<thead>
										<tr>
											<th scope="col" class="o__order-card-items-title mb-0 px-0">Product Details</th>
											<th scope="col" class="text-center o__order-card-items-sub-title mb-0 px-0">Price</th>
											<th scope="col" class="text-center o__order-card-items-sub-title mb-0 px-0">Quantity</th>
											<th scope="col" class="text-center o__order-card-items-sub-title mb-0 px-0">Subtotal</th>
											<th scope="col" class="text-center o__order-card-items-sub-title mb-0 px-0">Status</th>
											<th scope="col" class="o__order-card-items-sub-title mb-0 px-0"></th>
										</tr>
									</thead>

									<tbody>

										<?php 
											$query_res= mysqli_query($db,"select * from users_orders where u_id='".$_SESSION['user_id']."'");
											if(!mysqli_num_rows($query_res) > 0 )
											{
												echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
											}
											else
											{		
												while($row=mysqli_fetch_array($query_res))
												{
													$orig_price = $row['price']/$row['quantity'];
													$subtotal = $orig_price*$row['quantity'];
													// $subtotal = $row['price']*$row['quantity'];
										?>

										<tr class="o__order-item-line-wrap">
											<th scope="row" class="o__order-card-item-name border border-0"><?=$row['title']?></th>
											<td class="text-center border border-0"><p class="o__order-card-item-price mb-0">₱ <?=$orig_price?></p></td>
											<td class="text-center border border-0"><p class="o__order-card-item-qty mb-0"><?=$row['quantity']?></p></td>
											<td class="text-center o__order-card-item-sub border border-0">₱ <?=$subtotal?></td>
											<td class="text-center border border-0 o__order-card-item-status">
											<?php
											$status = $row['status'];
											if($status=="" or $status=="NULL")
											{
											?>
												<span class="badge bg-info">Dispatch</span>
											<?php 
											}
											if($status=="in process")
											{ ?>
												<span class="badge bg-warning">On The Way!</span>
											<?php
											}
											if($status=="closed")
											{
											?>
												<span class="badge bg-success">Delivered</span>
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
											</td>
											<td class="border border-0 d-flex align-items-center justify-content-center">
												<a href="#confirmModal" data-bs-toggle="modal" data-bs-target="#confirmModal" class="o__order-card-item-cancel mb-0"><i class="fa-solid fa-square-xmark"></i></a>
											</td>
										</tr>
										<!-- Modal -->
										<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
												<div class="modal-header">
													<h1 class="modal-title fs-5 text-danger fw-bold" id="confirmModalLabel">ATTENTION!</h1>
												</div>
												<div class="modal-body">
													<p class="text-center">Are you sure you want to cancel your order?</p>
												</div>
												<div class="modal-footer">
													<a href="delete_orders?order_del=<?php echo $row['o_id'];?>" type="button" class="btn btn-primary">Confirm</a>
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
												</div>
												</div>
											</div>
										</div>
										<?php
												}
											}
										?>
							
									</tbody>
								</table>

								<div class="row">
									<div class="col-6">

										<div class="o__order-card-bill-wrap">
											<div class="d-flex align-items-center justify-content-between">
												<p class="mb-0 o__order-card-bill-heading">BILL DETAILS</p>

												<?php
													$query_mop = mysqli_query($db, "SELECT mop FROM users_orders WHERE u_id='".$_SESSION['user_id']."'");
													if(mysqli_num_rows($query_mop) > 0) {
														while($echo = mysqli_fetch_array($query_mop)) {
															$mode = $echo['mop'];
														}
												?>
														<span class="badge bg-success text-capitalize"><?=$mode?></span>
												<?php
													}
												?>
											</div>
											<hr class="my-1">
											<div class="o__order-card-bill-sub-wrap">
												<?php
													$query_total = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='".$_SESSION['user_id']."'");

													if(mysqli_num_rows($query_res) > 0) {
														while($row = mysqli_fetch_assoc($query_total)) {
															$item_total += ($orig_price*$row['quantity']);
														}
												?>
														<div class="d-flex align-items-center justify-content-between">
															<p class="o__order-card-bill-sub-title mb-3">Subtotal:</p>
															<p class="o__order-card-bill-sub mb-3">₱ <?= $item_total?></p>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<?php
															$mop = mysqli_query($db, "SELECT mop FROM users_orders WHERE u_id='".$_SESSION['user_id']."'");
															if(mysqli_num_rows($mop) > 0) {
																$get_mop = mysqli_fetch_assoc($mop);

																if($get_mop == 'pick-up'){
															?>
																<p class="o__order-card-bill-sub-title mb-3">Delivery Fee:</p>
																<p class="o__order-card-bill-sub mb-3">₱ 5</p>
															<?php
																} else {
															?>
																<p class="o__order-card-bill-sub-title mb-3">Delivery Fee: </p>
																<p class="o__order-card-bill-sub mb-3">₱ 0</p>
															<?php
																}
															}
															?>
														</div>
														<div class="d-flex align-items-center justify-content-between">
															<p class="o__order-card-bill-sub-title mb-3">Total:</p>
															<?php
															if(mysqli_num_rows($mop) > 0) {
																$get_mop = mysqli_fetch_assoc($mop);
																if($get_mop == 'pick-up') {
																	$s_fee = 5;
																	$total_fee = $s_fee+$item_total;
																?>
																<p class="o__order-card-bill-sub mb-3">₱ <?= $total_fee?></p>
																<?php
																} else {
																	$s_fee = 0;
																	$total_fee = $s_fee+$item_total;
																?>
																<p class="o__order-card-bill-sub mb-3">₱ <?= $total_fee?></p>
																<?php
																}
															}
															?>
														</div>
												<?php
														// }
													}else {
												?>
													<?php
														echo "<p class='text-center mb-3 o__order-card-bill-sub-title'>You have No orders Placed yet.</p>";
														}
													?>


											</div>
										</div>

									</div>
									<div class="col-6"></div>
								</div>

							</div>
						</div>

					</div>

					<div class="col-12 col-sm-12 col-md-12 col-lg-4">
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

									<a href="#editProfileModal<?=$print['u_id']?>" class="o__profile-card-edit-btn c-btn-2" data-bs-toggle="modal" data-bs-target="#editProfileModal<?=$print['u_id']?>">EDIT PROFILE</a>

								</div>

									<p class="o__profile-username o__profile-title mb-0">USERNAME : <span><?= $print['username']?></span></p>
									<p class="o__profile-name o__profile-title mb-0">NAME : <span><?=$fullname?></span></p>
									<p class="o__profile-email o__profile-title mb-0">EMAIL : <span><?=$print['email']?></span></p>
									<p class="o__profile-phone o__profile-title mb-0">MOBILE NUMBER : <span><?=$print['phone']?></span></p>
									<hr>
									<p class="o__profile-address-title o__profile-title mb-0">DELIVERY ADDRESS</p>
									<p class="o__profile-address mb-0"><?=$print['address']?></p>


									<!-- EDIT PROFILE MODAL -->
									<div class="modal fade" id="editProfileModal<?=$print['u_id']?>" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content">
												<form method="POST" id="profile_form">
													<div class="modal-header">
														<h1 class="modal-title fs-5 fw-bold" id="editProfileModalLabel">EDIT PROFILE</h1>
													</div>
													<div class="modal-body">
														<input type="hidden" name="user_id" value="<?=$print['u_id']?>">
														<div class="row">
															<div class="col-12 fj-input-wrap mb-3">
																<label for="username" class="mb-1 s-font">Username</label>
																<input type="text" class="fj-input" name="u_username" value="<?= $print['username'] ?>" placeholder="Username" required>
															</div>
															<div class="col-6 fj-input-wrap mb-3">
																<label for="firstName" class="mb-1 s-font">First Name</label>
																<input type="text" class="fj-input" name="u_firstname" value="<?= $print['f_name'] ?>" placeholder="First Name" required>
															</div>
															<div class="col-6 fj-input-wrap mb-3">
																<label for="lastName" class="mb-1 s-font">Last Name</label>
																<input type="text" class="fj-input" name="u_lastname" value="<?= $print['l_name'] ?>" placeholder="Last Name" required>
															</div>
															<div class="col-6 fj-input-wrap mb-3">
																<label for="email" class="mb-1 s-font">Email Address</label>
																<input type="email" class="fj-input" name="u_email" value="<?= $print['email'] ?>" placeholder="Email Address" required>
															</div>
															<div class="col-6 fj-input-wrap mb-3">
																<label for="phone" class="mb-1 s-font">Mobile Number</label>
																<input type="text" class="fj-input" name="u_phone" value="<?= $print['phone'] ?>" placeholder="Mobile Number" required>
															</div>
															<div class="col-12 fj-input-wrap mb-3">
																<label for="password" class="mb-1 s-font">Password</label>
																<input type="password" class="fj-input" name="u_password" value="<?= $print['password'] ?>" placeholder="Password" required>
															</div>
															<div class="col-12 fj-input-wrap mb-3">
																<label for="address" class="mb-1 s-font d-block">Delivery Address</label>
																<textarea name="u_address" rows="3" placeholder="Address"><?= $print['address'] ?></textarea>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input id="action" type="hidden" name="action" value="editprofile">
														<!-- <input id="action" type="hidden" name="action" value="edit_profile"> -->
														<input type="submit" name="submit" class="btn btn-primary" value="Confirm">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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

	// jQuery(function($) {
	// 	$(document).ready(function () {
	// 		$('#profile_form').submit(function(e) {
	// 			e.preventDefault();
	// 			var formData = $(this).serialize();

	// 			$.ajax({
	// 				type: "POST",
	// 				url: "action.php",
	// 				data: formData,
	// 				before: function() {

	// 				},
	// 				success: function (response) {
						
	// 				}
	// 			});

	// 		})
	// 	})
	// })

</script>