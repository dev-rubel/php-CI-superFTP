<?php extract($_SESSION['userInfo']); ?>
<div class="sidebar content-box" style="display: block;">
<h3 class="text-center nav-text">Nav Menu</h3>
    <ul class="nav">
        <!-- Main menu -->
        <li class="<?php echo $current==''?'current':'';?>"><a href="<?php echo base_url();?>"><i class="glyphicon glyphicon-home"></i> Home</a></li>
        <?php if($userDesignation == 1): ?>
            <li class="<?php echo $current=='addFtp'?'current':'';?>"><a href="<?php echo base_url();?>add-ftp"><i class="glyphicon glyphicon-calendar"></i> Add FTP</a></li>
            <li class="<?php echo $current=='editFtp'?'current':'';?>"><a href="<?php echo base_url();?>edit-ftp"><i class="glyphicon glyphicon-stats"></i> Edit FTP</a></li>
            <li class="<?php echo $current=='deleteFtp'?'current':'';?>"><a href="<?php echo base_url();?>delete-ftp"><i class="glyphicon glyphicon-list"></i> Delete FTP</a></li>
            
            <li class="<?php echo $current=='addUserFtp'?'current':'';?>"><a href="<?php echo base_url();?>add-user"><i class="glyphicon glyphicon-calendar"></i> Add User</a></li>
            <li class="<?php echo $current=='manageUserFtp'?'current':'';?>"><a href="<?php echo base_url();?>manage-user"><i class="glyphicon glyphicon-list"></i> Manage Account</a></li>
            <li class="<?php echo $current=='settingsFtp'?'current':'';?>"><a href="<?php echo base_url();?>settings"><i class="glyphicon glyphicon-record"></i> Settings</a></li>            
        <?php endif; ?>
    </ul>
</div>