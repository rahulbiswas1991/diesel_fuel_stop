<?php
    $this->load->helper('comman_helper');
    //echo '<pre>';print_r($users); die;
    $searchby = '';
    $condition = '';
    $query = '';

    $searchby   = isset($_GET['search_by'])?$_GET['search_by']:'';
    $condition  = isset($_GET['condition'])?$_GET['condition']:'';
    //$query      = isset($_GET['query'])?$_GET['query']:'';
    if(isset($_GET['query']) && $_GET['query']!='')
    {
        $query      = $_GET['query'];
    }

//echo "<pre>"; print_r($permission); die();

?>     

<style type="text/css">
    button.btn.btn-primary.admin78-login {
    margin-top: 10px;
    padding:1px 5px;
}
</style>
           <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                
                        <div class="page-bar">
                        </div>
                        <!-- END PAGE BAR -->
                        
                        <!-- END PAGE HEADER-->

                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Manage Users
                        </h1>
                        <!-- END PAGE TITLE-->
                        
                        <div class="row">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                 <div class="col-md-12">
                                    <div class="portlet">
                                        <div class="caption">
                                            <!--<i class="fa fa-shopping-cart"></i>Advance Table </div>-->
                                            <form id="user_searchfm" action="<?=base_url()?>apcompundpower/ManageUser" method="get">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Select Search Option</label>
                                                        <select class="form-control" name="search_by">
                                                            <option value="">All</option>
                                                            <option <?=$searchby=='name'?'selected="selected"':'';?> value="name">Name</option>
                                                            <option <?=$searchby=='username'?'selected="selected"':'';?> value="username">Username</option>
                                                            <option <?=$searchby=='email'?'selected="selected"':'';?> value="email">Email</option>
                                                            <option <?=$searchby=='mobile'?'selected="selected"':'';?> value="mobile">Mobile</option>
                                                            <option <?=$searchby=='pancard'?'selected="selected"':'';?> value="pancard">Pancard</option>
                                                            <!-- <option>KYC Pending</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Select Option</label>
                                                        <select class="form-control" name="condition">
                                                            <option value="">All</option>
                                                            <option <?=$condition==1?'selected="selected"':'';?> value="1">Active User</option>
                                                            <option <?=$condition==2?'selected="selected"':'';?> value="2">Deactive User</option>
                                                     <!--       <option <?=$condition==3?'selected="selected"':'';?> value="3">KYC Approved</option>
                                                            <option <?=$condition==4?'selected="selected"':'';?> value="4">KYC Rejected</option>
                                                            <option <?=$condition==5?'selected="selected"':'';?> value="5">KYC Pending</option>
                                                            <option <?=$condition==6?'selected="selected"':'';?> value="6">KYC Not Submit</option>
                                                            <option <?=$condition==7?'selected="selected"':'';?> value="7">Paid Users</option>
                                                            <option <?=$condition==8?'selected="selected"':'';?> value="8">Unpaid Users</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label>Enter your choice...</label>
                                                    <div class="input-group">
                                                        <input type="text" name="query" class="form-control" placeholder="Search for..." value="<?=trim($query)?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn blue" type="submit">Search</button>
                                                            <a class="btn red" href="<?=base_url()?>apcompundpower/ManageUser"><i class="fa fa-refresh"></i> </a>
                                                            <button class="btn green excel_button" id="excel_button" type="button"><i class="fa fa-file-excel-o"></i> </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                                </div>
                                            </form>

                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable">
                                            <table class="table table-striped table-bordered table-advance table-hover" id="user_table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="checkboxes checkalluser" value=""/>
                                                            <span></span>
                                                        </label>
                                                        </th>
                                                        <th class="text-center">#</th>
                                                        <th>User Info </th>
                                                        
                                                        <th>Register on</th>
                                                        
                                                        <th>User Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $sno = $row+1;
                                                    foreach ($users as $obj)
                                                    {
                                                        
                                                        echo '
                                                            <tr>
                                                            <td class="text-center">
                                                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                    <input type="checkbox" class="checkboxes usercheck" value="'.$obj->id.'" />
                                                                    <span></span>
                                                                </label>
                                                            </td>
                                                            <td class="text-center">'.$sno++.'</td>
                                                            <td>
                                                                <a href="'.base_url().'apcompundpower/user-details/'.$obj->id.'" class="tooltips" data-original-title="View User Info"> '.$obj->name.'</a>
                                                                <span class="label label-sm label-success label-mini tooltips" data-original-title="Username"> '.$obj->username.' </span><br>
                                                                <i class="fa fa-envelope"></i> '.$obj->email.'<br>
                                                                <i class="fa fa-phone"> &nbsp; </i> '.$obj->phone.'<br>
                                                               
                                                            </td>
                                                            
                                                            <td> '.change_date_format($obj->created_date,"d-m-Y h:i:s").' </td>

                                                            

                                                            <td>
                                                                <a style="text-decoration:none;" href="javascript:void(0);" id="statusa_tag_'.$obj->id.'" class="status_up" data-status="'.(($obj->isactive ==1)? 2 : 1).'"><span id="status_span_'.$obj->id.'" class="label label-xs label-'.(($obj->isactive ==1)? 'success' : 'danger').' label-mini"> '.(($obj->isactive ==1)? 'Active' : 'Inactive').' </span></a>
                                                            </td>

                                                        </tr>';
                                                    } ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                            <br>
                                                <button type="button" class="btn green btn-sm change_status" data-status="1">Activate Selected</button>
                                                <button type="button" class="btn red btn-sm change_status" data-status="0">Deactivate Selected</button>
                                            </div>
                                            <div class="col-sm-6 text-right"><?php echo $pagination;?></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END SAMPLE TABLE PORTLET-->
                                
                            </div>
                        </div>
                        
                        
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                
            </div>
            <!-- END CONTAINER -->
<script type="text/javascript">
var segment =  <?=$this->uri->segment($this->config->item('uri_segment'))!=''?$this->uri->segment($this->config->item('uri_segment')):0?>;

if(segment=='ManageUser') {
    segment = '';
}

var search_by = '<?=isset($_GET['search_by'])?$_GET['search_by']:0?>';
var condition = '<?=isset($_GET['condition'])?$_GET['condition']:0?>';
var query     = '<?=isset($_GET['query'])?$_GET['query']:0?>';

document.getElementById("excel_button").onclick = function () {
    var rowCount = $('#user_table >tbody >tr').length;
    if(rowCount>0) {
        window.open(basepath+"apcompundpower/user_excel/"+segment+"?search_by="+search_by+"&condition="+condition+"&query="+query,"_self");
    } else {
        alert('No Data');
    }
}
</script>