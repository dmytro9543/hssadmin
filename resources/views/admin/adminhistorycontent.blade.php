<table class="table table-striped table-bordered table-hover dt-responsive dataTable" width="100%" id="sample">
     <div class="row">
    <div class="col-md-12 col-sm-12">
    <thead>
        <tr>
        <input type="hidden" id='page' value="{{$page}}">
        <input type="hidden" id="sort" value="{{$sort}}">
        <input type="hidden" id="order" value="{{$order}}">
            <th class="all" style="width:5%"><center>No</center></th>
            <th class="all" id="operated_by" style="width:15%" onclick="sortByHeader('operated_by');"><center>UserId</center></th>
            <th class="all" id="operation" style="width:40%" onclick="sortByHeader('operation');"><center>Function Info</center></th>
            <th class="all" id="created_at" style="width:30%" onclick="sortByHeader('created_at');"><center>Action Time</center></th>
            @if($permInfo[7]->perm_del == 1)
            <th class="all" style="width:10%"><center>Delete</scenter></th>
            @endif
        </tr>
    </thead>
    </div>
    <tbody>
        @foreach($tb as $key => $row)
            <tr>
            <td align="center"><font size="3.5">{{($page-1)*$data_per_page+$key+1}}</font></td>
            <td align="center"><font size="3.5">{{openssl_decrypt(base64_decode($row->operated_by), 'aes-128-cbc', '1234567812345678', true, "1234567812345678")}}</font></td>
            <td align="center"><font size="3.5">{{openssl_decrypt(base64_decode($row->operation), 'aes-128-cbc', '1234567812345678', true, "1234567812345678")}}</font></td>
            <td align="center"><font size="3.5">{{str_replace(array("-0", "-"), ".", $row->created_at)}}</font></td>
            @if($permInfo[7]->perm_del == 1)
            <td align="center">
                <a onclick="showConfirmDlg({{$row->id}});" href="#"><i class="fa fa-trash" title="Delete"><font size="2.5"></font></i></a>
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
