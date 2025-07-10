<table class="table table-striped table-bordered table-hover dt-responsive dataTable" width="100%" id="sample">
    <div class="row">
    <div class="col-md-12 col-sm-12">
    <input type="hidden" id='page' value="{{$page}}">
    <thead>
        <tr>
        <input type="hidden" id="sort" value='{{$sort}}'>
        <input type="hidden" id="order" value='{{$order}}'>
        <th class="all" style="width:10%"><center>No</center></th>
        <th class="all" id="Served_imsi" style="width:15%" onclick="sortByConnectingAdminHeader('Served_imsi');"><center>IMSI</center></th>
        <th class="all" id="Served_imei" style="width:15%" onclick="sortByConnectingAdminHeader('Served_imei');"><center>IMEI</center></th>
        <th class="all" id="Apn" style="width:10%" onclick="sortByConnectingAdminHeader('Apn');"><center>APN</center></th>
        <th class="all" id="Served_pdp_address" style="width:10%" onclick="sortByConnectingAdminHeader('Served_pdp_address');"><center>UE Address</center></th>
        <th class="all" id="TAC" style="width:10%" onclick="sortByConnectingAdminHeader('TAC');"><center>Tracking Area Code</center></th>
        <th class="all" id="eNB_id" style="width:10%" onclick="sortByConnectingAdminHeader('eNB_id');"><center>eNB No</center></th>
        <th class="all" id="Cell_id" style="width:10%" onclick="sortByConnectingAdminHeader('Cell_id');"><center>Cell No</center></th>
        
        <th class="all" style="width:10%"><center></center></th>
        </tr>
    </thead>

    <tbody>
        @foreach($tb as $key => $row)
            <tr>
            <td align="center"><font size="3.5" >{{($page-1)*$data_per_page+$key+1}}</font></td>
            <td align="center"><font size="3.5" >{{$row->Served_imsi}}</font></td>
            <td align="center"><font size="3.5" >{{$row->Served_imei}}</font></td>
            <td align="center"><font size="3.5" >{{$row->Apn}}</font></td>
            <td align="center"><font size="3.5" >{{$row->Served_pdp_address}}</font></td>
            <td align="center"><font size="3.5" >{{$row->TAC}}</font></td>
            <td align="center"><font size="3.5" >{{$row->eNB_id}}</font></td>
            <td align="center"><font size="3.5" >{{$row->Cell_id}}</font></td>
            
            <td align="center" style="width: 20px">
                <a onclick="showDetailDlg({{$row->id}});" href="#"><font size="2.5" >Detail</font></i></a>
            </td>
            </tr>
      @endforeach
    </tbody>
    </div>
    </div>
</table>
<div style="height: 20px"></div>
<div style="width: 100%" align="right">
  @include('include.paginate', ['data' => $tb])
</div>




