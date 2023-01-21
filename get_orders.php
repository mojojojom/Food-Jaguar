
<?php 
    session_start();
    // DATABASE
    include('connection/connect.php');
    $query_res= mysqli_query($db,"select * from user_orders where u_id='".$_SESSION['user_id']."'");
    if(!mysqli_num_rows($query_res) > 0 )
    {
        echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
    }
    else
    {		
        while($row=mysqli_fetch_array($query_res))
        {
            $orig_price = $row['price'];
            $subtotal = $orig_price*$row['quantity'];
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
        <span class="badge bg-warning">Queue</span>
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
    <?php
    if($status=="rejected" || $status == "closed") {
    ?>
        <td class="border border-0 d-flex align-items-center justify-content-center">
        <a href="#confirmModal<?=$row['o_id']?>" data-bs-toggle="modal" data-bs-target="#confirmModal<?=$row['o_id']?>" class="o__order-card-item-cancel mb-0 disabled" disabled><i class="fa-solid fa-square-xmark"></i></a>
    </td>
    <?php
    } else {
    ?>
        <td class="border border-0 d-flex align-items-center justify-content-center">
            <a href="#confirmModal<?=$row['o_id']?>" data-bs-toggle="modal" data-bs-target="#confirmModal<?=$row['o_id']?>" class="o__order-card-item-cancel mb-0"><i class="fa-solid fa-square-xmark"></i></a>
        </td>
    <?php
    }
    ?>
</tr>
<!-- Modal -->
<div class="modal fade" id="confirmModal<?=$row['o_id']?>" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-danger fw-bold" id="confirmModalLabel">ATTENTION!</h1>
            </div>
            <div class="modal-body">
                <p class="text-center">Are you sure you want to cancel your order?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" name="cancel_order" data-id="<?=$row['o_id']?>" class="c-btn-sm c-btn-3 cancel_order">Confirm</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php
        }
    }
?>