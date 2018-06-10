<?php extract($_SESSION['userInfo']); ?>
<?php $ftps = $this->ftpM->getFtpAccounts(); ?>
<div class="col-md-2">
    <div class="sidebar content-box" style="display: block;">
        <h3 class="text-center nav-text">FTP List</h3>
            <ul class="nav">
                <?php if(current_url() == base_url() || current_url() == base_url().'ftp'): ?>
                    <!-- Main menu -->
                    <!-- class="current" -->
                    <?php foreach($ftps as $k=>$ftp): $count = $k+1;
                            if($userDesignation != 1):
                                if(in_array($ftp['id'],$userFtpAccess)):
                    ?>
                        <li onclick="changeFtp('<?php echo $ftp['id']; ?>',this)"><a href="#"><?php echo $count.'. '.$ftp['ftpName']; ?></a></li>
                    <?php endif; else: ?>                
                        <li onclick="changeFtp('<?php echo $ftp['id']; ?>',this)"><a href="#"><?php echo $count.'. '.$ftp['ftpName']; ?></a></li>
                    <?php endif; endforeach; ?>

                <?php else: ?>
                    <li><a href="<?php echo base_url();?>">Back to FTP list</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<script>    
    
</script>