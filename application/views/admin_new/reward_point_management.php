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

<!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-user-plus"></i>
               </div>
               <div class="header-title">
                  <h1>Rewards</h1>
                  <small>Rewards Points</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                     <div class="col-lg-12 pinpin">
                           <div class="card lobicard" id="lobicard-custom-control" data-sortable="true">
                               <div class="card-header">
                                   <div class="card-title custom_title">
                                       <h4>Agent's Rewards</h4>
                                   </div>
                               </div>
                               <div class="card-body">
                                    <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                                       <div class="btn-group d-flex" role="group">
                                          <!--<div class="buttonexport"> -->
                                          <!--   <a href="#" class="btn btn-add" data-toggle="modal" data-target="#adduser"><i class="fa fa-plus"></i> Add Users</a>  -->
                                          <!--</div>-->
                                       </div>
                                       <div class="btn-group">
                                          <button class="btn btn-exp btn-sm" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                                          <ul class="dropdown-menu exp-drop" role="menu">
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'false'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/json.png" width="24" alt="logo"> JSON</a>
                                             </li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});">
                                                <img src="<?=base_url()?>assets_diesel/dist/img/json.png" width="24" alt="logo"> JSON (ignoreColumn)</a>
                                             </li>
                                             <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'true'});">
                                                <img src="<?=base_url()?>assets_diesel/dist/img/json.png" width="24" alt="logo"> JSON (with Escape)</a>
                                             </li>
                                            <li class="dropdown-divider"></li>
                                             <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'xml',escape:'false'});">
                                                <img src="<?=base_url()?>assets_diesel/dist/img/xml.png" width="24" alt="logo"> XML</a>
                                             </li>
                                             <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'sql'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/sql.png" width="24" alt="logo"> SQL</a>
                                             </li>
                                            <li class="dropdown-divider"></li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'csv',escape:'false'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/csv.png" width="24" alt="logo"> CSV</a>
                                             </li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'txt',escape:'false'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/txt.png" width="24" alt="logo"> TXT</a>
                                             </li>
                                             <li class="dropdown-divider"></li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/xls.png" width="24" alt="logo"> XLS</a>
                                             </li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'doc',escape:'false'});">
                                                <img src="<?=base_url()?>assets_diesel/dist/img/word.png" width="24" alt="logo"> Word</a>
                                             </li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'powerpoint',escape:'false'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/ppt.png" width="24" alt="logo"> PowerPoint</a>
                                             </li>
                                            <li class="dropdown-divider"></li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'png',escape:'false'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/png.png" width="24" alt="logo"> PNG</a>
                                             </li>
                                             <li>
                                                <a href="#" onclick="$('#dataTableExample1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> 
                                                <img src="<?=base_url()?>assets_diesel/dist/img/pdf.png" width="24" alt="logo"> PDF</a>
                                             </li>
                                          </ul>
                                       </div>
                                       <!-- ./Plugin content:powerpoint,txt,pdf,png,word,xl -->
                                       <div class="table-responsive">
                                          <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                             <thead class="back_table_color">
                                                <tr class="info">
                                                   <th>#</th>
                                                    <th>Date</th>
                                                    <th>User Info</th>
                                                    <th>Reward Point</th>
                                                    <th>Profit Status</th>
                                                    <th>Status</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                        //$i=1;
                                                        $sno = 1;
                                                        foreach ($listing as $key => $list) {
                                                           
                                                            
                                                        if($list['isactive'] == 0){
                                                            $status = 'Inactive';
                                                        }else if($list['isactive'] == 1){
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
                                                        
                                                        
                                                        
                                                     ?>      
                                                            
                                        
                                                <tr>
                                                    <td><?= $sno++; ?></td>
                                                   <td><?= change_date_format($list['created_date'],"d-M-Y h:i:s A") ?></td>
                                                    <td> <?= $list['name'] ?>
                                                <span class="label label-sm label-success label-mini tooltips" data-original-title="Username"> <?= $list['emp_id'] ?> </span><br>
                                                <i class="fa fa-envelope"></i> <?= $list['email'] ?></td>
                                                   <td><?= $list['amount'] ?></td>
                                                   <td><?= $pstatus?></td>     
                                                   <td><?= $status ?></td>
                                                   <!--<td>-->
                                                   <!--   <button type="button" class="btn btn-add btn-sm" data-toggle="modal" data-target="#update"><i class="fa fa-pencil"></i></button>-->
                                                   <!--   <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#customer2"><i class="fa fa-trash-o"></i> </button>-->
                                                   <!--</td>-->
                                                </tr>
                                                <?php } ?>
                                             </tbody>
                                          </table>
                                          
                                          <div class="row">
                                             <div class="col-md-6 text-right"><?php echo $pagination;?></div>
                                        </div>
                                          
                                       </div>
                                    </div>
                           </div>
                       </div>
               </div>
             
              
               <!-- /.modal -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->