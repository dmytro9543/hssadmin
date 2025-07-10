@extends('include.main')
@section('user_js')
    <script src="/js/security/security.js"></script>
@endsection
@section('content')
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <div class="page-content">
    <div class="container">
    <ul class="page-breadcrumb breadcrumb">
    <li>
    <font size="5" color="red" id="title">Security</font>
    </li>
    </ul>
    <div class="page-content-inner">
    <div class="row">
        <div class="col-md-12 col-sm-12">        
        <div class="portlet box blue">
        <div class="portlet-title">
        <div class="caption">
        <i class="fa fa-comments">
        <font size = "3"  color="white">OPC Settings</font>
        </i> 
        </div>
        </div>
        <div class="portlet-body">
        <div class="portlet-body form"> 
        <div class="form-body">
        <input type="hidden" id="op_id">
        <div class="row">
            <div class="col-md-12">
            <div class="form-group form-md-line-input" style="color: Black">
            <input type="text" class="form-control" id="opc" name="opc" maxlength="32">
            <label class="form_control_1">OPC</label>
            <span class="help-block">ex: e734f8734007d6c5ce7a0508809e7e9c</span>
            </div>
            </div>
        </div>

        <div style="height: 10px"></div>
        <div class="row">
            <div class="col-md-12">
            @if($permInfo[5]->perm_upd == 1)
            <center><button type="button" onclick="saveOPC();" class="btn blue">Apply</button></center>
            @endif
            </div>
        </div>
        </div>
        
        </div>
        </div>
        </div>
        </div>
        </div>
        <!--
    <div class="row">
     <div class="col-md-12 col-sm-12">      
        <div class="portlet box blue">
        <div class="portlet-title">
        <div class="caption">
        <i class="fa fa-comments">
        <font size = "3"  color="white">Ki복호화 열쇠설정</font>
        </i> 
        </div>
        </div>
        <div class="portlet-body">
        <div class="portlet-body form"> 
        <div class="form-body">
        <input type="hidden" id="op_id">
        <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="k1" maxlength="16" name="k1" placeholder=''>
            <label class="form_control_1">K1</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k2" maxlength="16" name="k2">
            <label class="form_control_1">K2</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k3" maxlength="16" name="k3">
            <label class="form_control_1">K3</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="k4" maxlength="16" name="k4">
            <label class="form_control_1">K4</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k5" maxlength="16" name="k5">
            <label class="form_control_1">K5</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k6" maxlength="16" name="k6">
            <label class="form_control_1">K6</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k7" maxlength="16" name="k7">
            <label class="form_control_1">K7</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k8" maxlength="16" name="k8">
            <label class="form_control_1">K8</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k9" maxlength="16" name="k9">
            <label class="form_control_1">K9</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="k10" maxlength="16" name="k10">
            <label class="form_control_1">K10</label>
            </div>
            </div>
        </div>
         <div style="height: 10px"></div>
        <div class="row">
            <div class="col-md-12">
            <center>
            @if($permInfo[5]->perm_upd == 1)
            <button type="button" onclick="saveKIInfo();" class="btn blue">설정</button>
            </center>
            @endif
            </div>
        </div>
        
        
        </div>
        
        </div>
        </div>
        </div>
        </div>

        <div class="col-md-6 col-sm-6">      
        <div class="portlet box blue">
        <div class="portlet-title">
        <div class="caption">
        <i class="fa fa-comments">
        <font size = "3"  color="white"> Ri/Ci값 설정</font>
        </i> 
        </div>
        </div>
        <div class="portlet-body">
        <div class="portlet-body form"> 
        <div class="form-body">
        <input type="hidden" id="op_id">
        <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="r1" maxlength="3" name="r1" placeholder="0 ~ 255사이 옹근수값">
            <label class="form_control_1">R1</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="c1" maxlength="3" name="c1">
            <label class="form_control_1">C1</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="r2" maxlength="3" name="r2">
            <label class="form_control_1">R2</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control" id="c2" maxlength="3" name="c2">
            <label class="form_control_1">C2</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="r3" maxlength="3" name="r3">
            <label class="form_control_1">R3</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="c3" maxlength="3" name="c3">
            <label class="form_control_1">C3</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="r4" maxlength="3" name="r4">
            <label class="form_control_1">R4</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="c4" maxlength="3" name="c4">
            <label class="form_control_1">C4</label>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="r5" maxlength="3" name="r5">
            <label class="form_control_1">R5</label>
            <span class="help-block"></span>
            </div>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group form-md-line-input">
            <input type="text" class="form-control"id="c5" maxlength="3" name="c5">
            <label class="form_control_1">C5</label>
            </div>
            </div>
        </div>
        <div style="height: 10px"></div>
        <div class="row">
            <div class="col-md-12">
             @if($permInfo[5]->perm_upd == 1)
            <center>
            <button type="button" onclick="saveRiCi();" class="btn blue">설정</button>
            </center>
            @endif
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div> 
    </div>-->
   
    </div>
    </div>
    </div>
</div>
@endsection