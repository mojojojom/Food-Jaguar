<form method="POST" id="add_menu" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label for="exampleFormControlInput1" class="form-label">Item Name</label>
                                        <input type="text" name="dish_name" class="form-control" placeholder="Item Name">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label for="exampleFormControlInput1" class="form-label">Item Price</label>
                                        <input type="text" name="dish_price" class="form-control" placeholder="₱">
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="exampleFormControlTextarea1" class="form-label">Item Description</label>
                                        <textarea class="form-control" name="dish_desc" id="exampleFormControlTextarea1" placeholder="Item Description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label for="formFile" class="form-label">Item Image</label>
                                        <input class="form-control" name="dish_img" type="file" id="formFile">
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label for="formFile" class="form-label">Item Category</label>
                                        <select class="form-select" name="dish_cat" aria-label="Default select example">
                                            <option selected>--SELECT CATEGORY--</option>
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
                                    <hr>
                                    <div class="col-12">
                                        <input type="hidden" name="action" value="add_dish">
                                        <button type="submit" id="add_dish_btn" class="c-btn-3 c-btn-sm">Add To Menu</button>
                                        <a href="dashboard" class="c-btn-6 c-btn-sm text-decoration-none text-white">Cancel</a>
                                    </div>
                                </div>
                            </form>