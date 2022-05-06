<?php
$this->load->helper('comman_helper');
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
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="#">Withdrawal</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>
                                    <a href="#">Canceled Withdrawal</a>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Canceled Withdrawal</h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                 <div class="col-md-12">
                                <div class="portlet">
                                    <div class="caption font-dark">
                                         <form method="get" action="<?=base_url()?>apcompundpower/pendingSearch">
                                             <input type="hidden" name="isactive" value="5">
                                                <div class="col-md-3">
                                                <div class="form-group">
                                                <label>Select Search Option</label>
                                                <select class="form-control" name="search_by">
                                            <option value="">All</option>
                                            <option <?=$searchby == 'name' ? 'selected="selected"' : '';?> value="name"> Name</option>
                                            <option <?=$searchby == 'username' ? 'selected="selected"' : '';?> value="username">Username</option>
                                            <option <?=$searchby == 'email' ? 'selected="selected"' : '';?> value="email">Email</option>
                                           
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-md-4">
                                    <div class="form-group" id="sandbox-container">
                                        <label> Date</label>
                                        <div class="input-group input-large input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                            <input type="text" class="form-control" name="startdate" placeholder="Start Date" value="<?=trim($startdate)?>">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" value="<?=trim($enddate)?>">
                                        </div>
                                        <!-- /input-group -->
                                        <span class="help-block"> Select date range </span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Enter your choice...</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search for..."
                                                name="query" value="<?=trim($query)?>">
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="submit">Search</button>
                                                <a class="btn red" href="<?=base_url()?>apcompundpower/cancel"><i class="fa fa-refresh"></i> </a>
                                               
                                                <button class="btn green" type="button" id="excel_button"><i class="fa fa-file-excel-o"></i> </butto>
                                            </span>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                </div>
                            </form>
                        </div>
                                   
                                    <div class="portlet-body">
                                       
                                            <div class="#">
                                    <table class="table table-striped table-bordered table-advance table-hover dataTable" id="sample_1">
                                            <thead>
                                                <tr>
                                                    
                                                    <th> # </th>
                                                    <th> Req. Date </th>
                                                    <th> Txn Number </th>
                                                    <th> User Info </th>
                                                    <th> Type </th>
                                                    <!--th> Account Info </th-->
                                                    <th> Deductions</th>
                                                    <th class="text-right"> Amount </th>
                                                </tr>
                                            </thead>
                                            <?php 
                                                if(!empty($pending))
                                                {
                                                    $i=0;
                                                    foreach ($pending as $key => $value)
                                                    {
                                                        $i++;
                                                        if($value['f_name']!=""){
                                                    $name=$value['f_name'];
                                                }else{
                                                    $name="";
                                                }
                                            ?>
                                                <tr class="odd gradeX" id="pend_<?=$value['id']?>">
                                                    
                                                    <td><?=$i?></td>
                                                    <td><?=change_date_format($value['created_date'],"d-M-Y").'<br>'.change_date_format($value['created_date'],"h:i:s")?></td>
                                                    <td>#<?=$value['invoice_number']?></td>
                                                     <td class="">
                                                <a href=""><?=$name?><br> (<?=$value['username']?>)</a><br>
                                                <i class="fa fa-envelope"></i> <?=$value['email']?> <br>
                                            </td>
                                                    <td>
                                                        <?php 
                                                            if($value['type'] == 1){
                                                                echo "Earning Wallet";
                                                            }elseif ($value['type'] == 2) {
                                                                echo "Auto Generated Profit";
                                                            }elseif ($value['type'] == 3) {
                                                                echo "Free Look Period";
                                                            }else{

                                                            }
                                                        ?>
                                                    </td>
                                                    <!--td style="max-width:200px; overflow-wrap: break-word;    white-space: normal !important;">
                                                       
                                                        <?php 
                                                            
                                                            echo '<b>Bitcoin Address:</b> ' . $value['bit_address'];
                                                        ?>
                                                         </td--><td><b>Service charges :</b> <span class="pull-right">
                                                <?=$value['admin_chrg_amount']?></span></td>
                                                    
                                                    <td class="text-right"><!--<sup>USD</sup>--> <?=number_format((float)$value['amount'], 2, '.', '')?></td>
                                                </tr>
                                            <?php }}?>
                                            </tbody>
                                          </table>
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
var segment = 0;

if (segment == 'ManageUser') {
    segment = '';
}

var search_by = '<?php echo $searchby ?>';
var condition = '0';
var query = '<?php echo $query ?>';
var startdate = '<?php echo $startdate ?>';
var enddate = '<?php echo $enddate ?>';

document.getElementById("excel_button").onclick = function() {
    var rowCount = $('#sample_1 >tbody >tr').length;

    if (rowCount > 0) {
        window.open(basepath + "apcompundpower/cancel_excel/" + segment + "?search_by=" + search_by +
            "&startdate=" + startdate + "&enddate=" + enddate + "&query=" + query, "_self");
    } else {
        alert('No Data');
    }
}
</script>