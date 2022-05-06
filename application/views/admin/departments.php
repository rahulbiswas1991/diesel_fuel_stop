
<style type="text/css">
	label#depName-error {
    color: red;
}
</style>
<!-- BEGIN CONTENT -->

<div class="page-content-wrapper">

	<!-- BEGIN CONTENT BODY -->

	<div class="page-content">



		<!-- END THEME PANEL -->

		<h1 class="page-title"> Add/Edit Departments

			<!--<small>statistics, charts, recent events and reports</small>-->

		</h1>

		<div class="page-bar">

			<ul class="page-breadcrumb">

				<li>

					<i class="icon-home"></i>

					<a href="index.php">Home</a>

					<i class="fa fa-angle-right"></i>

				</li>

                <li>

					<span>Departments</span>

                </li>

            </ul>

		</div>


<div class="row">

	<div class="col-md-12">

		<!-- BEGIN BORDERED TABLE PORTLET-->

		<div class="portlet light portlet-fit ">

			<div class="portlet-title">

				<div class="caption">

					<i class="icon-users font-dark"></i>

					<span class="caption-subject font-dark bold uppercase">Departments List</span>

				</div>

				<a data-toggle="modal" href="#responsive" class="btn btn-sm btn-info pull-right" style="margin-top: 5px; margin-right: 5px;"><i class="fa fa-plus"></i> Add Department</a>

			</div>

			<div class="portlet-body">

			

					<table class="table table-bordered table-hover" id="sample_1">

						<thead>

							<tr>

								<th class="text-center" width="5%">

								<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
									<input type="checkbox" class="group-checkable select_all" data-set="#sample_1 .checkboxes">
									<span></span>
								</label>

								</th>

								<th class="text-center" width="5%"> # </th>

								<th width="20%">Department</th>

								<th width="20%">Company</th>

								<th width="10%" class="text-center">Total Members</th>

								<th width="10%" class="text-center"> Added On </th>

								<th width="10%" class="text-center">Status</th>

								<th width="10%" class="text-center">Action</th>

							</tr>

						</thead>

						<tbody>



						<?php $i = 1; foreach ($datares as $key => $department) {

							

						?>

						

							<tr>

								<td class="text-center">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input name="usercheck" type="checkbox" class="checkboxes" id="chk_<?= $department['id'] ?>" />
										<span></span>
									</label>
								</td>

								<td class="text-center"><?=$i?></td>

								<td><?= $department['department_name']?></td>

								<td>Digital Sports</td>

								<td class="text-center"><?=$department['cid']?></td>

								<!-- <td class="text-center"><?=$department['created_at']?></td> -->

								<td class="text-center"><?=date('d-m-Y',strtotime($department['created_at']))?></td>

								

								<td class="text-center"><span class="label label-sm label-success" style="<?= $department['isactive'] == 1?'':'background-color:red !important'?>"><?= $department['isactive'] == 1?'Active':'Deactivate'?></span></td>


								<td class="text-center">

									<a href="<?= base_url('apcompundpower/user_rights/'.$department['id'].'') ?>" class="btn btn-outline btn-circle btn-xs blue" >

										<i class="fa fa-edit"></i> Manage

									</a>

								</td>

							</tr>	

						<?php $i++; }  ?>						

						</tbody>

					</table>

			

				<div class="margiv-top-10">

					<button class="btn green btn-sm req_actionbtn" data-tbl="<?= base64_encode('admin_department') ?>" data-type="admin_department" value="1"  data-column="isactive">Activate Selected</button>

					<button class="btn red btn-sm req_actionbtn" data-tbl="<?= base64_encode('admin_department') ?>" data-type="admin_department" value="0" data-column="isactive">Deactivate Selected</button>

				</div>

			</div>

		</div>

		<!-- END BORDERED TABLE PORTLET-->

	</div>

</div>

<div id="responsive" class="modal mymodl fade" tabindex="-1" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

				<h4 class="modal-title">Add Departments</h4>

			</div>

			<div class="modal-body">

				<div  data-always-visible="1" data-rail-visible1="1">

					<div class="row">

						<div class="col-md-12">

							<div class="portlet-body form">

								<!-- BEGIN FORM-->

								<form action="" class="form-horizontal" id="newModalForm_dep"> 

									<div class="form-body">

										<div class="form-group">

											<label class="col-md-4 control-label">Department Name</label>

											<div class="col-md-8">

												<input type="text" name="department_name" id="depName" class="form-control input-circle" placeholder="Enter text" >

												<span class="help-block">Name of a new deprtment.</span>

											</div>

										</div>

										<div class="form-group">

											<label class="col-md-4 control-label">Company Name</label>

											<div class="col-md-8">

												<select name="Company_id" class="form-control">

                                                    <option value="1" selected="selected">Digital Sports</option>

                                                </select>

											</div>

										</div>



										<div class="form-group text-center">

											<label class="mt-checkbox mt-checkbox-outline"> Select to Activate/Deactivate 

												<input type="checkbox" value="1" name="isactive">

												<span></span>

											</label>

										</div>
										<div class="form-group text-center">
									<div class="col-md-offset-3 col-md-9">

									<input type="submit" class="btn btn-circle green submit" id="add" value="Add Department">

									<input type="button" class="btn btn-circle red btn-outline" data-dismiss="modal" aria-hidden="true" value="Close">
									</div>	
								</div>

									</div>
				
 
		<div class="modal-footer">

			
			</div>

		</div>


								</form>

								<!-- END FORM-->

							</div>

						</div>

					</div>

				</div>

			</div>


	</div>

</div>



