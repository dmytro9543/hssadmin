function checkValidation(data){
	var flag = 0;
	var item = JSON.parse(data);
	var errorcode = item.errorcode;
	var errorName = item.errorName;
	var msg="";
	switch(errorcode){
		case '1000':
			msg='You must input IMSI.';
			break;
		case '1001':
			msg='You must input KI.';
			break;
		case '1002':
			msg='You must input Phone.';
			break;
		case '1003':
			msg='You must input IMEI.';
			break;
		case '1004':
			msg='You must input IMEI SV.';
			break;
		case '1020':
			msg='You must input OPC.';
			break;
		case '1030':
			msg='You must input K1.';
			break;
		case '1031':
			msg='You must input K2.';
			break;
		case '1032':
			msg='You must input K3.';
			break;
		case '1033':
			msg='You must input K4.';
			break;
		case '1034':
			msg='You must input K5.';
			break;
		case '1035':
			msg='You must input K6.';
			break;
		case '1036':
			msg='You must input K7.';
			break;
		case '1037':
			msg='You must input K8.';
			break;
		case '1038':
			msg='You must input K9.';
			break;
		case '1039':
			msg='You must input K10.';
			break;
		case '1040':
			msg='You must input R1.';
			break;
		case '1041':
			msg='You must input R2.';
			break;
		case '1042':
			msg='You must input R3.';
			break;
		case '1043':
			msg='You must input R4.';
			break;
		case '1044':
			msg='You must input R5.';
			break;
		case '1045':
			msg='You must input C1.';
			break;
		case '1046':
			msg='You must input C2.';
			break;
		case '1047':
			msg='You must input C3.';
			break;
		case '1048':
			msg='You must input C4.';
			break;
		case '1049':
			msg='You must input C5.';
			break;
		case '2000':
			msg = "IMSI already exists."
			break;
		case '2001':
			msg = "Phone already exists."
			break;
		case '2003':
			msg = "IMEI already exists."
			break;
		case '2004':
			var tmp='Black List';
			if(errorName == 'WHITELISTED')
				tmp = 'White List';
			msg = "Already inserted into " + tmp;
			break;
		case '3001':
			msg = "You must input APN."
			break;
		case '3002':
			msg = "You must select PDN type."
			break;
		case '3003':
			msg = "You must input IPv4."
			break;
		case '3004':
			msg = "You must input IPv6."
			break;
		case '3005':
			msg = "You must input Max Upload.";
			break;
		case '3006':
			msg = "You must input Max Download."
			break;
		case '3007':
			msg = "You must input QCI."
			break;
		case '3008':
			msg = "You must input Priority Level."
			break;
		case '3009':
			msg = "You must select PRE_EMP_CAP."
			break;
		case '3010':
			msg = "You must select PRE_EMP_VUL."
			break;
		case '3011':
			msg = "You must select LIPA Permission."
			break;
		case '3012':
			msg = "APN already exists.";
			break;
		case '3013':
			msg = "You can't delete because PDN is in use.";
			break;
		case '4001':
			msg = "You must input Profile.";
			break;
		case '4002':
			msg = "You must select User State.";
			break;
		case '4003':
			msg = "You must select RAU-TAU-Timer.";
			break;
		case '4004':
			msg = "You must select APN in PDN List.";
			break;
		case '4005':
			msg = "Profile Name already exists.";
			break;
		case '5000':
			msg = "You must input Administrator Name";
			break;
		case '5001':
			msg = "You must input UserId.";
			break;
		case '5002':
			msg = "You must input Password.";
			break;
		case '5003':
			msg = "UserId already exists.";
			break;
		case '5004':
			msg = 'Password is incorrect.';
			break;
		default:
			msg = "The operation finishes successfully."
			flag = 1;
	}
	showMessage(msg, flag);
	return flag;
}

function showMessage(msg, flag){
	var title="";
	title="Fail";
	if(flag)
		title="Success";
	//toastr.options.positionClass = 'toast-top-center';
	//toastr.options.ti
	toastr.options.closeButton = 'true';
	if(flag)
		toastr.success(msg, title);
	else
		toastr.error(msg, title);
}