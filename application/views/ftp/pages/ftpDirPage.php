<div id="wrapperContent2">
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

    <!-- start file copy section -->
        <?php if(isset($_SESSION[$ftpIdDynamic]['copyPath'])):?>
            <div class="col-md-12" id="copySection">
                <div>
                    <a href="#" class="btn btn-info btn-sm" onclick="fileCopy('<?php echo base_url('/ftp-file-copy-transfer/'.$ftpIdDynamic)?>')"
                        <?php if($_SESSION[$ftpIdDynamic]['copyPath']['path'] == $_SESSION[$ftpIdDynamic]['currentPath']):?>
                            disabled="disabled">Please Change Dir.
                        <?php else:?>
                            >Copy Here
                        <?php endif;?>                    
                    </a>
                    <a href="#" class="btn btn-warning btn-sm" onclick="fileCopyCancle('<?php echo base_url('/ftp-cancle-copy/'.$ftpIdDynamic)?>')">Cancle</a>
                </div>
            </div>
            <br><br>
        <?php endif;?>
    <!-- end file copy section -->

    <!-- start file move section -->
        <?php if(isset($_SESSION[$ftpIdDynamic]['movePath'])):?>
            <div class="col-md-12" id="moveSection">
                <div>
                    <a href="#" class="btn btn-info btn-sm" onclick="fileMove('<?php echo base_url('/ftp-file-move-transfer/'.$ftpIdDynamic)?>')"
                        <?php if($_SESSION[$ftpIdDynamic]['movePath']['path'] == $_SESSION[$ftpIdDynamic]['currentPath']):?>
                            disabled="disabled">Please Change Dir.
                        <?php else:?>
                            >Move Here
                        <?php endif;?>                    
                    </a>
                    <a href="#" class="btn btn-warning btn-sm" onclick="fileMoveCancle('<?php echo base_url('/ftp-cancle-move/'.$ftpIdDynamic)?>')">Cancle</a>
                </div>
            </div>
            <br><br>
        <?php endif;?>
    <!-- end file move section -->

    <!-- start action section -->
        <?php if(!isset($_SESSION[$ftpIdDynamic]['movePath']) && !isset($_SESSION[$ftpIdDynamic]['copyPath'])):?>
            <div class="col-md-12" id="actionSection">
                <!--  -->
                <div class="col-md-6 dir-list dir-list-padding">
                    <form id="mkdir">
                        <div class="form-group">
                            <div class="col-md-8">
                                <input type="text" name="foldername" class="form-control" placeholder="Folder name"> 
                                <input type="hidden" name="directoryId" value="<?php echo $ftpIdDynamic;?>"> 
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-info btn-sm">Create Folder</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-6 dir-list dir-list-padding">
                    <form id="uploadFile" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-8">
                                <input type="file" name="filename" data-text="Upload file" class="filestyle" data-btnClass="btn-primary" data-placeholder="No file" data-size="sm"> 
                                <input type="hidden" name="directoryId" value="<?php echo $ftpIdDynamic;?>"> 
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-info btn-sm">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12 dir-list dir-list-padding">
                    <form id="renameFile">
                        <div class="form-group">
                            <div class="col-md-5">
                                <input type="text" name="oldFileName" class="form-control" placeholder="Old file/folder name"> 
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="newFileName" class="form-control" placeholder="New file/folder name"> 
                            </div>
                            <div class="col-md-2">
                                <input type="hidden" name="directoryId" value="<?php echo $ftpIdDynamic;?>"> 
                                <button type="submit" class="btn btn-info btn-sm">Rename</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        <?php endif;?>
    <!-- end action section -->

    <!-- start location tab section -->
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
    <!-- end location tab section -->
</div>
    <!-- start ul section -->
    <ul id="tree2">
        <!-- Start li -->
            <?php foreach($sortDir as $k=>$each): 
                    $ext = getFileOrFolder($each);
                    if($ext == 'folder'):
                ?>
                    <!-- start folder section -->
                        <li>
                            <a href="#" 
                            class="folderDir"
                            id="folder<?php echo $k+1;?>" 
                            data-path="<?php echo $_SESSION[$ftpIdDynamic]['currentPath']==$_SESSION[$ftpIdDynamic]['basePath']?$_SESSION[$ftpIdDynamic]['basePath']:$_SESSION[$ftpIdDynamic]['currentPath'];echo $each.'/'?>"
                            data-dynamicid="<?php echo $ftpIdDynamic; ?>">
                                <?php echo $each; ?>
                            </a>
                            <?php
                                echo                        
                                '<span>'.
                                    ' <a href="'.base_url('/ftp-folder-delete/'.$ftpIdDynamic.'/'.$each).'" title="Delete" class="delete-confirm" data-confirm="Are you sure to delete this folder? This will remove all subfolder and files also."><i class="fa fa-trash"></i></a>'.
                                '</span>'
                                ;
                            ?>
                            <ul></ul>                    
                        </li>
                    <!-- end folder section -->
                <?php elseif($ext == 'img'): ?>
                    <!-- start image section -->
                        <li id="img<?php echo $k+1;?>">
                        <?php  
                            $imgInfo = explode('.',$each); 
                            if(!empty($imgInfo[0])) {
                                /* select last and first index. if found show file extention. */
                                if(!empty(array_values(array_slice($imgInfo, -1))[0]) && !empty($imgInfo[0])) {
                                    echo '<span class="fileExt">.
                                    '.array_values(array_slice($imgInfo, -1))[0].
                                    '</span>';
                                }
                                /* option remove when move file select */
                                if(isset($_SESSION[$ftpIdDynamic]['movePath']) && 
                                $_SESSION[$ftpIdDynamic]['movePath']['file'] == $each && 
                                $_SESSION[$ftpIdDynamic]['movePath']['path'] == $_SESSION[$ftpIdDynamic]['currentPath']
                                ||
                                /* option remove when copy file select */
                                isset($_SESSION[$ftpIdDynamic]['copyPath']) && 
                                $_SESSION[$ftpIdDynamic]['copyPath']['file'] == $each && 
                                $_SESSION[$ftpIdDynamic]['copyPath']['path'] == $_SESSION[$ftpIdDynamic]['currentPath']) {
                                    echo 
                                    '<span class="file-name">'.
                                        $imgInfo[0].                            
                                    '<span class="file-control">'.
                                        ' | Selected File'.
                                    '</span>'.
                                    '</span>'
                                    ;
                                } else {
                                    echo 
                                    '<span class="file-name">'.
                                        $imgInfo[0].                            
                                    '<span class="file-control">'.
                                    '<a href="'.base_url('/ftpserver/ftpFileDownload/'.$ftpIdDynamic.'/'.$each).'" title="Download" target="_blank"><i class="fa fa-download"></i></a>';
                                        /* remove copy/move option if move/copy path exist */
                                        if(!isset($_SESSION[$ftpIdDynamic]['movePath']) && 
                                            !isset($_SESSION[$ftpIdDynamic]['copyPath'])) {
                                                echo '|<a href="'.base_url('/ftp-file-copy/'.$ftpIdDynamic.'/'.$each).'" title="Copy To" class="copy-confirm"><i class="fa fa-clone"></i></a>|'.
                                                '<a href="'.base_url('/ftp-file-move/'.$ftpIdDynamic.'/'.$each).'" title="Move To" class="move-confirm"><i class="fa fa-copy"></i></a>';
                                        }
                                        echo '|<a href="'.base_url('/ftp-file-delete/'.$ftpIdDynamic.'/'.$each).'" title="Delete" class="delete-confirm" data-confirm="Are you sure to delete this item?"><i class="fa fa-trash"></i></a>'.
                                    '</span>'.
                                    '</span>'
                                    ;
                                }
                            }
                        ?>
                        </li>
                    <!-- end image section -->
                <?php elseif($ext == 'zip'): ?>
                    <!-- start zip section -->
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
                                echo 
                                '<span class="file-name">'.
                                    $imgInfo[0].                            
                                '<span class="file-control">'.
                                    '<a href="#" title="Extract"><i class="fa fa-arrows-alt"></i></a>|'.
                                    '<a href="'.base_url('/ftpserver/ftpFileDownload/'.$ftpIdDynamic.'/'.$each).'" title="Download" target="_blank"><i class="fa fa-download"></i></a>|'.
                                    '<a href="#" title="Copy To"><i class="fa fa-clone"></i></a>|'.
                                    '<a href="#" title="Move To"><i class="fa fa-copy"></i></a>'.
                                    '|<a href="'.base_url('/ftp-file-delete/'.$ftpIdDynamic.'/'.$each).'" title="Delete" class="delete-confirm" data-confirm="Are you sure to delete this item?"><i class="fa fa-trash"></i></a>'.
                                '</span>'.
                                '</span>'
                                ;                       
                            ?>
                        </li>
                    <!-- end zip section -->
                <?php else: ?>
                    <!-- start file section -->
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
                                /* option remove when move file select */
                                if(isset($_SESSION[$ftpIdDynamic]['movePath']) && 
                                $_SESSION[$ftpIdDynamic]['movePath']['file'] == $each && 
                                $_SESSION[$ftpIdDynamic]['movePath']['path'] == $_SESSION[$ftpIdDynamic]['currentPath']
                                ||
                                /* option remove when copy file select */
                                isset($_SESSION[$ftpIdDynamic]['copyPath']) && 
                                $_SESSION[$ftpIdDynamic]['copyPath']['file'] == $each && 
                                $_SESSION[$ftpIdDynamic]['copyPath']['path'] == $_SESSION[$ftpIdDynamic]['currentPath']) {
                                    echo 
                                    '<span class="file-name">'.
                                        $imgInfo[0].                            
                                    '<span class="file-control">'.
                                        ' | Selected File'.
                                    '</span>'.
                                    '</span>'
                                    ;
                                } else {
                                    echo 
                                    '<span class="file-name">'.
                                        $imgInfo[0].                            
                                    '<span class="file-control">'.
                                        '<a href="'.base_url('/ftp-file-edit/'.$ftpIdDynamic.'/'.$each).'" title="Edit" target="_blank"><i class="fa fa-edit"></i></a>';
                                        /* remove copy/move option if move/copy path exist */
                                        if(!isset($_SESSION[$ftpIdDynamic]['movePath']) && 
                                            !isset($_SESSION[$ftpIdDynamic]['copyPath'])) {
                                                echo '|<a href="'.base_url('/ftp-file-copy/'.$ftpIdDynamic.'/'.$each).'" title="Copy To" class="copy-confirm"><i class="fa fa-clone"></i></a>|'.
                                                '<a href="'.base_url('/ftp-file-move/'.$ftpIdDynamic.'/'.$each).'" title="Move To" class="move-confirm"><i class="fa fa-copy"></i></a>';
                                        }
                                        echo '|<a href="'.base_url('/ftp-file-delete/'.$ftpIdDynamic.'/'.$each).'" title="Delete" class="delete-confirm" data-confirm="Are you sure to delete this item?"><i class="fa fa-trash"></i></a>'.
                                    '</span>'.
                                    '</span>'
                                    ;
                                }
                            }
                        ?>
                        </li>
                    <!-- end file section -->
            <?php endif; endforeach; ?>
        <!-- End li -->
    </ul>
    <!-- end ul section -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-filestyle/2.1.0/bootstrap-filestyle.min.js"></script>

<script src="<?php echo base_url();?>assets/js/ftp.js"></script>
<script>

/* delete file or images */
var deleteLinks = document.querySelectorAll('.delete-confirm');
for (var i = 0; i < deleteLinks.length; i++) {
    deleteLinks[i].addEventListener('click', function(event) {
        event.preventDefault();
        var choice = confirm(this.getAttribute('data-confirm'));
        if (choice) {
            $.ajax({
                url: this.getAttribute('href'),
                success: function (response) {
                    var jData = JSON.parse(response);
                    if(!jData.type) {
                        toastr.error(jData.msg);
                        console.log(jData.html);
                    } else {
                        toastr.success(jData.msg);
                        $('#wrapperContent2').html(jData.html);
                    }
                }
            });
        }
    });
}
/* file upload form Submit */
$("#uploadFile").submit(function(evt) {
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: "<?php echo base_url();?>ftpserver/ftpFileUpload",
        type: 'POST',
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        success: function (response) {
            var jData = JSON.parse(response);
            if(!jData.type) {
                toastr.error(jData.msg);
                console.log(jData.html);
            } else {
                toastr.success(jData.msg);
                $('#wrapperContent2').html(jData.html); 
            }
        }
    });
    return false;
});
 /* make folder form Submit */
$("#mkdir").submit(function(evt) {
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: "<?php echo base_url();?>ftpserver/ftpMakeFolder",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            var jData = JSON.parse(response);
            if(!jData.type) {
                toastr.error(jData.msg);
                console.log(jData.html);
            } else {
                toastr.success(jData.msg);
                $('#wrapperContent2').html(jData.html); 
            }
        }
    });
    return false;
});
/* rename form Submit */
$("#renameFile").submit(function(evt) {
    evt.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: "<?php echo base_url();?>ftpserver/ftpFileRename",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            var jData = JSON.parse(response);
            if(!jData.type) {
                toastr.error(jData.msg);
                console.log(jData.html);
            } else {
                toastr.success(jData.msg);
                $('#wrapperContent2').html(jData.html); 
            }
        }
    });
    return false;
});

/* move file or images */
var moveLinks = document.querySelectorAll('.move-confirm');
for (var i = 0; i < moveLinks.length; i++) {
    moveLinks[i].addEventListener('click', function(event) {
        event.preventDefault();
            $.ajax({
                url: this.getAttribute('href'),
                success: function (response) {
                    var jData = JSON.parse(response);
                    console.log('move-confirm');
                    $('#wrapperContent2').html(jData.html);
                }
            });
    });
}
/* copy file or images */
var copyLinks = document.querySelectorAll('.copy-confirm');
for (var i = 0; i < copyLinks.length; i++) {
    copyLinks[i].addEventListener('click', function(event) {
        event.preventDefault();
            $.ajax({
                url: this.getAttribute('href'),
                success: function (response) {
                    var jData = JSON.parse(response);
                    console.log('copy-confirm');
                    $('#wrapperContent2').html(jData.html);
                }
            });
    });
}
/* file move */
// var fileMove = document.getElementById('fileMove');
// fileMove.addEventListener('click', function(event) {
//     event.preventDefault();
function fileMove(url) {
    $.ajax({
        url: url,
        success: function (response) {
            var jData = JSON.parse(response);
            console.log('move-file');
            if(!jData.type) {
                toastr.error(jData.msg);
                console.log(jData.html);
            } else {
                toastr.success(jData.msg);
                $('#wrapperContent2').html(jData.html);
            }
        }
    });
}
// });
/* cancle move */
// var cancleMove = document.getElementById('cancleMove');
// cancleMove.addEventListener('click', function(event) {
//     event.preventDefault();
function fileMoveCancle(url) {
    $.ajax({
        url: url,
        success: function (response) {            
            var jData = JSON.parse(response);
            toastr.success(jData.msg);
            $('#wrapperContent2').html(jData.html);
        }
    });
}
// });

/* file copy */
// var fileCopy = document.getElementById('fileCopy');
// fileCopy.addEventListener('click', function(event) {
//     event.preventDefault();
function fileCopy(url) {
    $.ajax({
        url: url,
        success: function (response) {
            var jData = JSON.parse(response);
            console.log('copy-file');
            if(!jData.type) {
                toastr.error(jData.msg);
                console.log(jData.html);
            } else {
                toastr.success(jData.msg);
                $('#wrapperContent2').html(jData.html);
            }
        }
    });
}
// });
/* cancle copy */
// var cancleCopy = document.getElementById('cancleCopy');
// cancleCopy.addEventListener('click', function(event) {
//     event.preventDefault();
function fileCopyCancle(url) {
    $.ajax({
        url: url,
        success: function (response) {            
            var jData = JSON.parse(response);
            toastr.success(jData.msg);
            $('#wrapperContent2').html(jData.html);
        }
    });
}
// });




</script>
</div>