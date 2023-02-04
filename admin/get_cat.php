
<?php
    // CONNECTION
    include('../connection/connect.php');
    $sql="SELECT * FROM food_category order by f_catid desc";
    $query=mysqli_query($db,$sql);
        if(!mysqli_num_rows($query) > 0 )
        {
            echo '<td colspan="7"><center>No Categories Data!</center></td>';
        }
        else
        {				
            while($rows=mysqli_fetch_array($query))
            {
?>
    <tr>
        <td><?=$rows['f_catname']?></td>
        <td class="text-center">
            <a href="#edit_cat<?=$rows['f_catid']?>" class="mx-2" data-bs-toggle="modal" data-bs-target="#edit_cat<?=$rows['f_catid']?>"><i class="fa-solid fa-pen-to-square"></i></i></a>
            <a href="#delete_cat<?=$rows['f_catid']?>" class="mx-2" data-bs-toggle="modal" data-bs-target="#delete_cat<?=$rows['f_catid']?>"><i class="fa-solid fa-trash text-danger"></i></a> 
        </td>
    </tr>


    <!-- EDIT MODAL -->
    <div class="modal fade edit_modal" id="edit_cat<?=$rows['f_catid']?>" tabindex="-1" aria-labelledby="edit_catLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="edit_catLabel">Update Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <?php 
                                    $ssql ="select * from food_category where f_catid='".$rows['f_catid']."'";
                                    $res=mysqli_query($db, $ssql); 
                                    $row=mysqli_fetch_array($res);
                                    ?>

                                <div class="form-group">
                                    <label class="control-label">Category</label>
                                    <input type="text" name="f_catname" data-name="new_cat" value="<?=$row['f_catname']?>" class="form-control cat_input<?=$row['f_catid']?>" placeholder="Category Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="c-btn-sm c-btn-3 edit_cat-btn" data-id="<?=$row['f_catid']?>">Save changes</button>
                        <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="modal fade delete_modal" id="delete_cat<?=$rows['f_catid']?>" tabindex="-1" aria-labelledby="edit_catLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="edit_catLabel">Delete Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="mb-0">Are you sure you want to delete this category?</h6>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="c-btn-sm c-btn-3 delete_cat-btn" data-id="<?=$row['f_catid']?>">Confirm</button>
                        <button type="button" class="c-btn-sm c-btn-6" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
            }	
        }
?>