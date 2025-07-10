
        <!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top" style="height:30px;">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="col-md-7" style="padding-top:15px;">
                <a href="/sysinform">
                    <div style="font-size:16pt; ">Subscriber Management System </div>
                </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu col-md-5">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    
                    <!-- END TODO DROPDOWN -->
                    <li class="droddown dropdown-separator">
                        <span class="separator"></span>
                    </li>
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user dropdown-dark">
                       <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-user"></i>                            <span class="username username-hide-mobile">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a data-toggle="modal" href="#setPasswordDlg">
                                    <i class="icon-key"></i> <font size="3.5" >Change Password</font> </a>
                            </li>
                              <li>
                                <a href="/logout">
                                    <i class="icon-login"></i> <font size="3.5" >Logout</font> </a>
                            </li>
                        </ul>
                       
                    </li>
                   
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    
    <div class="page-header-menu">
        <div class="container">
            <div class="hor-menu">
                <ul class="nav navbar-nav">
                    @if(isset($permInfo[0]) && $permInfo[0]->perm_view == 1)         
                    <li class="menu-dropdown classic-menu-dropdown ">
                         <a href="/imsi" class="nav-link">
                                     <font size="3.5" >
                                     IMSI</font>
                        </a>
                    </li>
                    @endif

                    @if(isset($permInfo[1]) && $permInfo[1]->perm_view == 1)         
                    
                    <li class="menu-dropdown classic-menu-dropdown ">
                         <a href="/profile" class="nav-link">
                                     <font size="3.5" >
                                     PROFILE</font>
                        </a>
                    </li>
                    @endif
                    
                    @if(isset($permInfo[2]) && $permInfo[2]->perm_view == 1)         
                    
                     <li class="menu-dropdown classic-menu-dropdown ">
                          <a href="/pdn" class="nav-link  active">
                                     <font size="3.5" >
                                     PDN
                                     </font>
                         </a>
                    </li>
                    @endif
                    @if((isset($permInfo[3]) && $permInfo[3]->perm_view == 1) || (isset($permInfo[4]) && $permInfo[4]->perm_view == 1))  
                    
                    <li class="menu-dropdown classic-menu-dropdown ">
                        <a href="javascript:;"> IMEI
                            <span class="arrow"></span>
                        </a>
                           <ul class="dropdown-menu pull-left">
                           @if(isset($permInfo[3]) && $permInfo[3]->perm_view == 1)         
                    
                            <li class=" active">
                                <a href="/blackList" class="nav-link">
                                <font size="3.5" >
                                    Black list
                                    </font>
                                </a>
                            </li>
                            @endif

                            @if(isset($permInfo[4]) && $permInfo[4]->perm_view == 1)         
                    
                            <li class=" active">
                                <a href="/whiteList" class="nav-link">
                                <font size="3.5" >
                                    White list
                                </font>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    @endif
                    @endif

                   @if((isset($permInfo[8]) && $permInfo[8]->perm_view == 1) || (isset($permInfo[9]) && $permInfo[9]->perm_view == 1))      

                   <li class="menu-dropdown classic-menu-dropdown ">
                        <a href="javascript:;"> ACCESS
                            <span class="arrow"></span>
                        </a>
                           <ul class="dropdown-menu pull-left">
                            @if(isset($permInfo[8]) && $permInfo[8]->perm_view == 1)         

                            <li class=" active">
                                <a href="/connectingAdmin" class="nav-link">
                                <font size="3.5" >
                                     User Online
                                    </font>
                                </a>
                            </li>
                            @endif

                            @if(isset($permInfo[9]) && $permInfo[9]->perm_view == 1)         

                            <li class=" active">
                                <a href="/connectedHistory" class="nav-link">
                                <font size="3.5" >
                                    Access Log
                                </font>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    @endif
                    @endif

                    @if(isset($permInfo[5]) && $permInfo[5]->perm_view == 1)         
                    
                    <li class="menu-dropdown classic-menu-dropdown ">
                        <a href=""> SECURITY
                            <span class="arrow"></span>
                        </a>
                           <ul class="dropdown-menu pull-left">

                            <li class=" active">
                                <a href="/security" class="nav-link">
                                <font size="3.5" >
                                     OPC settings
                                    </font>
                                </a>
                            </li>


                            <li class=" active">
                                <a href="/configBackup" class="nav-link">
                                <font size="3.5" >
                                    Save & Backup
                                </font>
                                </a>
                            </li>
                            
                        </ul>
                        
                    </li>
                    @endif

                    @if((isset($permInfo[6]) && $permInfo[6]->perm_view == 1) || (isset($permInfo[7]) && $permInfo[7]->perm_view == 1))       
                    
                    <li class="menu-dropdown classic-menu-dropdown">
                        <a href="javascript:;"> ADMIN
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                        @if(isset($permInfo[6]) && $permInfo[6]->perm_view == 1)         
                    
                            <li>
                                <a href="/adminManagement" class="nav-link">
                                <font size="3.5" >
                                Admin
                                </font>
                                </a>
                            </li>
                            @endif
                            
                            @if(isset($permInfo[7]) && $permInfo[7]->perm_view == 1)         
                            <li>
                                <a href="/adminHistory" class="nav-link">
                                <font size="3.5" >
                                Log
                                </font>
                                </a>
                            </li>
                            @endif
                        @endif
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
    <!-- END HEADER MENU -->
    @include('include.setPasswordDlg')
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
