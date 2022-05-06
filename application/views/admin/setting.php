<?php
  $path = base_url();
  $this->load->helper('comman_helper');
?>

	<!-- ############ Content START-->
	<div id="content" class="app-content box-shadow-0" role="main">
	    <!-- Main -->
		<div class="content-main " id="content-main">
		  <div class="d-sm-flex">
			<div class="w w-auto-xs light bg bg-auto-sm b-r">
			  <div class="py-3">
				<div class="nav-active-border left b-primary">
				  <ul class="nav flex-column nav-sm">
					<li class="nav-item">
					  <a class="nav-link active" href="#" data-toggle="tab" data-target="#profile">Profile</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link " href="#" data-toggle="tab" data-target="#account_sets">Account Settings</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link " href="#" data-toggle="tab" data-target="#email">Emails</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link " href="#" data-toggle="tab" data-target="#kyc">Manage KYC</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link " href="#" data-toggle="tab" data-target="#security">Security</a>
					</li>
				  </ul>
				</div>
			  </div>
			</div>
			<div class="col p-0">
			  <div class="tab-content pos-rlt">
				<div class="tab-pane active" id="profile">
				  <div class="p-4 b-b _600">Public profile</div>
				  <form role="form" class="p-4 col-md-6" enctype="multipart/form-data" name="update_profile" id="update_profile" method="post" data-action="<?=base_url()?>edit-profile">
					<div class="form-group">
					  <label>Profile picture</label>
					  <div class="form-group niupdiv">
					  <div class="form-file">
						<input type="file" name="profile_pic" id="profile_pic">
						<button class="btn white">Upload new picture</button>
					  </div>
					  </div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="u_fname">First Name</label>
							<input value="<?=$setting->first_name!=''?$setting->first_name:'';?>" id="u_fname" class="form-control" type="text" placeholder="Enter First Name" name="u_fname">
						</div>
						
						<div class="form-group col-md-6">
							<label for="u_lname">Last Name</label>
							<input value="<?=$setting->last_name!=''?$setting->last_name:'';?>" id="u_lname" class="form-control" type="text" placeholder="Enter Last Name" name="u_lname">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="u_dob">Date of Birth</label>
							<input readonly="readonly" value="<?=$setting->dob!=''?change_date_format($setting->dob,"m/d/Y"):'';?>" id="u_dob" class="form-control datetimepicker" type="text" placeholder="Enter Date of Birth" name="u_dob">
						</div>
						
						<div class="form-group col-md-6">
							<label for="u_address">Address</label>
							<textarea placeholder="Enter Full Address" id="u_address" name="u_address"><?=$setting->address!=''?$setting->address:'';?></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="u_city">City</label>
							<input value="<?=$setting->city!=''?$setting->city:'';?>" id="u_city" class="form-control" type="text" placeholder="Enter City Name" name="u_city">
						</div>
						
						<div class="form-group col-md-6">
							<label for="u_state">State/Province</label>
							<input value="<?=$setting->state!=''?$setting->state:'';?>" id="u_state" class="form-control" type="text" placeholder="Enter Stete/Province Name" name="u_state">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="u_country">Country</label>
							<select name="u_country" id="u_country" style="width: 100%;">
                            	<option value="">Select Country</option>
                            	<?php 
                            	  if(!empty($countries)){
                            		foreach($countries as $obj){
                            	?>
                            	<option value="<?=$obj->id?>" data-code="<?=$obj->std_code?>" <?=$obj->title==$setting->country?'selected="selected"':''?>><?=$obj->title?></option>
                            	<?php }}?>
                            </select>
						</div>
						
						<div class="form-group col-md-6">
							<label for="u_pincode">Postal Code</label>
							<input value="<?=$setting->zip_code!=''?$setting->zip_code:'';?>" id="u_pincode" class="form-control" type="text" placeholder="Enter Postal Code" name="u_pincode">
						</div>
					</div>
					
					<button type="submit" class="btn primary mt-2">Update</button>
				  </form>
				</div>
				<div class="tab-pane" id="account_sets">
				  <div class="p-4 b-b _600">Account settings</div>
				  <form role="form" class="p-4 col-md-6">
					<div class="form-group">
					  <label>Client ID</label>
					  <input type="text" disabled class="form-control" value="d6386c0651d6380745846efe300b9869">
					</div>
					<div class="form-group">
					  <label>Secret Key</label>
					  <input type="text" disabled class="form-control" value="3f9573e88f65787d86d8a685aeb4bd13">
					</div>
					<div class="form-group">
					  <label>App Name</label>
					  <input type="text" class="form-control">
					</div>
					<div class="form-group">
					  <label>App URL</label>
					  <input type="text" class="form-control">
					</div>
					<button type="submit" class="btn primary m-t">Update</button>
				  </form>
				</div>
				<div class="tab-pane" id="email">
				  <div class="p-4 b-b _600">Emails</div>
				  <form role="form" class="p-4 col-md-6">
					<p>E-mail me whenever</p>
					<div class="checkbox">
					  <label class="ui-check">
						<input type="checkbox"><i class="dark-white"></i> Anyone posts a comment
					  </label>
					</div>
					<div class="checkbox">
					  <label class="ui-check">
						<input type="checkbox"><i class="dark-white"></i> Anyone follow me
					  </label>
					</div>
					<div class="checkbox">
					  <label class="ui-check">
						<input type="checkbox"><i class="dark-white"></i> Anyone send me a message
					  </label>
					</div>
					<div class="checkbox">
					  <label class="ui-check">
						<input type="checkbox"><i class="dark-white"></i> Anyone invite me to group
					  </label>
					</div>
					<button type="submit" class="btn primary mt-2">Update</button>
				  </form>
				</div>
				<div class="tab-pane" id="kyc">
				  <div class="p-4 b-b _600">KYC</div>
				  <form role="form" class="p-4 col-md-10" enctype="multipart/form-data" name="kyc_upload" id="kyc_upload" method="post" data-action="<?=base_url()?>kyc-submit">
							<div class="row">
					<div class="col-sm-6">
						<div class="displaying-image-style">
						<h4>National Id</h4>
							<img id="blah" src="#" alt="" />
						</div>
						<div class="form-group niupdiv">
						<div class="file-upload">
							<label for="upload" class="file-upload__label">Upload Document <img src="<?=$path?>assets/images/upload.png" style="float:right;"></label>
							<input id="national_id" class="file-upload__input" type="file" name="national_id" onchange="readURL(this);">
						</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="displaying-image-style1">
						<h4>Address Proof</h4>
							<img id="blah1" src="#" alt="" />
						</div>
						<div class="form-group apupdiv">
						<div class="file-upload1">
							<label for="upload1" class="file-upload__label1">Upload Document <img src="<?=$path?>assets/images/upload.png" style="float:right;"></label>
							<input id="address_proof" class="file-upload__input1" type="file" name="address_proof" onchange="read_URL(this);">
						</div>
						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<button type="text" class="btn primary btn-sm p-x-md" id="text" value="+ 91" style="text-align:center;">Submit KYC</button>
						</div>
					</div>
				</div>
						
				  </form>
				</div>
				<div class="tab-pane" id="security">
				  <div class="p-4 b-b _600">Security</div>
				  <div class="p-4">
					<div class="clearfix">
					  <form id="change_upass" role="form" class="col-md-6 p-0" method="post" data-action="<?=base_url()?>change-password">
						<div class="form-group">
						  <label>Old Password</label>
						  <input type="password" class="form-control" name="u_oldpass">
						</div>
						<div class="form-group">
						  <label>New Password</label>
						  <input type="password" class="form-control" name="u_newpass">
						</div>
						<div class="form-group">
						  <label>New Password Again</label>
						  <input type="password" class="form-control" name="u_cnewpass">
						</div>
						<button type="submit" class="btn primary mt-2">Update</button>
					  </form>
					</div>

					<p class="mt-4"><strong>Delete account?</strong></p>
					<button type="submit" class="btn danger m-t" data-toggle="modal" data-target="#modal">Delete Account</button>

				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  </div>
		  <!-- .modal -->
		  <div id="modal" class="modal fade animate black-overlay" data-backdrop="false">
			<div class="modal-dialog modal-sm">
			  <div class="modal-content flip-y">
				<div class="modal-body text-center">          
				  <p class="py-3 mt-3"><i class="fa fa-remove text-warning fa-3x"></i></p>
				  <p>Are you sure to delete your account?</p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn white" data-dismiss="modal">No</button>
				  <button type="button" class="btn danger" data-dismiss="modal">Yes</button>
				</div>
			  </div><!-- /.modal-content -->
			</div>
		  </div>
		  <!-- / .modal -->
		

<!-- ############ Main END-->


<script>
function readURL(input) {
	//alert('ewter');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
function read_URL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah1').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>