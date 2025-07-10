<table class="table table-striped table-bordered table-hover dt-responsive dataTable" width="100%" id="sample">
     <div class="row">
    <div class="col-md-12 col-sm-12">
    <thead>
        <tr>
        <input type="hidden" id='page' value="{{$page}}">
        <input type="hidden" id="sort" value="{{$sort}}">
        <input type="hidden" id="order" value="{{$order}}">
            <th class="all"><center>No</center></th>
            <th class="all" onclick="sortByHeader('imsi');"><center>IMSI</center></th>
            <th class="all" onclick="sortByHeader('msisdn');"><center>Mobile phone</center></th>
            <th class="all" onclick="sortByHeader('rau_tau_timer');"><center>RAU-TAU-Timer</center></th>
            <th class="all" onclick="sortByHeader('ue_ambr_ul');"><center>Max Upload Size</center></th>
            <th class="all" onclick="sortByHeader('ue_ambr_dl');"><center>Max Download Size</center></th>
            <th class="all" ><center>PDN</center></th>
            <th class="all" ><center>Comment</center></th>
            @if($permInfo[0]->perm_upd == 1 || $permInfo[0]->perm_del == 1)
            <th class="all" nowrap><center>Action</center></th>
            @endif
        </tr>
    </thead>
    </div>

    <tbody>
        @foreach($tb as $key => $row)
            <tr>
            <td align="center"><font size="3.5" >{{($page-1)*$data_per_page+$key+1}}</font></td>
            <td align="center"><font size="3.5" >{{$row->imsi}}</font></td>
            <td align="center"><font size="3.5" >{{$row->msisdn}}</font></td>
            <td align="center"><font size="3.5" >{{$row->rau_tau_timer}} seconds</font></td>
            <td align="center"><font size="3.5" >
            {{number_format($row->ue_ambr_ul/1024/1024, 2)}}Mbps</font></td>
            <td align="center"><font size="3.5" >
            {{number_format($row->ue_ambr_dl/1024/1024, 2)}}Mbps</font></td>
            <td align="center"><font size="3.5" >
            {{$pdnCount_apnName_Array[$row->id]}}
            </font></td>
            <td align="center">
                <a onclick="showRemark({{$row->id}});" href="#"><font size="2" >Detail</font></a>   
            </td>
             @if($permInfo[0]->perm_upd == 1 || $permInfo[0]->perm_del == 1)
            <td align="center">
                @if($permInfo[0]->perm_upd == 1)
                <a onclick="showEditIMSIModal({{$row->id}});" href="#"><i class="fa fa-edit" title="Edit"><font size="2.5" ></font></i></a>
                @endif
                @if($permInfo[0]->perm_del == 1)
                <a onclick="showConfirmDlg({{$row->id}});" href="#"><i class="fa fa-trash" title="Delete"><font size="2.5" ></font></i></a>
                @endif
            </td>
            @endif
            </tr>
      @endforeach
    </tbody>
    </div>
</table>
<div style="height: 20px"></div>
<div style="width: 100%" align="right">
  @include('include.paginate', ['data' => $tb])
</div>
