function showIMEIModal(){
	$('#imei_id').val(0);
	$('#imei_dlg').val("");
	$('#sv_dlg').val('');
	$('#remark').val('');
	$('#imeiModal #add').html("Add");
	$('#imeiModal').modal('show');
}

function saveIMEIInfo(){
	var id = $('#imei_id').val();
	
	if(!checkField('IMEI', $('#imei_dlg').val()))
		return;
	if(!checkField('IMEI SV', $('#sv_dlg').val()))
		return;
	var imei = $('#imei_dlg').val();
	var sv = $('#sv_dlg').val();
	var remark = $('#remark').val();
	var status = $('#status').val();

	var is_Different = imei.search($('#tmp').val());
	$.ajax({
		url: '/imeiinfoSave',
		method: 'get',
		data: {
			id: id,
			status: status,
			imei: imei,
			sv: sv,
			remark: remark,
			is_Different: is_Different
		},
		success: function(data, state){
			if(checkValidation(data)){
				$('#imeiModal').modal('hide');
				refresh();
			}
		},
		error: function(code){
		}
	});
}

function refresh(){
	var url = '/blackList';
	if(!$('#status').val().search('WHITELISTED'))
		var url = '/whiteList';
	var imei = $('#searchImei').val();
	var imeiSv = $('#searchImeiSv').val();
	$.ajax({
		url: url,
		method: 'get',
		data: {
			gettype: 'json',
			myselect: $('#myselect').val(),
            page: $('#page').val(),
            sort:  $('#sort').val(),
            order: $('#order').val(),
            imei: imei,
            imeiSv: imeiSv
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

function sortByHeader(header) {
    if($('#order').val() == 'desc')
        $('#order').val('asc');
    else
        $('#order').val('desc');
    $('#sort').val(header);
    refresh();
}

function showEditIMEIModal(id){
	$('#imei_id').val(id);
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$.post(
		'/getIMEIInfo',
		{
			id: id,
		},
		function(data, state){

			var item = JSON.parse(data)[0];
			$('#imei_dlg').val(item.imei);
			$('#tmp').val(item.imei);
			$('#sv_dlg').val(item.sv);
			$('#remark').val(item.remark);
			$('#imeiModal #add').html("Edit");
			$('#imeiModal').modal('show');
		}
	);
}
function showRemark(id){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$.post(
		'/getRemark',
		{
			id: id,
		},
		function(data, state){
			var item = JSON.parse(data)[0];
			$('#RemarkModal #remarkText').html(item.remark);
			$('#RemarkModal').modal('show');
		}
	);
}

function deleteIMEIInfo(id){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$.post(
		'/deleteIMEIInfo',
		{
			id: id,
		},
		function(data, state){
			if(checkValidation(data)){
				$('#confirm').modal('hide');
				refresh();
			}
		}
	);
}

function showConfirmDlg(id){
    $('#confirm').modal('show');
    $('#yes').val(id);
    $('#menuName').val('IMEI');
}

function searchByEnter(){
	if(event.which == 13){
		refresh();
	}
}