<div class="portlet box blue">
<div class="portlet-title">
<div class="caption" style="margin-top: 8px">
<i class="fa fa-search"></i><font size="4.5">Search</font></div>
<div class="tools">
<a href="javascript:;" class="collapse" data-original-title="Collapse" title="Collapse"> </a></div>
</div>
<div class="portlet-body">
    <div class="row">
        <div class="col-md-6">
        <div class="form-group form-md-line-input has-info">
            <input type="text" class="form-control" maxlength='15' id="searchImei" name="searchImei" onkeypress="searchByEnter();">
            <span class="help-block"></span>
            <label class="form_control_1">IMEI</label>
        </div>
        </div>

        <div class="col-md-5">
        <div class="form-group form-md-line-input has-info">
            <input type="text" class="form-control" maxlength='2' id="searchImeiSv" name="searchImeiSv" onkeypress="searchByEnter();">
            <span class="help-block"></span>
            <label class="form_control_1">IMEI SV</label>
        </div>
        </div>
        
        <span class="input-group-btn btn-right" style="padding-top: 10px;">
        <button class="btn btn-success btn-md mt-ladda-btn ladda-button btn-circle" onclick="refresh();"> Search
        </button>
        </span>
    </div>


</div>
                            <!-- END EXAMPLE TABLE PORTLET-->
</div>