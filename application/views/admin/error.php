 <?php
  $path = base_url();
  $this->load->helper('comman_helper');
?>

  <link href="<?=$path?>assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
  <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
						 <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title">Page Not Found
                            <small></small>
                        </h1>
                        <!-- END PAGE TITLE-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="dashboard">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>No Record Found</span>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->

                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12 page-404">
									<h2>
										<a href="dashboard">
											<img src="<?=$path?>assets/astar/images/alphastar-logo.png" alt="logo" class="logo-default" /> 
										</a>
									</h2>
                                <div class="number "> 404 </div>
                                <div class="details">
                                    <h3>No Record Found</h3>
                                    <p> We can not find the page you're looking for.
                                        <br/>
                                        <a href="dashboard"> Return home </a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->