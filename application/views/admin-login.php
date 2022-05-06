<?php
defined('BASEPATH') OR exit('No direct script access allowed');//forget-password
//logged_in
if($this->session->userdata('admin_logged_in') == TRUE)
{
    redirect(base_url('apcompundpower/dashboard'));
}
elseif($this->session->userdata('logged_in') == TRUE)
{
    redirect(base_url('user/dashboard'));
}
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title> Dieasel Fule Stop| Admin Login</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/bootstrapValidator.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/login_style.css">
  <link href="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
  <link type="image/x-icon" href="<?=base_url()?>/assets/arab-token/img/coin.gif" rel="shortcut icon">
</head>
<body>
					<div class="login-section">
						<div class="container">
							<div class="col-sm-6 col-sm-offset-3">
								<a href="<?=base_url()?>"><img src="" width="20%" style="margin:auto;display:block;"></a>
								<div class="row">
									<div class="login-right row">
										<form id="admin_login" method="post" data-action="<?=base_url();?>login-admin">
											<h3>Log In</h3>
											<div class="control-group form-group">
											  <div class="controls">
											  <span class="input-icons"><img src="<?=base_url();?>assets/images/user.png"></span>
												<input type="text" id="u_username" name="u_username" placeholder="User Name" class="form-control login-fields" value="admin">
											  </div>
											</div>
											<div class="control-group form-group">
											  <div class="controls">
											  <span class="input-icons"><img src="<?=base_url();?>assets/images/lock.png"></span>
												<input type="password" id="u_password" name="u_password" placeholder="Password" class="form-control login-fields" value="123456">
											  </div>
											</div>
											<div class="form-group control-group ">
											   <div class="controls">
												 <div class="row">
													<div class="col-sm-12">
														<button class="btn btn-success orange-btn" type="submit" style="margin:auto;display:block;float:none;">Login</button>
													</div>
												 </div>
											   </div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
	<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/jquery-min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/global/plugins/bootstrapValidator.min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/bovalidator.min.js"></script>
	<script src="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function() {
        $('#admin_login').bootstrapValidator({
                excluded: ':disabled',
                fields: {
                    u_username: {
                        validators: {
                            notEmpty: {
                                message: 'The Username is required'
                            }
                     }
                    },
                    u_password: {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            },
                        }
                    }
                }
            })
            .on('success.form.bv', function(e) {
                // Prevent form submission
                e.preventDefault();
                // Get the form instance
                var $form = $(e.target);
                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

             		$.ajax({
                       type: "POST",
                       url: $form.attr('data-action'),
                       data: $form.serialize(), // serializes the form's elements.
                       dataType:'json',
                       success: function(data)
                       {
                          if(data.status==1)
                          {
                            $form.data('bootstrapValidator').resetForm(true);
                            window.location.href = data.url;
                          }
                           else if(data.status==0)
                          {
                            $form.data('bootstrapValidator').resetForm(true);
                            toastr.error(data.message);
                          }
                          else
                          {
                            $form.data('bootstrapValidator').resetForm(true);
                            toastr.error('Unknown Response, Try again after some time.');
                          }
                       },
                       error:function(data) 
                       {
                         toastr.error('Unknown Response, Try again after some time.');
                       }
                    });
           	});
       });
</script>
	</body>
	</html>