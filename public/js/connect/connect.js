function showDetailDlg(id){
	$.ajax({
		url: '/getDetailInfo',
		method: 'get',
		data: {
			id: id
		},
		success: function(data, state){
			var info = JSON.parse(data)[0];
			setBasicInfo(info);
			setQOSInfo(info);
			$('#detailModal').modal('show');
		},
		error: function(code){
		}	
	});
}
function showHistoryDetailInfo(id){
	$.ajax({
		url: '/getHistoryDetailInfo',
		method: 'get',
		data: {
			id: id
		},
		success: function(data, state){
			var info = JSON.parse(data)[0];
			setBasicInfo(info);
			setQOSInfo(info);
			$('#detailModal').modal('show');
		},
		error: function(code){
		}
	});
}
function setBasicInfo(info){
	$('#Charging_id_dlg').val(info.Charging_id);
	$('#Served_imsi_dlg').val(info.Served_imsi);
	$('#Served_imei_dlg').val(info.Served_imei);
	$('#Served_msisdn_dlg').val(info.Served_msisdn);
	$('#Apn_dlg').val(info.Apn);
	var second = info.Duration;
	var str = "";
	if(second>=3600)str+= parseInt((second/3600)) + ":";
	if(second>=60)str+= parseInt((second%3600)/60) + ":";
	str+= (second%3600)%60;
	$('#Duration_dlg').val(str);
	$('#TAC_dlg').val(info.TAC);
	$('#eNB_id_dlg').val(info.eNB_id);
	$('#Cell_id_dlg').val(info.Cell_id);
	$('#Start_time_dlg').val(info.Start_time);
	$('#Stop_time_dlg').val(info.Stop_time);
	$('#Served_pdp_address_dlg').val(info.Served_pdp_address);
	
	
	$('#Rating_Group_dlg').val(info.Rating_Group);
	$('#Charging_Rule_Base_Name_dlg').val(info.Charging_Rule_Base_Name);
}

function setQOSInfo(info){
	$('#QCI_dlg').val(info.QCI);
	$('#MaxRequestedBandwithUL_dlg').val(info.MaxRequestedBandwithUL);
	$('#MaxRequestedBandwithDL_dlg').val(info.MaxRequestedBandwithDL);
	$('#GuaranteedBitrateUL_dlg').val(info.GuaranteedBitrateUL);
	$('#GuaranteedBitrateDL_dlg').val(info.GuaranteedBitrateDL);
	$('#ARP_dlg').val(info.ARP);
	$('#APNAggregateMaxBitrateUL_dlg').val(info.APNAggregateMaxBitrateUL);
	$('#APNAggregateMaxBitrateDL_dlg').val(info.APNAggregateMaxBitrateDL);
	$('#Data_Volume_FBCUplink_dlg').val(Convert_From_B_To_MB(info.Data_Volume_FBCUplink)+"Mbps");
	$('#Data_Volume_FBCDownlink_dlg').val(Convert_From_B_To_MB(info.Data_Volume_FBCDownlink)+"Mbps");
	
}

function refreshConnectedHistory(){
	$.ajax({
		url: '/connectedHistory',
		method: 'get',
		data: {
			gettype: 'json',
			myselect: $('#data_per_page').val(),
            page: $('#page').val(),
            sort: $('#sort').val(),
            order: $('#order').val(),
            Served_imsi: $('#search_Served_imsi').val(),
          	Served_imei: $('#search_Served_imei').val(),
            Served_pdp_address: $('#search_Served_pdp_address').val()
		},
		success: function(data, state){
			$('#table_content').html(data);
			if($("#order").val() == "asc")
				$("#"+$("#sort").val()).attr("class", "sorting_desc");
			else
				$("#"+$("#sort").val()).attr("class", "sorting_asc");
		},
		error: function(code){
		}
	});
}

function refresh(){
	$.ajax({
		url: '/connectingAdmin',
		method: 'get',
		data: {
			gettype: 'json',
			myselect: $('#data_per_page').val(),
            page: $('#page').val(),
            sort: $('#sort').val(),
            order: $('#order').val(),
            Served_imsi: $('#search_Served_imsi').val(),
          	Served_imei: $('#search_Served_imei').val(),
            Served_pdp_address: $('#search_Served_pdp_address').val()
		},
		success: function(data, state){
			$('#table_content').html(data);
			if($("#order").val() == "asc")
				$("#"+$("#sort").val()).attr("class", "sorting_desc");
			else
				$("#"+$("#sort").val()).attr("class", "sorting_asc");
		},
		error: function(code){
		}
	});
}

function sortByConnectingAdminHeader(header) {
    if($('#order').val() == 'desc')
        $('#order').val('asc');
    else
        $('#order').val('desc');
    $('#sort').val(header);
    refresh();
}

function sortByConnectedHistoryHeader(header) {
    if($('#order').val() == 'desc')
        $('#order').val('asc');
    else
        $('#order').val('desc');
    $('#sort').val(header);
    refreshConnectedHistory();
}
