<div id="QuantityModal" class="modal fade" data-width="550">
    <div class="modal-body">
    <form id="csv" action="/imsi" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="proName">

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-md-line-input has-info">
            <select class="form-control" id="defPro" onchange="changeDefPro();">
                <option value=""></option>
            </select>
            <label for="form_control_1">Profile</label>
        </div>
        </div>
    </div>

    <div class="row" style="margin-top:15px">
        <div class="col-md-3">
            <font size="4">File Path</font>
        </div>
        <div class="col-md-9">
        <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="input-group input-large">
        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
        <i class="fa fa-file fileinput-exists"></i>&nbsp;
        <span class="fileinput-filename"></span>
        </div>
        <span class="input-group-addon btn default btn-file">
           <span class="fileinput-new">Select a file</span>
           <input type="file" name="csvFile" accept=".csv">
        </span>
        </div>
    </div>
    </div> 
    </div>
    </form>

    </div>
    <div class="modal-footer">
    <center>
       <button type="submit" class="btn blue" id="csvButton">
       <i class="fa fa-upload"></i><span>Upload</span></button>
       <button type="button" data-dismiss="modal" class="btn dark">Close</button>
    </center>
    </div>
</div>
