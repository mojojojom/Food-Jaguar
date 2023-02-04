<?php
    include('../connection/connect.php');
?>
<thead>
    <tr>
        <th scope="col">Category</th>
        <th scope="col">Item</th>
        <th scope="col">Description</th>
        <th scope="col">Price</th>
        <th scope="col">Stock</th>
        <th scope="col">Image</th>
        <th scope="col">Action</th>
    </tr>
</thead>
<tbody>
    <?php
        $get_menu = mysqli_query($db, "SELECT * FROM dishes ORDER BY d_id desc");
        if(mysqli_num_rows($get_menu) > 0) {
            while($rows = mysqli_fetch_array($get_menu)){
                $single_dish = mysqli_query($db, "SELECT * FROM food_category WHERE f_catid='".$rows['rs_id']."'");
                $fetch = mysqli_fetch_array($single_dish);
    ?>
                <tr>
                    <td scope="row"><?=$fetch['f_catname']?></td>
                    <td><?= $rows['title']?></td>
                    <td><?= $rows['slogan']?></td>
                    <td><?= $rows['price']?></td>
                    <td><?= $rows['d_stock']?></td>
                    <td>
                        <div class="col-12">
                            <center><img src="Res_img/dishes/<?= $rows['img']?>" class="img-thumbnail" style="height:75px; width: 100%; object-fit: cover;" alt=""></center>
                        </div>
                    </td>
                    <td class="admin__table-actions text-center">
                        <a href="#editModal<?php echo htmlentities($rows['d_id']); ?>"data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlentities($rows['d_id']);?>"><i class="fas fa-pen"></i></a>
                        <a href="#" id="delete_item" class="delete_item" data-item="<?=$rows['d_id']?>" class="delete"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <!------------------------------- MODALS ------------------------------->

                <!-- EDIT MODAL -->
                <div class="modal fade" id="editModal<?=$rows['d_id']?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="dish_form" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">Edit Item</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="dish_id" value="<?=$rows['d_id']?>">
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">Item Name</label>
                                            <input type="text" name="dish_name" class="form-control" placeholder="<?=$rows['title']?>" value="<?=$rows['title']?>">
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">Item Price</label>
                                            <input type="text" name="dish_price" class="form-control" placeholder="<?=$rows['price']?>" value="<?=$rows['price']?>">
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="exampleFormControlTextarea1" class="form-label">Item Description</label>
                                            <textarea class="form-control" name="dish_desc" id="exampleFormControlTextarea1" rows="3"><?=$rows['slogan']?></textarea>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="formFile" class="form-label">Item Image</label>
                                            <input class="form-control" name="dish_img" type="file" id="formFile">
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="formFile" class="form-label">Item Category</label>
                                            <select class="form-select" name="dish_cat" aria-label="Default select example">
                                                <option selected><?=$fetch['f_catname']?></option>
                                                <?php
                                                    $get_category = mysqli_query($db, "SELECT * FROM food_category");
                                                    if(mysqli_num_rows($get_category) > 0) {
                                                        while($cat = mysqli_fetch_array($get_category)) {
                                                ?>
                                                            <option><?=$cat['f_catname']?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="stock">Stocks</label>
                                            <input class="form-control" type="number" name="dish_stock" value="<?=$rows['d_stock']?>">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="action" value="edit_dish">
                                    <button type="submit" class="c-btn-3 c-btn-sm edit_dish" id="edit_dish" dish-id="<?=$rows['d_id']?>">Save</button>
                                    <button type="button" class="c-btn-5 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- DELETE MODAL -->
                <div class="modal fade" id="deleteModal<?=$rows['d_id']?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content view_user-modal">
                            <form action="" method="POST">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 fw-bold" id="deleteModalLabel">DELETE ITEM</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">Are you sure you want to delete this item?</p>
                                    <input type="text" name="id" value="<?=$rows['d_id']?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="c-btn-3 c-btn-sm delete_dish-btn" data-id="<?=$rows['d_id']?>">Confirm</button>
                                    <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
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
