<?php
//Clear cashe
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//Web path
$path = base_url();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        
        <title> Dieasel Fuel Stop | Admin Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <link type="image/x-icon" href="<?=base_url()?>assets/tokme/images/favicon.png" rel="shortcut icon">
        <meta content="" name="description" />
        <meta content="" name="" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

        <link href="<?=$path?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?=$path?>assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?=$path?>assets/global/css/sweetalert2.min.css">
        <link href="<?=$path?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?=$path?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?=$path?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?=$path?>assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?=$path?>assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
		<link href="<?=$path?>assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css">
        <link href="<?=$path?>assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css">
        <link href="<?=$path?>assets/global/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="" />
        <style type="text/css">
        /*      .page-logo a img {
            width: 61%;
        }*/

        div .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {position:relative;}
        div .table-scrollable .dataTable td>.btn-group button, .table-scrollable .dataTable th>.btn-group button {margin-bottom:5px;}
        .request-payment-content .form-horizontal#changepwd .form-group {margin:0 0 15px 0;}
        .form-horizontal#changepwd {padding-top:20px;}
        .table-checkable tr>td:first-child, .table-checkable tr>th:first-child {max-width:100% !important;}
        </style>
        <script src="<?= $path ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="<?=base_url('apcompundpower/dashboard')?>">
                            <img src="" alt="logo" class="logo-default" width="60px;"/> </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="<?=$path?>assets/layouts/layout/img/avatar3_small.jpg" />
                                    <span class="username username-hide-on-mobile"> <?=$this->session->userdata['username']?> </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                   
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="<?=base_url('apcompundpower/logout')?>">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                            <li class="sidebar-search-wrapper">
                                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                                

                                <!-- END RESPONSIVE QUICK SEARCH FORM -->
                            </li>
                            <li class="nav-item start ">
                                <a href="<?=base_url('apcompundpower/dashboard')?>" class="nav-link nav-toggle">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                </a>
                            </li>
                            <li class="heading">
                                <h3 class="uppercase">Main Features</h3>
                            </li>

                            <li class="nav-item  ">
                                <a href="<?=base_url('apcompundpower/ManageUser')?>" class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title">Manage Users</span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="<?=base_url('apcompundpower/ManageLeads')?>" class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title">Manage Leads</span>
                                </a>
                            </li>
                             <li class="nav-item  ">
                                <a href="<?=base_url('mannual_share')?>" class="nav-link nav-toggle">
                                    <i class="icon-credit-card"></i>
                                    <span class="title">Manage share ( % )</span>
                                </a>
                             </li>
                              <li class="nav-item  ">
                                <a href="<?=base_url('recordsheet_upload')?>" class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title">Fuel Management</span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="<?=base_url('apcompundpower/reward_points') ?>" class="nav-link nav-toggle">
                                    <i class="fa fa-sitemap"></i>
                                    <span class="title">Rewards</span>
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            <!--
                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-sitemap"></i>
                                    <span class="title">Player Report</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item  ">
                                        <a href="<?=base_url('apcompundpower/teamsummary')?>" class="nav-link ">
                                            <span class="title">Referral Team </span>
                                        </a>
                                    </li>
                                     
                                    <li class="nav-item  ">
                                        <a href="<?=base_url('apcompundpower/explorer')?>" class="nav-link ">
                                            <span class="title">Player Summary </span>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="<?=base_url('apcompundpower/bntree')?>" class="nav-link ">
                                            <span class="title">Team Work Group </span>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </li>

                            <li class="nav-item  ">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="fa fa-inr"></i>
                                    <span class="title">Earning Summary</span>
                                    <span class="arrow"></span>
                                </a>
                                
                            </li>
                            
                           
                           
                            <li class="nav-item  ">
                                <a href="<?=base_url('apcompundpower/notificationlist')?>" class="nav-link nav-toggle">
                                    <i class="icon-bell"></i>
                                    <span class="title">Manage Notifications</span>
                                </a>
                            </li>
                            -->

                            <li class="heading">
                                <h3 class="uppercase">Help & Support</h3>
                            </li>

                            
                            <li class="nav-item  ">
                                <a href="<?=base_url('apcompundpower/support')?>" class="nav-link nav-toggle">
                                    <i class="icon-envelope"></i>
                                    <span class="title">Support Ticket</span>
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a href="<?=base_url('apcompundpower/change_password')?>" class="nav-link nav-toggle">
                                    <i class="icon-envelope"></i>
                                    <span class="title">Change Password</span>
                                </a>
                            </li>
                            

                            <li class="nav-item  ">
                                <a href="<?=base_url('apcompundpower/logout')?>" class="nav-link nav-toggle">
                                    <i class="icon-power"></i>
                                    <span class="title">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>