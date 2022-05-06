<?php
$this->load->helper('comman_helper');
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
                                    <a href="index.html">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <a href="#">KYC</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Managed KYC</h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase"> Manage KYC</span>
                                        </div>
                                        <div class="actions">
                                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                                    <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                                                <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                                    <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                            <span></span>
                                                        </label>
                                                    </th>
                                                    <th> Username </th>
                                                    <th> Email </th>
                                                    <th> Referral Code </th>
                                                    <th> Joined </th>
                                                    <th> Status </th>
                                                    <th> Actions </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                if(!empty($users))
                                                 {
                                                    foreach ($users as $key => $obj) {
                                            
                                            ?>
                                                <tr class="odd gradeX" id="user_<?=$obj->id?>">
                                                    <td>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="checkboxes" value="1" />
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td> <?=$obj->username?> </td>
                                                    <td>
                                                        <a href="javascript:void(0);"><?=$obj->email?></a>
                                                    </td>
                                                    <td><?=$obj->ref_id?></td>
                                                    <td><?=change_date_format($obj->created_date,"d F Y h:i:s")?></td>
                                                    <td class="center">
                                                    <?php
                                                          $class = '';
                                                          $text = ''; 
                                                          if($obj->isactive==1)
                                                            {
                                                               $class = 'success';
                                                               $text = 'Active';
                                                            }
                                                          else
                                                            {
                                                                $class = 'danger';
                                                                $text = 'Inactive';
                                                            }
                                                    ?>
                                                        <span class="label label-sm label-<?=$class?>"><?=$text?></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu pull-left" role="menu">
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <i class="icon-docs"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <i class="icon-tag"></i>Delete</a>
                                                                </li>
                                                                
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->