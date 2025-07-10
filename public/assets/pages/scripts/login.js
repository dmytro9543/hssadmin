var Login = function() {

    var handleLogin = function() {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }

    
    return {
        //main function to initiate the module
        init: function() {
            handleLogin();
        }

    };

}();

var embed = null;
var status;             //통표의 상태값

//오유목록
var PT_ERR_OK = 0,
    PT_ERR_GENERAL = -100,
    PT_ERR_FAIL = -99,
    PT_ERR_INVALID_PARAM = -98,
    PT_ERR_FUNCTION_NOT_SUPPORTED = -97,
    PT_ERR_PARAM_NOT_SUPPORTED = -96,
    PT_ERR_NOT_INITIALIZED = -95,
    PT_ERR_NOT_LOGINED = -94,
    PT_ERR_USER_ALREADY_LOGGED_IN = -93,
    PT_ERR_NOT_FORMAT_TOKEN = -92,
    PT_ERR_EMPTY_USER = -91,
    PT_ERR_UNKNOWN_USER_NAME = -90,
    PT_ERR_EMPTY_CERT = -89,
    PT_ERR_LOAD_DATA = -88,
    PT_ERR_SAVE_DATA = -87,
    PT_ERR_LOAD_CERT = -86,
    PT_ERR_LOAD_ROOT_CERT = -85,
    PT_ERR_NOT_FOUND_CERT = -84,
    PT_ERR_SIGNATURE_INVALID = -83,
    PT_ERR_ENCRYPT = -82,
    PT_ERR_DECRYPT = -81,
    PT_ERR_SIGN = -80,
    PT_ERR_VERIFY = -79,
    PT_ERR_DATA_LEN_RANGE = -78,
    PT_ERR_PIN_INCORRECT = -77;
    PT_ERR_OPEN_FILE = -76;
    PT_ERR_CONNECT_SERVER = -75;
    PT_ERR_CREATE_KEYPAIR = -74;
    PT_ERR_CREATE_CSR = -73;
    PT_ERR_INSTALL_CERT = -72;
    PT_ERR_INVALID_SERVER_DATA = -71;
    PT_ERR_UPDATE_FIRMWARE = -70;
    PT_ERR_FINGERPRINT_EXPIRED = -69;

function loginByEnter(){
    if(event.which == 13){
        login();
    }
}

jQuery(document).ready(function() {

    $("#isToken").val("0");

    embed = document.getElementById("psjdc-usb-token-plugin-p");

    //Login.init();

    // initialize
    status = embed.Initialize();
    if(status == PT_ERR_OK) {
        $("#isToken").val("1");
        //document.formname.ResultData.value = "Initialize Success";
    } else {
        LastError(status);
        return;
    }

    // 통표장치에 가입한다.
    // status = embed.Login("장치암호", "증명서식별자", "사용자이름");
    // 입력파라메터로 빈문자렬을 입력하는 경우 해당한 항목을 요구하는 대면부가 현시된다.
    status = embed.Login("12345678", "", "");
    if(status == PT_ERR_OK || status == PT_ERR_USER_ALREADY_LOGGED_IN) {

        status = embed.GetCertField(1);
        if (status == PT_ERR_OK) {
            $("#uid").val(embed.ResultData());
            $.ajax({
                url: '/getRandom',
                method: 'get',
                data: {
                    
                },
                success: function(data, state){
                    $("#randomNumber").val(data);
                },
                error: function(code){
                }
            });
        } else {
            LastError(status);
            return;    
        }
    } else {
        LastError(status);
        return;
    }

    // 가입탈퇴
    //status = embed.Logout();
});

//오유표시함수
function LastError(errorstatus) {
    if (errorstatus == PT_ERR_OK) {
        //document.formname.ResultData.value = errorstatus;
    } else {
        if (errorstatus == PT_ERR_GENERAL) {
            alert('통표정보를 찾을수 없습니다.');
        }  else if (errorstatus == PT_ERR_USER_ALREADY_LOGGED_IN) {
            alert("통표에 이미 로그인하였습니다.")
        }
        else {
            alert('통표조작에서 오유가 발생하였습니다: ' + errorstatus);
        }
    }
    return;
}

function makeSha256(pwd){
    //For non-English words only
    var str = unescape(encodeURIComponent(pwd));
    
    var data = new Array(str.length);
    for(var i=0;i<data.length;i++)
        data[i] = str[i].charCodeAt(0);
            
    //SHA256 procedure here.
    pol_sha256.SHA256_init();
    pol_sha256.SHA256_update(data);
    hash = pol_sha256.SHA256_digest();
    var hash_str = "";
    var tmp="";
    for(i=0;i<hash.length;i++)
    {
        tmp = (hash[i] % 256).toString(16);
        if(tmp.length==1) tmp="0"+tmp;
        hash_str += tmp;
    }
    return hash_str;
}

function login(){
    var uid = $("#uid").val();
    var pwd = makeSha256($("#pwd").val());
    console.log(pwd);
    var isToken = $("#isToken").val();
    if(isToken == "1"){//통표에 의한 가입
        var signData;
        var cert;
        var randomNumber = $("#randomNumber").val();
        var data = escape(uid+pwd+randomNumber);
        var status = embed.Sign(data, 1);
            
            // var policyoid; 
            // var data = md5(uid+pwd+randomNumber);
            //var status = embed.Sign(data, 5); // 1: PT_SIGN_SHA256_RSA_PKCS, 5: PT_SIGN_SHA384_ECC_PKCS
			if(status == PT_ERR_OK){
                signData = embed.ResultData();
            } else {
            	alert('통표를 리용한 서명생성이 실패하였습니다.');
            	return;
            }
            //console.log(uid+pwd+randomNumber);
            //console.log(signData);
            status = embed.GetCert(2);
            if(status == PT_ERR_OK){
                cert = embed.ResultData();
            } else {
            	alert('통표에서 전자증명서를 얻을수 없습니다.');
            	return;
            }
            
            status = embed.GetCertField(17);
            if(status == PT_ERR_OK){
                policyoid = embed.ResultData();
            } else {
            	alert('통표에서 정책식별자를 얻을수 없습니다.');
            	return;
            }
            document.token.userId.value = uid;
            document.token.signData.value = signData;
            document.token.cert.value = cert;
            document.token.isToken.value = isToken;
	        document.token.policyoid = policyoid;
            document.token.submit();
    }
    else{//일반가입
        document.token.userId.value = uid;
        document.token.isToken.value = isToken;
        document.token.password.value = pwd;
        document.token.submit();
    }
}


