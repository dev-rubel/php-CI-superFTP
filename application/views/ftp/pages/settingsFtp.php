
<div class="content-box-header panel-heading nav-text">
    <div class="panel-title ">FTP Settings</div>
    
</div>
<div class="content-box-large box-with-header">
    <!-- start form -->
    <form action="<?php echo base_url();?>update-settings" class="form-horizontal" role="form" method="post">                      
        <div class="form-group">
            <label class="col-sm-2 control-label">General Color</label>
            <div class="col-sm-3">
                <div class="checkbox">
                    <label>
                        <input type="radio" name="systemGeneralColor[]" value="#d9534f"> <p class="radio-color" style="background-color: #d9534f;">#d9534f</p>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="systemGeneralColor[]" value="#f9f9f9"> <p class="radio-color" style="background-color: #f9f9f9;">#f9f9f9</p>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="systemGeneralColor[]" value="#5bc0de" checked="checked"> <p class="radio-color" style="background-color: #5bc0de;">#5bc0de</p>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="systemGeneralColor[]" value="#5cb85c"> <p class="radio-color" style="background-color: #5cb85c;">#5cb85c</p>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="radio" name="systemGeneralColor[]" value="#428bca"> <p class="radio-color" style="background-color: #428bca;">#428bca</p>
                    </label>
                </div>
            </div>

        </div>      
        <br><br>      
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </div>
    </form>
    <!-- end form -->
</div>
