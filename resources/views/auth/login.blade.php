<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
	    <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Subscriber Management System</title>
        <link href="../assets/title.ico" rel="icon" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- 평공USB보안통표 개인용 장치를 사용하는경우 -->
    	<embed TYPE='application/psjdc-usb-token-plugin-e'  hidden='true' style='height: 17px' id='psjdc-usb-token-plugin-p'/>

     <!-- BEGIN GLOBAL MANDATORY STYLES -->
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
        <link href="../assets/auth/auth-plugin.css" rel="stylesheet" type="text/css" />
        	
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <body class=" login" style="font-family: WKLChongbong">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <font size="6px" color="white">
                Subscriber Management System </font>
        </div>
        <form name="token" action="/login" method="post">
            {!! csrf_field() !!}
            <input type="hidden" id="userId" name="userId">
            <input type="hidden" id="isToken" name="isToken">
            <input type="hidden" name="signData" id="signData">
            <input type="hidden" name="cert" id="cert">
            <input type="hidden" id="password" name="password">
			<input type="hidden" id="policyoid" name="policyoid">
        </form>

        <div class="content">
   
            <div class="login-form" role="form" onkeypress="loginByEnter();">
                {!! csrf_field() !!}
                
                <input type="hidden" id="randomNumber" name="randomNumber">
                <div class="form-group{{ $errors->has('uid') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">User</label>

                    <input class="form-control form-control-solid placeholder-no-fix" type="text" name="uid" id="uid" value="{{ old('uid') }}" autocomplete="off" placeholder="User">

                    @if ($errors->has('uid'))
                        <span class="help-block">
                            <strong>{{ $errors->first('uid') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password" id="pwd" autocomplete="off" placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-actions">
                    <button onclick="login();" class="btn red btn-block uppercase">Login</button>
                </div>
                <!--
                <div class="form-actions">
                    <div class="pull-left">
                        <label class="rememberme check">
                            <input type="checkbox" name="remember" value="1" />암호를 기억하시겠습니까?</label>
                    </div>
                    <div class="pull-right forget-password-block">
                        <a href="{{ url('/register') }}" class="forget-password">암호를 잊으셨습니까?</a>
                    </div>
                </div>
                -->
            </form>
        </div>
     
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
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/sha256.js" type="text/javascript"></script>
        <script src="../assets/pages/scripts/login.js" type="text/javascript"></script>
        <script src="../js/md5.js" type="text/javascript"></script>
    </body>
</html>
