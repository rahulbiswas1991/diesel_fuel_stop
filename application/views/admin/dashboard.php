<?php
  $path = base_url();
  
  
//   echo "<pre>"; print_r($total_fund_transfer); echo "</br>"; 
//   echo "<pre>"; print_r($today_fund_transfer); die();
  
?>
    <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                 <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?=base_url();?>apcompundpower/dashboard">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Dashboard</span>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Admin Dashboard
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        <div class="row" style="background-color: #0a6b91;">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="<?=base_url()?>apcompundpower/ManageUser">
                                    <div class="visual">
                                        <i class="fa fa-comments"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?=$tot_users?>">0</span>
                                        </div>
                                        <div class="desc"> Total Registrations </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 green" href="<?=base_url()?>apcompundpower/purchase">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <?=$tot_buy['total_leads']>0?'INR':''?>
                                            <span data-counter="counterup" data-value="<?=number_format($tot_buy['total_purchase'],2)?>">0</span> 

                                        </div>
                                        <div class="desc"> Total Active Leads </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="<?=base_url()?>apcompundpower/ManageUser">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            
                                            <span data-counter="counterup" data-value="<?=$today_users?>">0</span></div>
                                        <div class="desc"> Today's Registration </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="<?=base_url()?>apcompundpower/purchase">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <?=$today_buy['total_purchase']>0?'INR':''?> 
                                            <span data-counter="counterup" data-value="<?=number_format($today_buy['total_purchase'],2)?>"> </span>

                                        </div>
                                        <div class="desc"> Today's Leads </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--
                        <div class=row style="background-color: #0a6b91;">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="<?=base_url()?>apcompundpower/ManageCredit">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            
                                            <?=$today_fund_transfer['today_fund_transfer']>0?'INR':''?> 
                                            <span data-counter="counterup" data-value="<?=number_format($today_fund_transfer['today_fund_transfer'],2)?>"> </span>
                                        </div>
                                        <div class="desc"> Today's Fund Transfer
 </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="<?=base_url()?>apcompundpower/ManageCredit">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <?=$total_fund_transfer['total_fund_transfer']>0?'INR':''?> 
                                            <span data-counter="counterup" data-value="<?=number_format($total_fund_transfer['total_fund_transfer'],2)?>"> </span>

                                        </div>
                                        <div class="desc"> Total Fund Transfer
 </div>
                                    </div>
                                </a>
                            </div>
                        </div> -->
                        <div class="clearfix"></div>
                        <!-- END DASHBOARD STATS 1-->
                        <div class="row">
                            <div class="col-lg-6 col-xs-12 col-sm-12">
                                <!-- BEGIN PORTLET-->
                               <!-- <div class="portlet light bordered">
                                   
                                </div>  -->
                                <!-- END PORTLET-->
                            </div>

                             <div class="col-lg-6 col-xs-12 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption">
                                            <i class="icon-globe font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">NEWS & UPDATES</span>
                                        </div>
                                       
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1_1">
                                                <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                                                    <ul class="feeds">
                                                        <?php if(!empty($recent_updates))
                                                              { 
                                                                foreach ($recent_updates as $key => $value){
                                                        ?>
                                                        <li>
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-info">
                                                                            <i class="fa fa-bullhorn"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"><?=$value['news']?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date"><?=change_date_format($value['created_date'],'d M h:i a')?></div>
                                                            </div>
                                                        </li>
                                                    <?php }}else{?>
                                                        <li>No Recent Activities Available</li>
                                                    <?php }?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_1_2">
                                                <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                                    <ul class="feeds">
                                                      
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->