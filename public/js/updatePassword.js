function savePassword(){
	var new_psw = $("#new_psw").val();
	var pre_Password = $("#pre_Password").val();
	var new_psw_Ok = $("#new_psw_Ok").val();
	if(!checkPrePassword(pre_Password))return;
	if(!checkNewPassword(new_psw)) return;
	if(!checkNewPasswordOn(new_psw, new_psw_Ok))return;
	$.ajax({
		url: '/updatePassword',
        method: 'get',
        type:'json',
        data: {
        	pre_Password: pre_Password,
        	new_psw: new_psw
        },
        success: function(data, state){
           if(checkValidation(data)){
                location.href = "/";
            }
        },
        error:function(code)
        {
            $('#rrr').html(code.responseText);
        }
	});
}

function checkPrePassword(value){
	if(value==undefined || value.length != 0)
		return true;
	else{
		showWarningMsg('You must input Password.', '');
		return false;
	}
}
function checkNewPassword(value){
	if(value == undefined || value.length <12){
		showWarningMsg('Password must be larger than 12 characters.', '');
		return false;
	}
	var str="";
	var flag = new Array(0, 0);
	for(var i=0; i<value.length; i++){
		var ascii= value.charCodeAt(i);
		str += ascii;
		if(ascii >=0x30 && ascii<= 0x39){
			flag[0] = 1;
			continue;
		}
		if((ascii >=97 && ascii<=122) || (ascii >=65 && ascii<=90))
			continue;
		flag[1] = 1;
	}
	if(flag[0] && flag[1])
		return true;
	showWarningMsg('Password must include Number & symbol.', '');
	return false;
}

function checkNewPasswordOn(val1, val2){
	if(val1 != val2){
		showWarningMsg("Password must match.");
		return false;
	}
	return true;
}