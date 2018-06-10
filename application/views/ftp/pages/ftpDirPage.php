<?php  
$folder = [];
$file = [];
$zip = [];
$img = [];
foreach($ftpDir as $k=>$each){
    $ext = getFileOrFolder($each);
    if($ext == 'folder'){
        $folder[] = $each;
    } elseif($ext == 'zip')  {
        $zip[] = $each;
    } elseif($ext == 'file') {
        $file[] = $each;
    } elseif($ext == 'img') {
        $img[] = $each;
    }
}
$sortDir = array_merge($folder,$file,$zip,$img);
?>

<style>
 .dir-list-padding {
    padding: 10px 0px;
 }
 .form-control {
     height: 30px !important;
 } 
 .form-group {
    margin-bottom: 0px;
}
</style>

<div class="content-box-header panel-heading nav-text">
    <div class="panel-title"><?php echo $ftpInfo['ftpName']; ?> Directory files&folder.</div>    
</div>
<div class="content-box-large box-with-header">   
<div class="row controlPanel" id="controlPanel">
    
    <div class="col-md-12">
        <div class="col-md-5 dir-list dir-list-padding">
            <form id="uploadFile">
                <div class="form-group">
                    <div class="col-md-8">
                        <input type="file" name="filename" data-text="Upload file" class="filestyle" data-btnClass="btn-primary" data-placeholder="No file" data-size="sm"> 
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-info btn-sm">Upload</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 dir-list dir-list-padding">
            <form id="renameFile">
                <div class="form-group">
                    <div class="col-md-5">
                        <input type="text" name="oldFileName" class="form-control" placeholder="Old file name"> 
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="newFileName" class="form-control" placeholder="New file name"> 
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-sm">Rename</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-2 dir-list">
            <a href="#" 
            data-path="<?php echo $_SESSION[$ftpIdDynamic]['basePath'];?>"
            data-dynamicid="<?php echo $ftpIdDynamic; ?>">
                Root
            </a>        
        </div>
        <?php 
            $current_path = '';
            $need_base_path = '';        
            if(strpos($_SESSION[$ftpIdDynamic]['currentPath'],$_SESSION[$ftpIdDynamic]['basePath'])){
                $need_base_path = $_SESSION[$ftpIdDynamic]['basePath'];
            }        
        ?>
        <?php         
            $paths = explode('/',$_SESSION[$ftpIdDynamic]['currentPath']);        
            foreach($paths as $k=>$path):                
                if(!empty($path)):
                    $current_path .= $path.'/';
                    
        ?>    
        <div class="col-md-2 dir-list">
            <a href="#" 
            data-path="<?php echo '/'.$need_base_path.$current_path;?>"
            data-dynamicid="<?php echo $ftpIdDynamic; ?>">
                <?php echo $path; ?>
            </a>        
        </div>
        <?php endif; endforeach; ?>
        <br>
    </div>     

</div>

    <ul id="tree2">
        <!-- Start li -->
        <?php foreach($sortDir as $k=>$each): 
                $ext = getFileOrFolder($each);
                if($ext == 'folder'):
            ?>
                <!-- Folder -->
                <li>
                    <a href="#" 
                    class="folderDir"
                    id="folder<?php echo $k+1;?>" 
                    data-path="<?php echo $_SESSION[$ftpIdDynamic]['currentPath']==$_SESSION[$ftpIdDynamic]['basePath']?$_SESSION[$ftpIdDynamic]['basePath']:$_SESSION[$ftpIdDynamic]['currentPath'];echo $each.'/'?>"
                    data-dynamicid="<?php echo $ftpIdDynamic; ?>">
                        <?php echo $each; ?>
                    </a>
                    <ul></ul>
                </li>
            <?php elseif($ext == 'img'): ?>
                <!-- Image -->
                <li id="img<?php echo $k+1;?>">
                    <?php  
                        $imgInfo = explode('.',$each); 
                        /* select last and first index. if found show file extention. */
                        if(!empty(array_values(array_slice($imgInfo, -1))[0]) && !empty($imgInfo[0])) {
                            echo 
                            '<span class="fileExt">.
                            '.array_values(array_slice($imgInfo, -1))[0].
                            '</span>';
                        }
                            echo $imgInfo[0];                        
                    ?>
                </li>
            <?php else: ?>
                <!-- File -->
                <li id="file<?php echo $k+1;?>">
                <?php  
                    $imgInfo = explode('.',$each); 
                    if(!empty($imgInfo[0])) {
                        /* select last and first index. if found show file extention. */
                        if(!empty(array_values(array_slice($imgInfo, -1))[0]) && !empty($imgInfo[0])) {
                            echo '<span class="fileExt">.
                            '.array_values(array_slice($imgInfo, -1))[0].
                            '</span>';
                        }
                        echo 
                        '<span class="file-name">'.
                            $imgInfo[0].                            
                        '<span class="file-control">'.
                            '<a href="'.base_url('/ftp-file-edit/'.$ftpIdDynamic.'/'.$each).'" title="Edit" target="_blank"><i class="fa fa-edit"></i></a>|'.
                            '<a href="#" title="Copy To"><i class="fa fa-clone"></i></a>|'.
                            '<a href="#" title="Move To"><i class="fa fa-copy"></i></a>'.
                            '|<a href="#" title="Delete"><i class="fa fa-trash"></i></a>'.
                        '</span>'.
                        '</span>'
                        ;
                    }
                ?>
                </li>
        <?php endif; endforeach; ?>
        <!-- End li -->
    </ul>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/2.1.0/bootstrap-filestyle.min.js"></script>

<script src="<?php echo base_url();?>assets/js/ftp.js"></script>
<script>
// file upload form Submit
$("#uploadFile").submit(function(evt){	 
      evt.preventDefault();
      var formData = new FormData($(this)[0]);
   $.ajax({
       url: "<?php echo base_url();?>ftpserver/test",
       type: 'POST',
       data: formData,
       async: false,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (response) {
         console.log(response);
       }
   });
   return false;
 });
// rename form Submit
$("#renameFile").submit(function(evt){	 
      evt.preventDefault();
      var formData = new FormData($(this)[0]);
   $.ajax({
       url: "<?php echo base_url();?>ftpserver/test2",
       type: 'POST',
       data: formData,
       async: false,
       cache: false,
       contentType: false,
       processData: false,
       success: function (response) {
         console.log(response);
       }
   });
   return false;
 });
</script>