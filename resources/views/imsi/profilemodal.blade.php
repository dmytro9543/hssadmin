<div id="ProfileModal" class="modal fade" data-width="700">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><font id="AddPro" size = "5"  color="red">Add Profile</font></h4>
     </div>
    
    <div class="modal-body">
    <div class="portlet-body form"> 
    <div class="form-body">
        <input type="hidden" id="profile_id" >
        <input type="hidden" id="tmp">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-md-line-input">
                        <input type="text" class="form-control" id="name" name="name">
                        <label for="form_control_1">Profile Name</label>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-md-line-input">
                         <select class="form-control edited" id="subscriber_status" >
                             <option value="SERVICE_GRANTED">SERVICE_GRANTED</option>
                             <option value="OPERATOR-DETERMINED-BARRING">OPERATOR-DETERMINED-BARRING</option>
                        </select>
                        <label for="form_control_1">User State</label>
                </div>
            </div>
        </div>
        <div style="height: 10px"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="rau_tau_timer" name="rau_tau_timer">
                    <label class="form_control_1">Rau-Tau</label>
                    <span class="help-block">unit must be second</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="ue_ambr_ul" name="ue_ambr_ul">
                    <span class="help-block">unit must be Mbps.</span>
                    <label class="form_control_1">Max Upload</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="ue_ambr_dl" name="ue_ambr_dl">
                    <span class="help-block">unit must be Mbps.</span>
                    <label>Max Download</label>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:15px">
            <div class="col-md-12">        
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-comments"></i>PDN List 
                        </div>
                    </div>
                <div class="portlet-body">
                      <div class="portlet-body form"> 
                        <div class="form-body" id="checkBoxs">
                            
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
        <button type="button" onclick="saveProfileInfo();" class="btn green">Apply</button>
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
    </div>
</div>
