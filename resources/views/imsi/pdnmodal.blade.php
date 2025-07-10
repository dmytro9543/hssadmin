<div id="PdnModal" class="modal fade" data-width="700">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><font id="AddPdn" size = "5"  color="red"></font></h4>
     </div>
    
    <div class="modal-body">
    <div class="portlet-body form"> 
    <div class="form-body">
        <input type="hidden" id="pdn_id">
        <input type="hidden" id="tmp">
        <div class="row">
            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="apn" name="apn">
            <label for="form_control_1">APN</label>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <select class="form-control edited" id="pdn_type" >
            <option value="IPv4">IPv4</option>
            <option value="IPv6">IPv6</option>
            <option value="IPv4v6">IPv4v6</option>
            <option value="IPv4_or_IPv6">IPv4_or_IPv6</option>
            </select>
            <label for="form_control_1">PDN type</label>
            </div>
            </div>
        </div>
        <div style="height: 25px"></div>
        <div class="row">
            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="pdn_ipv4" maxlength='15' name="pdn_ipv4">
            <label for="form_control_1">IPv4</label>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="pdn_ipv6" name="pdn_ipv6">
            <label for="form_control_1">IPv6</label>
            </div>
            </div>
        </div>
        <div style="height: 25px"></div>

        <div class="row">
            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="aggregate_ambr_ul" name="aggregate_ambr_ul">
            <span class="help-block">unit must be Mbps</span>
            <label class="form_control_1">Max Upload</label>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="aggregate_ambr_dl" name="aggregate_ambr_dl">
            <span class="help-block">unit must be Mbps</span>
            <label>Max Download</label>
            </div>
            </div>
        </div>
        <div style="height: 25px"></div>

        <div class="row">
           
            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="qci" maxlength='1' name="qci">
            <span class="help-block">must between 1 and 9</span>
            <label>QCI </label>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="priority_level" maxlength='2' name="priority_level">
            <span class="help-block">must between 1 and 15</span>
            <label>Priority Level</label>
            </div>
            </div>

      </div>

        <div style="height: 25px"></div>
        <div class="row">
            <div class="col-md-4">
            <div class="form-group form-md-line-input">
            <select class="form-control edited" id="pre_emp_cap" >
            <option value="ENABLED">Enable</option>
            <option value="DISABLED">Disable</option>
            </select>
            <label for="form_control_1">PRE_EMP_CAP</label>
            </div>
            </div>

            <div class="col-md-4">
            <div class="form-group form-md-line-input">
            <select class="form-control edited" id="pre_emp_vul" >
            <option value="ENABLED">Enable</option>
            <option value="DISABLED">Disable</option>
            </select>
            <label for="form_control_1">PRE_EMP_VUL</label>
            </div>
            </div>

            <div class="col-md-4">
            <div class="form-group form-md-line-input">
            <select class="form-control edited" id="LIPA_Permissions" >
            <option value="LIPA-PROHIBITED">LIPA-PROHIBITED</option>
            <option value="LIPA-ONLY">LIPA-ONLY</option>
            <option value="LIPA-CONDITIONAL">LIPA-CONDITIONAL</option>
            </select>
            <label for="form_control_1">LIPA Permissions</label>
            </div>
            </div>
        </div>
       
    </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="savePdnInfo();" class="btn green">Apply</button>
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Close</button>
    </div>
</div>
