<table class="table table-striped table-bordered table-hover dt-responsive dataTable" width="100%" id="sample">
     <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <thead>
        <tr>
        <input type="hidden" id='page' value="">
        <input type="hidden" id="sort" value="">
        <input type="hidden" id="order" value="">
            <th class="all" style="width:10%"><center>User</center></th>
            <th class="all" style="width:30%"><center>IP Address</center></th>
            <th class="all" style="width:30%"><center>Registered Date</center></th>
            <th class="all" style="width:30%"><center>Access Type</center></th>
        </tr>
    </thead>
    </div>

    <tbody>
        @foreach($historyInfo as $key => $row)
            <tr>
            <td align="center"><font size="3.5" >{{$row->uid}}</font></td>
            <td align="center"><font size="3.5" >{{$row->ipAddr}}</font></td>
            <td align="center"><font size="3.5" >{{str_replace(array("-0", "-"), ".", $row->created_at)}}</font></td>
            <td align="center"><font size="3.5" >
                @if($row->isToken == 1) Login by token @endif
                @if($row->isToken == 0) Normal Login @endif
            </font></td>
            </tr>
      @endforeach
    </tbody>
    </div>
</table>
<div style="height: 20px"></div>
<div style="width: 100%" align="right">
 @if(count($historyInfo) > 0)
<div class="row">
<div class = "table table-bordered ">    
    <div class="col-md-12">
    <div class="pull-right">
    <font size="3">
            {{ $historyInfo->appends(['myselect' => $data_per_page])->links() }}
    </font>
    </div>
    </div>
</div>
</div>
@endif
</div>
