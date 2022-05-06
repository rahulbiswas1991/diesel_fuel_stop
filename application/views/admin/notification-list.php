<?php
    $this->load->helper('comman_helper');
    $searchby = '';
    $condition = '';
    $query = '';

    $searchby   = isset($_GET['search_by'])?$_GET['search_by']:'';
    $condition  = isset($_GET['condition'])?$_GET['condition']:'';
    if(isset($_GET['query']) && $_GET['query']!='')
    {
        $query      = $_GET['query'];
    }
?>
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                
                        <div class="page-bar">
                            
                            
                            
                        </div>
                        <!-- END PAGE BAR -->
                        <h1 class="page-title">Notifications List
                        </h1>
                        <!-- END PAGE HEADER-->
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet">

                                        <div class="caption font-dark">
                                       

                                          

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                
                                                        <span class="input-group-btn">
                                                        
                                                            <a class="btn blue" href="<?=base_url()?>apcompundpower/notifications"><i class="fa fa-plus"></i> Add Notification</a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- </form> -->
                                        </div>
                                        </div>

                    <!-- Listing for transactions -->
                                        <div class="portlet-body">
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="notification_table">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="15%">Subject</th>
                                                    <th class="text-center" width="30%">Message</th>
                                                    <th class="text-center" width="10%">Image</th>
                                                    <th class="text-center" width="20%">Created At</th>
                                                    
                                                    <th class="text-center" width="20%">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <?php
                                                  if(!empty($notifications))
                                                   { 
                                                      $sno = $row+1;
                                                      foreach ($notifications as $key => $value)
                                                       {
                                             ?>
                                                <tr>
                                                    <td><?=$sno++?></td>
                                                    <td><?=$value['subject']?></td>
                                                    <td><?=$value['notification_message']?></td>
                                                     <td class="text-center"><?=$value['upimage']>0?'<img src="'.$value['path'].'/'.$value['image'].'" height="50" width="50">':'N/A'?></td>
                                                    <td class="text-center"><?=change_date_format($value['create_date'],"d M,Y h:i:s")?></td>
                                                    <td class="text-center"><a class="delete_unotification_admin" href="javascript:void(0);" data-ref="<?= $value['id'] ?>"><i class="fa fa-trash fa-2x"></i> </a></td>
                                                </tr>
                                            <?php }}?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-right"><?php echo $pagination;?></div>
                                        </div>
                                    </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                            </div>
                        </div>
                    <!-- END CONTENT BODY -->
                    </div>
                    <!-- END CONTENT -->
                </div>
            <!-- END CONTAINER -->