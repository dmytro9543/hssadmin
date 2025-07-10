@extends('include.main')
@section('user_js')
    <script src="/js/imsi/imsi.js"></script>
    <script src="/js/confirm.js"></script>
    
    <script type="text/javascript" language="javascript">
        window.onload = function(){
            @if($quantity == 1)
                var failureCnt = 0;
                var succssCnt = 0;
                var totalCnt = {{count($result)}};
                var title1="";
                var title2="";
                var msg="";
                
                @foreach($result as $key => $row)
                    //alert({{$row["imsi"]}});
                    if({{$row["status"]}} == "2000"){
                        failureCnt++;
                        msg += "IMSI:"+{{$row["imsi"]}}+"Failed Addition"+"\n";
                    }
                    if({{$row["status"]}} == "1")
                        succssCnt++;
                @endforeach

                if(failureCnt){
                    title2 = totalCnt+"  /  "+failureCnt+" Failed";
                    toastr.options.closeButton = 'true';
                    toastr.error(msg, title2);
                }
                if(succssCnt){
                    title1+=totalCnt+"  /  "+succssCnt+" Success";
                    toastr.options.closeButton = 'true';
                    toastr.success("", title1);
                }
            @endif

        }
    </script>
@endsection
@section('content')
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                <ul class="page-breadcrumb breadcrumb">
                  <li>
                        <font size="5" color="red">IMSI</font>
                  </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            @include('imsi.imsiSearchInfo')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption" style="margin-top: 8px">
                                        <i class="fa fa-globe"></i>IMSI List</div>
                                    @if($permInfo[0]->perm_upd == 1)
                                    <div class="tools">
                                    
                                    <input type="button" class="btn red-sunglo" value="Add" onclick="showIMSIModal();">
                                    </div>
                                    @endif
                                </div>  
                                <div class="portlet-body">
                                    <form action="/imsi" method="get" id="data_size">
                                    Rows:
                                    <select name="myselect" id="myselect" onchange="$('#data_size').submit()">
                                        <option value="5" @if($data_per_page == 5) selected @endif>5</option>
                                        <option value="10" @if($data_per_page == 10) selected @endif>10</option>
                                        <option value="15" @if($data_per_page == 15) selected @endif>15</option>
                                        <option value="20" @if($data_per_page == 20) selected @endif>20</option>
                                    </select>
                                    </form>
                                    <div style="height: 5px"></div>
                                    <div id="table_content">
                                         @include('imsi.imsicontent')
                                    </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                     @include('imsi.imsimodal')
                </div> 

                 @include('imsi.RemarkDlg')
                 @include('include.confirm')
                 
                 @include('imsi.imsiQuantityModal')
            </div>
        </div>
    </div>
</div>
@endsection