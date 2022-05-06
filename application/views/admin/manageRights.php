<!-- BEGIN CONTENT -->

<div class="page-content-wrapper">

	<!-- BEGIN CONTENT BODY -->

	<div class="page-content">



		<!-- END THEME PANEL -->

		<h1 class="page-title"> Assign Permissions

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

					<span>Permissions</span>

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

					<span class="caption-subject font-dark bold uppercase">Permissions List</span>

				</div>

				<a href="<?=$_SERVER['HTTP_REFERER']?>" class="btn btn-sm btn-warning pull-right" style="margin-top: 5px; margin-right: 5px;"><i class="fa fa-arrow-left"></i> Go Back</a>

			</div>

			<div class="portlet-body">

				<div class="table-scrollable">
				<form action="<?=base_url()?>apcompundpower/selectval" method="post" id="myselectmultiple" >
					<input type="hidden" name="user_id" value="<?=$depid?>">
					<!-- <table class="table table-bordered table-hover" id="sample_1"> -->
						<table class="table table-bordered table-hover" >

						<thead>

							<tr>

								<!-- <th class="text-center" width="5%">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable select_all" data-set="#sample_1 .checkboxes">
										<span></span>
									</label>

								</th> -->
								<th class="text-center" width="10%"> # </th>

								<th width="40%"> Permissions </th>

								<th width="10%" class="text-center"> View </th>

								<th width="10%" class="text-center">Add</th>

								<th width="10%" class="text-center">Edit/Update</th>

								<th width="10%" class="text-center">Delete</th>

								

							</tr>

						</thead>

						<tbody>

							<tr>

								<!-- <td class="text-center">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input name="usercheck" type="checkbox" class="checkboxes" id="chk_" />
										<span></span>
									</label>
								</td> -->

								<td class="text-center" style="vertical-align: middle;">

									#

								</td>

								<td style="vertical-align: middle;">

									Select All Modules >>>>

								</td>


								<th class="text-center" width="5%">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable select_all_view" data-set="#sample_1">
										<span></span>
									</label><br>Select All

								</th>

								

								<th class="text-center" width="5%">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable select_all_add" data-set="#sample_1 ">
										<span></span>
									</label><br>Select All

								</th>

								<th class="text-center" width="5%">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable select_all_edit" data-set="#sample_1 ">
										<span></span>
									</label><br>Select All

								</th>

								<th class="text-center" width="5%">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input type="checkbox" class="group-checkable select_all_delete" data-set="#sample_1 ">
										<span></span>
									</label><br>Select All

								</th>

							</tr>


						
							<tr>

							<?php
							$i= 1;
								foreach ($menu as $key => $menus) {
							?>
								<!-- <td class="text-center">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
										<input name="usercheck" type="checkbox" class="checkboxes" id="chk_" />
										<span></span>
									</label>
								</td> -->

								<td class="text-center">

									<?=$i?>

								</td>

								<td data-id="<?=$menus['privileges_menu']?>">

									<?=$key?>

								</td>

								<td class="text-center">
									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
									<?php
										if(in_array(1, $menus['permission_id']))
										{
									?>
										<input  type="checkbox" class="checkboxes_view" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="1" checked />
									<?php
										}else{
									?>
										<input  type="checkbox" class="checkboxes_view" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="1" />
									<?php
										}
									?>
										
										<span></span>
									</label>
								</td>

								<td class="text-center">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">

									<?php
										if ($key == "Manage Notification") 
										{			
									?>
										<input  type="checkbox" class="checkboxes_add" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="2" <?=in_array(2, $menus['permission_id'])?'checked':''?>/>
									<?php
										}else{
									?>
										<input disabled type="checkbox" class="checkboxes_add" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="2" />
									<?php
										}
									?>
										
										<span></span>
									</label>
								</td>

								<td class="text-center">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
									<?php
										if(in_array(3, $menus['permission_id']))
										{
									?>
										<input  type="checkbox" class="checkboxes_edit" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="3" checked/>
									<?php
										}elseif($key != "Network Exploring" && $key != "Team Summary" &&  $key != "Manage Networks" && $key != "Manage Earnings"  && $key != "Cashback Earnings"  && $key != "Level Cashback" && $key != "Appraisel Bonus"  && $key != "Club Royality"  && $key != "Passive Cashback"  && $key != "All Purchase" && $key != "paid"  && $key != "cancelled" && $key != "Manage Notification")
										{
									?>
										<input  type="checkbox" class="checkboxes_edit" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="3" />
									<?php
										}else{
									?>
										<input disabled type="checkbox" class="checkboxes_edit" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="3" />
									<?php		
										}
									?>
										
										<span></span>
									</label>
								</td>

								<td class="text-center">

									<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
									
										<input  disabled type="checkbox" class="checkboxes_delete" name="Menu_<?=$menus['pid']?>[]" id="chk_" value="4" />
									
										<span></span>
									</label>
								</td>

							</tr>

							<?php			
							$i++;	}
							?>
					
						</tbody>

					</table>

				</div>
			<!-- 	<div class="margiv-top-10">
					
				</div> -->
				<input type="submit" class="btn green" id="submitselect" value="Update Changes">
			</form>
			</div>

		</div>

		<!-- END BORDERED TABLE PORTLET-->

	</div>

</div>



<!-- <div class="margiv-top-10">

	<a href="javascript:;" class="btn green"> Update Changes </a>

	<a href="javascript:;" class="btn red"> Cancel </a>

</div> -->