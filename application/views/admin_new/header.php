<?php
//Clear cashe
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//Web path
$path = base_url();


//die();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Diesel Stop Admin Panel</title>
      <!-- Favicon and touch icons -->
      <link rel="shortcut icon" href="<?=base_url()?>assets_diesel/dist/img/ico/favicon.png" type="image/x-icon">
      <!-- Start Global Mandatory Style
         =====================================================================-->
      
    
      
      
      <!-- lobicard tather css -->
      <link rel="stylesheet" href="<?=base_url()?>assets_diesel/plugins/lobipanel/css/tether.min.css" />
      <!-- Bootstrap -->
      <!--<link href="<?=$path?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />  <!-- vkp -->
      <link href="<?=base_url()?>assets_diesel/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
       <!-- lobicard tather css -->
      <link rel="stylesheet" href="<?=base_url()?>assets_diesel/plugins/lobipanel/css/jquery-ui.min.css" />
      <!-- lobicard min css -->
      <link href="<?=base_url()?>assets_diesel/plugins/lobipanel/css/lobicard.min.css" rel="stylesheet" />
      <!-- lobicard github css -->
      <link href="<?=base_url()?>assets_diesel/plugins/lobipanel/css/github.css" rel="stylesheet" />
      <!-- Pace css -->
      <link href="<?=base_url()?>assets_diesel/plugins/pace/flash.css" rel="stylesheet" />
      <!-- Font Awesome -->
      <link href="<?=base_url()?>assets_diesel/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Pe-icon -->
      <link href="<?=base_url()?>assets_diesel/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" />
      <!-- Themify icons -->
      <link href="<?=base_url()?>assets_diesel/themify-icons/themify-icons.css" rel="stylesheet" />
      <!-- End Global Mandatory Style
         =====================================================================-->
      <!-- Start page Label Plugins 
         =====================================================================-->
      <!-- Emojionearea -->
      <link href="<?=base_url()?>assets_diesel/plugins/emojionearea/emojionearea.min.css" rel="stylesheet" />
      <!-- Monthly css -->
      <link href="<?=base_url()?>assets_diesel/plugins/monthly/monthly.css" rel="stylesheet" />
      <!-- End page Label Plugins 
         =====================================================================-->
      <!-- Start Theme Layout Style
         =====================================================================-->
      <!-- Theme style -->
      <link href="<?=base_url()?>assets_diesel/dist/css/stylecrm.css" rel="stylesheet" />
      <!-- Theme style rtl -->
      <!--<link href="<?=base_url()?>assets_diesel/dist/css/stylecrm-rtl.css" rel="stylesheet" />-->
      <!-- End Theme Layout Style
      
        <!--custom vkp-->
      <link rel="stylesheet" type="text/css" href="<?=$path?>assets/global/css/sweetalert2.min.css">
      <link href="<?=$path?>assets/global/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
         <link href="<?=$path?>assets/global/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?=$path?>assets/global/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        
        <link href="<?=$path?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
         <link href="<?=$path?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
         <link href="<?=$path?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
         
         <link href="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
         <link href="<?=base_url();?>assets_diesel/custumcss/custum_css.css" rel="stylesheet" type="text/css" />
        <!--<link href="<?=base_url();?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />-->
        <style>
        
        .page { 
            float: right;
            padding: 5px 5px 5px 5px;
            }
        .active {
    padding: 5px 5px 5px 5px;
}
        </style>
        
        
         <!--=====================================================================-->
   </head>
   <body class="hold-transition sidebar-mini">
      <!--preloader-->
      <div id="preloader">
         <div id="status"></div>
      </div>
      <!-- Site wrapper -->
      <div class="wrapper">
         <header class="main-header">
            <a href="<?=base_url()?>admin/dashboard" class="logo">
               <!-- Logo -->
               <span class="logo-mini">
               <img src="<?=base_url()?>assets_diesel/dist/img/mini-logo.png" alt="">
               </span>
               <span class="logo-lg">
               <img src="<?=base_url()?>assets_diesel/dist/img/logo.png" alt="" style="height: 74px;width: 150px;">
               </span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-expand py-0">
               <a href="<?=base_url()?>#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                  <!-- Sidebar toggle button-->
                  <span class="sr-only">Toggle navigation</span>
                  <span class="pe-7s-angle-left-circle"></span>
               </a>
               <!-- searchbar-->
               <!--<a href="<?=base_url()?>#search"><span class="pe-7s-search"></span></a>-->
               <!--<div id="search">-->
               <!--   <button type="button" class="close">×</button>-->
               <!--   <form>-->
               <!--      <input type="search" value="" placeholder="Search.." />-->
               <!--      <button type="submit" class="btn btn-add">Search...</button>-->
               <!--   </form>-->
               <!--</div>-->
               <div class="collapse navbar-collapse navbar-custom-menu" >
                 <ul class="navbar-nav ml-auto">
                  <!-- Orders -->
                   <!--<li class="nav-item dropdown messages-menu">-->
                   <!--  <a class="nav-link admin-notification" href="<?=base_url()?>#"  role="button" data-toggle="dropdown">-->
                   <!--     <i class="pe-7s-cart"></i>-->
                   <!--     <span class="label bg-primary">5</span>-->
                   <!--  </a>-->
                   <!--  <div class="dropdown-menu drop_drop custom_drop_scroll">-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menue">-->
                   <!--          <div class="left_item">-->
                   <!--              <img src="<?=base_url()?>assets_diesel/dist/img/basketball-jersey.png" class="img-thumbnail" alt="User Image">-->
                   <!--          </div>-->
                   <!--          <div class="right_item">-->
                   <!--              <h4>polo shirt</h4>-->
                   <!--              <p><strong>total item:</strong> 21-->
                   <!--              </p>-->
                   <!--          </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menue">-->
                   <!--          <div class="left_item">-->
                   <!--              <img src="<?=base_url()?>assets_diesel/dist/img/shirt.png" class="img-thumbnail" alt="User Image"/>-->
                   <!--          </div>-->
                   <!--          <div class="right_item">-->
                   <!--              <h4>Kits</h4>-->
                   <!--              <p><strong>total item:</strong> 11-->
                   <!--              </p>-->
                   <!--          </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menue">-->
                   <!--          <div class="left_item">-->
                   <!--              <img src="<?=base_url()?>assets_diesel/dist/img/football.png" class="img-thumbnail" alt="User Image"/>-->
                   <!--          </div>-->
                   <!--          <div class="right_item">-->
                   <!--              <h4>Football</h4>-->
                   <!--              <p><strong>total item:</strong> 16-->
                   <!--              </p>-->
                   <!--          </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menue">-->
                   <!--          <div class="left_item">-->
                   <!--              <img src="<?=base_url()?>assets_diesel/dist/img/shoe.png" class="img-thumbnail" alt="User Image"/>-->
                   <!--          </div>-->
                   <!--          <div class="right_item">-->
                   <!--              <h4>Sports sheos</h4>-->
                   <!--              <p><strong>total item:</strong> 10-->
                   <!--              </p>-->
                   <!--          </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--  </div>-->
                   <!--</li>-->
                  <!-- Messages -->
                   <!--<li class="nav-item dropdown messages-menu">-->
                   <!--  <a class="nav-link admin-notification" href="<?=base_url()?>#"  role="button" data-toggle="dropdown">-->
                   <!--     <i class="pe-7s-mail"></i>-->
                   <!--     <span class="label bg-success">5</span>-->
                   <!--  </a>-->
                   <!--  <div class="dropdown-menu drop_drop custom_drop_scroll">-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menue">-->
                   <!--          <div class="left_item">-->
                   <!--              <img src="<?=base_url()?>assets_diesel/dist/img/avatar.png"  class="rounded-circle" alt="User Image"/>-->
                   <!--          </div>-->
                   <!--          <div class="right_item">-->
                   <!--              <h4>Ronaldo</h4>-->
                   <!--              <p>Please oreder 10 pices of kits..</p>-->
                   <!--              <span class="badge badge-success badge-massege"><small>15 hours ago</small>-->
                   <!--              </span>-->
                   <!--          </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menue">-->
                   <!--          <div class="left_item pull-left">-->
                   <!--              <img src="<?=base_url()?>assets_diesel/dist/img/avatar2.png"  class="rounded-circle" alt="User Image"/>-->
                   <!--          </div>-->
                   <!--          <div class="right_item">-->
                   <!--              <h4>Leo messi</h4>-->
                   <!--              <p>Please oreder 10 pices of Sheos..</p>-->
                   <!--              <span class="badge badge-info badge-massege"><small>6 days ago</small>-->
                   <!--              </span>   -->
                   <!--          </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menue">-->
                   <!--          <div class="left_item">-->
                   <!--              <img src="<?=base_url()?>assets_diesel/dist/img/avatar3.png"  class="rounded-circle" alt="User Image"/>-->
                   <!--          </div>-->
                   <!--          <div class="right_item">-->
                   <!--              <h4>Modric</h4>-->
                   <!--              <p>Please oreder 6 pices of bats..</p>-->
                   <!--              <span class="badge badge-info badge-massege"><small>1 hour ago</small>-->
                   <!--              </span>-->
                   <!--          </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--  </div>-->
                   <!--</li>-->
                  <!-- Notifications -->
                   <!--<li class="nav-item dropdown notifications-menu">-->
                   <!--  <a class="nav-link admin-notification" href="<?=base_url()?>#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                   <!--     <i class="pe-7s-bell"></i>-->
                   <!--     <span class="label bg-warning">5</span>-->
                   <!--  </a>-->
                   <!--  <div class="dropdown-menu drop_drops custom_drop_scroll">-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menues">-->
                   <!--           <p>-->
                   <!--           <i class="fa fa-dot-circle-o color-red"></i>-->
                   <!--           Change Your font style</p>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--     <div class="menues">-->
                   <!--        <p>-->
                   <!--        <i class="fa fa-dot-circle-o color-red"></i>-->
                   <!--        check the system ststus..</p>-->
                   <!--    </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--     <div class="menues">-->
                   <!--        <p>-->
                   <!--        <i class="fa fa-dot-circle-o color-red"></i>-->
                   <!--        Add more admin...</p>-->
                   <!--    </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--     <div class="menues">-->
                   <!--        <p>-->
                   <!--        <i class="fa fa-dot-circle-o color-red"></i>-->
                   <!--        Add more clients and order</p>-->
                   <!--    </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--     <div class="menues">-->
                   <!--        <p>-->
                   <!--        <i class="fa fa-dot-circle-o color-red"></i>-->
                   <!--        Add more admin...</p>-->
                   <!--    </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--     <div class="menues">-->
                   <!--        <p>-->
                   <!--        <i class="fa fa-dot-circle-o color-red"></i>-->
                   <!--        Add more clients and order</p>-->
                   <!--    </div>-->
                   <!--    </a>-->
                   <!--  </div>-->
                   <!--</li>-->
                  <!-- Tasks -->
                   <!--<li class="nav-item dropdown tasks-menu">-->
                   <!--  <a class="nav-link admin-notification" href="<?=base_url()?>#"  role="button" data-toggle="dropdown">-->
                   <!--     <i class="pe-7s-note2"></i>-->
                   <!--     <span class="label bg-danger">5</span>-->
                   <!--  </a> -->
                   <!--  <div class="dropdown-menu drop_dropr custom_drop_scroll">-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menuers">-->
                   <!--           <div class="single_menuers_item">-->
                   <!--              <h3><i class="fa fa-check-circle"></i> Theme color should be <span><span class="label label-success float-right">50%</span></span></h3>-->
                   <!--           </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menuers">-->
                   <!--           <div class="single_menuers_item">-->
                   <!--              <h3><i class="fa fa-check-circle"></i> Fix Error and bugs <span><span class="label label-warning float-right">90%</span></span></h3>-->
                   <!--           </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menuers">-->
                   <!--           <div class="single_menuers_item">-->
                   <!--              <h3><i class="fa fa-check-circle"></i> Sidebar color change <span><span class="label label-danger float-right">80%</span></span></h3>-->
                   <!--           </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menuers">-->
                   <!--           <div class="single_menuers_item">-->
                   <!--              <h3><i class="fa fa-check-circle"></i> font-family should be  <span><span class="label label-info float-right">30%</span></span></h3>-->
                   <!--           </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menuers">-->
                   <!--           <div class="single_menuers_item">-->
                   <!--              <h3><i class="fa fa-check-circle"></i> Fix the database Error <span><span class="label label-success float-right">60%</span></span></h3>-->
                   <!--           </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--    <a class="dropdown-item" href="<?=base_url()?>#">-->
                   <!--       <div class="menuers">-->
                   <!--           <div class="single_menuers_item">-->
                   <!--              <h3><i class="fa fa-check-circle"></i> data table data missing <span><span class="label label-info float-right">20%</span></span></h3>-->
                   <!--           </div>-->
                   <!--       </div>-->
                   <!--    </a>-->
                   <!--  </div>-->
                   <!--</li>-->
                  <!-- Help -->
                   <!--<li class="nav-item dropdown  dropdown-help">-->
                   <!--  <a class="nav-link hidden_hidden" href="<?=base_url()?>#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                   <!--        <i class="pe-7s-settings"></i></a>-->
               
                   <!--  <div class="dropdown-menu drop_down">-->
                   <!--     <div class="menus">-->
                   <!--        <a class="dropdown-item" href="<?=base_url()?>#"> <i class="fa fa-line-chart"></i> Networking</a>-->
                   <!--        <a class="dropdown-item" href="<?=base_url()?>#"><i class="fa fa fa-bullhorn"></i> Lan settings</a>-->
                   <!--        <a class="dropdown-item" href="<?=base_url()?>#"><i class="fa fa-bar-chart"></i> Settings</a>-->
                   <!--        <a class="dropdown-item" href="<?=base_url()?>#"><i class="fa fa-wifi"></i> wifi</a>-->
                   <!--     </div>-->
                   <!--  </div>-->
                   <!--</li>-->
                  <!-- User -->
                   <li class="nav-item dropdown dropdown-user">
                     <a class="nav-link" href="<?=base_url()?>#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <img src="<?=base_url()?>assets_diesel/dist/img/avatar5.png" class="rounded-circle" width="50" height="50" alt="user"></a>
                    
                     <div class="dropdown-menu drop_down">
                          <div class="menus">
                              <a class="dropdown-item" href="<?=base_url()?>#"><i class="fa fa-user"></i> User Profile</a>
                              <!--<a class="dropdown-item" href="<?=base_url()?>#"><i class="fa fa-inbox"></i> Inbox</a>-->
                              <a class="dropdown-item" href="<?=base_url()?>admin/logout"><i class="fa fa-sign-out"></i> Signout</a>
                          </div>
                     </div>
                   </li>
                 </ul>
               </div>
             </nav>
            </header>
         <!-- =============================================== -->
         <!-- Left side column. contains the sidebar -->
         <aside class="main-sidebar">
            <!-- sidebar -->
            <div class="sidebar">
               <!-- sidebar menu -->
               <ul class="sidebar-menu">
                  <li class="" id="dashboard">
                     <a href="<?=base_url()?>admin/dashboard"><i class="fa fa-tachometer"></i><span>Dashboard</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li class="" id="ManageUser">
                     <a href="<?=base_url()?>admin/ManageUser"><i class="fa fa-users"></i><span>Agents</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  <li class="" id="ManageLeads">
                     <a href="<?=base_url()?>admin/ManageLeads"><i class="fa fa-leanpub"></i><span>Leads</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  
                   <li class="" id="ManageLeads">
                     <a href="<?=base_url()?>admin/ManageLeadsByAgents"><i class="fa fa-leanpub"></i><span>Leads By Agents</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  
                  
                  <li class="" id="mannual_share">
                     <a href="<?=base_url()?>admin/mannual_share"><i class="fa fa-shopping-basket"></i><span>Share (%)</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  
                   <li class="" id="upload_record_sheet">
                     <a href="<?=base_url()?>admin/upload_record_sheet"><i class="fa fa-file-text"></i><span>Fuel Management</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  
                  
                   <li class=""  id="reward_points">
                     <a href="<?=base_url()?>admin/reward_points"><i class="fa fa-shopping-bag"></i><span>Rewards</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  
                  
                  
                   <li class=""  id="change_password">
                     <a href="<?=base_url()?>admin/change_password"><i class="fa fa-user"></i><span>Change Password</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  
                  
                   <li class="" id="logout">
                     <a href="<?=base_url()?>admin/logout"><i class="fa fa-sign-out"></i><span>Logout</span>
                     <span class="pull-right-container">
                     </span>
                     </a>
                  </li>
                  
                  
                  
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-users"></i><span>Customers</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>add-customer.html">Add Customer</a></li>-->
                  <!--      <li><a href="<?=base_url()?>clist.html">List</a></li>-->
                  <!--      <li><a href="<?=base_url()?>group.html">Groups</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-shopping-basket"></i><span>Transaction</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>deposit.html">New Deposit</a></li>-->
                  <!--      <li><a href="<?=base_url()?>expense.html">New Expense</a></li>-->
                  <!--      <li><a href="<?=base_url()?>transfer.html">Transfer</a></li>-->
                  <!--      <li><a href="<?=base_url()?>view-tsaction.html">View transaction</a></li>-->
                  <!--      <li><a href="<?=base_url()?>balance.html">Balance Sheet</a></li>-->
                  <!--      <li><a href="<?=base_url()?>treport.html">Transfer Report</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-shopping-cart"></i><span>Sales</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>invoice.html">Invoices</a></li>-->
                  <!--      <li><a href="<?=base_url()?>ninvoices.html">New Invoices</a></li>-->
                  <!--      <li><a href="<?=base_url()?>recurring.html">Recurring invoices</a></li>-->
                  <!--      <li><a href="<?=base_url()?>nrecurring.html">New Recurring invoices</a></li>-->
                  <!--      <li><a href="<?=base_url()?>quote.html">quotes</a></li>-->
                  <!--      <li><a href="<?=base_url()?>nquote.html">New quote</a></li>-->
                  <!--      <li><a href="<?=base_url()?>payment.html">Payments</a></li>-->
                  <!--      <li><a href="<?=base_url()?>taxeport.html">Tax Rates</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-book"></i><span>Task</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>rtask.html">Running Task</a></li>-->
                  <!--      <li><a href="<?=base_url()?>atask.html">Archive Task</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-shopping-bag"></i><span>Accounting</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>cpayment.html">Client payment</a></li>-->
                  <!--      <li><a href="<?=base_url()?>emanage.html">Expense management</a></li>-->
                  <!--      <li><a href="<?=base_url()?>ecategory.html">Expense Category</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-file-text"></i><span>Report</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>preport.html">Project Report</a></li>-->
                  <!--      <li><a href="<?=base_url()?>creport.html">Client Report</a></li>-->
                  <!--      <li><a href="<?=base_url()?>ereport.html">Expense Report</a></li>-->
                  <!--      <li><a href="<?=base_url()?>incomexp.html">Income expense comparesion</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-bell"></i><span>Attendance</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>thistory.html">Time History</a></li>-->
                  <!--      <li><a href="<?=base_url()?>timechange.html">Time Change Request</a></li>-->
                  <!--      <li><a href="<?=base_url()?>atreport.html">Attendance Report</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-edit"></i><span>Recruitment</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>jpost.html">Jobs Posted</a></li>-->
                  <!--      <li><a href="<?=base_url()?>japp.html">Jobs Application</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-shopping-basket"></i><span>payroll</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>salary.html">Salary Template</a></li>-->
                  <!--      <li><a href="<?=base_url()?>hourly.html">Hourly</a></li>-->
                  <!--      <li><a href="<?=base_url()?>managesal.html">Manage salary</a></li>-->
                  <!--      <li><a href="<?=base_url()?>empsallist.html">Employee salary list</a></li>-->
                  <!--      <li><a href="<?=base_url()?>mpayment.html">Make payment</a></li>-->
                  <!--      <li><a href="<?=base_url()?>generatepay.html">Generate payslip</a></li>-->
                  <!--      <li><a href="<?=base_url()?>paysum.html">Payroll summary</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-bitbucket-square"></i><span>Stock</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>stockcat.html">Stock category</a></li>-->
                  <!--      <li><a href="<?=base_url()?>manstock.html">Manage Stock</a></li>-->
                  <!--      <li><a href="<?=base_url()?>astock.html">Assign stock</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-ticket"></i><span>Tickets</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>ticanswer.html">Answered</a></li>-->
                  <!--      <li><a href="<?=base_url()?>ticopen.html">Open</a></li>-->
                  <!--      <li><a href="<?=base_url()?>iprocess.html">Inprocess</a></li>-->
                  <!--      <li><a href="<?=base_url()?>close.html">CLosed</a></li>-->
                  <!--      <li><a href="<?=base_url()?>allticket.html">All Tickets</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-list"></i>-->
                  <!--   <span>Utilities</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>ativitylog.html">Activity Log</a></li>-->
                  <!--      <li><a href="<?=base_url()?>emailmes.html">Email message log</a></li>-->
                  <!--      <li><a href="<?=base_url()?>systemsts.html">System status</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-bar-chart"></i><span>Charts</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li class=""><a href="<?=base_url()?>charts_flot.html">Flot Chart</a></li>-->
                  <!--      <li><a href="<?=base_url()?>charts_Js.html">Chart js</a></li>-->
                  <!--      <li><a href="<?=base_url()?>charts_morris.html">Morris Charts</a></li>-->
                  <!--      <li><a href="<?=base_url()?>charts_sparkline.html">Sparkline Charts</a></li>-->
                  <!--   </ul>-->
                  <!--</li> -->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-briefcase"></i>-->
                  <!--   <span>Icons</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>icons_fontawesome.html">Fontawesome Icon</a></li>-->
                  <!--      <li><a href="<?=base_url()?>icons_flag.html">Flag Icons</a></li>-->
                  <!--      <li><a href="<?=base_url()?>icons_material.html">Material Icons</a></li>-->
                  <!--      <li><a href="<?=base_url()?>icons_weather.html">Weather Icons </a></li>-->
                  <!--      <li><a href="<?=base_url()?>icons_line.html">Line Icons</a></li>-->
                  <!--      <li><a href="<?=base_url()?>icons_pe.html">Pe Icons</a></li>-->
                  <!--      <li><a href="<?=base_url()?>icon_socicon.html">Socicon Icons</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-list"></i> <span>Other page</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>login.html">Login</a></li>-->
                  <!--      <li><a href="<?=base_url()?>register.html">Register</a></li>-->
                  <!--      <li><a href="<?=base_url()?>profile.html">Profile</a></li>-->
                  <!--      <li><a href="<?=base_url()?>forget_password.html">Forget password</a></li>-->
                  <!--      <li><a href="<?=base_url()?>lockscreen.html">Lockscreen</a></li>-->
                  <!--      <li><a href="<?=base_url()?>404.html">404 Error</a></li>-->
                  <!--      <li><a href="<?=base_url()?>505.html">505 Error</a></li>-->
                  <!--      <li><a href="<?=base_url()?>blank.html">Blank Page</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-bitbucket"></i><span>UI Elements</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>buttons.html">Buttons</a></li>-->
                  <!--      <li><a href="<?=base_url()?>tabs.html">Tabs</a></li>-->
                  <!--      <li><a href="<?=base_url()?>notification.html">Notification</a></li>-->
                  <!--      <li><a href="<?=base_url()?>tree-view.html">Tree View</a></li>-->
                  <!--      <li><a href="<?=base_url()?>progressbars.html">Progressber</a></li>-->
                  <!--      <li><a href="<?=base_url()?>list.html">List View</a></li>-->
                  <!--      <li><a href="<?=base_url()?>typography.html">Typography</a></li>-->
                  <!--      <li><a href="<?=base_url()?>panels.html">Panels</a></li>-->
                  <!--      <li><a href="<?=base_url()?>modals.html">Modals</a></li>-->
                  <!--      <li><a href="<?=base_url()?>icheck_toggle_pagination.html">iCheck, Toggle, Pagination</a></li>-->
                  <!--      <li><a href="<?=base_url()?>labels-badges-alerts.html">Labels, Badges, Alerts</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li class="treeview">-->
                  <!--   <a href="<?=base_url()?>#">-->
                  <!--   <i class="fa fa-gear"></i>-->
                  <!--   <span>settings</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   <i class="fa fa-angle-left float-right"></i>-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--   <ul class="treeview-menu">-->
                  <!--      <li><a href="<?=base_url()?>gsetting.html">Genaral settings</a></li>-->
                  <!--      <li><a href="<?=base_url()?>stfsetting.html">Staff settings</a></li>-->
                  <!--      <li><a href="<?=base_url()?>emailsetting.html">Email settings</a></li>-->
                  <!--      <li><a href="<?=base_url()?>paysetting.html">Payment</a></li>-->
                  <!--   </ul>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>company.html">-->
                  <!--   <i class="fa fa-home"></i> <span>Companies</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>holiday.html">-->
                  <!--   <i class="fa fa-stop-circle"></i> <span>Public Holiday</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>user.html">-->
                  <!--   <i class="fa fa-user-circle"></i><span>User</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>items.html">-->
                  <!--   <i class="fa fa-file-o"></i><span>Items</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>department.html">-->
                  <!--   <i class="fa fa-tree"></i><span>Departments</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>document.html">-->
                  <!--   <i class="fa fa-file-text"></i> <span>Documents</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>train.html">-->
                  <!--   <i class="fa fa-clock-o"></i><span>Training</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>calender.html">-->
                  <!--   <i class="fa fa-calendar"></i> <span>Calender</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>notice.html">-->
                  <!--   <i class="fa fa-file-text"></i> <span>Notice Board</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>message.html">-->
                  <!--   <i class="fa fa-envelope-o"></i> <span>Message</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
                  <!--<li>-->
                  <!--   <a href="<?=base_url()?>note.html">-->
                  <!--   <i class="fa fa-comment"></i> <span>Notes</span>-->
                  <!--   <span class="pull-right-container">-->
                  <!--   </span>-->
                  <!--   </a>-->
                  <!--</li>-->
               </ul>
            </div>
            <!-- /.sidebar -->
         </aside>
         
         
         