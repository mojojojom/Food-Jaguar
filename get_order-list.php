<?php
session_start();
include('connection/connect.php');
$get_orders = mysqli_query($db, "SELECT SUM(quantity) as quantity,SUM(price) as price, mop, s_fee, s_address, original_address, status, order_number FROM user_orders WHERE u_id='".$_SESSION['user_id']."' AND status != 'rejected' GROUP BY order_number , mop, s_fee,s_address, original_address, status");

if(!mysqli_num_rows($get_orders) > 0) 
{
    echo '<span class="alert alert-danger text-center fw-bold d-flex align-items-center justify-content-center">No orders found.</span>';
}
else 
{
    while($row = mysqli_fetch_assoc($get_orders)) 
    {
        $total_price = $row['price']+$row['s_fee'];
        ?>
        <div class="card mb-3">
            <?php
                if($row['mop'] == 'deliver') 
                {
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
                        if($status=="preparing") 
                        {
                            ?>
                                <span class="badge bg-primary">Preparing</span>
                            <?php
                        }
                        if($status=="in process")
                        { 
                            ?>
                                <span class="badge bg-info">On The Way!</span>
                            <?php
                        }
                        if($status=="closed")
                        {
                            ?>
                                <span class="badge bg-secondary">Delivered</span>
                            <?php 
                        } 
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
                else 
                {
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
                        { 
                            ?>
                                <span class="badge bg-info">On The Way!</span>
                            <?php
                        }
                        if($status=="closed")
                        {
                            ?>
                                <span class="badge bg-secondary">Delivered</span>
                            <?php 
                        } 
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
        <?php
    }
}
?>