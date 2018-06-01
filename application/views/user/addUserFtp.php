
<div class="content-box-header panel-heading nav-text">
    <div class="panel-title ">Manage Users Account</div>
    
</div>
<div class="content-box-large box-with-header">
    <div class="panel-body">
    <!-- start form -->
        <form action="<?php echo base_url();?>add-user-account" class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label for="userNameID" class="col-sm-2 control-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" name="userFullName" class="form-control" id="userNameID" placeholder="Full Name">
                </div>
            </div>
            <div class="form-group">
                <label for="userNameID" class="col-sm-2 control-label">User Name</label>
                <div class="col-sm-10">
                    <input type="text" name="userName" class="form-control" id="userNameID" placeholder="User Name">
                </div>
            </div>
            <div class="form-group">
                <label for="emailID" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="userEmail" class="form-control" id="emailID" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="passwordID" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="userPassword" class="form-control" id="passwordID" placeholder="Password">
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
                        <option value="2">User</option>
                        <option value="1">Admin</option>
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
                                <input type="checkbox" name="userFtpAccess[]" value="<?php echo $ftp['id']; ?>"> <?php echo $ftp['ftpName']; ?>
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
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileAdd"> File Add
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileEdit"> File Edit
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileDelete"> File Delete
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="fileRename"> File Rename
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="ftpAdd"> FTP Acc. Add
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="ftpEdit"> FTP Acc. Edit
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="userFtpFileAccess[]" value="ftpDelete"> FTP Acc. Delete
                            </label>
                        </div>
                    </div>
                </div>     
            </div>
            <?php if(!empty($ftps)): ?>       
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Add User Account</button>
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
        <!-- end form -->
    </div>
    <!-- end panel body -->
</div>


<script>
    $('#userFTPAccessArea').hide();

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