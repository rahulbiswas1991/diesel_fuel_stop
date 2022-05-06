<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//logged_in
if($this->session->userdata('logged_in') == TRUE) {
  redirect(base_url('user/dashboard'));
}
//print_r($_SESSION);
?>
<!Doctype html>
<html lang="eng">
<?php include_once('header-inner.php');?>

<section>
		<div class="login-cont py-5">
			<div class="container py-5">
				<div class="login-inner col-sm-10 col-md-7 col-lg-6 mx-auto">
					<h2>Reset Password</h2>
					<div class="col-md-11 col-lg-10 mx-auto form-message">
						<p>One Tme Password has been sent to your registered mobile number, please enter below </p>
					</div>

					<form id="reset_passfm" method="post" data-action="<?=base_url()?>reset-pass">
						<div class="col-md-10 mx-auto">

							<input type="hidden" name="pass_ref" value="<?=$userid?>">
							<div class="form-group col-12">
								<input type="password" id="u_password" name="u_password" required="" class="form-control" placeholder="New Password"/>
							</div>

							<div class="form-group col-12">
								<input type="password" id="u_cpassword" name="u_cpassword" required="" class="form-control" placeholder="Retype New Password"/>
							</div>

							<div class="col-12 text-center pb-4">
								<input type="submit" class="common-btn mb-2" value="SUBMIT"/>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

<script type="text/javascript">var basepath = "<?=base_url();?>";</script>
<script type="text/javascript" src="<?=$path?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$path?>js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?=$path?>js/bovalidator.min.js"></script>
<script type="text/javascript" src="<?=$path?>js/toastr.min.js"></script>
<script type="text/javascript" src="<?=$path?>js/home.js"></script>
<?php
  $this->load->helper('form');
  $error = $this->session->flashdata('error');
  $success = $this->session->flashdata('success');//success
  if($error) {
    echo "<SCRIPT LANGUAGE='javascript'> window.onload = function() {
          toastr.error(`".$this->session->flashdata('error')."`); };</SCRIPT>\n";
  }
  if($success) {
    echo "<SCRIPT LANGUAGE='javascript'> window.onload = function() {
          toastr.success(`".$this->session->flashdata('success')."`); };</SCRIPT>\n";
  }
?>
<?php include("footer-inner.php") ?>