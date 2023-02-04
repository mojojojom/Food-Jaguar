<?php
    session_start();
    include('../connection/connect.php');
?>

<thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Phone Number</th>
        <th scope="col">Address</th>
        <th scope="col">Action</th>
    </tr>
</thead>
<tbody>
    <?php
        $get_users = mysqli_query($db, "SELECT * FROM users ORDER BY u_id desc");
        $count = 1;
        if(mysqli_num_rows($get_users) > 0) {
            while($rows = mysqli_fetch_array($get_users)){
                $fullname = $rows['f_name'] . " " . $rows["l_name"];
    ?>
                <tr>
                    <td scope="row"><?=$count?></td>
                    <td><?=$fullname?></td>
                    <td><?= $rows['username']?></td>
                    <td><?= $rows['email']?></td>
                    <td><?= $rows['phone']?></td>
                    <td><?= $rows['address']?></td>
                    <td class="d-flex justify-content-around admin__table-actions">
                        <a href="#viewModal<?php echo htmlentities($rows['u_id']);?>" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo htmlentities($rows['u_id']);?>"><i class="fas fa-eye"></i></a>
                        <a href="#editModal<?php echo htmlentities($rows['u_id']); ?>" data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlentities($rows['u_id']);?>"><i class="fas fa-pen"></i></a>
                        <a href="" class="delete delete_user-btn" data-id="<?=$rows['u_id']?>"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>


                <!-- VIEW MODAL -->
                <div class="modal fade" id="viewModal<?php echo htmlentities($rows['u_id']);?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bold" id="viewModalLabel">VIEW USER</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                    $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id='".$rows['u_id']."'");
                                    $fetch = mysqli_fetch_array($get_user);
                                    $full_name = $fetch['f_name'].' '.$fetch['l_name'];
                                ?>
                                <div class="row">
                                    <div class="col-6 mb-3 fj-input-wrap">
                                        <label for="name">Name</label>
                                        <div class="fj-input cursor-default"><?=$full_name?></div>
                                    </div>
                                    <div class="col-6 mb-3 fj-input-wrap">
                                        <label for="name">Username</label>
                                        <div class="fj-input cursor-default"><?=$fetch['username']?></div>
                                    </div>
                                    <div class="col-6 mb-3 fj-input-wrap">
                                        <label for="name">Phone Number</label>
                                        <div class="fj-input cursor-default"><?=$fetch['phone']?></div>
                                    </div>
                                    <div class="col-6 mb-3 fj-input-wrap">
                                        <label for="name">Verification Status</label>
                                        <?php
                                        if($fetch['u_verify'] == 'Yes') {
                                        ?>
                                        <div class="fj-input cursor-default bg-success text-light">Verified</div>
                                        <?php
                                        } else {
                                        ?>
                                        <div class="fj-input cursor-default bg-danger text-light">Not Verified</div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="address">Address</label>
                                        <div class="fj-input"><?=$fetch['address']?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="c-btn-3 c-btn-sm" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EDIT MODAL -->
                <div class="modal fade" id="editModal<?php echo htmlentities($rows['u_id']);?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" id="edit_user" class="edit_user">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 fw-bold" id="editModalLabel">EDIT USER DETAILS</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                        $get_user = mysqli_query($db, "SELECT * FROM users WHERE u_id='".$rows['u_id']."'");
                                        $fetch = mysqli_fetch_array($get_user);
                                        $full_name = $fetch['f_name'].' '.$fetch['l_name'];
                                    ?>
                                    <div class="row">
                                        <input type="hidden" name="user_id" value="<?=$rows['u_id']?>">
                                        <div class="col-6 mb-3 fj-input-wrap">
                                            <label for="name">First Name</label>
                                            <input type="text" name="f_name" class="fj-input f_name" value="<?=$fetch['f_name']?>">
                                        </div>
                                        <div class="col-6 mb-3 fj-input-wrap">
                                            <label for="name">Last Name</label>
                                            <input type="text" name="l_name" class="fj-input l_name" value="<?=$fetch['l_name']?>">
                                        </div>
                                        <div class="col-6 mb-3 fj-input-wrap">
                                            <label for="name">Email</label>
                                            <input type="email" name="email" class="fj-input email" value="<?=$fetch['email']?>">
                                        </div>
                                        <div class="col-6 mb-3 fj-input-wrap">
                                            <label for="name">Phone Number</label>
                                            <input type="text" name="phone" class="fj-input phone" value="<?=$fetch['phone']?>">
                                        </div>
                                        <div class="col-12 mb-3 fj-input-wrap">
                                            <label for="address">Address</label>
                                            <textarea name="address" rows="3" class="fj-input address"><?=$fetch['address']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="u_id" value="<?=$rows['u_id']?>">
                                    <input type="hidden" name="action" value="edit_user">
                                    <button type="submit" class="c-btn-3 c-btn-sm edit_user-btn" data-id="<?=$rows['u_id']?>" data-bs-dismiss="modal">Save</button>
                                    <button type="button" class="c-btn-6 c-btn-sm" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    <?php
        $count = $count+1;
            }
        } else {
    ?>
        <td colspan="7" class="text-center fw-bold text-danger">No Users Availabe</td>
    <?php
        }
    ?>
</tbody>