<?php
$this->load->helper('comman_helper');
#echo "<pre>"; print_r($mylistings); die();
$searchby = '';
$startdate = '';
$enddate = '';
$query = '';

$searchby = isset($_GET['search_by']) ? $_GET['search_by'] : '';
$startdate = isset($_GET['startdate']) ? $_GET['startdate'] : '';
$enddate = isset($_GET['enddate']) ? $_GET['enddate'] : '';
if (isset($_GET['query']) && $_GET['query'] != '') {
    $query = $_GET['query'];
}
?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <div class="page-bar">
        </div>
        <!-- END PAGE BAR -->

        <!-- END PAGE HEADER-->
        <h1 class="page-title">All Rewards</h1>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet">
                        <div class="caption font-dark">
                            <form method="get" action="<?=base_url()?>apcompundpower/reward_points">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Search Option</label>
                                        <select class="form-control" name="search_by">
                                            <option value="">All</option>
                                            <option <?=$searchby == 'name' ? 'selected="selected"' : '';?> value="name">Name </option>
                                            <option <?=$searchby == 'username' ? 'selected="selected"' : '';?> value="username">Username</option>
                                            <option <?=$searchby == 'email' ? 'selected="selected"' : '';?> value="email">Email</option>
                                            <option <?=$searchby == 'mobile' ? 'selected="selected"' : '';?> value="mobile"> Mobile</option>
                                            <!-- <option>KYC Pending</option> -->
                                        </select>
                                    </div>
                                </div>
                              
                                <div class="col-md-4">
                                    <div class="form-group" id="sandbox-container">
                                        <label>Select date range</label>
                                        <div class="input-group input-large input-daterange" data-date="10/11/2012"
                                            data-date-format="mm/dd/yyyy">
                                            <input type="text" class="form-control" name="startdate" placeholder="Start Date" value="<?=trim($startdate)?>">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" value="<?=trim($enddate)?>">
                                        </div>
                                        <!-- /input-group -->
                                        
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Enter your choice...</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search for..." name="query" value="<?=trim($query)?>">
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="submit">Search</button>
                                                <a class="btn red" href="<?=base_url()?>apcompundpower/reward_points"><i class="fa fa-refresh"></i> </a>
                                                <!--<button class="btn green" type="button" id="excel_button"><i class="fa fa-file-excel-o"></i> </button>-->
                                            </span>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class=row>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="<?=base_url()?>apcompundpower/reward_points">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            <?=$today_buy['total_purchase']>0?'INR':''?> 
                                            <span data-counter="counterup" data-value="<?=number_format($today_buy['total_purchase'],2)?>"> </span>

                                        </div>
                                        <div class="desc"> Today's Rewards </div>
                                    </div>
                                </a>
                            </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green" href="<?=base_url()?>apcompundpower/reward_points">
                                        <div class="visual">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <?=$tot_buy['total_purchase']>0?'INR':''?>
                                                <span data-counter="counterup" data-value="<?=number_format($tot_buy['total_purchase'],2)?>">0</span> 
    
                                            </div>
                                            <div class="desc"> Total Rewards </div>
                                        </div>
                                    </a>
                                </div>
                        </div>
                        
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tableData">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">Date</th>
                                        <th>User Info</th>
                                        <th class="text-right">Total Purchase</th>
                                        <th>Profit Status</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //$i=1;
                                    $sno = $row + 1;
                                    foreach ($listing as $key => $list) {
                                       
                                        
                                        if($list['isactive '] == 0){
                                        $status = 'Inactive';
                                    }else if($list['isactive '] == 1){
                                        $status = 'Active';
                                    }else {
                                        $status = 'Unknown';
                                    }
                                       
                                       
                                    if($list['profit_type'] == 0){
                                        $pstatus = 'Hold';
                                    }else if($list['profit_type'] == 1){
                                        $pstatus = 'Earned';
                                    }else if($list['profit_type'] == 2){
                                        $pstatus = 'Transferred';
                                    }else if($list['profit_type'] == 3){
                                        $pstatus = 'Pending';
                                    }else if($list['profit_type'] == 4){
                                        $pstatus = 'InProcess';
                                    }else {
                                        $pstatus = 'Unknown';
                                    }   
                                       
                                        
                                        
                                        echo '
                                        <tr class="odd gradeX referaltr" data-type=' . $list['user_id'] . ' data-from=' . $list['user_id'] . '>
                                            <td>
                                                ' . $sno++ . '
                                            </td>
                                            <td class="text-left">' . change_date_format($list['created_date'],"d-M-Y h:i:s A") . '</td> 
                                            <td> ' . $list['name'] . '
                                                <span class="label label-sm label-success label-mini tooltips" data-original-title="Username"> ' . $list['emp_id'] . ' </span><br>
                                                <i class="fa fa-envelope"></i> ' . $list['email'] . '
                                            </td>
                                            
                                            <td class="text-right"> ' . $list['amount'] . '</td>
                                            <td> ' . $status . '</td>
                                            <td> ' . $pstatus . '</td>';
                                    ?>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-right"><?php echo $pagination; ?></div>
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
<!--<script src="../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>-->
<script type="text/javascript">
var segment =  <?=$this->uri->segment($this->config->item('uri_segment'))!=''?$this->uri->segment($this->config->item('uri_segment')):0?>;

if(segment=='ManageUser') {
    segment = '';
}

var search_by = '<?=isset($_GET['search_by'])?$_GET['search_by']:''?>';
var startdate = '<?=isset($_GET['startdate'])?$_GET['startdate']:''?>';
var enddate = '<?=isset($_GET['enddate'])?$_GET['enddate']:''?>';
var query     = '<?=isset($_GET['query'])?$_GET['query']:''?>';

document.getElementById("excel_button").onclick = function () {
    var rowCount = $('#tableData >tbody >tr').length;
    if(rowCount>0) {
        window.open(basepath+"apcompundpower/purchase_excel/"+segment+"?search_by="+search_by+"&startdate="+startdate+"&enddate="+enddate+"&query="+query,"_self");
    } else {
        alert('No Data');
    }
}
</script>