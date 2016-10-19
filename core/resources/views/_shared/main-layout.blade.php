<?php
/**
 * Get current path for side menu toggle effect`s enable and disable purpose
 */
$currentPath = \Illuminate\Support\Facades\Route::getCurrentRoute()->getPath();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome to SLIIT Resource Management System</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('assets/images/alien-head.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet"/>

    <!-- Animation Css -->
    <link href="{{ asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet"/>

    <!-- Preloader Css -->
    <link href="{{ asset('assets/plugins/material-design-preloader/md-preloader.css') }}" rel="stylesheet"/>

    <!-- Scroll Bar Css-->
    <link href="{{ asset('assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet"/>

    <!-- Master Custom Css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Theme -->
    <link href="{{ asset('assets/css/themes/theme-red.css') }}" rel="stylesheet"/>

    @yield('css')

</head>

<body class="theme-red">
<!-- xcrfc token-->
<input type="hidden" value="{{ csrf_token() }}" id="crfc_token"/>
<!-- site root url -->
<input type="hidden" value="{{ url('/')  }}" id="site_root"/>

<!-- Used for get base URL for Ajax calls and dynamic content loading -->
<input type="hidden" id="base_URL" value="{{ URL('/') }}"/>

<!-- logged user id for notification service -->
<input type="hidden" id="user_id" value="3"/>

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="md-preloader pl-size-md">
            <svg viewbox="0 0 75 75">
                <circle cx="37.5" cy="37.5" r="33.5" class="pl-red" stroke-width="4"/>
            </svg>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
               data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{ URL('/') }}">SLIIT - RMS</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i
                                class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->
                <!-- Notifications -->
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        <span class="label-count" id="notifications_count">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" style="min-width: 300px">NOTIFICATIONS</li>
                        <li class="body">
                            <ul class="menu" id="notifications_panel">
                                <!-- Load notifications -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Notifications</a>
                        </li>
                    </ul>
                </li>
                <!-- #END# Notifications -->
                <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i
                                class="material-icons">more_vert</i></a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="{{ asset('assets/images/user.png') }}" width="48" height="48" alt="User"/>
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>
                <div class="email">john.doe@example.com</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                        <li role="seperator" class="divider"></li>
                        @if ( UAuth::isLogged() )
                            <li><a href="{{url('logout')}}"><i class="material-icons">input</i>Sign
                                    Out {{ UAuth::getUserLevel()  }}</a></li>
                        @else
                            <li><a href="{{ url('login')}}"><i class="material-icons">input</i>Sign In</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li class="{{ Request::is('/') ? 'active' : '' }}">
                    <a href="{{ URL('/') }}">
                        <i class="material-icons">home</i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="{{ Request::is('accounts') ? 'active' : '' }}">
                    <a href="{{url('accounts')}}">
                        <i class="material-icons">account_box</i>
                        <span>User Accounts</span>
                    </a>
                </li>
                <li class="{{ Request::is('timetable/*') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-toggle
                    <?php
                    /**
                     * get current path with matching sub paths
                     * for enable toggle on this tab
                     */
                    switch ($currentPath) {
                        case 'timetable/batch':
                        case 'timetable/hall':
                        case 'timetable/lab':
                        case 'timetable/lecture':
                        case 'timetable/configurations':
                            echo "toggled";
                            break;
                    }
                    ?>
                            ">
                        <i class="material-icons">view_carousel</i>
                        <span>Time Tables</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{ URL('/timetable/batch') }}">
                                <?php if($currentPath == 'timetable/batch'){ ?>
                                <b>
                                    <?php } ?>
                                    Batch
                                    <?php if($currentPath == 'timetable/batch'){ ?>
                                </b>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL('timetable/hall') }}">
                                <?php if($currentPath == 'timetable/hall'){ ?>
                                <b>
                                    <?php } ?>
                                    Halls
                                    <?php if($currentPath == 'timetable/hall'){ ?>
                                </b>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL('timetable/lab') }}">
                                <?php if($currentPath == 'timetable/lab'){ ?>
                                <b>
                                    <?php } ?>
                                    Labs
                                    <?php if($currentPath == 'timetable/lab'){ ?>
                                </b>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL('timetable/lecture') }}">
                                <?php if($currentPath == 'timetable/lecturer'){ ?>
                                <b>
                                    <?php } ?>
                                    Lecturer
                                    <?php if($currentPath == 'timetable/lecture'){ ?>
                                </b>
                                <?php } ?>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL('timetable/configurations') }}">
                                <?php if($currentPath == 'timetable/configurations'){ ?>
                                <b>
                                    <?php } ?>
                                    Configurations
                                    <?php if($currentPath == 'timetable/configurations'){ ?>
                                </b>
                                <?php } ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        {{--<div class="legal">
            <div class="copyright">
                &copy; 2016 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.3
            </div>
        </div>--}}
                <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                <ul class="demo-choose-skin">
                    <li data-theme="red" class="active">
                        <div class="red"></div>
                        <span>Red</span>
                    </li>
                    <li data-theme="pink">
                        <div class="pink"></div>
                        <span>Pink</span>
                    </li>
                    <li data-theme="purple">
                        <div class="purple"></div>
                        <span>Purple</span>
                    </li>
                    <li data-theme="deep-purple">
                        <div class="deep-purple"></div>
                        <span>Deep Purple</span>
                    </li>
                    <li data-theme="indigo">
                        <div class="indigo"></div>
                        <span>Indigo</span>
                    </li>
                    <li data-theme="blue">
                        <div class="blue"></div>
                        <span>Blue</span>
                    </li>
                    <li data-theme="light-blue">
                        <div class="light-blue"></div>
                        <span>Light Blue</span>
                    </li>
                    <li data-theme="cyan">
                        <div class="cyan"></div>
                        <span>Cyan</span>
                    </li>
                    <li data-theme="teal">
                        <div class="teal"></div>
                        <span>Teal</span>
                    </li>
                    <li data-theme="green">
                        <div class="green"></div>
                        <span>Green</span>
                    </li>
                    <li data-theme="light-green">
                        <div class="light-green"></div>
                        <span>Light Green</span>
                    </li>
                    <li data-theme="lime">
                        <div class="lime"></div>
                        <span>Lime</span>
                    </li>
                    <li data-theme="yellow">
                        <div class="yellow"></div>
                        <span>Yellow</span>
                    </li>
                    <li data-theme="amber">
                        <div class="amber"></div>
                        <span>Amber</span>
                    </li>
                    <li data-theme="orange">
                        <div class="orange"></div>
                        <span>Orange</span>
                    </li>
                    <li data-theme="deep-orange">
                        <div class="deep-orange"></div>
                        <span>Deep Orange</span>
                    </li>
                    <li data-theme="brown">
                        <div class="brown"></div>
                        <span>Brown</span>
                    </li>
                    <li data-theme="grey">
                        <div class="grey"></div>
                        <span>Grey</span>
                    </li>
                    <li data-theme="blue-grey">
                        <div class="blue-grey"></div>
                        <span>Blue Grey</span>
                    </li>
                    <li data-theme="black">
                        <div class="black"></div>
                        <span>Black</span>
                    </li>
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="settings">
                <div class="demo-settings">
                    <p>GENERAL SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Report Panel Usage</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Email Redirect</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>SYSTEM SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Notifications</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Auto Updates</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>ACCOUNT SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Offline</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Location Permission</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
</section>

<section class="content">
    <!-- Page Content -->
    @yield('dynamic-content')
            <!-- Page Content -->
</section>

<!-- Jquery Core Js -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('assets/plugins/node-waves/waves.js') }}"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="{{ asset('assets/plugins/jquery-countto/jquery.countTo.js') }}"></script>

<!-- Autosize Plugin Js -->
<script src="{{ asset('assets/plugins/autosize/autosize.js') }}"></script>

<!-- Scroll bar Plugin Js -->
<script src="{{ asset('assets/plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

<!-- Notifications Js -->
<script src="{{ asset('assets/custom/js/notifications.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('assets/js/admin.js') }}"></script>


@yield('JS-Plugins')

</body>

</html>