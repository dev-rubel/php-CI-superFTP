<?php
    list($name,$ext) = explode('.',$file);
?>
<style type="text/css" media="screen">
    pre.ace_editor.ace-monokai.ace_dark {
        height: 400px;
        font-size: 16px;
    }
</style>

<?php  $rowFile = file_get_contents($path.$file, FILE_USE_INCLUDE_PATH); ?>
<div class="row">
    <div class="col-md-12">
        <p id="savingProcess"></p>           
        <textarea name="code" class="form-control" id="editor"><?php echo $rowFile; ?></textarea>
    </div>
</div>
<!-- ace editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/theme-monokai.js"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/<?php echo $ext; ?>");
</script>