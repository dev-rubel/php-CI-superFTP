<div class="content-box-header panel-heading nav-text">
    <div class="panel-title ">Modify '<?php echo $ftps[0]['ftpName']; ?>' FTP Account</div>
    
</div>
<div class="content-box-large box-with-header">        
    <div class="panel-body">
    <!-- start form -->
    <?php if(!empty($ftps)): foreach($ftps as $k=>$ftp): ?>
        <form action="<?php echo base_url().'update-ftp-account/'.$ftp['id'];?>" class="form-horizontal" role="form" method="post">
        
            <div class="form-group">
                <label for="ftpNameID" class="col-sm-2 control-label">FTP Name</label>
                <div class="col-sm-10">
                    <input type="text" name="ftpName" class="form-control" id="ftpNameID" value="<?php echo $ftp['ftpName']?>" placeholder="Set A Unique Name">
                </div>
            </div>
            <div class="form-group">
                <label for="hostID" class="col-sm-2 control-label">Host</label>
                <div class="col-sm-10">
                    <input type="text" name="ftpHost" class="form-control" id="hostID" value="<?php echo $ftp['ftpHost']?>" placeholder="Host">
                </div>
            </div>
            <div class="form-group">
                <label for="userNameID" class="col-sm-2 control-label">User Name</label>
                <div class="col-sm-10">
                    <input type="text" name="ftpUser" class="form-control" id="userNameID" value="<?php echo $ftp['ftpUser']?>" placeholder="User Name">
                </div>
            </div>
            <div class="form-group">
                <label for="passwordID" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" name="ftpPassword" class="form-control" id="passwordID" value="<?php echo $this->encryption->decrypt($ftp['ftpPassword'])?>" placeholder="Password">                        
                </div>
                <div class="col-sm-1">
                    <button type="button" class="btn btn-info" onclick="if (passwordID.type == 'text') passwordID.type = 'password'; else passwordID.type = 'text';"><i class="glyphicon glyphicon-eye-open"></i></button>
                </div>
            </div>
            <div class="form-group">
                <label for="pathID" class="col-sm-2 control-label">Location Path</label>
                <div class="col-sm-10">
                    <input type="text" name="ftpPath" class="form-control" id="pathID" value="<?php echo $ftp['ftpPath']?>" placeholder="Location Path ['/' for root]">
                </div>
            </div>
            <div class="form-group">
                <label for="portID" class="col-sm-2 control-label">Port</label>
                <div class="col-sm-2">
                    <input type="text" name="ftpPort" class="form-control" id="portID" value="<?php echo $ftp['ftpPort']?>" placeholder="port" value="21" readonly="readonly">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Update FTP Account</button>
                </div>
            </div>
        </form>
        <?php endforeach; endif; ?>
        <!-- end form -->
    </div>
    <!-- end panel body -->
</div>
<!-- end box content -->
