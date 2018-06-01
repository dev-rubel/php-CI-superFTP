<div class="content-box-header panel-heading nav-text">
    <div class="panel-title ">Edit User Account</div>
    
</div>
<div class="content-box-large box-with-header">
    <div class="panel-body">
    <!-- start form -->
    <?php if(!empty($users)): 
            foreach($users as $k=>$user): 
            $userFtpAccess = explode(',',$user['userFtpAccess']); 
            $userFtpFileAccess = explode(',',$user['userFtpFileAccess']); 
        ?>
        <form action="<?php echo base_url().'update-user-account/'.$user['id'];?>" class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label for="userNameID" class="col-sm-2 control-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" name="userFullName" class="form-control" value="<?php echo $user['userFullName'] ?>" value="<?php echo $user['userFullName'] ?>" id="userNameID" placeholder="Full Name">
                </div>
            </div>
            <div class="form-group">
                <label for="userNameID" class="col-sm-2 control-label">User Name</label>
                <div class="col-sm-10">
                    <input type="text" name="userName" class="form-control" value="<?php echo $user['userName'] ?>" id="userNameID" placeholder="User Name">
                </div>
            </div>
            <div class="form-group">
                <label for="emailID" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="userEmail" class="form-control" value="<?php echo $user['userEmail'] ?>" id="emailID" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="passwordID" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="userPassword" class="form-control" value="<?php echo $this->encryption->decrypt($user['userPassword']) ?>" id="passwordID" placeholder="Password">
                </div>
                <div class="col-sm-1">
                    <button type="button" class="btn btn-info" onclick="if (passwordID.type == 'text') passwordID.type = 'password'; else passwordID.type = 'text';"><i class="glyphicon glyphicon-eye-open"></i></button>
                </div>
            </div>
            <div class="form-group">
                <label for="passwordID" class="col-sm-2 control-label">Designation</label>
                <div class="col-sm-10">
                    <select name="userDesignation" class="form-control" onchange="userDesignations(this)">
                        <option value="">Select One</option>
                        <option value="2" <?php selected(2,$user['userDesignation']); ?>>User</option>
                        <option value="1" <?php selected(1,$user['userDesignation']); ?>>Admin</option>
                    </select>
                </div>
            </div>
            <div id="userFTPAccessArea">
                <div class="form-group">
                    <label class="col-sm-2 control-label">FTP Access</label>
                    <div class="col-sm-3">
                    <?php if(!empty($ftps)):                                 
                            foreach($ftps as $k=>$ftp):
                        ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpAccess[]" value="<?php echo $ftp['id']; ?>" <?php checked($ftp['id'],$userFtpAccess,'multi'); ?>> <?php echo $ftp['ftpName']; ?>
                            </label>
                        </div>
                    <?php endforeach; endif; ?>                       
                    </div>
                </div>            
                <div class="form-group">
                    <label class="col-sm-2 control-label">FTP File Access</label>
                    <div class="col-sm-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileAdd" <?php checked('fileAdd',$userFtpFileAccess,'multi'); ?>> File Add
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileEdit" <?php checked('fileEdit',$userFtpFileAccess,'multi'); ?>> File Edit
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileDelete" <?php checked('fileDelete',$userFtpFileAccess,'multi'); ?>> File Delete
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileRename" <?php checked('fileRename',$userFtpFileAccess,'multi'); ?>> File Rename
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="ftpAdd" <?php checked('ftpAdd',$userFtpFileAccess,'multi'); ?>> FTP Acc. Add
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="ftpEdit" <?php checked('ftpEdit',$userFtpFileAccess,'multi'); ?>> FTP Acc. Edit
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="ftpDelete" <?php checked('ftpDelete',$userFtpFileAccess,'multi'); ?>> FTP Acc. Delete
                            </label>
                        </div>
                    </div>
                </div>     
            </div>
            <?php if(!empty($ftps)): ?>       
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Update User Account</button>
                </div>
            </div>
            <?php else: ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-danger">Please Add FTP Account First</button>
                    </div>
                </div>
            <?php endif; ?>
        </form>
        <?php endforeach; endif; ?>
        <!-- end form -->
    </div>
    <!-- end panel body -->
</div>


<script>

    function userDesignations(id) {
        if(id.value) {
            if(id.value == 2) {
                $('#userFTPAccessArea').show();
            } else {
                $('#userFTPAccessArea').hide();
            }
        }        
    }
</script>