<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//logged_in
if($this->session->userdata('logged_in') == TRUE) {
  redirect(base_url('user/dashboard'));
}
?>
<style>
    .foregt-pass
    {
        display: block !important;
    }
</style>

<?php include_once('header-inner.php');?>

	<section>
		<div class="login-cont_dt foregt-pass">
			<div class="container">
			     <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">
			    	
				<div class="login-inner col-md-6 col-lg-6" style="display: block;margin: 0 auto;background: #fff;filter: drop-shadow(0px 8px 28px #212121);">
				    <div class="text-center">
					<h1 class="h4 text-gray-900 mb-4" style="color: #0f1932 !important;font-family: raleways;">Reset Password</h1>
					<br>
					<p style="color: #0f1932 !important;"> Just enter your email address below and we'll send you a link to reset your password!</p>
					</div>

					<form class="user" id="forgot_passwordfm" method="post" data-action="<?=base_url()?>forget-pass">
						<div class="col-md-10 mx-auto pb-3">
							<div class="form-group col-12">
								<input type="text" id="u_email" name="u_email" required="" class="form-control form-control-user" placeholder="Enter EmailId" style="background: transparent;border: 1px solid #f9c95f;border-radius: 50px !important;"/>
							</div>

							<div class="col-12 text-center">
								<input class="common-btn" type="submit" value="SUBMIT" style="background: #e62e50;
    border: none;">
							</div>
							<hr>
							<div class="text-center">
								<p class="mb-0" style="color: #0f1932;line-height: 25px;">Don't have account? <a href="<?=base_url('register')?>" style="color: #0f1932;">SIGNUP</a></p>
						    </div>
							<div class="text-center">
							<p class="mb-0" style="color: #0f1932;">Already have account? <a href="<?= base_url('login') ?>" style="color: #0f1932;">LOGIN</a></p>
						</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		</div>
	</section>

<script type="text/javascript">var basepath = "<?=base_url();?>";</script>
<script type="text/javascript" src="<?=base_url()?>assets/frontend/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/frontend/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/frontend/js/bovalidator.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/frontend/js/toastr.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/frontend/js/home.js"></script>
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
<?php include_once('footer-inner.php');?>