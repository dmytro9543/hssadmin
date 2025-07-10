<div id="IMSIModal" class="modal fade" data-width="800">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><font id="AddIMSI" size = "5"  color="red">Add IMSI</font></h4>
     </div>
    <div class="modal-body">
    <div class="portlet-body form"> 
    <div class="form-body">
        <div class="row"><div class="col-md-12">
        <div class="portlet box blue">
        <div class="portlet-title">
        <div class="caption">
        <i class="fa fa-comments">
        <font size = "3"  color="white">Basic information</font>
        </i>
        </div>
        </div>
        <div class="portlet-body">
        <div class="portlet-body form"> 
        <div class="form-body">
        <div class="row">
                <input type="hidden" id="IMSI_id" >
        <input type="hidden" id="tmp">
        
        <div class="col-md-4">
        <div class="form-group form-md-line-input has-info">
        <input type="text" class="form-control" maxlength='15' id="imsi_dlg" name="imsi">
        <span class="help-block">must contain 15 numers</span>
        <label class="form_control_1">IMSI</label>
        </div>
        </div>


        <div class="col-md-4">
        <div class="form-group form-md-line-input has-info">
        <input type="text" class="form-control" id="msisdn" name="msisdn_dlg">
        <span class="help-block"></span>
        <label>Phone</label>
        </div>
        </div>


        <div class="col-md-4">
        <div class="form-group form-md-line-input">
        <select class="form-control edited" id="profileName" onchange="getProfileInfo();">
                       
        </select>
        <label for="form_control_1">Profile</label>
        </div>
        </div>
        <input type="hidden" id="profileId">
        <div class="row">
        <div class="col-md-12 col-sm-12">
        <div style="height: 10px"></div>
        <div class = "table table-bordered ">
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-12">
        <div class="form-group form-md-line-input has-info">
        <input type="text" class="form-control" id="ki_dlg" name="ki_dlg">
        <label class="form_control_1">KI</label>
        <span class="help-block">hexadecimal letters</span>
        </div>
        </div>
        </div>

        <div class="row" style="padding-top: 10px;">
        <div class="col-md-6">
        <div class="form-group form-md-line-input">
        <input type="text" class="form-control" id="rau_tau_timer_dlg" name="rau_tau_timer_dlg">
        <label class="form_control_1">Rau-Tau</label>
        <span class="help-block">must be seconds</span>
        </div>
        </div>

        <div class="col-md-6">
        <div class="form-group form-md-line-input">
        <select class="form-control edited" id="subscriber_status" >
        <option value="SERVICE_GRANTED">Normal</option>
        <option value="OPERATOR-DETERMINED-BARRING">Blocked</option>
        </select>
        <label for="form_control_1">User State</label>
        </div>
        </div>
          
        </div>
        <div style="height: 10px"></div>
        <div class="row">
        <div class="col-md-6">
        <div class="form-group form-md-line-input">
        <input type="text" class="form-control" id="ue_ambr_ul_dlg" name="ue_ambr_ul_dlg">
        <span class="help-block">unit must be Mbps</span>
        <label class="form_control_1">Max Upload</label>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group form-md-line-input">
        <input type="text" class="form-control" id="ue_ambr_dl_dlg" name="ue_ambr_dl">
        <span class="help-block">unit must be Mbps</span>
        <label>Max Download</label>
        </div>
        </div>
              
        </div>


        <div class="row" style="margin-top:15px"><div class="col-md-12">
        <div class="form-group form-md-line-input has-info" >
        <textarea class="form-control" rows="1" id='remark'></textarea>
        <label for="form_control_1">Comment</label>
        </div>
        </div>
        </div>

        <div style="height: 10px"></div>
        <div class="row"><div class="col-md-12">
        <div class="portlet light bordered">    
        <div class="portlet-title">
        <div class="caption">
        <i class="icon-settings font-blue">
        <font size = "3"  color="blue">Allowed PDN List</font>
        </i>
        <span class="caption-subject font-red sbold uppercase"></span>
        </div>
        </div>
        <div class="portlet-body" id="apnInfo">
             
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="saveIMSIInfo();" class="btn blue">Apply</button>
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
    </div>
</div>
