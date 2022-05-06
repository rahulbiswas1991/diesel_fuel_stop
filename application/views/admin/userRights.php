<style type="text/css">
	label.error {
    color: red;
}
</style>
<!-- BEGIN CONTENT -->

<div class="page-content-wrapper">

	<!-- BEGIN CONTENT BODY -->

	<div class="page-content">



		<!-- END THEME PANEL -->

		<h1 class="page-title"> Manage Users Rights

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

					<span>User Rights</span>

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

					<span class="caption-subject font-dark bold uppercase">Manage User's Rights</span>

				</div>

				<a data-toggle="modal" href="#responsive" class="btn btn-sm btn-info pull-right" style="margin-top: 5px; margin-right: 5px;"><i class="fa fa-plus"></i> Add User</a>

				<a href="/apcompundpower/departments" class="btn btn-sm btn-warning pull-right" style="margin-top: 5px; margin-right: 5px;"><i class="fa fa-arrow-left"></i> Go Back</a>

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

								<th width="20%"> Full Name </th>

								<th width="20%"> Email ID </th>

								<th width="20%"> Company Name </th>

								<th width="10%"> Department </th>

								<th width="10%">Mobile</th>

								<th width="10%" class="text-center"> Added On </th>

								<th width="5%" class="text-center">Status</th>

								<th width="5%" class="text-center">Action</th>

							</tr>

						</thead>

						<tbody>

						<?php $i = 1; foreach ($users as $key => $depuser) {
						?>
							<tr>

								<td class="text-center">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input name="usercheck" type="checkbox" class="checkboxes" id="chk_<?= $depuser['id'] ?>" />
										<span></span>
									</label>
								</td>

								<td class="text-center"><?=$i?></td>

								<td>

									<?=$depuser['username']?>								

								</td>

								<td>

									<?=$depuser['email']?>	

								</td>

							

								<td>Digital Sports</td>
								
								
								<td class=""><?=$depuser['department_name']?></td>

								
								<td class=""><?=$depuser['mobile']?></td>

								<td class="text-center"><?=date('d-m-Y',strtotime($depuser['created_date']))?>	</td>

								<td class="text-center"><span class="label label-sm label-success" style="<?= $depuser['isactive'] == 1?'':'background-color:red !important'?>"><?= $depuser['isactive'] == 1?'Active':'Deactivate'?></span></td>

								<td class="text-center">

									<a href="<?= base_url('apcompundpower/ManageRights/'.$depuser['id'].'') ?>"  class="btn btn-outline btn-circle btn-xs blue">

										<i class="fa fa-edit"></i> Manage

									</a>

								</td>

							</tr>
						<?php $i++; }  ?>		

						</tbody>

					</table>

				<div class="margiv-top-10">

					<button class="btn green btn-sm req_actionbtn" data-tbl="<?= base64_encode('admin') ?>" data-type="admin" value="1"  data-column="isactive">Activate Selected</button>

					<button class="btn red btn-sm req_actionbtn" data-tbl="<?= base64_encode('admin') ?>" data-type="admin" value="0" data-column="isactive">Deactivate Selected</button>

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

				<h4 class="modal-title">Add User</h4>

			</div>

			<div class="modal-body">

				<div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible1="1">

					<div class="row">

						<div class="col-md-12">

							<div class="portlet-body form">

								<!-- BEGIN FORM-->

								<form class="form-horizontal" id="DepModalForm" method="post" name="myformid">

									<div class="form-body">

										<div class="form-group">

											<label class="col-md-4 control-label">Full Name</label>

											<div class="col-md-8">

												<input type="hidden" name="department_id" id="department_id" value="<?=$depid?>">
												<input type="hidden" name="role" id="role" value="user">

												<input type="text" name="username" id="username" class="form-control input-circle" placeholder="Enter text" required>
												
												

											</div>

										</div>

										<div class="form-group">

											<label class="col-md-4 control-label">Email Address</label>

											<div class="col-md-8">

												<div class="input-group">

													<span class="input-group-addon input-circle-left">

														<i class="fa fa-envelope"></i>

													</span>

													<input type="email" name="email" id="email" class="form-control input-circle-right" placeholder="Email Address" required>

												</div>

												

											</div>

										</div>

										<div class="form-group">

											<label class="col-md-4 control-label">Mobile Number</label>

											<div class="col-md-8">

												<div class="input-group">

													<span class="input-group-addon input-circle-left">

														<i class="fa fa-phone"></i>

													</span>

													<input type="text" name="mobile" id="mobile" class="form-control input-circle-right" placeholder="Mobile Numebr" required>

												</div>

												

											</div>

										</div>

										<div class="form-group">

											<label class="col-md-4 control-label">Password</label>

											<div class="col-md-8">

												<div class="input-group">

													<input type="text" name="password" id="password" class="form-control input-circle-right" placeholder="password" required>

													<input type="button" class="button" id="pwdid" value="Generate"  tabindex="2">

												</div>

												

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
													<input type="submit" class="btn btn-circle green submitUser" id="submitUser" value="Add User">

													<input type="button" class="btn btn-circle red btn-outline" data-dismiss="modal" aria-hidden="true" value="Close">
												</div>
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

	</div>

</div>