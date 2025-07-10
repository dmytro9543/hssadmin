<div class="portlet box blue">
<div class="portlet-title">
<div class="caption" style="margin-top: 8px">
<i class="fa fa-globe"></i><font size="4.5" >Management Permissions</font></div>
</div>
<div class="portlet-body">
<div id="table_content">
<table class="table table-bordered table-striped mb-0" id="datatable-adminhistory">
    <thead>
        <tr>
            <th style="width: 5%"><center>No</center></th>
            <th style="width: 25%"><center>Function</center></th>
            <th style="width: 20%"><center>View</center></th>
            <th style="width: 20%"><center>Edit</center></th>
            <th style="width: 20%"><center>Delete</center></th>
        </tr>
    </thead>
    <tbody>
        @foreach($tb as $key => $row)
            <tr>
            <td align="center"><font size="3.5" >{{$key+1}}</font></td>
            <td align="center"><font size="3.5" >{{$row->name}}</font></td>
            <td align="center"><font size="3.5" >
                <input type="checkbox" id="checkBox_{{$key*3+1}}" class="make-switch" data-on-color="success" data-off-color="danger" data-off-text="deny" data-on-text="allow" @if($row_Id != 0 && $row->perm_view == 1) checked @endif>
            </font></td>
            <td align="center"><font size="3.5" >
            <input type="checkbox" id="checkBox_{{$key*3+2}}" class="make-switch" data-on-color="success" data-off-color="danger" data-off-text="deny" data-on-text="allow" @if($row_Id != 0 && $row->perm_upd == 1) checked @endif>            
            </font></td>
            <td align="center"><font size="3.5" >
            <input type="checkbox" id="checkBox_{{$key*3+3}}" class="make-switch" data-on-color="success" data-off-color="danger" data-off-text="deny" data-on-text="allow" @if($row_Id != 0 && $row->perm_del == 1) checked @endif>
            </font></td>
            </tr>
      @endforeach
    </tbody>
</table>
</div>
    <div class="row">
    <div class="col-md-12">
    <center>
    <button type="button" onclick="saveAdmin()" class="btn green">
    <i class="fa fa-cogs"></i>
    Apply
    </button>
    <button type="button" onclick="back();" class="btn green">Backward</button>
    </center>
    </div>
    </div>
</div>
</div>