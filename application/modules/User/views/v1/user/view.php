<div class="white-box">
    <div class="table_show">
        <div class="table_head">
            <div class="info">
                <a href="<?php echo site_url('user/add')?>" class="btn btn-info">Tambah Penguna</a>  
            </div>
        </div>
        <table id="table_sort" class="table table-hover" cellspacing="0" width="100%" data-page-length="10">
            <thead>
                <tr>
                    <th width="50px" class="arrow_non">No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Last Update</th>
                    <th width="50px" class="arrow_non">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_user as $key => $user) :?>
                <tr>
                    <td align="center">
                        <?php echo $key+1 ?>
                    </td>
                    <td>
                        <?php echo $user->first_name.' '.$user->last_name;?>
                    </td>
                    <td>
                        <?php echo $user->email;?>
                    </td>
                    <td>
                        <?php echo $user->role=='1'?"Super Admin":($user->role=='2'?'Admin':'CS');?>
                    </td>
                    <td>
                        <?php $last_update= new DateTime($user->updated_at);
                        echo $last_update->format('l, d F Y');?>
                    </td>
                    <td class="action">
                        <a href="<?php echo site_url('user/edit/'.$user->id)?>" title="Edit Data">
                            <span class="fa fa-edit"></span>
                        </a>
                        <a href="javascript:void(0)" class="delete_btn" class="delete" onclick="deleteButton('<?php echo site_url('user/delete/'.$user->id)?>')" title="Hapus Data">
                            <span class="fa fa-remove warning" style="color:red"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $("#table_sort").dataTable();
</script>