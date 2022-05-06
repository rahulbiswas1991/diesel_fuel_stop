
<?php
defined('BASEPATH') OR exit('No direct script access allowed');//forget-password
//logged_in
if($this->session->userdata('logged_in') == TRUE)
{
     if($this->session->userdata['u_role']==2)
     {
     	redirect(base_url('user/dashboard_cloud'));
     }
     else
     {
     	redirect(base_url('user/dashboard'));
     }
}
else
{
	$this->session->unset_userdata('usr_id');
	if(empty($this->session->userdata('user_type')))
	{
	 	redirect(base_url());
	}
}
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Methercredits Login</title>
  <link type="image/x-icon" href="<?=base_url()?>assets/frontend/images/favicon.png" rel="shortcut icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/bootstrapValidator.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/login_style.css">
  <link href="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>
        #load {
          background: rgba(215, 215, 215, 0.6) url("<?=base_url()?>assets/images/loader1.gif") no-repeat scroll center center;
          height: 100%;
          position: fixed;
          width: 100%;
		  display:none;
          z-index: 9999;
        }
	@font-face {
		font-family: 'MYRIADPROREGULAR';
		src: url('assets/fonts/MYRIADPROREGULAR.eot');
		src: local('assets/fonts/MYRIADPROREGULAR'), url('assets/fonts/MYRIADPROREGULAR.woff') format('woff'), url('assets/fonts/MYRIADPROREGULAR.ttf') format('truetype');
	}
	@font-face {
		font-family: 'Myriadpro-light';
		src: url('assets/fonts/Myriadpro-light.eot');
		src: local('assets/fonts/Myriadpro-light'), url('assets/fonts/Myriadpro-light.woff') format('woff'), url('assets/fonts/Myriadpro-light.ttf') format('truetype');
	}
	@media screen and (max-width:767px){
		.login-right.row {
		  padding: 20px 0px !important;
		  margin-top: 0;
		}
			.forgot-content {
		  text-align: center;
		}
	}

	.bcontent {
  width: 100%;
  overflow: hidden;
  padding-top:100px;
}
.bcontent  #reffral-section {
  position: relative;
  display: block;
  left: 110%;
}
	</style>
</head>
<body onload="load()">
<div id="load"></div>

<div class="login-section" id="login_primary">
	<div class="container">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="row">
				<div class="col-sm-5">
					<div class="login-left row">
						<a href="<?=base_url()?>"><img src="<?=base_url();?>assets/images/logo.png"></a>
						<br><br>
						<h4>Hello,</h4>
						<h3>Welcome To Mether.</h3>
					</div>
				</div>
				<div class="col-sm-7">
					<div class="login-right row">
						  <form id="user_login" method="post" data-action="<?=base_url();?>login-me">
						  <h3>Log In</h3>
						  <div class="control-group form-group">
											  <div class="controls">
											  <span class="input-icons"><img src="<?=base_url();?>assets/images/user.png"></span>
												<input type="text" id="u_email" name="u_email" placeholder="Username/Email" class="form-control login-fields">
											  </div>
											</div>
							<div class="control-group form-group">
											  <div class="controls">
											  <span class="input-icons"><img src="<?=base_url();?>assets/images/lock.png"></span>
												<input type="password" id="u_password" name="u_password" placeholder="Password" class="form-control login-fields">
											  </div>
											</div>
										<div class="control-group form-group">
								<div class="controls">
								  <div class="row">
									 <div class="col-sm-12">
										<div class="g-recaptcha" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback" data-sitekey="<?=$this->config->item('recaptcha_sitekey');?>"></div>
									  </div>
								  </div>
								</div>
								<input type="hidden" id="vcaptcha_input" class="form-control" data-recaptcha="true" name="valcap">
							</div>
							<div class="form-group control-group ">
							   <div class="controls">
								 <div class="row">
									<div class="col-sm-12">
										<button class="btn btn-success orange-btn" type="submit" id="submitbtn" disabled="disabled">Login <span style="display: none;" id="login_spinner"><i class="fa fa-spinner fa-pulse fa-fw"></i></span></button>
									</div>
								 </div>
							   </div>
							</div>
							<div class="form-group">
							  <div class="row">
									<div class="col-sm-6">
										<p class="forgot-content"><a href="<?=base_url();?>forget-password">Forgot Password?</a></p>
									</div>
									<div class="col-sm-6">
									  <p class="new-user">New User<a href="<?=base_url();?>signup"> Register Here!</a>
									  </p>
								  </div>
							  </div>
						  </div>
						  </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="login-section bcontent" style="display: none;" id="login_secondary">
	<div class="container"  id="reffral-section">
		<div class="col-sm-6 col-sm-offset-3">
			<a href=""><img style="margin:auto;display:block;" src="<?=base_url();?>assets/images/logo.png"></a>
			<div class="row">
				<div class="login-right row">
					<form data-action="<?=base_url();?>frontend/save_referral" method="post" class="bv-form" id="save_referral">
						<h3>referral Code</h3>
						<div class="control-group form-group">
							<div class="controls">
								<span class="input-icons"><img src="<?=base_url();?>assets/images/user2.png"></span>
								<input type="text" class="form-control login-fields" placeholder="Enter Referral code" name="user_refferal" >
							</div>
						</div>
						<div class="form-group control-group ">
							<div class="controls">
								<div class="row">
									<div class="col-sm-12">
										<button style="margin:auto;display:block;float:none;" type="submit" class="btn btn-success orange-btn">Submit</button>
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
<script type="text/javascript">var basepath = "<?= base_url(); ?>";</script>
<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/home.js"></script>
<?php
  $this->load->helper('form');
  $error = $this->session->flashdata('error');
  $success = $this->session->flashdata('success');//success
  if($error)
    {
      echo "<SCRIPT LANGUAGE='javascript'> window.onload = function() {
    toastr.error(`".$this->session->flashdata('error')."`); };</SCRIPT>\n";
    }
  if($success)
   {
    echo "<SCRIPT LANGUAGE='javascript'> window.onload = function() {
      toastr.success(`".$this->session->flashdata('success')."`); };</SCRIPT>\n";
   }
?>
		<script type="text/javascript">
                $(window).load(function() {      //Do the code in the {}s when the window has loaded 
                  $("#load").fadeOut("fast");  //Fade out the #loader div
                });
		</script>
<script type="text/javascript">
setTimeout(function() {
       $('#vcaptcha_input').next('small').css('margin-left','17%');
    }, 500);
var originalInputSelector = $.fn.validator.Constructor.INPUT_SELECTOR
$.fn.validator.Constructor.INPUT_SELECTOR = originalInputSelector + ', input[data-recaptcha]'

window.verifyRecaptchaCallback = function (response) {
  $('input[data-recaptcha]').val(response).trigger('change');
  $('#user_login').bootstrapValidator('revalidateField', 'valcap');
}

window.expiredRecaptchaCallback = function () {
  $('input[data-recaptcha]').val("").trigger('change');
  $('#user_login').bootstrapValidator('revalidateField', 'valcap');
}
</script>

<script>
$(document).ready(function() {

    $("#reffral-section").animate({left: "0"}, {
    duration: 1000       
    });
});
</script>
</body>
</html>