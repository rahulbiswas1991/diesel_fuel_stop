<?php
$this->load->helper('comman_helper');
//echo '<pre>';print_r($users); die;
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
         <h1>Leads of agents</h1>
         <small>List of Agent's Leads</small>
      </div>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-lg-12 pinpin">
            <div class="card lobicard" id="lobicard-custom-control" data-sortable="true">
               <div class="card-header">
                  <div class="card-title custom_title">
                     <h4>Leadas Details</h4>
                  </div>
               </div>
               <div class="card-body">
                  <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <form class="form-horizontal" action="ManageLeadsByAgents" method="get">

                           <div class="row">

                              <!-- Enter Colum Name  -->
                              <div class="col-sm-6 col-md-6 col-lg-3">
                                 <div class="form-group">
                                    <label>Search Options</label>
                                    <select class="form-control" name="search_by" value="<?= $_GET['search_by']?$_GET['search_by']:"" ?>">
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
                                       <input type="text" class="form-control" placeholder="Search for..." name="query" value="<?= $_GET['query']?$_GET['query']:"" ?>">                                      
                                    </div>
                                    <!-- /input-group -->
                                 </div>
                              </div>

                              <!-- date range  -->
                              <div class="col-sm-6 col-md-6 col-lg-3">
                                 <div class="form-group" id="sandbox-container">
                                    <label>Select Date Range</label>
                                    <div class="input-group input-large input-daterange"  data-date="10/11/2020"
                                       data-date-format="mm/dd/yyyy">
                                       <input type="text" class="form-control" autocomplete="off" name="startdate" placeholder="Start Date"
                                          value="<?= $_GET['startdate']?$_GET['startdate']:"" ?>">
                                       <span class="input-group-addon"> &nbsp To &nbsp </span>
                                       <input type="text" class="form-control" autocomplete="off" name="enddate" placeholder="End Date"
                                          value="<?= $_GET['enddate']?$_GET['enddate']:"" ?>">
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
                                          <button class="btn blue" style="background: #009688;height: 34px;"
                                             type="submit">Search</button>
                                          <a class="btn red" style="background: red; height: 34px;"
                                             href="ManageLeadsByAgents"><i class="fa fa-refresh"></i> </a>
                                       </span>
                                    </div>
                                    <!-- /input-group -->
                                 </div>
                              </div>
                           </div>

                        </form>
                  <div class="btn-group d-flex" role="group">
                     <div class="buttonexport">
                        <a href="#" class="btn btn-add" data-toggle="modal" data-target="#addlead"><i class="fa fa-plus"></i> Import CSV File</a>
                     </div>
                  </div>

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

                  <!-- ./Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <div class="table-responsive">
                     <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead class="back_table_color">
                           <tr class="info">
                              <th>#</th>
                              <th>Agent's Name</th>
                              <th>Agent's Mobile</th>
                              <th>Agent's Email</th>
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
                           <?php $sno = $row + 1;
                           foreach ($users as $obj) {

                              // echo "<pre>"; print_r($obj); die();


                              if ($obj->profile_pic != "") {
                                 $src =  base_url() . "uploads/profile-pic/" . $obj->profile_pic;
                              } else {
                                 $src =  "https://dieselfuelstop.com/diesel_stop/assets_diesel/dist/img/avatar5.png";
                              }

                           ?>

                              <tr>
                                 <input type="hidden" class="checkboxes usercheck" value="<?= $obj->id ?>" />
                                 <td><?= $sno++; ?></td>

                                 <td><?= $obj['user_name'] ?>
                                    <span class="label label-sm label-success label-mini tooltips" data-original-title="Username"> <?= $obj['emp_id'] ?> </span><br>
                                    <!--<i class="fa fa-envelope"></i> <?= $obj['user_mail'] ?><br>-->
                                    <i class="fa fa-phone"></i> <?= $obj['user_phone'] ?>
                                 </td>
                                 <td><?= $obj['user_phone'] ?></td>
                                 <td><?= $obj['user_mail'] ?></td>
                                 <td><?= $obj['lead_name'] ?></td>
                                 <td><?= $obj['company_name'] ?></td>
                                 <td><?= $obj['lead_dot_number'] ?></td>
                                 <td><?= $obj['lead_phone'] ?></td>
                                 <td><?= $obj['lead_mail'] ?></td>
                                 <td><?= $obj['lead_total_trucks'] ?></td>
                                 <td><?= $obj['lead_street'] ?></td>
                                 <td><?= $obj['lead_city'] ?></td>
                                 <td><?= $obj['lead_state'] ?></td>
                                 <td><?= $obj['lead_zip_code'] ?></td>
                                 <td><?= $obj['lead_potential_gallons'] ?></td>
                                 <td><?= $obj['lead_description_field'] ?></td>
                                 <td><?= change_date_format($obj['created_date'], 'd M,Y h:i:s')  ?>
                                    </br>
                                    <?= $cdate  ?>
                                 </td>
                                 <td><?= $sts ?></td>
                                 <td style="width:18%">
                                    <a href="<?php echo base_url() . 'admin/user_lead_details/' . $obj['lead_id'] ?>"><button type="button" class="btn btn-add btn-sm"><i class="fa fa-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger btn-sm" id="delete_user" data-agent_id="<?= $obj['lead_id'] ?>"><i class="fa fa-trash"></i> </button>
                                 </td>
                              </tr>
                           <?php } ?>
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

      <!--<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-hidden="true">-->
      <!--   <div class="modal-dialog">-->
      <!--      <div class="modal-content">-->
      <!--         <div class="modal-header modal-header-primary">-->
      <!--            <h3><i class="fa fa-plus m-r-5"></i> Add new User</h3>-->
      <!--            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
      <!--         </div>-->
      <!--         <div class="modal-body">-->
      <!--            <div class="row">-->
      <!--               <div class="col-md-12">-->
      <!--                  <form class="form-horizontal">-->
      <!--                    <div class="row">-->
      <!--                             <div class="col-md-6 form-group">-->
      <!--                              <label class="control-label">Photo</label>-->
      <!--                              <input name="filebutton" class="input-file" type="file">-->
      <!--                           </div>-->
      <!-- Text input-->
      <!--                           <div class="col-md-6 form-group">-->
      <!--                              <label class="control-label">Agent Name</label>-->
      <!--                              <input type="text" placeholder="User Name" class="form-control">-->
      <!--                           </div>-->
      <!-- Text input-->
      <!--                           <div class="col-md-6 form-group">-->
      <!--                              <label class="control-label">status</label>-->
      <!--                              <input type="text" placeholder="status" class="form-control">-->
      <!--                           </div>-->
      <!--                           <div class="col-md-6 form-group">-->
      <!--                              <label class="control-label">Type</label>-->
      <!--                              <input type="text" placeholder="Type" class="form-control">-->
      <!--                           </div>-->
      <!--                           <div class="col-md-12 form-group user-form-group">-->
      <!--                              <div class="float-right">-->
      <!--                                 <button type="button" class="btn btn-danger btn-sm">Cancel</button>-->
      <!--                                 <button type="submit" class="btn btn-add btn-sm">Update</button>-->
      <!--                              </div>-->
      <!--                           </div>-->
      <!--                    </div>-->
      <!--                  </form>-->
      <!--               </div>-->
      <!--            </div>-->
      <!--         </div>-->
      <!--         <div class="modal-footer">-->
      <!--            <button type="button" class="btn btn-danger float-left" data-dismiss="modal">Close</button>-->
      <!--         </div>-->
      <!--      </div>-->
      <!--   </div>-->
      <!--</div>-->


      <div class="modal fade" id="addlead" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-primary">
                  <h3><i class="fa fa-plus m-r-5"></i> Upload Csv file Only</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form action="<?= base_url() ?>admin/importlead_sheet" method="post" enctype="multipart/form-data">
                           <div class="row">
                              <!-- Text input-->
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Excel File</label>                                 
                                 <input type="file" name="file" id="file" required accept=".xlsx" />
                              </div>

                              <div class="col-md-12 form-group user-form-group">
                                 <div class="float-right">
                                    <!--<button type="button" class="btn btn-danger btn-sm">Cancel</button>-->
                                    <button type="submit" class="btn btn-add btn-sm">Import</button>

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


      <div class="modal fade" id="addnewagentmodel" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-primary">
                  <h3><i class="fa fa-plus m-r-5"></i> Add New Agent</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <!--<form class="form-horizontal">-->
                        <form class="form-horizontal" method="post" id="addnewagent" data-action="<?= base_url() ?>admin/add_newagent">
                           <div class="row">

                              <!-- Text input-->
                              <div class="col-md-6 form-group">
                                 <label class="control-label">User Name</label>
                                 <input type="text" name="username" placeholder="User Name" class="form-control">
                              </div>
                              <!-- Text input-->
                              <div class="col-md-6 form-group">
                                 <label class="control-label">Email</label>
                                 <input type="text" name="email" placeholder="User Email ID" class="form-control">
                              </div>
                              <div class="col-md-12 form-group user-form-group">
                                 <div class="float-right">
                                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Cancel</button>
                                    <button type="submit" class="btn btn-add btn-sm">Add Agent</button>
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
      <!-- delete user Modal2 -->
      <div class="modal fade" id="customer2" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-primary">
                  <h3><i class="fa fa-user m-r-5"></i> Delete Agents</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form class="form-horizontal">
                           <fieldset>
                              <div class="col-md-12 form-group user-form-group">
                                 <label class="control-label">Delete Agents</label>
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