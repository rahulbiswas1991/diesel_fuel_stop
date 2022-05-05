<?php
      $path = base_url();
      $this->load->helper('comman_helper');
?>
<style>
    .page-content {
	   background: #eef1f5 none repeat scroll 0 0;
    }
</style>
	<!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->  
		        <!-- BEGIN PAGE BAR -->
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="dashboard">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span>User</span>
                        </li>
                    </ul>
                </div>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
               <h1 class="page-title">User Profile</h1>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PROFILE SIDEBAR -->
                                <div class="profile-sidebar">
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive image" alt=""> 
											<div class="middle">
												<div class="text">Edit</div>
											</div>
										</div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> <?=$user_data->name?> </div>
                                            <div class="profile-usertitle-job"> Meth<?=sprintf('%05d', $user_data->id);?> </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <!-- SIDEBAR BUTTONS -->
                                        <div class="profile-userbuttons">
                                            <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                                            <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                        </div>
                                        <!-- END SIDEBAR BUTTONS -->
                                        <!-- SIDEBAR MENU -->
                                        <div class="profile-usermenu">
                                            <ul class="nav">
                                                <li class="active">
                                                    <a href="profile">
                                                        <i class="icon-settings"></i> Profile Settings </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_1_3" data-toggle="tab">
                                                        <i class="icon-info"></i> Change Password </a>
                                                </li>
												<li>
                                                            <a href="#tab_1_4" data-toggle="tab">
															 <i class="icon-info"></i> KYC</a>
                                                        </li>
                                            </ul>
                                        </div>
                                        <!-- END MENU -->
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                </div>
                                <!-- END BEGIN PROFILE SIDEBAR -->
                                <!-- BEGIN PROFILE CONTENT -->
                                <div class="profile-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title tabbable-line">
                                                    <div class="caption caption-md">
                                                        <i class="icon-globe theme-font hide"></i>
                                                        <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                    </div>
                                                    <ul class="nav nav-tabs">
                                                        <li class="active">
                                                            <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                                        </li>
                                                        <li>
                                                            <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                                        </li>
														<li>
                                                            <a href="#tab_1_4" data-toggle="tab">KYC</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="tab-content">
                                                        <!-- PERSONAL INFO TAB -->
                                                        <div class="tab-pane active" id="tab_1_1">
                                                            <form role="form" action="<?=base_url()?>process/edit_user_profile" method="post">
																<div class="form-group">
																	<div class="row">
																		<div class="col-sm-6">
																			<label class="control-label">First Name</label>
																			<input type="text" name="f_name" value="<?=$user_data->f_name?>" class="form-control" /> 
																		</div>
																		<div class="col-sm-6">
																			<label class="control-label">Last Name</label>
																			<input type="text" name="l_name" value="<?=$user_data->l_name?>" class="form-control" /> 
																		</div>
																	</div>
																</div>
																
																<div class="form-group">
																	<div class="row">	
																		<div class="col-sm-6">
																			<label class="control-label">Phone Number</label>
																			<input type="text" name="phone" value="<?=$user_data->phone?>" class="form-control" /> 
																		</div>
																		<div class="col-sm-6">
																			<label class="control-label">My Email Id</label>
																			<input type="email" name="email" value="<?=$user_data->email?>" class="form-control" /> 
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<div class="row">
																		<div class="col-sm-6">
																			<label class="control-label">Date of Birth</label>
																			<input class="form-control date-picker" name="dob" size="16" type="text"value="<?=$user_data->dob?>" />
																		</div>
																		<div class="col-sm-6">
																			<label class="control-label">Gender</label>
																			<select class="form-control">
																				<option>Male</option>
																				<option>Female</option>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<div class="row">
																		<div class="col-sm-6">
																			<label class="control-label">State/Province</label>
																			<input type="text" name="state" value="<?=$user_data->state?>" class="form-control" />
																		</div>
																		<div class="col-sm-6">
																			<label class="control-label">City</label>
																			<input type="text" name="city" value="<?=$user_data->city?>" class="form-control" /> 
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<div class="row">
																		<div class="col-sm-6">
																			<label class="control-label">Country</label>
																			<select class="form-control">
																				<option value="<?=$user_data->country?>"></option>
																			</select>
																		</div>
																		<div class="col-sm-6">
																			<label class="control-label">Postal Code</label>
																			<input type="text" name="zip_code" value="<?=$user_data->zip_code?>" class="form-control" /> 
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<div class="row">
																		
																		<div class="col-sm-12">
																			<label class="control-label">Address</label>
																			<input type="text" name="address" value="<?=$user_data->address?>" class="form-control" /> 
																		</div>
																	</div>
																</div>
                                                                <div class="margiv-top-10">
                                                                    <button type="submit" class="btn green"> Save Changes </button>
                                                                    <button type="reset" class="btn default"> Cancel </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END PERSONAL INFO TAB -->
                                                        <!-- CHANGE PASSWORD TAB -->
                                                        <div class="tab-pane" id="tab_1_3">
                                                            <form action="#">
                                                                <div class="form-group">
                                                                    <label class="control-label">Current Password</label>
                                                                    <input type="password" class="form-control" /> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">New Password</label>
                                                                    <input type="password" class="form-control" /> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Re-type New Password</label>
                                                                    <input type="password" class="form-control" /> </div>
                                                                <div class="margin-top-10">
                                                                    <a href="javascript:;" class="btn green"> Change Password </a>
                                                                    <a href="javascript:;" class="btn default"> Cancel </a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- END CHANGE PASSWORD TAB -->
														<div class="tab-pane" id="tab_1_4">
                                                            <form action="#">
																<div class="row">
																	<div class="col-sm-12">
																		<h4 style="color:#000;margin-bottom:20px;font-weight:normal">Select Id</h4>
																	</div>
																	<div class="col-sm-6">
																		<div class="displaying-image-style">
																		<h4>National Id</h4>
																			<img id="blah" src="#" alt="" />
																		</div>
																		<div class="file-upload">
																			<label for="upload" class="file-upload__label">Upload Document <img src="../assets/pages/media/profile/upload.png" style="float:right;"></label>
																			<input id="upload" class="file-upload__input" type="file" name="file-upload" onchange="readURL(this);">
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="displaying-image-style1">
																		<h4>Address Proof</h4>
																			<img id="blah1" src="#" alt="" />
																		</div>
																		<div class="file-upload1">
																			<label for="upload1" class="file-upload__label1">Upload Document <img src="../assets/pages/media/profile/upload.png" style="float:right;"></label>
																			<input id="upload1" class="file-upload__input1" type="file" name="file-upload1" onchange="read_URL(this);">
																		</div>
																	</div>
																</div>
																<br>
															</form>
														</div>
				
				
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
				
				
				<script>
function readURL(input) {
	//alert('ewter');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width()
                    .height();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
function read_URL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah1')
                    .attr('src', e.target.result)
                    .width()
                    .height();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>