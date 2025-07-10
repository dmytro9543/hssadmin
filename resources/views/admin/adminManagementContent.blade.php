<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample">
     <div class="row">
    <div class="col-md-12 col-sm-12">
    <thead>
        <tr>
        <input type="hidden" id='page' value="{{$page}}">
        <input type="hidden" id="sort" value="{{$sort}}">
        <input type="hidden" id="order" value="{{$order}}">
            <th class="all" style="width:5%"><center>No</center></th>
            <th class="all" style="width:20%" nowrap onclick="sortByHeader('users.name');"><center>Name</center></th>
            <th class="all" style="width:20%" nowrap onclick="sortByHeader('users.uid');"><center>UserId</center></th>
            <th class="all" style="width:20%" nowrap onclick="sortByHeader('users.created_at');"><center>Created Date</center></th>
            <th class="all" style="width:20%"><center>Comment</center></th>
            @if($permInfo[6]->perm_upd == 1 || $permInfo[6]->perm_del == 1)
            <th class="all" style="width:15%"><center>Action</scenter></th>
            @endif
        </tr>
    </thead>
    </div>

    <tbody>
        @foreach($tb as $key => $row)
            <tr>
            <td align="center"><font size="3.5">{{($page-1)*$data_per_page+$key+1}}</font></td>
            <td align="center"><font size="3.5">{{$row->name}}</font></td>
            <td align="center"><font size="3.5">{{$row->uid}}</font></td>
            <td align="center"><font size="3.5">{{str_replace(array("-0", "-"), ".", $row->created_at)}}</font></td>
            <td align="center"><font size="3.5">{{$row->user_authorize}}</font></td>
           @if($permInfo[6]->perm_upd == 1 || $permInfo[6]->perm_del == 1)
            <td align="center">
            @if($permInfo[6]->perm_upd == 1 && empty(strstr($row->uid ,'admin')))
                <a onclick="AdminInfo({{$row->id}});" href="#"><i class="fa fa-edit" title="Edit"><font size="2.5"></font></i></a>
            @endif
           @if($permInfo[6]->perm_del == 1 && empty(strstr($row->uid ,'admin')))
            <a onclick="showConfirmDlg({{$row->id}});" href="#"><i class="fa fa-trash" title="Delete"><font size="2.5"></font></i></a>
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
