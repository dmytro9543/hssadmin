<table class="table table-striped table-bordered table-hover dt-responsive dataTable" width="100%" id="sample">
    <div class="row">
    <div class="col-md-12 col-sm-12">
    <input type="hidden" id='page' value="{{$page}}">
    <thead>
        <tr>
        <input type="hidden" id="sort" value='{{$sort}}'>
        <input type="hidden" id="order" value='{{$order}}'>
        <th class="all" style="width:5%"><center>No</center></th>
        <th class="all" id="Served_imsi" style="width:11%" onclick="sortByConnectedHistoryHeader('Served_imsi');"><center>IMSI</center></th>
        <th class="all" id="Served_imei" style="width:11%" onclick="sortByConnectedHistoryHeader('Served_imei');"><center>IMEI</center></th>
        <th class="all" id="Apn" style="width:5%" onclick="sortByConnectedHistoryHeader('Apn');"><center>APN</center></th>
        <th class="all" id="Duration" style="width:7%" onclick="sortByConnectedHistoryHeader('Duration');"><center>Duration</center></th>
        <th class="all" id="Start_time" style="width:7%" onclick="sortByConnectedHistoryHeader('Start_time');"><center>Start Time</center></th>
        <th class="all" id="Stop_time" style="width:7%" onclick="sortByConnectedHistoryHeader('Stop_time');"><center>End Time</center></th>
        <th class="all" id="Served_pdp_address" style="width:7%" onclick="sortByConnectedHistoryHeader('Served_pdp_address');"><center>UE Address</center></th>
        <th class="all" id=TAC"" style="width:7%" onclick="sortByConnectingAdminHeader('TAC');"><center>Tracking Area Code</center></th>
        <th class="all" id="eNB_id" style="width:7%" onclick="sortByConnectingAdminHeader('eNB_id');"><center>eNB No</center></th>
        <th class="all" id="Cell_id" style="width:7%" onclick="sortByConnectingAdminHeader('Cell_id');"><center>Cell No</center></th>
        <th class="all" style="width:9%"><center>Transfer amount</center></th>
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
            <td align="center"><font size="3.5" >
                @if(strtotime($row->Stop_time)-strtotime($row->Start_time) >= 3600) {{intval((strtotime($row->Stop_time)-strtotime($row->Start_time))/3600)}}시간@endif
                @if((strtotime($row->Stop_time)-strtotime($row->Start_time)) >= 60 && (strtotime($row->Stop_time)-strtotime($row->Start_time)) %3600 !=0) {{intval(((strtotime($row->Stop_time)-strtotime($row->Start_time))%3600)/60)}}분@endif
                @if((strtotime($row->Stop_time)-strtotime($row->Start_time))%60 != 0) {{(strtotime($row->Stop_time)-strtotime($row->Start_time))%60}}초 @endif
            </font></td>
            <td align="center"><font size="3.5" >{{str_replace(array("-0", "-"), ".", $row->Start_time)}}</font></td>
            <td align="center"><font size="3.5" >{{str_replace(array("-0", "-"), ".", $row->Stop_time)}}</font></td>
            <td align="center"><font size="3.5" >{{$row->Served_pdp_address}}</font></td>
            <td align="center"><font size="3.5" >{{$row->TAC}}</font></td>
            <td align="center"><font size="3.5" >{{$row->eNB_id}}</font></td>
            <td align="center"><font size="3.5" >{{$row->Cell_id}}</font></td>
            <td align="center"><font size="3.5" >{{number_format($row->Data_Volume_FBCUplink/1024/1024, 2)}}Mbps/{{number_format($row->Data_Volume_FBCDownlink/1024/1024, 2)}}Mbps</font></td>
            <td align="center" style="width: 20px">
                <a onclick="showHistoryDetailInfo({{$row->id}});" href="#"><font size="2.5" >Detail</font></i></a>
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




