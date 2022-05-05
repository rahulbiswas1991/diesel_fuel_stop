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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Methercredits Sign Up</title>
	<link type="image/x-icon" href="<?=base_url()?>assets/frontend/images/favicon.png" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/frontend/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/bootstrapValidator.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/login_style.css">
	<link href="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>
		@font-face {
		font-family: 'MYRIADPROREGULAR';
		src: url('<?=base_url();?>assets/fonts/MYRIADPROREGULAR.eot');
		src: local('<?=base_url();?>assets/fonts/MYRIADPROREGULAR'), url('<?=base_url();?>assets/fonts/MYRIADPROREGULAR.woff') format('woff'), url('<?=base_url();?>assets/fonts/MYRIADPROREGULAR.ttf') format('truetype');
	}
	@font-face {
		font-family: 'Myriadpro-light';
		src: url('<?=base_url();?>assets/fonts/Myriadpro-light.eot');
		src: local('<?=base_url();?>assets/fonts/Myriadpro-light'), url('<?=base_url();?>assets/fonts/Myriadpro-light.woff') format('woff'), url('<?=base_url();?>assets/fonts/Myriadpro-light.ttf') format('truetype');
	}
	@media screen and (max-width:767px){
	.register-right.row {
	  background: #fff none repeat scroll 0 0;
	  margin-top: 0;
	  padding: 5px 15px;
	}
	}
	.left-label{
		width:20%;
		float:left;
		font-weight:normal;
	}
	.left-right {
    width: 80%;
    padding: 0;
    text-align: center;
}
	.left-right li {
    display: inline-block;
    position: relative;
    margin: 0 10px;
}
	.select-radio {
	   -moz-user-select: none;
	   cursor: pointer;
	   display: block;
	   margin-bottom: 12px;
	   padding-left: 35px;
	   position: relative;
	}
	.select-radio input {
	   cursor: pointer;
	   opacity: 0;
	   position: absolute;
	}
	.radiomark {
	    background-color: #fff;
	    border: 1px solid #213967;
	    border-radius: 50%;
	    height: 23px;
	    left: 0;
	    position: absolute;
	    top: 0;
	    font-weight:500;
	    width: 23px;
	}
	.select-radio span {
	    font-weight: 400;
	    color: #888;
	}
	.select-radio:hover input ~ .radiomark {
	   background-color: #fff;
	}
	.select-radio input:checked ~ .radiomark {
	   background-color: #fff;
	}
	.radiomark::after {
	   content: "";
	   display: none;
	   position: absolute;
	}
	.select-radio input:checked ~ .radiomark::after {
	   display: block;
	}
	.select-radio .radiomark::after {
    background: #213967 none repeat scroll 0 0;
    border-radius: 50%;
    height: 13px;
    left: 4px;
    top: 4px;
    width: 13px;
}
	</style>
</head >
<body onload="load()">
<div class="register-section">
	<div class="container">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="row">
				<div class="col-sm-5">
				
					<div class="login-left row  register-side-card">
						<a href="<?=base_url()?>"><img src="<?=base_url();?>assets/images/logo.png"></a>
						<br>
						<h4>Hello,</h4>
						<h3>Let's Get Started.</h3>
					</div>
				</div>
				<div class="col-sm-7">
					<div class="register-right row">
						<form id="user_registration" method="post" data-action="<?=base_url();?>register-user">
						<h3>Register</h3>
							<div class="control-group form-group">
							  <!-- User -->
							  <div class="controls">
							  <span class="input-icons"><img src="<?=base_url();?>assets/images/user.png"></span>
								<input maxlength="10" type="text" id="u_username" name="u_username" placeholder="User Name" class="form-control login-fields">
							  </div>
							</div>
							
							<div class="control-group form-group">
							  <!-- E-mail -->
							  <div class="controls">
							  <span class="input-icons"><img src="<?=base_url();?>assets/images/mail.png"></span>
								<input type="email" id="u_email" name="u_email" placeholder="Email" class="form-control login-fields" required="required">
							  </div>
							</div>
							
						
							
							<div class="control-group form-group">
							  <!-- Password-->
							  <div class="controls">
							  <span class="input-icons"><img src="<?=base_url();?>assets/images/lock.png"></span>
								<input type="password" id="u_password" name="u_password" placeholder="Password" class="form-control login-fields">
							  </div>
							</div>
							<div class="control-group form-group">
							  <!-- re-Password-->
							  <div class="controls">
							  <span class="input-icons"><img src="<?=base_url();?>assets/images/lock.png"></span>
								<input type="password" id="u_cpassword" name="u_cpassword" placeholder="Retype Password" class="form-control login-fields">
							  </div>
							</div>

							<?php if(isset($_SESSION['user_type']) && $_SESSION['user_type']==2)
			 						{
			 							$userType = $_SESSION['user_type'];
									 }
									 else
									 {
							?>
							<div class="control-group form-group">
							  <!--referral user -->
							  <div class="controls">
							  <span class="input-icons"><img src="<?=base_url();?>assets/images/user2.png"></span>
								<input type="text" id="user_refferal" name="user_refferal" placeholder="Referral Username" class="form-control login-fields">
							  </div>
							</div>
							<div class="control-group form-group">
							  <!--referral user -->
							  <div class="controls">
							  	<label class="left-label">Placement : &nbsp;&nbsp;</label>
								<ul id="myForm" class="left-right">
									
									<li>
										<label class="select-radio">
										     <span>Left</span>
										     <input checked="checked" type="radio" name="user_position" value="0">
										     <span  class="radiomark"></span>
										</label>
									</li>
									<li>
										<label class="select-radio">
										     <span>Right</span>
										     <input type="radio" name="user_position" value="1">
										     <span  class="radiomark"></span>
										</label>
									</li>
								</ul>
							  </div>
							</div>
							<?php }?>
							<div class="form-group">
								<div class="controls">
									<div class="row">
										<div class="col-sm-12">
											 <div class="g-recaptcha" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback" data-sitekey="<?=$this->config->item('recaptcha_sitekey');?>"></div>
											 <input type="hidden" id="vcaptcha_input" class="form-control" data-recaptcha="true" name="valcap">
									   </div>
									</div>
								</div>
							</div>

							<div class="form-group control-group ">
								<div class="controls">
									<div class="row">
										<div class="col-sm-12">
											<button class="btn btn-success orange-btn" type="submit" id="submitbtn"  disabled="disabled">Submit</button>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<p class="new-user">Already have a account?<a href="<?=base_url('login');?>"> Login Here</a>
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
<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/jquery-min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/global/plugins/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/bovalidator.min.js"></script>
<script src="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script type="text/javascript">var basepath = "<?= base_url(); ?>";</script>
<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/home.js"></script>
<script type="text/javascript">

setTimeout(function() {
       $('#vcaptcha_input').next('small').css('margin-left','17%');
    }, 500);
var originalInputSelector = $.fn.validator.Constructor.INPUT_SELECTOR
$.fn.validator.Constructor.INPUT_SELECTOR = originalInputSelector + ', input[data-recaptcha]'

window.verifyRecaptchaCallback = function (response) {
  $('input[data-recaptcha]').val(response).trigger('change');
  $('#user_registration').bootstrapValidator('revalidateField', 'valcap');
}

window.expiredRecaptchaCallback = function () {
  $('input[data-recaptcha]').val("").trigger('change');
  $('#user_registration').bootstrapValidator('revalidateField', 'valcap');
}
//Restrict spaces in Username
$("input#u_username").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});
</script>
</body>
</html>