<? 
//echo "<pre>"; print_r($datapopup); die();

?>
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

		<h1 class="page-title"> Manage POP UP

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

					<span>Manage POP-up</span>

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

					<span class="caption-subject font-dark bold uppercase">POP up List</span>

				</div>

				<!--<a data-toggle="modal" href="#responsive" class="btn btn-sm btn-info pull-right" style="margin-top: 5px; margin-right: 5px;"><i class="fa fa-plus"></i> Add Department</a>-->

			</div>

			<div class="portlet-body">

			

					<table class="table table-bordered table-hover" id="sample_1">

						<thead>

							<tr>

								<th class="text-center" width="5%"> # </th>

								<th width="30%" class="text-center">Name</th>
								
                                <th width="20%" class="text-center">Image</th>
                                    
								<th width="10%" class="text-center">Status</th>

								<th width="10%" class="text-center">Action</th>

							</tr>

						</thead>

						<tbody>



						<?php $i = 1; foreach ($datapopup as $key => $pop) {
						
						$img = '<a target="_blank" href="' . base_url() . $pop['path'] . $pop['image'] . '"> <img src="' . (($pop['image'] != "") ?
                                            base_url() . $pop['path'] . $pop['image'] : '' . base_url() . '') . ' " style="width:80px"></a>';

						?>
							<tr>
								<td class="text-center"><?=$i?></td>
                                <td class="text-center"><?= $pop['name']?></td>
                                <td class="text-center" style="max-width:100px;">
                                            <?= $img ?> </td>
								<td class="text-center"><span class="label label-sm label-success" style="<?= $pop['isactive'] == 0 ?'':'background-color:red !important'?>"><?= $pop['isactive'] == 0 ?'Active':'Deactivate'?></span></td>
                                <td class="text-center">
                                        <a id ="m_popup" data-popup_id="<?= $pop['id']?>" data-popup_name="<?= $pop['name']?>" data-status="<?= $pop['isactive']?>" class="btn btn-outline btn-circle btn-xs blue" >
                                            <i class="fa fa-edit"></i> Manage
                                        </a>
                                </td>
							</tr>	

						<?php $i++; }  ?>						

						</tbody>

					</table>

			</div>

		</div>

		<!-- END BORDERED TABLE PORTLET-->

	</div>

</div>

<div id="m_popup_model" class="modal mymodl_update_mpopup fade" tabindex="-1" aria-hidden="true">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

				<h4 class="modal-title">Manage POP-Up</h4>

			</div>

			<div class="modal-body">

				<div  data-always-visible="1" data-rail-visible1="1">

					<div class="row">

						<div class="col-md-12">

							<div class="portlet-body form">

								<!-- BEGIN FORM-->

								<form class="form-horizontal" id="Form_manage_popup" data-action = "<?= base_url() ?>/apcompundpower/update_mpopup"> 

                                    <input id= "popup_id" type="hidden" name="popup_id" value=""> 
									<div class="form-body">

										<div class="form-group">

											<label class="col-md-4 control-label">Name</label>

											<div class="col-md-8">

												<input type="text" name="popup_name" id="popup_name" class="form-control input-circle" placeholder="Enter Name" Readonly>

												<span class="help-block">Name of a POP up.</span>

											</div>

										</div>

										<div class="form-group">

											<label class="col-md-4 control-label">Select For Active / Deactive</label>

											<div class="col-md-8">
											    <select name="status" class="form-control">
											        <option value="0">Active</option>
											        <option value="1">De - Active</option>
											     </select>
											</div>

										</div>

										<div class="form-group text-center">
									<div class="col-md-offset-3 col-md-9">

									<input type="submit" class="btn btn-circle green submit" id="add" value="Update">

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

<script>
$("#m_popup").click(function(e) {
      
        var popup_id = $(this).attr('data-popup_id');
        var popup_name = $(this).attr('data-popup_name');
         var popup_status = $(this).attr('data-status');
        
         $('#popup_id').val(popup_id);
         $('#popup_name').val(popup_name);
         
        $('#m_popup_model').modal('show');
        
    });
</script>
