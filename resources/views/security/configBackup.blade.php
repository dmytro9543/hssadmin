@extends('include.main')
@section('user_js')
    <script src="/js/security/security.js"></script>
@endsection
@section('content')
<div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <div class="page-content">
        <div class="container">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <font size="5" color="red" id="title">Backup & Restore</font>
                </li>
            </ul>
            <div class="page-content-inner">
                <div class="row">
                    <div class="col-md-6 col-sm-6">        
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-comments">
                                    <font size = "3" color="white">Backup</font>
                                    </i> 
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div class="portlet-body form"> 
                                    <div class="form-body">
                                        <div style="height: 10px"></div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <form action="{{url('/backup')}}" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <center><button type="submit" class="btn blue">Backup</button></center>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">        
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-comments">
                                    <font size = "3" color="white">Restore</font>
                                    </i> 
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div class="portlet-body form"> 
                                    <div class="form-body">
                                        <div style="height: 10px"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form action="{{url('/restore')}}" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                              <input type="file" class="" id="id-sql-file" name="sqlfile" required style="display:none" aria-required="true">
                                                <span class="btn btn-default fileinput-button form-control" id="id-sql-btn">
                                                    <i class="fa fa-file-text"></i>
                                                    <span> &nbsp;Select a file(*.sql)</span>
                                                </span>
                                                <div style="height: 10px"></div>
                                                <center><button type="submit" class="btn blue">Restore</button></center>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection