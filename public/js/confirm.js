$(document).ready(function(){
    $('#yes').click(function(){
    	switch($('#menuName').val()){
            case 'IMSI':
                deleteIMSIInfo($('#yes').val());break;
    		case 'PROFILE':
                deleteProfileInfo($('#yes').val());break;
            case 'PDN':
              deletePdnInfo($('#yes').val());break;
            case 'IMEI':
              deleteIMEIInfo($('#yes').val());break;
            case 'AdministratorManagement':
                deleteAdminInfo($('#yes').val());break;
            case 'History':
                 deleteHistoryInfo($('#yes').val());break;
    	}
    });
});