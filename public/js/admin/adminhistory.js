function refreshPage() {
    var searchAdmiId = $('#searchAdmiId').val();
    $.ajax({
        url: '/adminHistory',
        method: 'get',
        data: {
            myselect: $('#data_per_page').val(),
            page: $('#page').val(),
            gettype: 'json',
            sort: $('#sort').val(),
            order: $('#order').val(),
            searchAdmiId: searchAdmiId
        },
        success: function(data, state) {
            $('#table_content').html(data);
            if($("#order").val() == "asc")
                $("#"+$("#sort").val()).attr("class", "sorting_desc");
            else
                $("#"+$("#sort").val()).attr("class", "sorting_asc");
        },
        error:function(code)
        {
            
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

function showConfirmDlg(id){
    $('#confirm').modal('show');
    $('#yes').val(id);
    $('#menuName').val('History');
}

function deleteHistoryInfo(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/deleteHistoryInfo',
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

function reset(){

$.ajax({
        url: '/clearHistory',
        method: 'get',
        data: {
            
        },
        success: function(data, state) {
            refreshPage();
        },
        error:function(code)
        {
            
        }
    });

}

function searchByEnter(){
    if(event.which == 13){
        refreshPage();
    }
}