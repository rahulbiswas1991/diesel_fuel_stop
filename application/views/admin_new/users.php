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
         <h1>Agents</h1>
         <small>List of Agents</small>
      </div>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-lg-12 pinpin">
            <div class="card lobicard" id="lobicard-custom-control" data-sortable="true">
               <div class="card-header">
                  <div class="card-title custom_title">
                     <h4>Agents Details</h4>
                  </div>
               </div>
               <div class="card-body">
                  <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <div class="btn-group d-flex" role="group">
                     <div class="buttonexport">
                        <a href="#" class="btn btn-add" data-toggle="modal" data-target="#addnewagentmodel"><i class="fa fa-plus"></i> Add New Agent</a>
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

                  <div class="row">
                     <div class="col-md-12">
                        <!--<form class="form-horizontal">-->
                        <form id="user_searchfm" action="<?= base_url() ?>admin/ManageUser" method="get">
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label>Select Search Option</label>
                                    <select class="form-control" name="search_by">
                                       <option value="">All</option>
                                       <option <?= $searchby == 'name' ? 'selected="selected"' : ''; ?> value="name">Name</option>
                                       <option <?= $searchby == 'emp_id' ? 'selected="selected"' : ''; ?> value="emp_id">EMP ID</option>
                                       <option <?= $searchby == 'email' ? 'selected="selected"' : ''; ?> value="email">Email</option>
                                       <option <?= $searchby == 'mobile' ? 'selected="selected"' : ''; ?> value="mobile">Mobile</option>
                                       <option <?= $searchby == 'pancard' ? 'selected="selected"' : ''; ?> value="pancard">Pancard</option>
                                       <!-- <option>KYC Pending</option> -->
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label>Select Option</label>
                                    <select class="form-control" name="condition">
                                       <option value="">All</option>
                                       <option <?= $condition == 1 ? 'selected="selected"' : ''; ?> value="1">Active Agents</option>
                                       <option <?= $condition == 2 ? 'selected="selected"' : ''; ?> value="2">Deactive Agents</option>
                                       <!--       <option <?= $condition == 3 ? 'selected="selected"' : ''; ?> value="3">KYC Approved</option>
                                                            <option <?= $condition == 4 ? 'selected="selected"' : ''; ?> value="4">KYC Rejected</option>
                                                            <option <?= $condition == 5 ? 'selected="selected"' : ''; ?> value="5">KYC Pending</option>
                                                            <option <?= $condition == 6 ? 'selected="selected"' : ''; ?> value="6">KYC Not Submit</option>
                                                            <option <?= $condition == 7 ? 'selected="selected"' : ''; ?> value="7">Paid Users</option>
                                                            <option <?= $condition == 8 ? 'selected="selected"' : ''; ?> value="8">Unpaid Users</option> -->
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Enter your choice...</label>
                                    <div class="input-group">
                                       <input type="text" name="query" class="form-control" placeholder="Search for..." value="<?= trim($query) ?>">
                                       <span class="input-group-btn">
                                          <button class="btn blue" style="background: #009688;height: 34px;" type="submit">Search</button>
                                          <a class="btn red" style="background: red; height: 34px;" href="<?= base_url() ?>admin/ManageUser"><i class="fa fa-refresh"></i> </a>
                                          <!--<button class="btn blue" type="submit">Search</button>-->
                                          <!--<a class="btn red" href="<?= base_url() ?>apcompundpower/ManageUser"><i class="fa fa-refresh"></i> </a>-->
                                          <!--<button class="btn green excel_button" id="excel_button" type="button"><i class="fa fa-file-excel-o"></i> </button>-->
                                       </span>
                                    </div>
                                    <!-- /input-group -->
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>

                  <!-- ./Plugin content:powerpoint,txt,pdf,png,word,xl -->
                  <div class="table-responsive">
                     <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                        <thead class="back_table_color">
                           <tr class="info">
                              <th>#</th>
                              <th>Photo</th>
                              <th>Agent Name</th>
                              <th>Emp ID</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>DOB</th>
                              <th>Address</th>
                              <th>City</th>
                              <th>Register on</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $sno = $row + 1;
                           foreach ($users as $obj)
                              // print_r($obj);die; 
                              {
                              if ($obj['isactive'] == 0) {
                                 $sts = '<span class="label-danger label label-default"> In Process </span>';
                              } elseif ($obj['isactive'] == 1) {
                                 $sts = '<span class="label-custom label label-default"> Complete </span>';
                              } elseif ($obj['isactive'] == 2) {
                                 $sts = '<span class="label-danger label label-default"> Cancelled </span>';
                              } elseif ($obj['isactive'] == 3) {
                                 $sts = '<span class="label-danger label label-default"> Hold </span>';
                              }
                              // if ($obj->profile_pic != "") {
                                 // $src =  base_url() . "uploads/profile-pic/" . $obj->profile_pic;
                              // } else {
                                 $src =  "https://dieselfuelstop.com/diesel_stop/assets_diesel/dist/img/avatar5.png";
                              // }
                           ?>
                              <tr>
                                 <input type="hidden" class="checkboxes usercheck" value="<?= $obj['id'] ?>" />
                                 <td><?= $sno++; ?></td>

                                 <td><img src="<?= $src ?>" class="img-circle rounded-circle" alt="User Image" width="50" height="50"></td>
                                 <td><?= $obj['user_name'] ?></td>
                                 <td><?= $obj['emp_id'] ?></td>
                                 <td><?= $obj['email'] ?></td>
                                 <td><?= $obj['phone'] ?></td>
                                 <td><?= $obj['dob'] ?></td>
                                 <td><?= $obj['address'] ?></td>
                                 <td><?= $obj['city'] ?></td>
                                 <td><?= $obj['created_date'] ?></td>
                                 <td><?= $sts ?></td>
                                 <td>
                                    <a href="<?php echo base_url().'admin/user-details/'.$obj['id'] ?>"><button type="button" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></button></a>
                                    <button type="button" class="btn btn-danger btn-sm" id="delete_user" data-agent_id="<?= $obj['id'] ?>" ><i class="fa fa-trash"></i> 
                                    </button>
                                 </td></td>
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