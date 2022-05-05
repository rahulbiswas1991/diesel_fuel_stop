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
                                    <a href="#">Users</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Manage Users</h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase"> User Details</span>
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
                                                    <th> Registred On </th>
                                                    <th> Kyc Status </th>
                                                    <th> Status </th>
                                                    <th> Actions </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                if(!empty($users))
                                                {
                                                    foreach ($users as $key => $obj){
                                            ?>
                                                <tr class="odd gradeX" id="user_<?=$obj->id?>">
                                                    <td>
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="checkboxes" id="chk_<?=$obj->id?>" />
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td> <?=$obj->username?> </td>
                                                    <td>
                                                        <a href="javascript:void(0);"><?=$obj->email?></a>
                                                    </td>
                                                    <td><?=$obj->ref_id?></td>
                                                    <td><?=change_date_format($obj->created_date,"d-M-Y h:i:s")?></td>
                                                    <td><?=$obj->kyc?></td>
                                                    <td class="center">
                                                    <?php
                                                          $class = '';
                                                          $text = ''; 
                                                          if($obj->isactive==1)
                                                            {
                                                               $class = 'btn green';
                                                               $text = 'Active';
                                                            }
                                                          else if($obj->isactive==0)
                                                          {
                                                                $class = 'btn yellow dis-me';
                                                                $text = 'Inadequate Info';
                                                          }else
                                                            {
                                                                $class = 'btn red';
                                                                $text = 'Inactive';
                                                            }
                                                    ?>
                                                        <span id="<?=$obj->id?>" onclick="conf('<?=$obj->id?>','<?=$obj->isactive?>','members')" class="app_req btn  btn-xs label-<?=$class?>"><?=$text?></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu pull-right" role="menu">
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <i class="icon-docs"></i>Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;">
                                                                        <i class="icon-tag"></i>Delete</a>
                                                                </li>
                                                                <!-- <li class="divider"> </li> -->
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }}?>
                                            </tbody>
                                        </table>
                                    </div>
									<div class="portlet-footer">
									<div class="actions">
                                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                                <button class="btn red dark btn-outline btn-circle btn-sm active req_action" data-tbl="members" value="1">Suspend Selected</button>
                                                <button class="btn green dark btn-outline btn-circle btn-sm active req_action" data-tbl="members" value="2">Activate Selected</button>
                                            </div>
                                        </div>
									</div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
<script type="text/javascript">
    
window.onload = function() {
        document.getElementById('excel_button').onclick = function(){
            //var currentSearchString = window.location.search;
            window.open(basepath+"apcompundpower/user_excel"+$this->config->item('uri_segment'),"_self");
        }
    }
</script>