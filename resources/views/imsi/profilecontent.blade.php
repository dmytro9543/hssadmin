<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample">
    <thead>
        <tr>
        <input type="hidden" id='page' value="{{$page}}">
        <input type="hidden" id="sort" value="{{$sort}}">
        <input type="hidden" id="order" value="{{$order}}">
            <th class="all" ><center>No</center></th>
            <th class="all" nowrap onclick="sortByHeader('name')"><center>Profile Name</center></th>
            <th class="all" nowrap><center>User state</center></th>
            <th class="all" nowrap onclick="sortByHeader('rau_tau_timer')"><center>RAU-TAU-Timer</center></th>
            <th class="all" nowrap onclick="sortByHeader('ue_ambr_ul')"><center>Max Upload</center></th>
            <th class="all" nowrap onclick="sortByHeader('ue_ambr_dl')"><center>Max Download</center></th>
            <th class="all" nowrap><center>PDN count</center></th>
            @if($permInfo[0]->perm_upd == 1)
            <th class="all" nowrap><center>Standard Profile</center></th>
            @endif
            @if($permInfo[1]->perm_upd == 1 || $permInfo[1]->perm_del == 1)
            <th class="all" nowrap><center>Action</center></th>
            @endif
        </tr>
    </thead>
    <tbody>
      @foreach($tb as $key => $row)
        <tr>
        <td align="center"><font size="3.5" >{{($page-1)*$data_per_page+$key+1}}</font></td>
        <td align="center"><font size="3.5" >{{$row->name}}</font></td>
        <td align="center"><font size="3.5" >{{$row->subscriber_status}}</font></td>
        <td align="center"><font size="3.5" >{{$row->rau_tau_timer}} seconds</font></td>
        <td align="center"><font size="3.5" >
        {{number_format($row->ue_ambr_ul/1024/1024, 2)}}Mbps</font></td>
        <td align="center"><font size="3.5" >
        {{number_format($row->ue_ambr_dl/1024/1024, 2)}}Mbps</font></td>
        <td align="center"><font size="3.5" >{{$pdnCounts[$row->id]}}</font></td>
        @if($permInfo[0]->perm_upd == 1)
        <td align="center"><font size="3.5" >
                    <input type="radio"  onclick='changeDefault({{$row->id}});' name="radio211" class="md-radiobtn" @if($row->isDefault == 1) checked @endif>
                    <span class="box"></span>Apply</label>
        @endif                      
        </font></td>
        @if($permInfo[1]->perm_upd == 1 || $permInfo[1]->perm_del == 1)
        <td align="center">
            @if($permInfo[1]->perm_upd == 1)
            <a onclick="showEditProfileModal({{$row->id}});" href="#"><i class="fa fa-edit" title="Edit"><font size="2.5" ></font></i></a>
            @endif
            @if($permInfo[1]->perm_del == 1)
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
