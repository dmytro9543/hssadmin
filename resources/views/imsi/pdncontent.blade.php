<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample">
    <div class="row">
    <div class="col-md-12 col-sm-12">
    <input type="hidden" id='page' value="{{$page}}">
    <thead>
     <tr>
        <input type="hidden" id="sort" value='{{$sort}}'>
        <input type="hidden" id="order" value='{{$order}}'>
        <th class="all" style="width: 5%"><center>No</center></th>
        <th class="all" style="width:12%" onclick="sortByHeader('apn');"><center>APN</center></th>
        <th class="all" style="width:12%" onclick="sortByHeader('pdn_type');"><center>PDN type</center></th>
        <th class="all" style="width:12%" onclick="sortByHeader('pdn_ipv4');"><center>IPv4</center></th>
        <th class="all" style="width:12%" onclick="sortByHeader('aggregate_ambr_ul');"><center>Max Upload</center></th>
        <th class="all" style="width:12%" onclick="sortByHeader('aggregate_ambr_dl');"><center>Max Download</center></th>
        <th class="all" style="width:12%" onclick="sortByHeader('qci');"><center>QCI</center></th>
        <th class="all" style="width:12%"><center>User Count</center></th>
        @if($permInfo[2]->perm_upd == 1 || $permInfo[2]->perm_del == 1)
        <th class="all" nowrap><center>Action</center></th>
        @endif

    </tr>
    </thead>
    <tbody>
        @foreach($tb as $key => $row)
            <tr>
            <td align="center"><font size="3.5">{{($page-1)*$data_per_page+$key+1}}</font></td>
            <td align="center"><font size="3.5">{{$row->apn}}</font></td>
            <td align="center"><font size="3.5">{{$row->pdn_type}}</font></td>
            <td align="center"><font size="3.5">{{$row->pdn_ipv4}}</font></td>
            <td align="center">
            <font size="3.5">{{number_format($row->aggregate_ambr_ul/1024/1024, 2)}}Mbps</font>
            </td>
            <td align="center">
            <font size="3.5">{{number_format($row->aggregate_ambr_dl/1024/1024, 2)}}Mbps</font>
            </td>
            <td align="center"><font size="3.5">{{$row->qci}}</font></td>
            <td align="center"><font size="3.5">{{$userpdncounts[$row->id]}}</font></td>
             @if($permInfo[2]->perm_upd == 1 || $permInfo[2]->perm_del == 1)
            <td align="center" style="width: 20px">
                @if($permInfo[2]->perm_upd == 1)
                <a onclick="showPdnModal({{$row->id}});" href="#"><i class="fa fa-edit" title="Edit"><font size="2.5"></font></i></a>
             @endif
            @if($permInfo[2]->perm_del == 1)                
                <a onclick="showConfirmDlg({{$row->id}});" href="#"><i class="fa fa-trash" title="삭제"><font size="2.5"></font></i></a>
                @endif            
            </td>
            @endif

            </tr>
      @endforeach
    </div>
    </div>
    </tbody>
</table>
 <div style="width: 100%" >
  @include('include.paginate', ['data' => $tb])
</div>
