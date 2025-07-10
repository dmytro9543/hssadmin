@if(count($data) > 0)
<div class="row">
<div class = "table table-bordered ">

	<div class="col-md-4">
	<div class="pull-left" style="margin-bottom: 30px">
		<div style="height: 10px"></div>
		<font size="5px">
			<span>Total:&nbsp<b id="total_data_size">{{number_format($data_size, 0, ".", " ")}}</b>&nbsp</span>
		</font>
	</div>
	</div>
	
	<div class="col-md-8">
	<div class="pull-right">
	<font size="3">
			{{ $data->appends(['myselect' => $data_per_page])->links() }}
	</font>
	</div>
	</div>
</div>
</div>
@endif