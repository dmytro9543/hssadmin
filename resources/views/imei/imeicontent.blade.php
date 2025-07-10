<table class="table table-striped table-bordered table-hover dt-responsive dataTable" width="100%" id="sample">
    <div class="row">
    <div class="col-md-12 col-sm-12">
    <input type="hidden" id='page' value="{{$page}}">
    <thead>
        <tr>
        <input type="hidden" id="sort" value='{{$sort}}'>
        <input type="hidden" id="order" value='{{$order}}'>
        <th class="all" style="width:5%"><center>No</center></th>
        <th class="all" id="imei" style="width:20%"nowrap onclick="sortByHeader('imei');"><center>IMEI</center></th>
        <th class="all" id="sv" style="width:20%"nowrap onclick="sortByHeader('sv');"><center>IMEI SV</center></th>
        <th class="all" id="created_at" style="width:20%" nowrap onclick="sortByHeader('created_at');"><center>Created Date</center></th>
        <th class="all" style="width:20%" nowrap ><center>Comment</center></th>
        @if(($permInfo[3]->perm_upd == 1 || $permInfo[3]->perm_del == 1 && !empty(strstr("BLACKLISTED", $status))) || ($permInfo[4]->perm_upd == 1 || $permInfo[4]->perm_del == 1 && !empty(strstr("WHITELISTED", $status))))
        <th class="all" nowrap><center>Action</center></th>
        @endif
        </tr>
    </thead>

    <tbody>
        @foreach($tb as $key => $row)
            <tr>
            <td align="center"><font size="3.5"  >{{($page-1)*$data_per_page+$key+1}}</font></td>
            <td align="center"><font size="3.5"  >{{$row->imei}}</font></td>
            <td align="center"><font size="3.5"  >{{$row->sv}}</font></td>
            <td align="center"><font size="3.5"  >
            {{str_replace(array("-0", "-"), ".", $row->created_at)}}
            </font></td>
            <td align="center">
                <a onclick="showRemark({{$row->id}});" href="#"><font size="2"  >Detail</font></a>   
            </td>
            @if(($permInfo[3]->perm_upd == 1 || $permInfo[3]->perm_del == 1 && !empty(strstr("BLACKLISTED", $status))) || ($permInfo[4]->perm_upd == 1 || $permInfo[4]->perm_del == 1 && !empty(strstr("WHITELISTED", $status))))
            <td align="center" style="width: 20px">
            @if(($permInfo[3]->perm_upd == 1 && !empty(strstr("BLACKLISTED", $status))) || ($permInfo[4]->perm_upd == 1 && !empty(strstr("WHITELISTED", $status))))
                <a onclick="showEditIMEIModal({{$row->id}});" href="#"><i class="fa fa-edit" title="Edit"><font size="2.5"></font></i></a>
            @endif    
            @if(($permInfo[3]->perm_del == 1 && !empty(strstr("BLACKLISTED", $status))) || ($permInfo[4]->perm_del == 1 && !empty(strstr("WHITELISTED", $status))))
                <a onclick="showConfirmDlg({{$row->id}});" href="#"><i class="fa fa-trash" title="Delete"><font size="2.5"></font></i></a>
            @endif
            </td>
            @endif

            </tr>
      @endforeach
    </tbody>
    </div>
    </div>

</table>
 <div style="width: 100%" >
   @include('include.paginate', ['data' => $tb])
</div>



