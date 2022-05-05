 <?php
  $path = base_url();
  $this->load->helper('comman_helper');
  
  ?>
	<!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->  
		  <!-- BEGIN PAGE BAR -->
		  <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="dashboard">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Bank Details</span>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> User Bank Details
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12 ">
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption ">
                                            <i class="fa fa-bank"></i>
                                            <span class="caption-subject bold uppercase">User Banks</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="row">
												<div class="col-sm-6 col-lg-3">
														<div class="m-widget1__item">
															<div class="row m-row--no-padding align-items-center bank-box ">
																<div class="col-xs-9">
																	<h4 class="m-widget1__title">Bank Name</h4>
																	<span class="m-widget1__desc">Account Number</span>
																</div>
																<div class="col-xs-3 m--align-right">
																	<span class="m-widget1__number m--font-brand"><IMG SRC="<?=base_url();?>assets/images/bank.png"></span>
																</div>
															</div>
														</div>
												</div>
												<div class="col-sm-6 col-lg-3">
														<div class="m-widget1__item">
															<div class="row m-row--no-padding align-items-center bank-box ">
																<div class="col-xs-9">
																	<h4 class="m-widget1__title">Bank Name</h4>
																	<span class="m-widget1__desc">Account Number</span>
																</div>
																<div class="col-xs-3 m--align-right">
																	<span class="m-widget1__number m--font-brand"><IMG SRC="<?=base_url();?>assets/images/bank.png"></span>
																</div>
															</div>
														</div>
												</div>
												<div class="col-sm-6 col-lg-3">
														<div class="m-widget1__item">
															<div class="row m-row--no-padding align-items-center bank-box ">
																<div class="col-xs-9">
																	<h4 class="m-widget1__title">Bank Name</h4>
																	<span class="m-widget1__desc">Account Number</span>
																</div>
																<div class="col-xs-3 m--align-right">
																	<span class="m-widget1__number m--font-brand"><IMG SRC="<?=base_url();?>assets/images/bank.png"></span>
																</div>
															</div>
														</div>
												</div>
												<div class="col-sm-6 col-lg-3">
														<div class="m-widget1__item">
															<div class="row m-row--no-padding align-items-center bank-box ">
																<div class="col-xs-9">
																	<h4 class="m-widget1__title">Bank Name</h4>
																	<span class="m-widget1__desc">Account Number</span>
																</div>
																<div class="col-xs-3 m--align-right">
																	<span class="m-widget1__number m--font-brand"><IMG SRC="<?=base_url();?>assets/images/bank.png"></span>
																</div>
															</div>
														</div>
												</div>
											</div>
                                    </div>
                                </div>
                                <!-- END SAMPLE FORM PORTLET-->
                                </div>
                            </div>
                                <!-- END SAMPLE FORM PORTLET-->
                        <div class="row ">
                            <div class="col-md-12">
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet light bordered">
									<!--begin::Form-->
									<div class="m-portlet__body">
										<form method="post" id="bank_delsfrm"  class="m-form m-form--fit m-form--label-align-right" data-action="<?=base_url();?>save-bank">
											<div class="form-group">
												<div class="row">
													<div class="col-md-12">
														<label for="bnk_beneficery">Name in Bank</label>
														<input id="bnk_beneficery" class="form-control m-input m-input--air" type="text" placeholder="Enter Name" name="bnk_beneficery">
													</div>
												</div>
											</div>
											
											<div class="form-group">
												<div class="row">
													<div class="col-lg-6">
														<label for="bnk_name">Bank Name</label>
														<input id="bnk_name" class="form-control m-input m-input--air" type="test" placeholder="Enter Bank Name" name="bnk_name">
													</div>
													
													<div class="col-lg-6">
														<label for="bnk_branch">Branch Name</label>
														<input id="bnk_branch" class="form-control m-input m-input--air" type="test" placeholder="Enter Branch Name" name="bnk_branch">
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">
													<div class="col-lg-6">
														<label for="bnk_accountno">Account Number</label>
														<input id="bnk_accountno" class="form-control" type="test" placeholder="Enter Account Number" name="bnk_accountno">
													</div>
													
													<div class="col-lg-6">
														<label for="bnk_ifsc">IFSC Code</label>
														<input id="bnk_ifsc" class="form-control" type="test" placeholder="Enter IFSC Code" name="bnk_ifsc">
													</div>
												</div>
											</div>
										</form>
									</div>
									<!--end::Form-->
									<div class="m-portlet__foot m-portlet__foot--fit">
										<div class="m-form__actions m-form__actions">
											<button class="btn btn-primary" type="submit">Add Bank</button>
										</div>
									</div>
								</div>
							<!--end::Portlet-->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
				
				
				
	