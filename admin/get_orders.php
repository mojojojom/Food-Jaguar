<thead>
    <tr>
        <th scope="col">Order Number</th>
        <th scope="col">User</th>
        <th scope="col">Title</th>
        <th scope="col">Quantity</th>
        <th scope="col">Price</th>
        <th scope="col">Address</th>
        <th scope="col">Status</th>
        <th scope="col">Date Ordered</th>
        <th scope="col">Action</th>
    </tr>
</thead>
<tbody>
    <?php
        // DATABASE CONNECTION
        include('../connection/connect.php');
        $get_orders = mysqli_query($db, "SELECT users.*, user_orders.* FROM users INNER JOIN user_orders ON users.u_id=user_orders.u_id");
        // $sql="SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id ";
        if(mysqli_num_rows($get_orders) > 0) {
            while($rows = mysqli_fetch_array($get_orders)){
                $fullname = $rows['f_name'] . " " . $rows["l_name"];
    ?>
                <tr>
                    <td scope="row"><?=$rows['order_number']?></td>
                    <td><?=$fullname?></td>
                    <td><?= $rows['title']?></td>
                    <td><?= $rows['quantity']?></td>
                    <td><?= $rows['price']?></td>
                    <td><?= $rows['address']?></td>
                    <?php 
                        $status=$rows['status'];
                        if($status=="" or $status=="NULL")
                        {
                    ?>
                        <!-- <td> <button type="button" class="btn btn-info"><span class="fa fa-bars"  aria-hidden="true" ></span> Queue</button></td> -->
                        <td class="text-center"><span class="badge bg-warning text-center fw-medium">Queue</span></td>
                    <?php 
                        }
                        if($status=="in process")
                        { 
                    ?>
                        <!-- <td> <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"  aria-hidden="true" ></span> On The Way!</button></td>  -->
                        <td class="text-center"><span class="badge bg-info text-center fw-medium">On The Way</span></td>
                    <?php
                        }
                        if($status=="closed")
                        {
                    ?>
                        <!-- <td> <button type="button" class="btn btn-primary" ><span  class="fa fa-check-circle" aria-hidden="true"></span> Delivered</button></td>  -->
                        <td class="text-center"><span class="badge bg-success text-center fw-medium">Delivered</span></td>
                    <?php 
                        } 
                    ?>
                    <?php
                        if($status=="rejected")
                        {
                    ?>
                        <!-- <td> <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i> Cancelled</button></td>  -->
                        <td class="text-center"><span class="badge bg-danger text-center fw-medium">Cancelled</span></td>
                    <?php 
                        } 
                    ?>
                    <td><?= $rows['date']?></td>
                    <td class="admin__table-actions text-center">
                        <a href="#viewModal<?php echo htmlentities($rows['o_id']);?>" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo htmlentities($rows['o_id']);?>"><i class="fas fa-eye"></i></a>
                        <!-- <a href="#editModal<?php echo htmlentities($rows['u_id']); ?>" data-bs-toggle="modal"><i class="fas fa-pen"></i></a> -->
                        <a href="#" id="delete_order" class="delete_order" data-order="<?=$rows['o_id']?>" class="delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <!------------------------------- MODALS ------------------------------->

                <!-- VIEW MODAL -->
                <div class="modal fade" id="viewModal<?php echo htmlentities($rows['o_id']);?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="viewModalLabel">VIEW ORDER</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                <input type="hidden" name="order_num" value="<?=$rows['o_id']?>">
                                <div class="row">
                                    <div class="col-6 mb-3"><p class="mb-0 fw-bold">NAME</p><p class="mb-0 card p-2"><?=$fullname?></p></div>
                                    <div class="col-6 mb-3"><p class="mb-0 fw-bold">ORDER NAME</p><p class="mb-0 card p-2"><?=$rows['title']?></p></div>
                                    <div class="col-6 mb-3"><p class="mb-0 fw-bold">QUANTITY</p><p class="mb-0 card p-2"><?=$rows['quantity']?></p></div>
                                    <div class="col-6 mb-3"><p class="mb-0 fw-bold">PRICE</p><p class="mb-0 card p-2"><?=$rows['price']?></p></div>
                                    <div class="col-6 mb-3"><p class="mb-0 fw-bold">ADDRESS</p><p class="mb-0 card p-2"><?=$rows['address']?></p></div>
                                    <div class="col-6 mb-3"><p class="mb-0 fw-bold">DATE ORDERED</p><p class="mb-0 card p-2"><?=$rows['date']?></p></div>
                                    <div class="col-6 mb-3">
                                        <p class="mb-0 fw-bold">STATUS</p>
                                        <p class="mb-0 card p-2">
                                            <?php 
                                                $status=$rows['status'];
                                                if($status=="" or $status=="NULL")
                                                {
                                            ?>
                                                <span class="badge bg-warning text-center fw-medium">Queue</span>
                                            <?php 
                                                }
                                                if($status=="in process")
                                                { 
                                            ?>
                                                <span class="badge bg-info text-center fw-medium">On The Way</span>
                                            <?php
                                                }
                                                if($status=="closed")
                                                {
                                            ?>
                                                <span class="badge bg-success text-center fw-medium">Delivered</span>
                                            <?php 
                                                } 
                                            ?>
                                            <?php
                                                if($status=="rejected")
                                                {
                                            ?>
                                                <span class="badge bg-danger text-center fw-medium">Cancelled</span>
                                            <?php 
                                                } 
                                            ?>
                                            </p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p class="mb-0 fw-bold">CHANGE STATUS</p>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>Select Status</option>
                                            <option value="in process">On The Way</option>
                                            <option value="closed">Delivered</option>
                                            <option value="rejected">Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                        </div>
                    </div>
                </div>



    <?php
            }
        } else {
    ?>
        <td colspan="9" class="text-center fw-bold text-danger">No Orders</td>
    <?php
        }
    ?>
</tbody>