function showPdnModal(id) {
    if(id == 0)//Add
        pdnInfoInit();
    else{//Update{
        getPdnInfo(id);
    }
    $("#PdnModal").modal('show');
}

function pdnInfoInit(){
    $("#apn").val("");
    $("#tmp").val("");
    $("#pdn_type").val("IPv4");
    $("#pdn_ipv4").val("0.0.0.0");
    $("#pdn_ipv6").val("0:0:0:0:0:0:0:0");
    $("#aggregate_ambr_ul").val(Convert_From_B_To_MB(50000000));
    $("#aggregate_ambr_dl").val(Convert_From_B_To_MB(100000000));
    $("#qci").val(9);
    $("#priority_level").val(15);
    $("#pre_emp_cap").val("DISABLED");
    $("#pre_emp_vul").val("DISABLED");
    $("#LIPA_Permissions").val("LIPA-ONLY");
    $("#PdnModal #AddPdn").html("Add PDN");
}

function getPdnInfo(id){
     $.ajax({
        url: '/pdn/getinfo',
        method: 'get',
        type:'json',
        data: {
            id: id,
        },
        success: function(data, state){
            var item = JSON.parse(data)[0];
            $("#tmp").val(item.apn);
            $("#pdn_id").val(item.id);
            $("#apn").val(item.apn);
            $("#pdn_ipv4").val(item.pdn_ipv4);
            $("#pdn_ipv6").val(item.pdn_ipv6);
            $("#aggregate_ambr_ul").val(Convert_From_B_To_MB(item.aggregate_ambr_ul));
            $("#aggregate_ambr_dl").val(Convert_From_B_To_MB(item.aggregate_ambr_dl));
            $("#qci").val(item.qci);
            $("#priority_level").val(item.priority_level);
            $("#pdn_type").val(item.pdn_type);
            $("#pre_emp_cap").val(item.pre_emp_cap);
            $("#pre_emp_vul").val(item.pre_emp_vul);
            $("#LIPA_Permissions").val(item.LIPA_Permissions);
            $("#PdnModal #AddPdn").html("Edit PDN");
        },
        error:function(code)
        {
            //$('#rrr').html(code.responseText);
        }
    });
}

function savePdnInfo() {
    if(!checkField('APN', $("#apn").val()))
        return;
    if(!checkField('IPv4', $("#pdn_ipv4").val()))
        return;
     if(!checkField('IPv6', $("#pdn_ipv6").val()))
        return;
     if(!checkField('Max Upload', $("#aggregate_ambr_ul").val()))
        return;
     if(!checkField('Max Download', $("#aggregate_ambr_dl").val()))
        return;
    if(!checkField('Priority Level', $("#priority_level").val()))
        return;
    if(!checkField('QCI', $("#qci").val()))
        return;
    var isDifferent = $("#apn").val().search($('#tmp').val());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/pdn/saveinfo',
        method: 'post',
        type:'json',
        data: {
            id: $("#pdn_id").val(),
            apn: $("#apn").val(),
            pdn_type: $("#pdn_type").val(),
            pdn_ipv4: $("#pdn_ipv4").val(),
            pdn_ipv6: $("#pdn_ipv6").val(),
            aggregate_ambr_ul: $("#aggregate_ambr_ul").val(),
            aggregate_ambr_dl: $("#aggregate_ambr_dl").val(),
            qci: $("#qci").val(),
            priority_level: $("#priority_level").val(),
            pre_emp_cap: $("#pre_emp_cap").val(),
            pre_emp_vul: $("#pre_emp_vul").val(),
            LIPA_Permissions: $("#LIPA_Permissions").val(),
            isDifferent: isDifferent
        },
        success: function(data, state){
            if(checkValidation(data)){
                $("#PdnModal").modal('hide');
                refreshPage();
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
        url: '/pdn',
        method: 'get',
        data: {
            myselect: $('#data_per_page').val(),
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
            
        }
    });
}

function showConfirmDlg(id){
    $('#confirm').modal('show');
    $('#yes').val(id);
    $('#menuName').val('PDN');
}

function deletePdnInfo(id){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/pdn/deletePdnInfo',
        method: 'post',
        type:'json',
        data: {
            id: id,
        },
        success: function(data, state){
            if(checkValidation(data)){
                $("#confirm").modal('hide');
                refreshPage();
            }
        },
        error:function(code)
        {
            $('#rrr').html(code.responseText);
        }
    });
}

function sortByHeader(header) {
    if($('#order').val() == 'desc')
        $('#order').val('asc');
    else
        $('#order').val('desc');
    $('#sort').val(header);
    refreshPage();
}