function checkField(field, value){
	switch(field){
		case 'APN':
		case 'Profile Name':
		case 'FilePath':
			return checkEmptyField(field, value);
		case 'IPv4':
			return checkEmptyField(field, value) && checkIpv4Address(field, value);
		case 'IPv6':
			return checkEmptyField(field, value) &&　checkIpv6Address(field, value);
		case 'Max Upload':
		case 'Max Download':
			return checkEmptyField(field, value) && checkFloat(field, value);
		case 'Priority Level':
			return checkEmptyField(field, value) && checkRange(field, value, 1, 15);
		case 'QCI':
			return checkEmptyField(field, value) && checkRange(field, value, 1, 9);
		case 'RAU_TAU_TIMER':
			return checkEmptyField(field, value) && checkDigit(field, value);
		case 'PDN List':
			return checkPdnList(field, value);
		case 'IMSI':
		case 'IMEI':
			return checkEmptyField(field, value) && checkLength(field, value, 15) && checkDigit(field, value);
		case 'IMEI SV':
			return checkEmptyField(field, value) && checkLength(field, value, 2) && checkDigit(field, value);
		case 'KI':
			return checkEmptyField(field, value) && checkK(field, value);
		case 'Phone':
			return checkEmptyField(field, value);
		case 'OPC':
			return 	checkEmptyField(field, value) && checkLength(field, value, 32) && checkHex(field, value);
		case 'K':
			return checkKField(value);
		// case 'r':
		// case 'c':
		// 	return check_R_Or_CField(field, value);
		case 'Name':
		case 'UserId':
			return checkEmptyField(field, value);
		 case 'Password':
		 	return checkPassword(field, value);
		case 'Confirm Password':
			return isValueSame(field, value, $("#Apassword").val());
		case 'AdminIp':
			return checkIpv4Address(field, value);
		default:
			return false;
	}
}

function checkK(field, value){
	for(var i=0; i<value.length; i++){
		if(value[i]>='0' && value[i]<='f')
			continue;
		else{
			showWarningMsg(field + "type incorrect.");
			return false;	
		}
	}
	return true;
}

function checkPassword(field, value){
    if(value == undefined || value.length <12){
		showWarningMsg(field+'must be longer than 12 characters.');
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
	showWarningMsg(field+'must include Number & symbol.');
    return false;
}

function isValueSame(field, val1, val2){
	if(val1 != val2){
		showWarningMsg("Retype in" + field);
		return false;
	}
	return true;
}

function test(field, value){
	
	
}


function checkPdnList(field, value){
	var flag = false;
	for(var i=0; i<value.length; i++){
		if(value[i]["state"] == true){
			if(!checkIpv4Address(field, value[i]["ipAddr"]))
				return false;
			flag = true
		}
	}
	if(!flag){
		showWarningMsg('Select APN in' + field);
		return false;
	}
	return true;
}

function checkFloat(field, value){
	var floatVal = parseFloat(value);
	if(floatVal == NaN || floatVal < 0 || value.length != floatVal.toString().length){
		showWarningMsg("Correct the" + field + ".", "Type Error");
		return false;
	}
	return true;
}

function checkIpv6Address(field, value){
	/*var str = value.split(':');
	if(str.length != 6){
		showWarningMsg("Correct the" + field + ".", "Type Error");
		return false;
	}
	for(var i=0; i<6; i++){
		if(str[i].match('^([0-9a-fA-F]){1,4}$') == null){
			showWarningMsg("Correct the" + field + ".", "Type Error");
			return false;
		}
		var intVal = parseInt(str[i]);
		if(intVal>255 || intVal<0){
			return showWarningMsg("Correct the" + field + ".", "Type Error");
		}
		if(intVal.toString().search(str[i]) ==-1)
			showWarningMsg("Correct the" + field + ".", "Type Error");
			return false;
	}*/
	return true;
}
showWarningMsg("Correct the" + field + ".", "Type Error");
function checkIpv4Address(field, value){

	if(field == 'PDN'){
		var str = value.split('.');
		if(str.length != 4){
			showWarningMsg('Correct IP in ' + field + ".", 'Type Error');
			return false;
		}
		for(var i=0; i<4; i++){
			if(str[i].match('^([0-9]){1,3}$') == null){
				showWarningMsg('Correct IP in ' + field + ".", 'Type Error');
				return false;
			}
			var intVal = parseInt(str[i]);
			if(intVal>255 || intVal<0){
					showWarningMsg('Correct IP in ' + field + ".", 'Type Error');
				return false;
			}
			if(intVal.toString().search(str[i]) ==-1){
				showWarningMsg('Correct IP in ' + field + ".", 'Type Error');
				return false;
			}
		}
		return true;
	}

	else{
		var str = value.split('.');
		if(str.length != 4){
			showWarningMsg("Correct the" + field + ".", "Type Error");
			return false;
		}
		for(var i=0; i<4; i++){
			if(str[i].match('^([0-9]){1,3}$') == null){
				showWarningMsg("Correct the" + field + ".", "Type Error");
				return false;
			}
			var intVal = parseInt(str[i]);
			if(intVal>255 || intVal<0){
				showWarningMsg("Correct the" + field + ".", "Type Error");
				return false;
			}
			if(intVal.toString().search(str[i]) ==-1){
				showWarningMsg("Correct the" + field + ".", "Type Error");
				return false;
			}
		}
		return true;
	}
}

// function check_R_Or_CField(field, value){
// 	for(var i=0; i<value;i++){
// 		var str='#'+field+(i+1);
// 		var val = $(str).val();
// 		if(!checkEmptyField(field+(i+1), val) || !checkRange(field+(i+1), val, 0, 255))
// 			return false;
// 	}
// 	return true
// }

function checkRange(field, val, st, en){
	var tmp = val.match('[0-9]+');
	var len = val.length;
	var str = field.toUpperCase();
	if(tmp == null || tmp[0].length != len){
		showWarningMsg(str + "field must contain integer between " + st + " and " + en, 'Type Error');
		return false;
	}
	var intVal = parseInt(val, 10);
	if(intVal >en || intVal <st){
		showWarningMsg(str + "field must contain integer between " + st + " and " + en, 'Type Error');
		return false;
	}
	return true;
}

function checkKField(value){
	for(var i=0; i<value; i++){
		var str='#k'+(i+1);
		var ki = $(str).val();
		if(!checkEmptyField('K'+(i+1), ki) || !checkLength('K'+(i+1), ki, 16))
			return false;
	}
	return true;
}

function checkHex(field, value){
	var str  = value.match("([A-Fa-f0-9])+");
	if(str ==null || str[0].length != value.length){
		showWarningMsg(field+' field must contain only hexademical letters.', 'Type Error');
		return false;
	}
	return true;
}

function checkLength(field, value, length){
	if(value.length == length)
		return true;
	else{
		showWarningMsg(field + " field must contain " + length + ' characters.', "Type Error");
		return false;
	}
		
}

function checkDigit(field, value){
	for(var i=0; i<value.length; i++){
		if(value.charAt(i)<'0' || value.charAt(i)>'9'){
			showWarningMsg(field+ " field is incorrect.", 'Type Error'); 
			return false;
		}
	}
	return true;
}

function checkEmptyField(field, value){
	var str = field.toUpperCase();
	if(value==undefined ||value.length != 0)
		return true;
	else{
		showWarningMsg('You must input in ' + field + " field.", "");
		return false;
	}
}

function showWarningMsg(title, msg){
	toastr.options.positionClass = 'toast-top-right';
	toastr.options.closeButton = 'true';
	toastr.warning(title, msg);
}

function showInfoMsg(title, msg){
	toastr.options.positionClass = 'toast-top-right';
	toastr.options.closeButton = 'true';
	toastr.info(title, msg);
}

function Convert_From_B_To_MB(value){
    var mb = new String(value/1024/1024);
    return mb.substring(0,mb.indexOf('.')+4);
}