@extends('include.main')
@section('user_js')
    <script src="/js/admin/adminManagement.js"></script>
@endsection
@section('content')
<input type="hidden" id="id" value="{{$row_Id}}">
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                <ul class="page-breadcrumb breadcrumb">
                  <li>
                        <font size="5" color="red">Admin</font>
                  </li>
                </ul>
                <!-- END PAGE BREADCRUMBS -->
                <!-- BEGIN PAGE CONTENT INNER -->
                <div class="page-content-inner">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                           @include('admin.adminManagementBasicInfo')
                           @include('admin.adminManagementAuthorityInfo')
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@endsection