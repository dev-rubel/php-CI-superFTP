<div class="content-box-header panel-heading nav-text">
    <div class="panel-title ">Manage Users Account</div>
    
</div>
<div class="content-box-large box-with-header">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>FTP Access</th>
                <th>FTP File Access</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($users)): 
                    foreach($users as $k=>$user):
                ?>
            <tr>
                <td><?php echo $k+1; ?></td>
                <td><?php echo $user['userFullName']; ?></td>
                <td><?php echo $user['userEmail']; ?></td>
                <td><?php 
                    $userFtpAccess = explode(',',$user['userFtpAccess']);
                    foreach($userFtpAccess as $k2=>$each){
                        echo $this->ftpM->getFtpAccountName($each).',';
                    }
                ?></td>
                <td><?php echo $user['userFtpFileAccess'] ?></td>
                <td>
                    <a href="<?php echo base_url().'edit-user/'.$user['id'];?>" class="btn btn-info btn-xs">Edit</a>
                    <a href="<?php echo base_url().'delete-user-account/'.$user['id'];?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
    <!-- end table -->
</div>
