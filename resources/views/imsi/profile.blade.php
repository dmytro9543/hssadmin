@extends('include.main')
@section('user_js')
    <script src="/js/imsi/profile.js"></script>
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
                        <font size="5" color="red">Profile</font>
                  </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption" style="margin-top: 8px">
                                        <i class="fa fa-globe"></i>Profile List</div>
                                    <div class="tools">
                                    @if($permInfo[1]->perm_upd == 1)<input type="button" class="btn red-sunglo" value="Add" onclick="showProfileModal();">@endif
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <form action="/profile" method="get" id="data_size">
                                    Rows:
                                    <select name="myselect" id="myselect" onchange="$('#data_size').submit()">
                                        <option value="5" @if($data_per_page == 5) selected @endif>5</option>
                                        <option value="10" @if($data_per_page == 10) selected @endif>10</option>
                                        <option value="15" @if($data_per_page == 15) selected @endif>15</option>
                                        <option value="20" @if($data_per_page == 20) selected @endif>20</option>
                                    </select>
                                    <div style="height: 5px"></div>
                                    <div id="table_content">
                                         @include('imsi.profilecontent')
                                    </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                     @include('imsi.profilemodal')
                     @include('include.confirm')
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection