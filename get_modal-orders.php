
<?php
    session_start();
    include('connection/connect.php');
    $get_orders = mysqli_query($db, "SELECT SUM(quantity) as quantity,SUM(price) as price, mop, order_number FROM user_orders WHERE u_id='".$_SESSION['user_id']."' GROUP BY order_number , mop");
    if(!mysqli_num_rows($get_orders) > 0) {
        echo '<span class="alert alert-danger text-center fw-bold">No orders found.</span>';
    }else {
        while($row = mysqli_fetch_assoc($get_orders)) {
        
?>
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
                $get_single = mysqli_query($db,'SELECT user_orders.*, (SELECT SUM(price*quantity) FROM user_orders WHERE status != "rejected" AND order_number="'.$row['order_number'].'") as total_price FROM user_orders WHERE order_number="'.$row['order_number'].'"');
                if(!mysqli_num_rows($get_single) > 0) {
            ?>
                <span class="alert alert-danger text-center fw-bold">No orders found.</span>
            <?php
                } else {
                    $total_price= 0;
                    while($dish = mysqli_fetch_assoc($get_single)) {
                        $total_price = $dish['total_price'];
            ?>
                        <?php
                            if($dish['status'] == 'rejected') {
                        ?>
                        <div class="card mb-3 bg-danger">
                            <div class="card-body">
                                <div class="modal__checkout-wrap">
                                    <div class="row">
                                        <div class="modal__checkout-item-desc-wrap col-11">
                                            <p class="modal__checkout-item-name mb-1 fs-5 text-white text-decoration-line-through"><?=$dish["title"]?></p>
                                            <div class="d-flex align-items-center gap-2">
                                                <p class="modal__checkout-item-price mb-0 text-white">₱<?=$dish['price']?></p>
                                                <p class="modal__checkout-item-qty mb-0 text-white">x<?=$dish['quantity']?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-1 d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-square-xmark fs-5 text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            } else {
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
                                                <a href="#" id="cancel_order" data-id="<?=$dish['o_id']?>" class="o__order-card-item-cancel mb-0 cancel_order"><i class="fa-solid fa-square-xmark fs-5"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
            <?php
                    }
                }
            ?>
            
            <div class="card">
                <div class="card-body">
                    <p class="modal__checkout-item-price mb-0 d-flex justify-content-between fw-bold"><span class="fw-normal">TOTAL PRICE : </span>₱<?=$total_price?></p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="c-btn-sm c-btn-3">Save changes</button>
            <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
<?php
    }
}
?>