<?php
$path = base_url();
$this->load->helper('comman_helper');
?>
<!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-shopping-basket"></i>
               </div>
               <div class="header-title">
                  <h1>Change Password</h1>
                  <small>&nbsp;</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                     <div class="col-lg-6 pinpin">
                           <div class="card lobicard lobicard-custom-control"  data-sortable="true"> 
                               <div class="card-header">
                                   <div class="card-title custom_title">
                                       <h4>Change Password</h4>
                                   </div>
                               </div>
                               <div class="card-body">
                                      <form class="form-horizontal" id="changepwd">
                                       
                                        <div class="form-group">
                                            <label for="id-number">Old Password</label>
                                            <input id="old_pass" class="form-control required" type="password" value="" name="old_password" required>
                                        </div>
                                       <div class="form-group">
                                            <label for="request-amount">New Password</label>
                                            <input id="new_password" class="form-control required" type="password" value="" name="new_password" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="request-amount">Confirm Password</label>
                                            <input id="conf_pwd" class="form-control required" type="password" value="" name="confirm_new_password" required>
                                        </div>
                                       <div class="form-group">
                                          <button type="submit" class="btn btn-add change_passwoed"><i class="fa fa-check"></i> Submit
                                          </button>
                                          <label class="success_msg" style="padding: 9px;margin: 0;" id="demo"></label>
                                       </div>
                                    </form>
                                 </div>
                           </div>
                       </div>
                     
               </div>
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->