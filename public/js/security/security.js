function saveOPC(){
	if(!checkField('OPC', $('#opc').val()))
		return;
	$.ajax({
		url: '/saveOPC',
		method: 'get',
		data: {
			opc: $('#opc').val(),
		},
		success: function(data, state){
			checkValidation(data);			
		},
		error: function(code){

		}
	});
}
function saveKIInfo(){
	if(!checkField('K', 10))//10 is not value of Ki Field. it is count of K field
		return;
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$.post(
		'/saveKIInfo',
		{
			ki: getKi(),
		},
		function(data, state){
			checkValidation(data);
		}
	);
}
function getKi(){
	var ki = new Array();
	for(var i=0; i<=10; i++){
		var str='#'+'k'+(i+1);
		ki.push($(str).val());
	}
	return ki;
}

$("#id-sql-btn").click(function() {
    $("#id-sql-file").click();
});

$("#id-sql-file").change(function() {
    var sql_file = $("#id-sql-file").val();
    if (["sql"].indexOf(sql_file.toLowerCase().substr(-3)) == -1) {
    	// alert("Unknown file type.");
    	alert("Unknown file type.");
    	$("#id-cert-file").val("");
    	return false;
    }

    var tmp = sql_file.split("\\");
    if (tmp.length > 1)
    {
        $("#id-sql-btn span").html("Backup file(" + tmp[tmp.length - 1] + ")");
    }

    return true;
});