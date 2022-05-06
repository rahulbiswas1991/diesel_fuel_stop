<?php
defined('BASEPATH') OR exit('No direct script access allowed');//forget-password
//logged_in

if($this->session->userdata('logged_in') == TRUE)
{
     redirect(base_url('user/dashboard'));
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Methertech Forgot Password</title>
  <link type="image/x-icon" href="<?=base_url()?>assets/frontend/images/favicon.png" rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/bootstrapValidator.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/login_style.css">
  <link href="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
	<style>
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
	</style>
</head>
<body onload="load()">
<div class="login-section">
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
					<div class="login-right row forgot-right">
          <form id="forgot_passwordfm" method="post" data-action="<?=base_url();?>forget-pass">
          <h3>Forgot Password</h3>
          <div class="control-group form-group">
                              <div class="controls">
                              <span class="input-icons"><img src="<?=base_url();?>assets/images/user.png"></span>
                                <input type="text" id="u_email" name="u_email" placeholder="Email" class="form-control login-fields">
                              </div>
                            </div>
            <div class="form-group control-group ">
               <div class="controls">
                 <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-success orange-btn" type="submit" id="submitbtn" disabled="disabled">Forget Password</button>
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
</script>
</body>
</html>