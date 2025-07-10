@extends('include.main')
@section('user_js')

@endsection
@section('content')
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <!-- BEGIN PAGE HEAD-->

        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE CONTENT BODY -->
        <div class="page-content">
            <div class="container">
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-green-sharp">
                                            <span data-counter="counterup" data-value="{{$imsiCnt}}">{{$imsiCnt}}</span>
                                        </h3>
                                        <small>IMSI</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-pie-chart"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-red-haze">
                                            <span data-counter="counterup" data-value="{{$blackListCnt}}">{{$blackListCnt}}</span>
                                        </h3>
                                        <small>Bloked IMEI</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-like"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="{{$whiteListCnt}}">
                                                {{$whiteListCnt}}
                                            </span>
                                        </h3>
                                        <small>Allowed IMEI</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-basket"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 ">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-purple-soft">
                                            <span data-counter="counterup" data-value="{{$pdnCnt}}">
                                                {{$pdnCnt}}
                                            </span>
                                        </h3>
                                        <small>PDN</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress">
                                        <span style="width: 100%;" class="progress-bar progress-bar-success purple-soft">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        
                    </div>
                    
                    <div class="row">
               
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-globe font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase">Access Log</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div id="table_content">
                                         @include('historyInfo')
                                    </div>
                            </div>
                            </div>
                            <!-- END PORTLET-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- BEGIN INNER FOOTER -->

@endsection