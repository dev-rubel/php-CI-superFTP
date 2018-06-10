function changeFtp(id,info){
    $(".nav li").removeClass('current');
    $(info).addClass('current');
    $.ajax({
        url: "ftpserver/getFtpContent",
        type: 'post',
        data: {'id':id},
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
}

$(document).ready(function()  {
    $('.file-control').hide();
    $(".file-name").hover(function(){
        this.querySelector('.file-control').style.display = 'inline-block';
    },function(){
        this.querySelector('.file-control').style.display = 'none';
    });
    /* end file control script section */
    $('#controlPanel a').click(function(e)   {
        var path = $(this).data('path');
        var dynamicid = $(this).data('dynamicid');
        $.ajax({
            url: "ftpserver/getFtpContentInfo",
            type: 'post',
            data: {'path':path,'dynamicid':dynamicid},
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
    /* end navigation ajax function */
    $('#tree2 li .folderDir').click(function(e)   {
        var path = $(this).data('path');
        var dynamicid = $(this).data('dynamicid');
        $.ajax({
            url: "ftpserver/getFtpContentInfo",
            type: 'post',
            data: {'path':path,'dynamicid':dynamicid},
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
    /* end link ajax function */
});

/* Folder Treeview Script */
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