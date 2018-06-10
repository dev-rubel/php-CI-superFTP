
<div class="content-box-header panel-heading nav-text">
    <div class="panel-title ">Delete FTP Account</div>
    
</div>
<div class="content-box-large box-with-header">
    <div class="panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Host</th>
                    <th>Location Path</th>
                    <th>Port</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($ftps)): 
                        foreach($ftps as $k=>$ftp):
                    ?>
                <tr>
                    <td><?php echo $k+1; ?></td>
                    <td><?php echo $ftp['ftpName']; ?></td>
                    <td><?php echo $ftp['ftpHost']; ?></td>
                    <td><?php echo $ftp['ftpPath']; ?></td>
                    <td><?php echo $ftp['ftpPort']; ?></td>
                    <td>
                        <a href="<?php echo base_url().'delete-ftp-account'.$ftp['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
