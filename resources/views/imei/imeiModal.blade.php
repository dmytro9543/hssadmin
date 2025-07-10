<div id="imeiModal" class="modal fade" data-width="800">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><font id="add" size = "5"  color="red"></font></h4>
     </div>
    <div class="modal-body">
    <div class="portlet-body form"> 
    <div class="form-body">
        <input type="hidden" id="imei_id">
        <input type="hidden" id="tmp">
        <div class="row">
        <div class="col-md-6">
        <div class="form-group form-md-line-input">
        <input type="text" class="form-control" maxlength='15' id="imei_dlg" name="imei">
        <label class="form_control_1">IMEI</label>
        <span class="help-block">must contain 15 numbers</span>
        </div>
        <div style="height: 5px"></div>
        </div>
        <div class="col-md-6">
        <div class="form-group form-md-line-input">
        <input type="text" class="form-control" id="sv_dlg" name="sv_dlg" maxlength='2'>
        <span class="help-block">ex:78</span>
        <label>IMEI SV</label>
        </div>
        </div>
        </div>
        <div class="row" style="margin-top:15px"><div class="col-md-12">
        <div class="form-group form-md-line-input" >
        <textarea class="form-control" rows="2" id='remark'></textarea>
        <label for="form_control_1">Comment</label>
        </div>
        </div>
        </div> 
        </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="saveIMEIInfo();" class="btn blue">Apply</button>
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
    </div>
</div>
