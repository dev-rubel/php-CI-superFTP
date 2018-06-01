<?php 

$folder = [];
$file = [];
$zip = [];
foreach($ftpDir as $k=>$each){
    $ext = getFileOrFolder($each);
    if($ext == 'folder'){
        $folder[] = $each;
    } elseif($ext == 'zip')  {
        $zip[] = $each;
    } elseif($ext == 'file') {
        $file[] = $each;
    }

}
$sortDir = array_merge($folder,$file,$zip);


// debug($_SESSION['previousPath']);
// debug($_SESSION['currentPath']);
?>


<div class="content-box-header panel-heading nav-text">
    <div class="panel-title"><?php echo $ftpInfo['ftpName']; ?> Directory files&folder.</div>
    
</div>
<div class="content-box-large box-with-header">   
<div class="row">

    <div id="controlPanel" class="controlPanel">
    <?php if($_SESSION['currentPath'] !== $_SESSION['basePath']): ?>
        <div class="col-md-2">
            <a href="#" data-path="<?php echo $_SESSION['basePath'];?>">
                <i class="glyphicon glyphicon-fast-backward"></i> Root Folder
            </a>        
        </div>
    <?php endif; ?>
    <?php if($_SESSION['previousPath'] !== $_SESSION['basePath']): ?>
        <div class="col-md-3">
            <a href="#" data-path="<?php echo $_SESSION['previousPath'];?>">
                <i class="glyphicon glyphicon-step-backward"></i> Previous Folder
            </a>        
        </div>
    </div>
    <?php endif; ?>

</div>
        <ul id="tree2">
            <!-- Start li -->
            <?php foreach($sortDir as $k=>$each): 
                    $ext = getFileOrFolder($each);
                    if($ext == 'folder'):
                ?>
                    <!-- Folder -->
                    <li><a href="#" id="folder<?php echo $k+1;?>" data-path="<?php echo $_SESSION['currentPath']==$_SESSION['basePath']?$_SESSION['basePath']:$_SESSION['currentPath'];echo $each.'/'?>"><?php echo $each; ?></a>
                        <ul></ul>
                    </li>
                <?php elseif($ext == 'img'): ?>
                    <!-- Image -->
                    <li id="img<?php echo $k+1;?>"><?php echo $each; ?></li>
                <?php else: ?>                
                    <!-- File -->
                    <li id="file<?php echo $k+1;?>"><?php echo $each; ?></li>
            <?php endif; endforeach; ?>
            <!-- End li -->
        </ul>

</div>

<script>
$(document).ready(function()  {
    $('#controlPanel a').click(function(e)   {
        var path = $(this).data('path');
        $.ajax({
            url: "ftp/getFtpContentTwo",
            type: 'post',
            data: {'path':path},
            success:function(response){
                var jData = JSON.parse(response);

                if(!jData.type) {
                    toastr.error(jData.msg);
                } else {
                    toastr.success(jData.msg);
                    $('#wrapperContent').html(jData.html);                    
                    // console.log(jData.html);
                }
            }
        });
    });
    $('#tree2 li a').click(function(e)   {
        var path = $(this).data('path');
        $.ajax({
            url: "ftp/getFtpContentTwo",
            type: 'post',
            data: {'path':path},
            success:function(response){
                var jData = JSON.parse(response);

                if(!jData.type) {
                    toastr.error(jData.msg);
                } else {
                    toastr.success(jData.msg);
                    $('#wrapperContent').html(jData.html);                    
                    // console.log(jData.html);
                }
            }
        });
    });
});
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews
$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});
</script>