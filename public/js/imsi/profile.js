var cnt = 0;

function getApnName(id){
	$.ajax({
		url: '/profile/getApnName',
		method: 'get',
		type: 'json',
		data: {
			id: id,
		},
		success: function(data, state){
			var item = JSON.parse(data);
			cnt = item.length;
			if(cnt == 0){
				showInfoMsg('PDN List is empty. You must insert PDN in PDN Management.', '');
			}
			var str="";
			$('#checkBoxs').empty();
			for(var i=0; i<cnt; i++){
				if(!i%4){
					str+="<div class='row'>";
				}
				str+="<div class='col-md-3'>";
				str+="<div class='md-checkbox'>";
				str+="<input type='checkbox' id='checkbox"+i+"'"+"class='md-check'";
				if(item[i].selected == 1){
					str+="checked";
				}
				str+=">";
				str+="<label for='checkbox"+i+"'>";
				str+="<span class='inc'></span>";
				str+="<span class='check'></span>";
				str+="<span class='box'></span>";

				str+=item[i].apn+"</label></div></div>";
				if(!(i+1)%4)
					str+="</div";
			}
			$('#checkBoxs').append(str);
			$('#ProfileModal').modal('show');
		},
		error: function(code){
			$('#rrr').html(code.responseText);
		}
	});
}
function showProfileModal(){
	getApnName(0);
	$('#name').val("");
	$('#subscriber_status').val('SERVICE_GRANTED');
	$('#rau_tau_timer').val(120);
	$('#ue_ambr_ul').val(Convert_From_B_To_MB(50000000));
	$('#ue_ambr_dl').val(Convert_From_B_To_MB(100000000));
	$('#ProfileModal #AddPro').html("Add Profile");
}

function saveProfileInfo(){
	if(cnt == 0){
		showInfoMsg('PDN List is empty. You must insert PDN in PDN Management.', '');
		$('#ProfileModal').modal('hide');
		return;
	}
	var id = $('#profile_id').val();

	if(!checkField('Profile Name', $('#name').val()))
        return;
    if(!checkField('RAU_TAU_TIMER', $('#rau_tau_timer').val()))
        return;
  	if(!checkField('Max Upload', $('#ue_ambr_ul').val()))
        return;
    if(!checkField('Max Download', $('#ue_ambr_dl').val()))
        return;
	var name = $('#name').val();
	var subscriber_status = $('#subscriber_status').val();
	var rau_tau_timer = $('#rau_tau_timer').val();
	var ue_ambr_ul = $('#ue_ambr_ul').val();
	var ue_ambr_dl = $('#ue_ambr_dl').val();
	var checkBoxStates = Array();
	var flag = false;
	for(var i=0;i<cnt;i++){
		var str='checkbox'+i;
		checkBoxStates[i] = document.getElementById(str).checked;
		if(checkBoxStates[i] == true){
			flag = true;	
		}
	}
	
	if(flag == false){
		var msg = "Select APN in PDN List.";
		var title = "";
		toastr.warning(msg, title);
		return;
	}
	
	
	
	var isDifferent = name.search($('#tmp').val());
	$.ajax({
		url: '/saveProfileInfo',
		method: 'get',
		type: 'json',
		data: {
			id: id,
			name: name,
			subscriber_status: subscriber_status,
			rau_tau_timer: rau_tau_timer,
			ue_ambr_ul: ue_ambr_ul,
			ue_ambr_dl: ue_ambr_dl,
			checkBoxStates: checkBoxStates,
			isDifferent: isDifferent
		},
		success: function(data, state){
			if(checkValidation(data)){
                $('#ProfileModal').modal('hide');
                refresh();
            }
		},
		error: function(code){
		}
	});
}
function showEditProfileModal(id){
	$.ajax({
		url: '/getProfileInfo',
		method: 'get',
		type: 'json',
		data: {
			id: id,
		},
		success: function(data, state){
			var item = JSON.parse(data)[0];
            $("#tmp").val(item.name);
			$('#name').val(item.name);
			$('#subscriber_status').val(item.subscriber_status);
			$('#rau_tau_timer').val(item.rau_tau_timer);
			$('#ue_ambr_ul').val(Convert_From_B_To_MB(item.ue_ambr_ul));
			$('#ue_ambr_dl').val(Convert_From_B_To_MB(item.ue_ambr_dl));
			$('#ProfileModal #AddPro').html("Edit Profile");
			$('#profile_id').val(id);
			getApnName(id);
			$('#ProfileModal').modal('show');
		},
		error: function(code){
			$('#rrr').html(code.responseText);
		}
	});
}
function showConfirmDlg(id){
    $('#confirm').modal('show');
    $('#yes').val(id);
    $('#menuName').val('PROFILE');
}
function deleteProfileInfo(id){
	$.ajax({
		url: '/deleteProfileInfo',
		method: 'get',
		data: {
			id: id,
		},
		success: function(data, state){
			 if(checkValidation(data)){
                $("#confirm").modal('hide');
                refresh();
            }
		},
		error: function(code){
		}
	});
}
function refresh(){
	$.ajax({
		url: '/profile',
		method: 'get',
		data: {
			gettype: 'json',
			myselect: $('#data_per_page').val(),
            page: $('#page').val(),
            sort: $('#sort').val(),
            order: $('#order').val()
		},
		success: function(data, state){
			$('#table_content').html(data);
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

function changeDefault(id){
	$.ajax({
		url: '/changeDefault',
		method: 'get',
		data: {
			id: id
		},
		success: function(data, state){
			if(checkValidation(data)){
				refresh();
			}
		},
		error: function(code){
			
		}
	});
}