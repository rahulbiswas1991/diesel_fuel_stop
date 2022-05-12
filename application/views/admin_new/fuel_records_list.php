<?php
$this->load->helper('comman_helper');
// echo '<pre>';print_r($users); die;
$searchby = '';
$condition = '';
$query = '';

$searchby   = isset($_GET['search_by']) ? $_GET['search_by'] : '';
$condition  = isset($_GET['condition']) ? $_GET['condition'] : '';
//$query      = isset($_GET['query'])?$_GET['query']:'';
if (isset($_GET['query']) && $_GET['query'] != '') {
   $query      = $_GET['query'];
}

//echo "<pre>"; print_r($permission); die();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="header-icon">
         <i class="fa fa-user-plus"></i>
      </div>
      <div class="header-title">
         <h1>Fuel Records</h1>
         <small>List of Records</small>
      </div>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-lg-12 pinpin">
            <div class="card lobicard" id="lobicard-custom-control" data-sortable="true">
               <div class="card-header">
                  <div class="card-title custom_title">
                     <h4>Fuel CSV Records</h4>
                  </div>
               </div>
               <div class="card-body">
                  <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <form class="form-horizontal" action="upload_record_sheet" method="get">

                     <div class="row">

                        <!-- Enter Colum Name  -->
                        <div class="col-sm-6 col-md-6 col-lg-3">
                           <div class="form-group">
                              <label>Search Options</label>
                              <select class="form-control" name="search_by" value="<?= $_GET['search_by'] ? $_GET['search_by'] : "" ?>">
                                 <option value="">All</option>
                                 <option value="name">Name</option>
                              </select>
                           </div>
                        </div>

                        <!-- Enter search query  -->
                        <div class=" col-sm-6 col-md-6 col-lg-3">
                           <div class="form-group">
                              <label>Enter Search Query</label>
                              <div class="input-group">
                                 <input type="text" class="form-control" placeholder="Search for..." name="query" value="<?= $_GET['query'] ? $_GET['query'] : "" ?>">
                              </div>
                              <!-- /input-group -->
                           </div>
                        </div>

                        <!-- date range  -->
                        <div class="col-sm-6 col-md-6 col-lg-3">
                           <div class="form-group" id="sandbox-container">
                              <label>Select Date Range</label>
                              <div class="input-group input-large input-daterange" data-date="10/11/2020" data-date-format="mm/dd/yyyy">
                                 <input type="text" class="form-control" autocomplete="off" name="startdate" placeholder="Start Date" value="<?= $_GET['startdate'] ? $_GET['startdate'] : "" ?>">
                                 <span class="input-group-addon"> &nbsp To &nbsp </span>
                                 <input type="text" class="form-control" autocomplete="off" name="enddate" placeholder="End Date" value="<?= $_GET['enddate'] ? $_GET['enddate'] : "" ?>">
                              </div>
                              <!-- /input-group -->
                           </div>
                        </div>

                        <!-- search btn  -->
                        <div class=" col-sm-6 col-md-6 col-lg-3">
                           <div class="form-group">
                              <label>&nbsp; &nbsp;</label>
                              <div class="input-group">
                                 <!--<input type="text" class="form-control" placeholder="Search for..." name="query" value="">-->
                                 <span class="input-group-btn">
                                    <button class="btn blue" style="background: #009688;height: 34px;" type="submit">Search</button>
                                    <a class="btn red" style="background: red; height: 34px;" href="admin/upload_record_sheet"><i class="fa fa-refresh"></i> </a>
                                 </span>
                              </div>
                              <!-- /input-group -->
                           </div>
                        </div>
                     </div>

                  </form>

                  <div class="btn-group">
                     <button class="btn btn-exp btn-sm" data-toggle="modal" data-target="#import_fuel_records"><i class="fa fa-plus"></i> Import CSV File</button> &nbsp
                     <button class="btn btn-exp btn-sm" data-toggle="dropdown"><i class="fa fa-bars"></i> Export
                        Table Data
                     </button>
                     <ul class="dropdown-menu exp-drop" role="menu">
                        <!-- <li>
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
                        <li class="dropdown-divider"></li> -->
                        <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'xml',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/xml.png" width="24" alt="logo"> XML</a>
                        </li>
                        <!-- <li><a href="#" onclick="$('#dataTableExample1').tableExport({type:'sql'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/sql.png" width="24" alt="logo"> SQL</a>
                        </li>
                        <li class="dropdown-divider"></li> -->
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'csv',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/csv.png" width="24" alt="logo"> CSV</a>
                        </li>
                        <!-- <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'txt',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/txt.png" width="24" alt="logo"> TXT</a>
                        </li>
                        <li class="dropdown-divider"></li> -->
                        <li>
                           <a href="#" onclick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});">
                              <img src="<?= base_url() ?>assets_diesel/dist/img/xls.png" width="24" alt="logo"> XLS</a>
                        </li>
                        <!-- <li>
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
                        </li> -->
                     </ul>
                  </div>
                  <!-- ./Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <div class="table-responsive">
                     <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead class="back_table_color">
                           <tr class="info">
                              <th>#</th>
                              <th>Carrier Name</th>

                              <th>Company</th>

                              <th>Billing Card</th>
                              <th>Acct</th>
                              <th>PFJ Ascend</th>
                              <th>Acct Type</th>
                              <th>Fuel (Gallons)</th>
                              <th>Share (%)</th>
                              <th>Total Share</th>
                              <th>Upload Date</th>
                              <th>Month</th>
                              <th>Year</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1;

                           if (!empty($roi_detailss)) {
                              $after_filter = array_filter($roi_detailss, function ($data) {
                                 if (!empty($data['carrier_name'])) {
                                    return true;
                                 } else {
                                    return false;
                                 }
                              });
                              foreach ($after_filter as $key => $roi) {
                                 //   echo "<pre>"; print_r($team['paid_status']); //die();


                           ?>
                                 <tr class="show_fuel_records" data-carrier="<?= $roi['carrier_name'] ?>" data-company="<?= $roi['company'] ?>" data-billing="<?= $roi['billing_card'] ?>" data-acct="<?= $roi['acct'] ?>" data-pfj="<?= $roi['pfj_ascend'] ?>" data-acctype="<?= $roi['acct_type'] ?>" data-fuel="<?= $roi['fuel_gallons'] ?>" data-share="<?= $roi['share_per'] ?>" data-totalshare="<?= $roi['total_share'] ?>" data-createddate="<?= $roi['created_date'] ?>">
                                    <td><?= $i++; ?></td>
                                    <td><?= $roi['carrier_name'] ?> </td>
                                    <td> <?= $roi['company'] ?> </td>
                                    <td> <?= $roi['billing_card'] ?> </td>
                                    <td> <?= $roi['acct'] ?> </td>
                                    <td> <?= $roi['pfj_ascend'] ?> </td>
                                    <td> <?= $roi['acct_type'] ?> </td>
                                    <td> <?= $roi['fuel_gallons'] ?> </td>
                                    <td> <?= $roi['share_per'] ?> </td>
                                    <td> <?= $roi['total_share'] ?> </td>
                                    <td> <?= $roi['created_date'] ?></td>
                                    <td> <?= $roi['month'] ?></td>
                                    <td> <?= $roi['year'] ?></td>
                                 </tr>
                           <?php }
                           } ?>
                        </tbody>
                     </table>

                     <div class="row">
                        <div class="col-md-6 text-right"><?php echo $pagination; ?></div>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- /.modal -->
      <!-- Modal -->
      <!-- User Modal1 -->
      <div class="modal fade" id="show_fuel_lead" tabindex="-1" role="dialog" aria-hidden="true">
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
                           <div class="row">
                              <!-- Text input-->
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Carrier Name :</label>
                                 <input placeholder="carrier name" id="carrier" name="carrier name" class="form-control" type="text" disabled />
                              </div>

                              <div class="col-md-6 form-group">
                                 <label class="control-label">Company Name</label>
                                 <input placeholder="Company name" id="company" name="company_name" class="form-control" type="text" disabled />
                              </div>

                              <div class="col-md-6 form-group">
                                 <label class="control-label">Billing Card</label>
                                 <input placeholder="billing" id="billing" name="billing" class="form-control" type="text" disabled />
                              </div>
                              <!-- Text input-->
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Acct</label>
                                 <input placeholder="Account" id="acct" name="Account" class="form-control" type="text" disabled />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">PFJ Ascend</label>
                                 <input placeholder="pfj" id="pfj" name="pfj" class="form-control" type="text" disabled />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Acct Type</label>
                                 <input placeholder="Acct Type" id="acctype" name="acctype" class="form-control" type="text" disabled />
                              </div>

                              <div class="col-md-6 form-group">
                                 <label class="control-label">Fuel (Gallons)</label>
                                 <input placeholder="fuel" id="fuel" name="fuel" class="form-control" type="text" disabled />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Share (%)</label>
                                 <input placeholder="share" id="share" name="share" class="form-control" type="text" disabled />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Total Share</label>
                                 <input placeholder="totalshare" id="totalshare" name="totalshare" class="form-control" type="text" disabled />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Upload Date</label>
                                 <input placeholder="Upload date" id="createddate" name="createddate" class="form-control" type="text" disabled />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Month</label>
                                 <input placeholder="Month" id="month" name="month" class="form-control" type="text" disabled />
                              </div>
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Year</label>
                                 <input placeholder="Year" id="year" name="year" class="form-control" type="text" disabled />
                              </div>
                              <!-- <div class="col-md-12 form-group user-form-group">
                                 <div class="float-right">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-add btn-sm">Save</button>
                                 </div>
                              </div> -->
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
      <div class="modal fade" id="import_fuel_records" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-primary">
                  <h3><i class="fa fa-plus m-r-5"></i> Upload Csv file Only</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form action="<?= base_url() ?>admin/importfuelrecord_sheet" method="post" enctype="multipart/form-data">
                           <div class="row">

                              <div class="col-sm-12 col-md-6 col-lg-6">
                                 <div class="form-group">
                                    <label>Select Import Data Year</label>
                                    <select class="form-control" name="year" required>
                                       <option value="">Select</option>
                                       <option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
                                       <option value="<?php echo date("Y", strtotime("-1 year")); ?>">
                                          <?php echo date("Y", strtotime("-1 year")); ?></option>
                                    </select>
                                 </div>
                              </div>

                              <!-- Text input-->
                              <div class="col-md-12 mt-2 form-group">
                                 <label class="control-label">Select Excel File</label><br>
                                 <input type="file" name="file" id="file" required accept=".xlsx" />
                              </div>

                              <div class="col-md-12 form-group user-form-group">
                                 <div class="float-right">
                                    <!--<button type="button" class="btn btn-danger btn-sm">Cancel</button>-->
                                    <button type="submit" class="btn btn-primary">Import</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- Modal -->
      <!-- delete user Modal2 -->
      <div class="modal fade" id="customer2" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-primary">
                  <h3><i class="fa fa-user m-r-5"></i> Delete User</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form class="form-horizontal">
                           <fieldset>
                              <div class="col-md-12 form-group user-form-group">
                                 <label class="control-label">Delete User</label>
                                 <div class="float-right">
                                    <button type="button" class="btn btn-danger btn-sm">NO</button>
                                    <button type="submit" class="btn btn-add btn-sm">YES</button>
                                 </div>
                              </div>
                           </fieldset>
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