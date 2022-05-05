<?php
defined('BASEPATH') OR exit('No direct script access allowed');//forget-password
//logged_in

if($this->session->userdata('logged_in') == TRUE)
{
     redirect(base_url('user/dashboard'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Methertech Reset Password</title>
  <link type="image/x-icon" href="<?=base_url()?>assets/frontend/images/favicon.png" rel="shortcut icon">
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/bootstrapValidator.min.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/global/css/login_style.css">
  <link href="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
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
  </style>
</head >
<body onload="load()">
<div class="login-section">
  <div class="container">
    <div class="col-sm-10 col-sm-offset-1">
      <div class="row">
        <div class="col-sm-5">
        
          <div class="login-left row ">
            <a href="<?=base_url()?>"><img src="<?=base_url();?>assets/images/logo.png"></a>
            <br>
            <h4>Hello,</h4>
            <h3>Let's Get Started.</h3>
          </div>
        </div>
        <div class="col-sm-7">
          <div class="login-right row reset-right">
            <form id="reset_passfm" method="post" data-action="<?=base_url();?>reset-pass">
            <input type="hidden" name="pass_ref" value="<?=$userid?>">
            <h3>Reset Password</h3>

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
                      <p class="new-user">Already have a account?<a href="<?=base_url();?>login"> Login Here</a>
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
<script type="text/javascript" src="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script type="text/javascript">var basepath = "<?= base_url(); ?>";</script>
<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/home.js"></script>
</body>
</html>