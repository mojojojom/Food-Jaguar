<?php
session_start();
include('connection/connect.php');
$get_orders = mysqli_query($db, "SELECT SUM(quantity) as quantity,SUM(price) as price, mop, s_fee, s_address, original_address, status, order_number FROM user_orders WHERE u_id='".$_SESSION['user_id']."' AND status <> 'rejected' GROUP BY order_number , mop, s_fee,s_address, original_address, status");
if(!mysqli_num_rows($get_orders) > 0) {
    echo '<span class="alert alert-danger text-center fw-bold d-flex align-items-center justify-content-center">No orders found.</span>';
}else {
    while($row = mysqli_fetch_assoc($get_orders)) {
        $row_total_price = $row['price']+$row['s_fee'];
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
                    <p class="mb-0">TOTAL PRICE : <span>₱<?=$row_total_price?></span></p>
                </div>
            </div>
        </div>


        <!-- ORDER MODAL -->
        <div class="modal fade order_modal-wrap" id="order_modal<?=$row['order_number']?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" name="hidden_num" value="<?=$row['order_number']?>">
                    <h1 class="modal-title fs-5">ORDER #<?=$row['order_number']?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="">
                    <input type="hidden" value="<?=$row['order_number']?>">
                    <?php
                        $get_single = mysqli_query($db,'SELECT user_orders.*, (SELECT SUM(price) FROM user_orders WHERE status != "rejected" AND order_number="'.$row['order_number'].'") as total_price FROM user_orders WHERE u_id="'.$_SESSION["user_id"].'" AND order_number="'.$row['order_number'].'"');
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
                                                        <p class="modal__checkout-item-price mb-0">₱<?=$dish['price']?></p>
                                                        <p class="modal__checkout-item-qty mb-0">x<?=$dish['quantity']?></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-1 d-flex align-items-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <a href="#" id="cancel_order" data-date="<?=$dish['date']?>" data-id="<?=$dish['o_id']?>" class="o__order-card-item-cancel mb-0 cancel_order"><i class="fa-solid fa-square-xmark fs-5"></i></a>
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
                    <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">CLOSE</button>
                    <a href="download.php?id=<?=$row['order_number']?>" target="_blank" class="c-btn-sm c-btn-4 text-decoration-none">RECEIPT</a>
                </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>