<div id="setPasswordDlg" class="modal fade" data-width="500">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><font id="add" size = "5"  color="red">Change Password</font></h4>
     </div>
    <div class="modal-body">
    <div class="portlet-body form"> 
    <div class="form-body">
        <input type="hidden" id="pre_Password_tmp">
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group form-md-line-input">
        <input type="password" class="form-control" minlength='12' id="pre_Password" name="pre_Password">
        <label class="form_control_1">Password</label>
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group form-md-line-input">
        <input type="password" class="form-control" minlength='12' id="new_psw" name="new_psw">
        <label class="form_control_1">New Password</label>
        </div>
        </div>
        </div>


        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group form-md-line-input">
        <input type="password" class="form-control" minlength='12' id="new_psw_Ok" name="new_psw_Ok">
        <label class="form_control_1">Confirm Password</label>
        </div>
        </div>
        </div>
       
        </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="savePassword();" class="btn blue">Save</button>
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
    </div>
</div>
