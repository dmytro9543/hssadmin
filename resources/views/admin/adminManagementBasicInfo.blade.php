<div class="portlet box blue">
<div class="portlet-title">
<div class="caption" style="margin-top: 8px">
<i class="fa fa-globe"></i><font size="4.5" >Basic Information</font></div>
<div class="tools">
<a href="javascript:;" class="collapse" data-original-title="축소" title="축소"> </a></div>
</div>
<div class="portlet-body">
        <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-6 ">
        <div class="form-group form-md-line-input ">
        <input type="text" class="form-control" id="Aname" name="Aname" @if($row_Id != 0) value="{{$name}}"  @endif>
        <label class="form_control_1">Name</label>
        <span class="help-block"></span>
        </div>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group form-md-line-input has-info">
        <input type="text" class="form-control" id="Aid" name="Aid" @if($row_Id != 0) value="{{$user_id}}" disabled @endif>
        <label class="form_control_1">UserId</label>
        <span class="help-block"></span>
        </div>
        </div>
    </div>
        <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group form-md-line-input">
        <input class="form-control" type='password' id="Apassword" name="Apassword">
        <label class="form_control_1">Password</label>
        <span class="help-block">Password must be larger than 12 characters</span>
        </div>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group form-md-line-input">
        <input class="form-control" type='password' id="ApasswordOk" name="ApasswordOk">
        <label class="form_control_1">Confirm Password</label>
        <span class="help-block">Password must match</span>
        </div>
        </div>

        </div>
        <div style="height: 10px"></div>
        <div class="row">

        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group form-md-line-input">
        <input type="text" class="form-control" id="ipAddr" name="ipAddr" @if($row_Id != 0) value="{{$user_ipAddr}}" @endif>
        <label class="form_control_1">IP</label>
        <span class="help-block"></span>
        </div>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group form-md-line-input">
        <input type="text" class="form-control" id="Adcontent" name="Adcontent" @if($row_Id != 0) value="{{$user_authorize}}" @endif>
        <label class="form_control_1">Comment</label>
        <span class="help-block"></span>
        </div>
        </div>
        </div>
        </div>
        </div>
    </div>
</div>
</div>