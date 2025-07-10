function getAuthorityInfo(){
    var authorityInfo = Array();
    for(var i=0;i<30;i++){
        var str='checkBox_'+(i+1);
        authorityInfo[i] = document.getElementById(str) ? document.getElementById(str).checked : 0;
    }
    return authorityInfo;
}


function saveAdmin(){
    var id = $('#id').val();
    if(!checkField('Name', $('#Aname').val()))
        return;
    if(!checkField('UserId', $('#Aid').val()))
        return;
   var psw = $("#Confirm Password").val();
   var psw_ok = $("#Confirm Password").val();
   if(id == 0 || (psw != undefined && psw != "")){
        if(!checkField("Password", psw)) return;
        if(!checkField("Confirm Password", psw, psw_ok)) return;  
   }
    if($("#ipAddr").val() != undefined  && $("#ipAddr").val() != "")
        if(!checkField("AdminIp", $("#ipAddr").val()))
            return;
    
    var authorityInfo = getAuthorityInfo();
    $.ajax({
        url: '/saveAdmin',
        method: 'get',
        type:'json',
        data: {
            id: id,
            name: $('#Aname').val(),
            uid: $('#Aid').val(),
            ipAddr: $("#ipAddr").val(),
            password: $('#Apassword').val(),
            Adcontent: $('#Adcontent').val(),
            authorityInfo: authorityInfo
        },
        success: function(data, state){
           if(checkValidation(data)){
                back();
            }
        },
        error:function(code)
        {
            $('#rrr').html(code.responseText);
        }
    });
}
function refreshPage() {
    $.ajax({
        url: '/adminManagement',
        method: 'get',
        data: {
            myselect: $('#myselect').val(),
            page: $('#page').val(),
            gettype: 'json',
            sort: $('#sort').val(),
            order: $('#order').val()
        },
        success: function(data, state) {
            $('#table_content').html(data);
        },
        error:function(code)
        {
            $('#rrrr').html(code.responseText);
        }
    });
}

function sortByHeader(header) {
    if ($('#order').val() == 'asc') {
        var order = 'desc';
    } else {
        var order = 'asc';
    }
    $('#sort').val(header);
    $('#order').val(order);
    refreshPage();
}
function AdminInfo(id){
    document.adminRowNumber.row_Id.value = id;
    document.adminRowNumber.submit();
}
function showConfirmDlg(id){
    $('#confirm').modal('show');
    $('#yes').val(id);
    $('#menuName').val('AdministratorManagement');
}
function deleteAdminInfo(id){
    $.ajax({
        url: '/admin_dele',
        method: 'get',
        data:{
            id : id,
        },
        success:function(data, state){
            if(checkValidation(data)){
                $('#confirm').modal('hide');
                refreshPage();
            }
        },
        error: function(code){

        }
    });
}

function back(){
    location.href="/adminManagement";
}

window.onload = function() {
    $('.bootstrap-switch-container, .bootstrap-switch-handle-off').on('click', function (e) {
       var selChk = $(this).find("input");
       if (!$(selChk).attr("id")) selChk = $(this).parent().find("input");
       var selId = $(selChk).attr("id").substring(9);
       if(selId%3 != 1){
        if ($(selChk).is(":checked")) {
            var i;
            if(selId%3 == 2) i=selId-1;
            if(selId%3 == 0) i=selId-2;
            if(!$("#checkBox_"+i).is(":checked"))
                $('#checkBox_'+i).click();
            }
        }
       else{
            if(!$(selChk).is(":checked")){
                var str1 = "#checkBox_"+(parseInt(selId)+1);
                var str2 = "#checkBox_"+(parseInt(selId)+2);
                
                if($(str1).is(":checked")){
                    $(str1).click();
                }
                if($(str2).is(":checked")){
                    $(str2).click();
                }
            }
       }
    });
}