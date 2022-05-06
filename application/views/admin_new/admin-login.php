<?php
defined('BASEPATH') OR exit('No direct script access allowed');//forget-password
//logged_in
if($this->session->userdata('admin_logged_in') == TRUE)
{
    redirect(base_url('admin/dashboard'));
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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Diesel Stop | Admin Panel</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?=base_url()?>assets_diesel/dist/img/ico/favicon.png" type="image/x-icon">
        <!-- Bootstrap -->
        <link href="<?=base_url()?>assets_diesel/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        
        <link href="<?=$path?>assets/global/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
        <!-- Pe-icon-7-stroke -->
        <link href="<?=base_url()?>assets_diesel/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" />
        <!-- style css -->
        <link href="<?=base_url()?>assets_diesel/dist/css/stylecrm.css" rel="stylesheet" />
        
    </head>
    <body>
        <!-- Content Wrapper -->
        <div class="login-wrapper">
            
            <div class="container-center">
            <div class="login-area">
                <div class="card panel-custom">
                    <div class="card-heading custom_head"> 
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Admin Login</h3>
                                <small><strong>Please enter your credentials to login.</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <form id="admin_login" method="post" data-action="<?=base_url();?>login-admin">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                               <input type="text" id="u_username" name="u_username" placeholder="User Name" class="form-control login-fields" value="admin">
                                <!--<span class="help-block small">Your unique username </span>-->
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" id="u_password" name="u_password" placeholder="Password" class="form-control login-fields" value="">
                                <!--<span class="help-block small">Your strong password</span>-->
                            </div>
                            <div>
                                <button class="btn green_btn">Login</button>
                                 <label class="success_msg" style="padding: 9px;margin: 0;" id="demoo"></label>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- jQuery -->
    <script type="text/javascript" src="<?=base_url();?>assets/global/scripts/jquery-min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/global/plugins/bootstrapValidator.min.js"></script>
	<script type="text/javascript" src="<?=base_url();?>assets/global/scripts/bovalidator.min.js"></script>
	<script src="<?=base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
	
    </body>
    
    <?php // include("admin_new/footer.php");?>
    
</html>

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
                            //  document.getElementById("demoo").innerHTML = data.message;
                            window.location.href = data.url;
                          }
                           else if(data.status==0)
                          {
                            $form.data('bootstrapValidator').resetForm(true);
                             document.getElementById("demoo").innerHTML = data.message;
                            toastr.error(data.message);
                          }
                          else
                          {
                            $form.data('bootstrapValidator').resetForm(true);
                            toastr.error('Unknown Response, Try again after some time.');
                              document.getElementById("demoo").innerHTML = data.message;
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
