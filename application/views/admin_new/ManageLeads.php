<?php
// print_r(count($history));die;
// foreach ($history as $abc) {
//    print_r($abc);
//    die;
// }
$this->load->helper('comman_helper');
$searchby = '';
$condition = '';
$query = '';

$startdate = '';
$enddate = '';


$searchby   = isset($_GET['search_by']) ? $_GET['search_by'] : '';
$condition  = isset($_GET['condition']) ? $_GET['condition'] : '';
$startdate = isset($_GET['startdate']) ? $_GET['startdate'] : '';
$enddate = isset($_GET['enddate']) ? $_GET['enddate'] : '';
if (isset($_GET['query']) && $_GET['query'] != '') {
   $query      = $_GET['query'];
}

$path = base_url();
?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="header-icon">
         <i class="fa fa-leanpub"></i>
      </div>
      <div class="header-title">
         <h1><a href="<?= base_url() ?>admin/ManageLeads">Leads</a></h1>
         <small>Manage Leads</small>
      </div>
   </section>
   <!-- Main content -->
   <section class="content">


      <div class="row">
         <div class=" col-sm-6 col-md-6 col-lg-6">
            <div id="cardbox3">
               <div class="statistic-box">
                  <i class="fa fa-money fa-3x"></i>
                  <div class="counter-number pull-right">
                     <!--<i class="ti ti-money"></i>-->
                     <span class="count-number"><?= number_format($total_leads['total_leads']) ?></span>
                     <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                     </span>
                  </div>
                  <h3> Total Leads</h3>
               </div>
            </div>
         </div>
         <div class=" col-sm-6 col-md-6 col-lg-6">
            <div id="cardbox4">
               <div class="statistic-box">
                  <i class="fa fa-files-o fa-3x"></i>
                  <div class="counter-number pull-right">
                     <span class="count-number"><?= number_format($today_leads['today_leads']) ?></span>
                     <span class="slight"><i class="fa fa-play fa-rotate-270"> </i>
                     </span>
                  </div>
                  <h3> Today's Leads</h3>
               </div>
            </div>
         </div>
      </div>


      <div class="row">
         <div class="col-md-12">
            <!--<form class="form-horizontal">-->
            <form class="form-horizontal" method="get" action="<?= base_url() ?>admin/ManageLeads">
               <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-3">
                     <div class="form-group">
                        <label>Search Options</label>
                        <select class="form-control" name="search_by">
                           <option value="">All</option>
                           <option <?= $searchby == 'name' ? 'selected="selected"' : ''; ?> value="name">Name</option>
                           <option <?= $searchby == 'username' ? 'selected="selected"' : ''; ?> value="username">EMP ID</option>
                           <!--<option <?= $searchby == 'email' ? 'selected="selected"' : ''; ?> value="email">Email</option>-->
                           <!--<option <?= $searchby == 'mobile' ? 'selected="selected"' : ''; ?> value="mobile">Mobile</option>-->
                           <!-- <option>KYC Pending</option> -->
                        </select>
                     </div>
                  </div>
                  <div class=" col-sm-6 col-md-6 col-lg-3" style="display:none;">
                     <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="condition">
                           <option value="">All</option>
                           <option <?= $condition == 1 ? 'selected="selected"' : ''; ?> value="1">Credited</option>
                           <option <?= $condition == 2 ? 'selected="selected"' : ''; ?> value="2">Debited</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-3">
                     <div class="form-group" id="sandbox-container">
                        <label>Lead Date</label>
                        <div class="input-group input-large input-daterange" data-date="10/11/2020" data-date-format="mm/dd/yyyy">
                           <input type="text" class="form-control" name="startdate" placeholder="Start Date" value="<?= trim($startdate) ?>">
                           <span class="input-group-addon"> to </span>
                           <input type="text" class="form-control" name="enddate" placeholder="End Date" value="<?= trim($enddate) ?>">
                        </div>
                        <!-- /input-group -->
                        <span class="help-block"> Select date range </span>
                     </div>
                  </div>
                  <div class=" col-sm-6 col-md-6 col-lg-3">
                     <div class="form-group">
                        <label>Enter your choice...</label>
                        <div class="input-group">
                           <input type="text" class="form-control" placeholder="Search for..." name="query" value="<?= trim($query) ?>">
                           <!--<span class="input-group-btn">-->
                           <!--    <button class="btn blue" type="submit">Search</button>-->
                           <!--    <a class="btn red" href="<?= base_url() ?>admin/ManageLeads"><i class="fa fa-refresh"></i> </a>-->
                           <!--</span>-->
                        </div>
                        <!-- /input-group -->
                     </div>
                  </div>
                  <div class=" col-sm-6 col-md-6 col-lg-3">
                     <div class="form-group">
                        <label>&nbsp; &nbsp;</label>
                        <div class="input-group">
                           <!--<input type="text" class="form-control" placeholder="Search for..." name="query" value="<?= trim($query) ?>">-->
                           <span class="input-group-btn">
                              <button class="btn blue" style="background: #009688;height: 34px;" type="submit">Search</button>
                              <a class="btn red" style="background: red; height: 34px;" href="<?= base_url() ?>admin/ManageLeads"><i class="fa fa-refresh"></i> </a>
                           </span>
                        </div>
                        <!-- /input-group -->
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-12 pinpin">
            <div class="card lobicard" data-sortable="true">
               <div class="card-header">
                  <div class="card-title custom_title">
                     <h4>Leads</h4>
                  </div>
               </div>
               <div class="card-body">
                  <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <!--<div class="btn-group d-flex" role="group">-->
                  <!--   <div class="buttonexport" id="buttonlist"> -->
                  <!--      <a class="btn btn-add" href="add-customer.html"> <i class="fa fa-plus"></i> Add Customer-->
                  <!--      </a>  -->
                  <!--   </div>-->
                  <!--</div> -->
                  <div class="btn-group">
                     <button class="btn btn-exp btn-sm" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                     <ul class="dropdown-menu exp-drop" role="menu">
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/json.png" width="24" alt="logo"> JSON</a>
                        </li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'false',ignoreColumn:'[2,3]'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/json.png" width="24" alt="logo"> JSON (ignoreColumn)</a>
                        </li>
                        <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'json',escape:'true'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/json.png" width="24" alt="logo"> JSON (with Escape)</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'xml',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/xml.png" width="24" alt="logo"> XML</a>
                        </li>
                        <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'sql'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/sql.png" width="24" alt="logo"> SQL</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'csv',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/csv.png" width="24" alt="logo"> CSV</a>
                        </li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'txt',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/txt.png" width="24" alt="logo"> TXT</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/xls.png" width="24" alt="logo"> XLS</a>
                        </li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'doc',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/word.png" width="24" alt="logo"> Word</a>
                        </li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'powerpoint',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/ppt.png" width="24" alt="logo"> PowerPoint</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'png',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/png.png" width="24" alt="logo"> PNG</a>
                        </li>
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/pdf.png" width="24" alt="logo"> PDF</a>
                        </li>
                     </ul>
                  </div>
                  <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <div class="table-responsive" style="display: block;overflow-x: auto;white-space: nowrap;">
                     <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead class="back_table_color">
                           <tr class="info">
                              <th>#</th>
                              <th>Agent's Info</th>
                              <th style="width: 15%;">Lead Name</th>
                              <th style="width: 17%;">Company Name</th>
                              <th>DOT number</th>
                              <th>Mobile</th>
                              <th>Email</th>
                              <th># of trucks</th>
                              <th>Street</th>
                              <th>City</th>
                              <th>state</th>
                              <th>Zip Code</th>
                              <th>Potential Gallons</th>
                              <th>Description Field</th>
                              <th style="width: 18%;">Lead Date / Updated Date</th>
                              <th style="width: 10%;">Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           //$i=1;
                           $sno = $row + 1;
                           foreach ($history as $record) {
                              if ($record['status'] == 0) {
                                 $sts = '<span class="label-danger label label-default"> In Process </span>';
                              } elseif ($record['status'] == 1) {
                                 $sts = '<span class="label-custom label label-default"> Complete </span>';
                              } elseif ($record['status'] == 2) {
                                 $sts = '<span class="label-danger label label-default"> Cancelled </span>';
                              } elseif ($record['status'] == 3) {
                                 $sts = '<span class="label-danger label label-default"> Hold </span>';
                              }

                              $cdate = $record['updated_date'] != "0000-00-00 00:00:00" ? change_date_format($record['updated_date'], 'd M,Y h:i:s') : " ";
                           ?>

                              <tr>
                                 <td><?= $sno++ ?></td>
                                 <td><?= $record['user_name'] ?>
                                    <span class="label label-sm label-success label-mini tooltips" data-original-title="Username"> <?= $record['emp_id'] ?> </span><br>
                                    <!--<i class="fa fa-envelope"></i> <?= $record['user_mail'] ?><br>-->
                                    <i class="fa fa-phone"></i> <?= $record['user_phone'] ?>
                                 </td>
                                 <td><?= $record['lead_name'] ?></td>
                                 <td><?= $record['company_name'] ?></td>
                                 <td><?= $record['lead_dot_number'] ?></td>
                                 <td><?= $record['lead_phone'] ?></td>
                                 <td><?= $record['lead_mail'] ?></td>
                                 <td><?= $record['lead_total_trucks'] ?></td>
                                 <td><?= $record['lead_street'] ?></td>
                                 <td><?= $record['lead_city'] ?></td>
                                 <td><?= $record['lead_state'] ?></td>
                                 <td><?= $record['lead_zip_code'] ?></td>
                                 <td><?= $record['lead_potential_gallons'] ?></td>
                                 <td><?= $record['lead_description_field'] ?></td>
                                 <td><?= change_date_format($record['created_date'], 'd M,Y h:i:s')  ?>
                                    </br>
                                    <?= $cdate  ?>
                                 </td>
                                 <td><?= $sts ?></td>
                                 <td>
                                    <button type="button" class="btn btn-add btn-sm adlead_popup" data-ref="<?= $record['lead_id'] ?>" data-b_user_id="<?= $record['id'] ?>"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm deleteLead" data-id="<?= $record['lead_id'] ?>"><i class="fa fa-trash-o"></i> </button>
                                 </td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                     <div class="row">
                        <div class="col-sm-12 text-right"><?php echo $pagination; ?></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>




      <!-- customer Modal1 -->
      <div class="modal fade" id="adedit_lead" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-primary">
                  <h3><i class="fa fa-user m-r-5"></i> Update Lead</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <!--<form class="form-horizontal">-->
                        <form class="form-horizontal" method="post" id="edlead_delsfrm" data-action="<?= base_url() ?>process/adupdate_lead">
                           <input type="hidden" value="" id="lead_ref" name="lead_ref">
                           <input type="hidden" value="" id="b_user_id" name="b_user_id">
                           <div class="row">
                              <!-- Text input-->
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Agent Info:</label>
                                 <input placeholder="User Name" id="user_name" name="user_name" class="form-control" type="text" required />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Lead Name:</label>
                                 <input placeholder="Lead Name" id="lead_name" name="lead_name" class="form-control" type="text" required />
                              </div>

                              <div class="col-md-6 form-group">
                                 <label class="control-label">Company Name</label>
                                 <input placeholder="Company name" id="company_name" name="company_name" class="form-control" type="text" required />
                              </div>

                              <div class="col-md-6 form-group">
                                 <label class="control-label">Email</label>
                                 <input placeholder="Email" id="email" name="email" class="form-control" type="text" required />
                              </div>
                              <!-- Text input-->
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Phone No</label>
                                 <input placeholder="Phone" id="phone" name="phone" class="form-control" type="text" required />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Street</label>
                                 <input placeholder="Street" id="street" name="street" class="form-control" type="text" required />
                              </div>                              
                              <div class="col-md-6 form-group">
                                 <label class="control-label">City</label>
                                 <input placeholder="City" id="city" name="city" class="form-control" type="text" required />
                              </div>                              
                              <div class="col-md-6 form-group">
                                 <label class="control-label">State</label>
                                 <input placeholder="State" id="state" name="state" class="form-control" type="text" required />
                              </div>                              
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Zip code</label>
                                 <input placeholder="Zip code" id="zip_code" name="zip_code" class="form-control" type="text" required />
                              </div>                              
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Total trucks</label>
                                 <input placeholder="Total trucks" id="total_trucks" name="total_trucks" class="form-control" type="text" required />
                              </div>                              
                              <div class="col-md-6 form-group">
                                 <label class="control-label">potential gallons</label>
                                 <input placeholder="potential_gallons" id="potential_gallons" name="potential_gallons" class="form-control" type="text" required />
                              </div>                              

                              <div class="col-md-6 form-group">
                                 <label class="control-label">Current Status</label>
                                 <select class="form-control" id="lead_status" name="lead_status" required >
                                 <option value="0"> IN Process</option>
                                 <option value="1">Complete</option>
                                 <option value="2">Cancelled</option>
                                 <option value="3">Hold</option>
                                 </select>
                              </div>


                              <div class="col-md-12 form-group user-form-group">
                                 <div class="float-right">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-add btn-sm">Save</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger float-left" data-dismiss="modal">Close</button>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- Modal -->
      <!-- Customer Modal2 -->
      <div class="modal fade" id="customer2" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-primary">
                  <h3><i class="fa fa-user m-r-5"></i> Delete Customer</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form class="form-horizontal">
                           <div class="row">
                              <div class="col-md-12 form-group user-form-group">
                                 <label class="control-label">Delete Customer</label>
                                 <div class="float-right">
                                    <button type="button" class="btn btn-danger btn-sm">NO</button>
                                    <button type="submit" onClick = "deleteLead()" class="btn btn-add btn-sm">YES</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger float-left" data-dismiss="modal">Close</button>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->