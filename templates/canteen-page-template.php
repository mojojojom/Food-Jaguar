<?php
    include('../connection/connect.php');
    session_start();
    $id = $_GET['id'];
    $check_status = mysqli_query($db, "SELECT c_status FROM canteen_table WHERE id = '$id'");
    $stat = mysqli_fetch_assoc($check_status);

    if($stat['c_status'] == '1') {
    ?>
        <?php
        $get_dishes = mysqli_query($db, "SELECT * FROM dishes WHERE c_id = '$id' AND dishes.d_status = 'Post'");
        if(mysqli_num_rows($get_dishes) > 0) {
        ?>
        <div class="row d-flex justify-content-center">
            <?php
            while($rows = mysqli_fetch_array($get_dishes)) {
            ?>
                
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <div class="h__menu-list-box card">
                        
                        <div class="card-body">
                            <!-- TITLE -->
                            <div class="h__menu-list-box-name-wrap text-center">
                                <h1 class="h__menu-list-box-name"><?=$rows['title']?></h1>
                            </div>

                            <!-- IMAGE -->
                            <div class="h__menu-list-box-img-wrap">
                                <img src="../admin/Res_img/dishes/<?=$rows['img']?>" alt="Menu" class="h__menu-list-box-img">
                            </div>

                            <!-- ADD TO CART BUTTON -->
                            <input type="hidden" class="m__menu-qty" id="menu_qty" type="number" name="quantity"  value="1" size="2" />
                            <div class="h__menu-list-btn-wrap d-flex align-items-center justify-content-center gap-2 mt-3">
                                <button href="#qtyModal<?=htmlentities($rows['d_id'])?>" class="h__menu-list-btn addCartBtn" data-bs-toggle="modal" data-bs-target="#qtyModal<?=htmlentities($rows['d_id'])?>">ADD TO CART</button>
                                <div class="h__menu-list-fave-wrap">
                                    <?php
                                        if(isset($_SESSION['user_id'])) {
                                            $check_fave = mysqli_query($db, "SELECT * FROM fave_table WHERE d_id = '".$rows['d_id']."' AND u_id = '".$_SESSION['user_id']."'");
                                            if(mysqli_num_rows($check_fave) > 0) {
                                    ?>
                                            <a href="#" class="h__menu-list-fave-btn fave_btn active" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart text-danger"></i></a>
                                    <?php
                                            } else {
                                    ?>
                                            <a href="#" class="h__menu-list-fave-btn fave_btn" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                                    <?php
                                            }
                                        } else {
                                    ?>
                                            <a href="#" class="h__menu-list-fave-btn fave_btn" data-canteen="<?=$rows['c_id']?>" data-item="<?=$rows['d_id']?>" data-user="<?=$_SESSION['user_id']?>"><i class="fa-solid fa-heart"></i></a>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- QUANTITY MODAL -->
                <div class="modal fade quantity_modal-<?=htmlentities($rows['d_id'])?>" id="qtyModal<?=htmlentities($rows['d_id'])?>" tabindex="-1" aria-labelledby="qtyModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <form id="menu_form">
                                <div class="modal-header">
                                    <h4 class="modal-title fw-bold" id="qtyModalLabel">QUANTITY</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-4">
                                    <input type="hidden" class="add__cart-dish-id" data-product-id="<?=$rows['d_id']?>" value="<?= $rows['d_id']?>">
                                    <div class="card py-2">
                                        <div class="card-body">
                                            <div class="add__cart-dish-name-wrap mb-4">
                                                <h1 class="add__cart-dish-name"><?=$rows['title']?></h1>
                                            </div>

                                            <div class="add__cart-dish-qty-wrap d-block text-center">
                                                <input class="add__cart-dish-qty pe-0" type="number" data-product-qty="quantity" name="quantity" size="2" min="1" value="1" placeholder="1" required/>
                                                <p class="mb-0 mt-2">ENTER QUANTITY</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <?php
                                        $check_stock = mysqli_query($db, "SELECT d_stock FROM dishes WHERE d_id='".$rows['d_id']."'");
                                        while($get_stock = mysqli_fetch_array($check_stock)) {
                                            $stocks = $get_stock['d_stock'];
                                        }
                                        
                                        if($stocks <= 0) {
                                    ?>
                                    <input type="button" class="c-btn-3 disabled" disabled value="OUT OF STOCK">
                                    <?php
                                        } else {
                                    ?>
                                    <input type="hidden" name="action" class="add_action" value="add_cart">
                                    <input type="submit" name="submit" class="c-btn-3 add_cart_btn" data-action-id="add_cart" data-dish-id="<?= $rows['d_id']?>" value="Add to Cart" data-bs-dismiss="modal">
                                    <?php
                                        }
                                    ?>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
        } else {
        ?>
        <span class="alert alert-danger fw-bold text-center d-flex justify-content-center align-items-center mb-0">NO MENU AVAILABLE</span>
        <?php
        }
        ?>
    <?php
    } else {
    ?>
    <span class="alert alert-danger d-flex align-items-center justify-content-center fw-bold text-center text-uppercase"><?=$_GET['canteen']?> IS CLOSE.</span>
    <?php
    }
?>