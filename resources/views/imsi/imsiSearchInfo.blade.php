<div class="portlet box blue">
<div class="portlet-title">
<div class="caption" style="margin-top: 8px">
<i class="fa fa-search"></i><font size="4.5" >Search</font></div>
<div class="tools">
<a href="javascript:;" class="collapse" data-original-title="Collaps" title="Collaps"> </a></div>
</div>
<div class="portlet-body">
    <div class="row">
        <div class="col-md-6">
        <div class="form-group form-md-line-input has-info">
            <input type="search" class="form-control" maxlength='15' id="searchImsi" name="searchImsi" onkeypress="searchByEnter();">
            <span class="help-block"></span>
            <label class="form_control_1">IMSI</label>
        </div>
        </div>

        <div class="col-md-5">
            <div class="form-group form-md-line-input">
            <select class="form-control edited" id="search_subscriber_status" >
            <option value="ALL">All</option>
            <option value="SERVICE_GRANTED">Normal</option>
            <option value="OPERATOR-DETERMINED-BARRING">Blocked</option>
            </select>
            <label for="form_control_1">user state</label>
            </div>
        </div>

        <span class="input-group-btn btn-right" style="padding-top: 10px;">
        <button class="btn btn-success btn-md mt-ladda-btn ladda-button btn-circle" onclick="refresh();">Search
        </button>
        </span>
    </div>

</div>
                            <!-- END EXAMPLE TABLE PORTLET-->
</div>