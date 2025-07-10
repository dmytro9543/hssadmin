<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Subscriber Management System</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="../assets/title.ico" rel="icon" />

        <link href="../assets/global/plugins/bootstrap-toastr/toastr.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="../assets/pages/css/login-2.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
    </head>
    <body class=" login" style="font-family: 'WKLChongbong'">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <font size="6px" color="white">
                Change Password </font>
        </div>
        <div class="content">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">


            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>

                <input class="form-control placeholder-no-fix" type="text" class="form-control" id="previous_Password" autocomplete="off" placeholder="Password">
            </div>

            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">New Password</label>
                <input class="form-control placeholder-no-fix" type="password" class="form-control" id="password" autocomplete="off" placeholder="New Password">
            </div>

            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>

                <input class="form-control placeholder-no-fix" type="password" class="form-control" id="password_confirmation" autocomplete="off" placeholder="Confirm Password">

            </div>
          
            <div class="form-actions">
            <div class="row">
            <div class="col-md-6">
            <button onclick="setPassword();" class="btn red btn-block uppercase">OK</a>
            </div>
            <div class="col-md-6">
            <a href="/login" class="btn red btn-block uppercase">Cancel</a>
            </div>
            </div>
            </div>


        </div>
        <script src="../js/updatePassword.js" type="text/javascript"></script>
        <script src="../js/checkField.js" type="text/javascript"></script>
        <script src="../js/ErrorCode.js" type="text/javascript"></script>
      
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->

      
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-toastr/toastr.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
    </body>
</html>