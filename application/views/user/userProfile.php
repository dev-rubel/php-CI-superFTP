
<div class="content-box-header panel-heading nav-text">
    <div class="panel-title ">Users Profile & Update Information</div>
    
</div>
<div class="content-box-large box-with-header">
    <div class="panel-body">
    <!-- start form -->
        <form action="<?php echo base_url();?>update-user-account-info" class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label for="userNameID" class="col-sm-2 control-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" name="userFullName" class="form-control" value="<?php echo $users['userFullName'];?>" id="userNameID" placeholder="Full Name">
                </div>
            </div>
            <div class="form-group">
                <label for="userNameID" class="col-sm-2 control-label">User Name</label>
                <div class="col-sm-10">
                    <input type="text" name="userName" class="form-control" value="<?php echo $users['userName'];?>" id="userNameID" placeholder="User Name" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="emailID" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="userEmail" class="form-control" value="<?php echo $users['userEmail'];?>" id="emailID" placeholder="Email" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="changePasswordID" class="col-sm-2 control-label">Change Password</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="changePassword" id="changePasswordID" onclick="changepassword(this)">
                </div>
            </div>  
            <div id="changePasswordArea">
                <div class="form-group">
                    <label for="oldPasswordID" class="col-sm-2 control-label">Old Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="userOldPassword" class="form-control" id="oldPasswordID" placeholder="Old Password">
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-info" onclick="if (oldPasswordID.type == 'text') oldPasswordID.type = 'password'; else oldPasswordID.type = 'text';"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>  
                <div class="form-group">
                    <label for="newPasswordID" class="col-sm-2 control-label">New Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="userNewPassword" class="form-control" id="newPasswordID" placeholder="New Password">
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-info" onclick="if (newPasswordID.type == 'text') newPasswordID.type = 'password'; else newPasswordID.type = 'text';"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>  
                <div class="form-group">
                    <label for="confPasswordID" class="col-sm-2 control-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="userConfPassword" class="form-control" id="confPasswordID" placeholder="Confirm Password">
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-info" onclick="if (confPasswordID.type == 'text') confPasswordID.type = 'password'; else confPasswordID.type = 'text';"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </div>
                </div>  
            </div>
            <!-- end change password area -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Upade Account Info</button>
                </div>
            </div>
        </form>
        <!-- end form -->
    </div>
    <!-- end panel body -->
</div>

<script>
    $('#changePasswordArea').hide();
    function changepassword(id) {
        if(id.checked) {
            $('#changePasswordArea').show();
        } else {
            $('#changePasswordArea').hide();
        }
    }
</script>