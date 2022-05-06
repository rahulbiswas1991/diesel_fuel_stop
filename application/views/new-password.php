<?php
defined('BASEPATH') OR exit('No direct script access allowed');//forget-password
//logged_in
if($this->session->userdata('logged_in') == TRUE)
{
    redirect(base_url('user/dashboard'));
}
//print_r($_SESSION);
?>
<!Doctype html>
<html lang="eng">
<?php include_once('header.php');?>
<section class="user-login-content" style="background: url(<?=$path?>images/Login-background-2.png)repeat center;">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
          <div class="loginmodal-container-text">
            
            <div class="Custome-lofin-content">
              <form class="loged-formclass">
                <div class="pax-logs-text">
                  <h1>Reset Password</h1>
                  <p class="log-discription">Excepteur sint occaecat cupidatat non proident, 
                    sunt in culpa qui officia deserunt.</p>
                    <div class="form-fields form-group">
                      <label class="field-icon"><img src="<?=$path?>images/icon/phone-call.png"></label>
                      <input type="text" class="form-control" id="" name=""  placeholder="Mobile Number">
                    </div>
                </div>
                <div class="logs-submit">
                  <input type="submit" name="" class="login loginmodal-submit" value="Send OTP">
              </div>
            </form>
          </div><!-- Custome-lofin-content -->
          </div>
      </div>
    </div>
  </div>
</section>
<!--welcome section End-->
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
</body>
</html>