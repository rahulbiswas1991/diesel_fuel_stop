<?php
  $path = base_url();
  $this->load->helper('comman_helper');
  
  ?>
  <style>
		.page-content {
			background: #eef1f5 none repeat scroll 0 0;
		}
	  .widget-box , .widget-box:hover{
		color: #333;
		text-decoration: none;
		}
		.widget-box:hover .m-widget1__item , .widget-box-selected{
			border: 1px solid !important;
			box-shadow: 0 0 5px #ccc;
		}
		.m-widget1__item {
			border: 1px solid #ccc;
		}
		.close.card-close {
		  opacity: 0.6;
		  position: absolute;
		  right: 25px !important;
		  top: 10px !important;
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
                                    <a href="Dashboard">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>User</span>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Edit User Profile
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
							<!-- BEGIN ACCORDION PORTLET-->
                                <div class="portlet box white">
                                    <div class="portlet-title">
                                        <div class="caption">
											Edit Detail
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"> </a>
                                            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                                            <a href="javascript:;" class="reload"> </a>
                                            <a href="javascript:;" class="remove"> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="panel-group accordion" id="accordion3">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> Personal Information </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_3_1" class="panel-collapse in">
                                                    <div class="panel-body">
														<form class="form-horizontal" role="form">
															<div class="form-body">
																<div class="row">
																	<div class="col-sm-6">
																			<label class="control-label">User Name</label>
																			<input class="form-control" type="text" placeholder="Enter User Name">
																	</div>
																	<div class="col-sm-6">
																			<label class="control-label">First Name</label>
																			<input class="form-control" type="text" placeholder="Enter First Name">
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-6">
																			<label class="control-label">Last Name</label>
																			<input class="form-control" type="text" placeholder="Enter Last Name">
																	</div>
																	<div class="col-sm-6">
																			<label class="control-label">Email ID</label>
																			<input class="form-control" type="text" placeholder="Enter Email ID">
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-6">
																			<label class="control-label">Date of Birth</label>
																			<input class="form-control date-picker" size="16" type="text" placeholder="Date of Birth" value="" />
																	</div>
																	<div class="col-sm-6">
																			<label class="control-label">Phone Number</label>
																			<input class="form-control" type="text" placeholder="Enter Phone Number">
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-6">
																			<label class="control-label">Country</label>
																			<input class="form-control" type="text" placeholder="Enter Country">
																	</div>
																	<div class="col-sm-6">
																			<label class="control-label">City</label>
																			<input class="form-control" type="text" placeholder="Enter City">
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-6">
																			<label class="control-label">State</label>
																			<input class="form-control" type="text" placeholder="Enter State">
																	</div>
																	<div class="col-sm-6">
																			<label class="control-label">Zip code</label>
																			<input class="form-control" type="text" placeholder="Enter Zip code">
																	</div>
																</div>
																<div class="row">
																	<div class="col-sm-12">
																			<label class="control-label">Address</label>
																			<input class="form-control" type="text" placeholder="Enter Address">
																	</div>
																</div>
																<br>
																<div class="row">
																	<div class="col-sm-12">
																		<button class="btn btn-success" type="button">Update Information</button>
																	</div>
																</div>
																<br>
															</div>
														</form>
													</div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2">KYC</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_3_2" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
															<div class="col-sm-6">
																<div class="form-group">
																	<div class="displaying-image-style">
																		<h5>National Id</h5>
																		<img id="blah" alt="" src="../assets/images/id-card.png">
																		<br>
																		<div class="row">
																			<div class="col-sm-12" style="text-align:center;">
																				<label class="mt-radio">
																					<input type="radio" name="optionsRadios" id="optionsRadios22" value="option1" checked>Approved
																					<span></span>
																				</label>
																				<label class="mt-radio">
																					<input type="radio" name="optionsRadios" id="optionsRadios23" value="option2" checked>Declined
																					<span></span>
																				</label>
																			</div>
																		</div>
																	</div>
																	<div class="col-sm-12 listing-class"> </div>
																	
																</div>
																
															</div>
															<div class="col-sm-6">
																<div class="form-group">
																	<div class="displaying-image-style">
																		<h5>Address Proof</h5>
																		<img id="blah" alt="" src="../assets/images/id-card.png">
																		<br>
																		<div class="row">
																			<div class="col-sm-12" style="text-align:center;">
																				<label class="mt-radio">
																					<input type="radio" name="optionsRadios" id="optionsRadios44" value="option1" checked>Approved
																					<span></span>
																				</label>
																				<label class="mt-radio">
																					<input type="radio" name="optionsRadios" id="optionsRadios24" value="option2" checked>Declined
																					<span></span>
																				</label>
																			</div>
																		</div>
																	</div>
																	<div class="col-sm-12 listing-class"> </div>
																</div>
															</div>
															<br>
															<div class="col-sm-12" style="text-center;">
															
															</div>
															<br>
														</div>
														
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3">Bank Details</a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_3_3" class="panel-collapse collapse">
                                                    <div class="panel-body">
														<div class="row">
															<div class="col-md-12 ">
																<div id="all_bank_list" class="row">
																	<div id="" class="col-sm-6 col-lg-4">
																		<a class="widget-box bank_info" href="javascript:void(0);">
																			<div class="m-widget1__item">
																				<div class="row m-row--no-padding align-items-center bank-box ">
																					<button class="close card-close" type="button">×</button>
																					<div class="col-xs-9">
																						<h4 class="m-widget1__title">SBI</h4>
																						<span class="m-widget1__desc">12345678901234567890</span>
																					</div>
																					<div class="col-xs-3 m--align-right">
																						<span class="m-widget1__number m--font-brand">
																							<img src="../assets/images/bank.png">
																						</span>
																					</div>
																				</div>
																			</div>
																		</a>
																	</div>
																	<div id="" class="col-sm-6 col-lg-4">
																		<a class="widget-box bank_info" href="javascript:void(0);">
																			<div class="m-widget1__item">
																				<div class="row m-row--no-padding align-items-center bank-box ">
																					<button class="close card-close" type="button">×</button>
																					<div class="col-xs-9">
																						<h4 class="m-widget1__title">SBI</h4>
																						<span class="m-widget1__desc">12345678901234567890</span>
																					</div>
																					<div class="col-xs-3 m--align-right">
																						<span class="m-widget1__number m--font-brand">
																							<img src="../assets/images/bank.png">
																						</span>
																					</div>
																				</div>
																			</div>
																		</a>
																	</div>
																	<div id="" class="col-sm-6 col-lg-4">
																		<a class="widget-box bank_info" href="javascript:void(0);">
																			<div class="m-widget1__item">
																				<div class="row m-row--no-padding align-items-center bank-box ">
																					<button class="close card-close" type="button">×</button>
																					<div class="col-xs-9">
																						<h4 class="m-widget1__title">SBI</h4>
																						<span class="m-widget1__desc">12345678901234567890</span>
																					</div>
																					<div class="col-xs-3 m--align-right">
																						<span class="m-widget1__number m--font-brand">
																							<img src="https://mukh.pixelsoftwares.com/methertech/assets/images/bank.png">
																						</span>
																					</div>
																				</div>
																			</div>
																		</a>
																	</div>
																</div>
															</div>
														</div>
														<h4>Bank Name</h4>
														<div class="row">
															<div class="col-sm-6">
																<label class="control-label">Bank Name</label>
																<input class="form-control" type="text" placeholder="Enter text">
															</div>
															<div class="col-sm-6">
																<label class="control-label">BENEFICIARY NAME</label>
																<input class="form-control" type="text" placeholder="Enter text">
															</div>
														</div>
														<div class="row">
															<div class="col-sm-6">
																<label class="control-label">BENEFICIARY ACCOUNT NO.</label>
																<input class="form-control" type="text" placeholder="Enter text">
															</div>
															<div class="col-sm-6">
																<label class="control-label">SWIFT CODE</label>
																<input class="form-control" type="text" placeholder="Enter text">
															</div>
														</div>
														<div class="row">
															<br>
															<div class="col-sm-12">
																<button class="btn btn-success" type="button">Approve</button>
																<button class="btn btn-danger" type="button">Decline</button>
															</div>
															<br>
														</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END ACCORDION PORTLET-->
							</div>
						</div>
					</div>
				</div>