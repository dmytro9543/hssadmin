var cnt = 0; 
var IMSI_ADD = 0;

function refresh(){
	var imsi = $('#searchImsi').val();
	var subscriber_status = $('#search_subscriber_status').val();
	$.ajax({
		url: '/imsi',
		method: 'get',
		data: {
			gettype: 'json',
			myselect: $('#data_per_page').val(),
            page: $('#page').val(),
            sort: $('#sort').val(),
            order: $('#order').val(),
            imsi: imsi,
            subscriber_status: subscriber_status
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

function showIMSIModal(){
	$('#IMSI_id').val(IMSI_ADD);
	$('#imsi_dlg').val("");
	$('#imsi_dlg').removeAttr('disabled');
	$('#ki_dlg').val("");
	$('#ki_dlg').removeAttr('disabled');
	
	$('#remark').val("");
	$('#msisdn').val("");
	$('#ue_ambr_ul_dlg').val("");
	$('#ue_ambr_dl_dlg').val("");
	$('#IMSIModal #AddIMSI').html("Add IMSI");
	isExistOPCValue();
	
	getProfileName(IMSI_ADD);
	getApnName(IMSI_ADD);
	$('#IMSIModal').modal('show');
}

function errMsg(title, msg){
	toastr.error(msg, title);
	$('#IMSIModal').modal('hide');
}

function isExistOPCValue() {
	$.ajax({
		url: '/imsi/isExistOpc',
		method: 'get',
		success: function(data, state){
			if(data == "false"){
				var title = 'Error'
				var msg = "Set OPC field in Security and Click Add button."
				errMsg(title, msg);
			}
		},
		error: function(code){
			
		}
	});
}

function getProfileName(type){
	$.ajax({
		url: '/imsi/getProfileName',
		method: 'get',
		success: function(data, state){
			var item = JSON.parse(data);
			var profileCount = item.length;
			$('#profileName').empty();
			
			if(profileCount == 0){
				var title = 'Error';
				var msg = "You must insert Profile then add IMSI."
				errMsg(title, msg);
				return;
			}
			
			
			var str="<option></option>";
			for(var i=0; i<profileCount; i++){
				str+="<option value='"+item[i].name+"'"+">";
				str+=item[i].name+"</option>";
			}
			$('#profileName').append(str);
			getProfileInfo();

		},
		error: function(code){
			
		}
	});
}
function getProfileInfo(){
	var name = document.getElementById('profileName').value;
	if (name=="") return;
	$.ajax({
		url: '/imsi/getProfileInfo',
		method: 'get',
		data: {
			name: name,
		},
		success: function(data, state){
			var item = JSON.parse(data);
			var	 cnt = item.length;
		
			$('#subscriber_status').val(item[0].subscriber_status);
			$('#rau_tau_timer_dlg').val(item[0].rau_tau_timer);
			$('#ue_ambr_ul_dlg').val(Convert_From_B_To_MB(item[0].ue_ambr_ul));
			$('#ue_ambr_dl_dlg').val(Convert_From_B_To_MB(item[0].ue_ambr_dl));
		},
		error: function(code){
		}
	});
}
function saveIMSIInfo(){
	if(cnt == 0){
		showInfoMsg('PDN List is empty. Insert PDN in PDN Management.', '');
		$('#IMSIModal').modal('hide');
		return;
	}
	var id = $('#IMSI_id').val();
	var imsi = $('#imsi_dlg').val();
    var ki = $('#ki_dlg').val();
    var msisdn = $('#msisdn').val();
	var remark = $('#remark').val();
	var subscriber_status = $('#subscriber_status').val();
	var rau_tau_timer = $('#rau_tau_timer_dlg').val();
	var ue_ambr_ul = $('#ue_ambr_ul_dlg').val();
	var ue_ambr_dl = $('#ue_ambr_dl_dlg').val();
	if(!checkField('IMSI', imsi))
		return;
	if(!checkField('KI', ki))
		return;
	
	if(!checkField('RAU_TAU_TIMER', rau_tau_timer))
        return;
  	if(!checkField('Max Upload', ue_ambr_ul))
        return;
    if(!checkField('Max Download', ue_ambr_dl))
        return;
	var checkBoxStates = Array(new Array());
	for(var i=0;i<cnt;i++){
		var str='checkbox'+i;
		var info = new Array();
		info["ipAddr"] = $("#ipAddr_" + i).val();
		info["state"] = document.getElementById(str).checked;
		info["id"] = $("#row_" + i).val();
		checkBoxStates[i] = info;
	}
	if(!checkField('PDN List', checkBoxStates))
		return;

	var pdnList = new Array();
	var j=0;
	for(var i=0; i<checkBoxStates.length; i++){
		if(checkBoxStates[i]["state"]){
			pdnList[j++] = checkBoxStates[i]["ipAddr"] + "&" + checkBoxStates[i]["id"];
		}
	}
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$.ajax({
		url: '/saveIMSIInfo',
		method: 'post',
		type: 'json',
		data: {
			id: id,
			imsi: imsi,
			ki: ki,
			msisdn: msisdn,
			remark: remark,
			subscriber_status: subscriber_status,
			rau_tau_timer: rau_tau_timer,
			ue_ambr_ul: ue_ambr_ul,
			ue_ambr_dl: ue_ambr_dl,
			pdnList: pdnList
		},
		success: function(data, state){
			if(checkValidation(data)){
				$('#IMSIModal').modal('hide');
				refresh();
			}
		},
		error: function(code){
					
			}
			});
}

function showRemark(id){
	$.ajax({
		url: '/getRemark',
		method: 'get',
		type: 'json',
		data: {
			id: id,
		},
		success: function(data, state){
			var item = JSON.parse(data)[0];
			$('#RemarkModal #remarkText').html(item.remark);
			$('#RemarkModal').modal('show');
			
		},
		error: function(code){

		}
	});

}

function showEditIMSIModal(id){
	$('#IMSI_id').val(id);
	$.ajax({
		url: '/getIMSIInfo',
		method: 'get',
		type: 'json',
		data: {
			id: id,
		},
		success: function(data, state){
			getProfileName(1);
			var item = JSON.parse(data)[0];
			$("#tmp").val(item.imsi);
			$('#imsi_dlg').val(item.imsi);
			$('#imsi_dlg').attr('disabled','disabled');
			$('#ki_dlg').attr('disabled','disabled');

			$('#msisdn').val(item.msisdn);
			$('#remark').val(item.remark);
			$('#subscriber_status').val(item.subscriber_status);
			$('#rau_tau_timer_dlg').val(item.rau_tau_timer);
			$('#ue_ambr_ul_dlg').val(Convert_From_B_To_MB(item.ue_ambr_ul));
			$('#ue_ambr_dl_dlg').val(Convert_From_B_To_MB(item.ue_ambr_dl));
			getKI_According_To_IMSI(item.imsi);
			getApnName(item.imsi);
			$('#IMSIModal #AddIMSI').html("Edit IMSI");
			$('#IMSIModal').modal('show');
		},
		error: function(code){

		}
	});

}

function getKI_According_To_IMSI(imsi){
	$.ajax({
		url: '/getKI',
		method: 'get',
		data: {
			imsi: imsi,
		},
		success: function(data, state){
			$('#ki_dlg').val(data);
		},
		error: function(code){

		}
	});
}

function deleteIMSIInfo(id){
	$.ajax({
		url: '/deleteImsiInfo',
		method: 'get',
		data: {
			id: id,
		},
		success: function(data, state){
			if(checkValidation(data)){
				$('#confirm').modal('hide');
				refresh();
			}
		},
		error: function(code){

		}
	});
}

function appInfoTable(item, cnt){
	var str = "<table class='table table-striped table-bordered table-hover dt-responsive dataTable' width='100%'' id='sample'>";
	str += "<div class='row'>";
	str += "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
	str += "<thead>";
	str += "<tr>";
	str += "<th class='all' style='width:10%''><center></center></th>";
	str += "<th class='all' style='width:45%''><center>PDN</center></th>";
	str += "<th class='all' style='width:45%''><center>IP</center></th>";
	str += "</tr>"          
	str += "</thead>";
	str += "</div>";

	var body = tableBody(item, cnt);
	str += body;
	str += "</table";
	return str;
}

function changeState(i){
	if($("#ipAddr_"+i).attr("disabled") == undefined){
	    $("#ipAddr_"+i).attr("disabled", "disabled");
	}
	else{
		$("#ipAddr_"+i).removeAttr("disabled");
	}
}

function tableBody(item, cnt){
	var body = "<tbody>";
	for(var i=0; i<cnt; i++){
		body += "<tr>";
		body += "<input type='hidden' id='row_"+i+"' value='"+item[i].id+"'>";
	    body += "<td align='center'><font size='3.5'>";
	    body += "<div class='md-checkbox' align='center'>";
		body+="<input type='checkbox' id='checkbox"+i+"'"+"class='md-check'";
		body += "onclick = 'changeState(" + i +");'";
		if(item[i].selected == 1){
			body+="checked";
		}
		body+=">";
		body+="<label for='checkbox"+i+"'>";
		body+="<span class='inc'></span>";
		body+="<span class='check'></span>";
		body+="<span class='box'></span>";
	    body += "</center></font></td>";
	    body += "<td align='center'><font size='5.5'>"+item[i].apn+"</font></td>"
	    body += "<td align=center'><input type='text' maxlength='15' class='form-control' id='ipAddr_"+i+"'";
	    if(!item[i].selected){
	    	body += "value='"+"0.0.0.0"+"'";
	    	body += "disabled";
	    }
	    else
	    	body += "value='"+item[i].ipAddr+"'";
	    
	    body += "></td>";
	    body += "</tr>"
	}
	body += "</tbody>"
	return body;
}

function getApnName(imsi){
	$.ajax({
		url: '/imsi/getApn',
		method: 'get',
		type: 'json',
		data: {
			imsi: imsi,
		},
		success: function(data, state){
			var item = JSON.parse(data);
			cnt = item.length;
			if(cnt == 0){
				showInfoMsg("PDN List is empty. Please insert PDN in PDN Management");
			}
			var str = appInfoTable(item, cnt);
			$('#apnInfo').empty();
			$('#apnInfo').append(str);
		},
		error: function(code){
			$('#rrr').html(code.responseText);
		}
	});
}
function showConfirmDlg(id){
    $('#confirm').modal('show');
    $('#yes').val(id);
    $('#menuName').val('IMSI');
}
function sortByHeader(header) {
    if($('#order').val() == 'desc')
        $('#order').val('asc');
    else
        $('#order').val('desc');
    $('#sort').val(header);
    refresh();
}

function showQuaintityIMSIModal(){
	$('#QuantityModal').modal('show');
	isExistOPCValue();
	getDefaultProfile();
}

function changeDefPro(){
	var defPro = document.getElementById('defPro').value;
	document.forms['csv']['proName'].value = defPro;
}
function getDefaultProfile(){
	$.ajax({
		url: '/getDefaultProfile',
		method: 'get',
		
		success: function(data, state){
			var proInfo = JSON.parse(data);
			var cnt = proInfo.length;
			$('#defPro').empty();
			if(cnt == 0){
				var title = 'Error';
				var msg = "You must insert Profile.";
				$('#QuantityModal').modal('hide');
				toastr.error(msg, title);
				return;
			}
			
			var str="";
			for(var i=0; i<proInfo.length; i++){
				str+="<option value='"+proInfo[i].name+"'";
				if(proInfo[i].isDefault == 1){
					str+='selected';
					document.forms['csv']['proName'].value = proInfo[i].name;
				}
				str+=">"+proInfo[i].name;
				str+="</option>";
			}
			$('#defPro').append(str);
		},
		error: function(code){

		}
	});
}
$(document).ready(function(){
	$('#csvButton').click(function(){
		if(!checkField('FilePath', $('.fileinput-filename').text()))
			return;
		document.forms['csv']['proName'].value = document.getElementById('defPro').value;
		document.forms['csv'].submit();
	});
});
function searchByEnter(){
	if(event.which == 13){
		refresh();
	}
}