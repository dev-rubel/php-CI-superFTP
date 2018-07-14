<?php
if(empty($serverId)):
    echo 'Please open file from main source.';
else:
    list($name,$ext) = explode('.',$file);
?>
<style type="text/css" media="screen">
    pre.ace_editor.ace-monokai.ace_dark {
        height: 400px;
        font-size: 16px;
    }
    #content {
        display: none;
    }
    .state-icon {
        margin-right: 10px;
    }
</style>    

<?php  $rowFile = file_get_contents($path.$file); ?>
<div class="row">
    <div class="col-md-12">
        <p id="savingProcess"></p>        
        <textarea name="code" class="form-control" id="editor"><?php echo $rowFile; ?></textarea>        
    </div>

    <div class="col-md-12">
        <textarea class="form-control" name="content" id="content" rows="5" cols="70" disabled="disabled"></textarea>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <button class="col-md-offset-2 btn btn-primary col-md-8" id="updateFile">Update</button>
</div>

<div class="row">        
    <div class="col-xs-12">
        <h3 class="text-center">Server List</h3>
        <div class="well" style="max-height: 300px;overflow: auto;">
            <ul class="list-group checked-list-box">
                <?php 
                $this->db->select('id, ftpName');
                $ftpServers = $this->db->get('ftp_ftpaccounts')->result_array();?>
                <?php foreach($ftpServers as $k => $each):?>
                    <li class="list-group-item" data-style="button" data-color="success"><?php echo $each['ftpName'];?></li>
                <?php endforeach;?>                
            </ul>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>assets/vendors/jquery/jquery.js"></script>
<!-- ace editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/theme-monokai.js"></script>
<script>
    var textarea = $('#content');
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/<?php echo $ext; ?>");
    /* onchange */
    editor.getSession().on('change', function () {
       textarea.val(editor.getSession().getValue());
   });
   /* inisital change */
   textarea.val(editor.getSession().getValue());
   /* update file to click submit button */
   $("#updateFile").on('click', function () {
    /* server item check */
    var selected = new Array();
    $(".btn-success").each(function() {
        selected.push($(this).text());
    });
    /* if server item selected */
    if(selected.length > 0) {
        $('#updateFile').text('Saving............');
        // console.log(selected);
    for(var i = 0; i < selected.length; i++) {
       $.ajax({
            url: "<?php echo base_url();?>ftpserver/ftpFileUpdate",
            type: 'POST',
            data: {
                    "data": textarea.val(),
                    "fileName":"<?php echo $file; ?>",
                    "serverId":"<?php echo $serverId; ?>",
                    "serverPath":"<?php echo $serverPath; ?>",
                    "localPath":"<?php echo $localPath; ?>",
                    "eachServer": selected[i],
                    "indecator": i
                },           
            success: function (response) {
                // console.log(response);                
                var jData = JSON.parse(response);
                if(jData.type) {
                    toastr.success(jData.msg);
                } else {
                    toastr.error(jData.msg);
                }
                var intval = parseInt(jData.html,10);
                if(intval+1 == selected.length) {
                    $('#updateFile').text('Update'); 
                }
            }
        });
    }    
    /* if not select */
    } else {
        toastr.error('Please select FTP Server.');
    }

});

/* checkbox button style */
$(function () {
    $('.list-group.checked-list-box .list-group-item').each(function () {
        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" />'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };            
        $widget.css('cursor', 'pointer')
        $widget.append($checkbox);
        // Event Handlers
        $widget.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });
        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");
            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);
            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color + ' active');
            } else {
                $widget.removeClass(style + color + ' active');
            }
        }
        // Initialization
        function init() {
            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }            
            updateDisplay();
            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
            }
        }
        init();
    });
    $('#get-checked-data').on('click', function(event) {
        event.preventDefault(); 
        var checkedItems = {}, counter = 0;
        $("#check-list-box li.active").each(function(idx, li) {
            checkedItems[counter] = $(li).text();
            counter++;
        });
        $('#display-json').html(JSON.stringify(checkedItems, null, '\t'));
    });
});
</script>
<!-- end php condition -->
<?php endif;?>