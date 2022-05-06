<?php
        $this->load->helper('comman_helper');
        //echo '<pre>';print_r($ethereum);//die;
        $path = base_url();
     //  echo '<pre>'; print_r($userdata); //die; 
       $bank_details = $bank_details[0];
	 //  echo '<pre>'; print_r($bank_details); die; 
?>
<!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-shopping-basket"></i>
               </div>
               <div class="header-title">
                  <h1>User Details</h1>
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
                                       <h4>Personal Information</h4>
                                   </div>
                               </div>
                               <div class="card-body">
                                   
                                   <div id="userref" style="display: none;"><?=$userid;?></div>
                                   
                                       <form id="userdels_updatefm" method="post" data-action="<?=$path?>common/updateusrprofile">
 
 
                                        <div class="form-group">
                                            <label for="id-number">EMP ID</label>
                                             <input type="text" name="emp_id" class="form-control" value="<?=$userdata['emp_id']!=''?$userdata['emp_id']:''?>" placeholder="EMP ID" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="id-number">User Name</label>
                                             <input type="text" name="username" class="form-control" value="<?=$userdata['first_name']!=''?$userdata['first_name']:''?>" placeholder="username" readonly>
                                        </div>
                                       
                                       <div class="form-group">
                                            <label for="id-number">Full Name</label>
                                           <input id="ufname" type="text" name="ufname" class="form-control" value="<?=$userdata['first_name']!=''?$userdata['first_name']:''?>" placeholder="First Name">
                                        </div>
                                       
                                       
                                       
                                       <div class="form-group">
                                            <label for="id-number">Email ID</label>
                                             <input type="email" name="email" class="form-control" value="<?=$userdata['email']!=''?$userdata['email']:''?>" placeholder="Email">
                                        </div>
                                       
                                       
                                       <div class="form-group">
                                            <label for="id-number">Phone Number</label>
                                             <input type="number" name="phone" class="form-control" value="<?=$userdata['phone']!=''?$userdata['phone']:''?>" placeholder="Phone">
                                        </div>
                                       
                                       
                                       <div class="form-group">
                                            <label for="id-number">City</label>
                                            <input type="text" class="form-control" value="<?=$userdata['city']!=''?$userdata['city']:''?>" placeholder="City" name="ucity">
                                        </div>
                                       
                                       
                                       <div class="form-group">
                                            <label for="id-number">Address</label>
                                            <input type="text" class="form-control" name="uaddress" value="<?=$userdata['address']!=''?$userdata['address']:''?>" placeholder="Address">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="id-number">Password</label>
                                             <input type="text" class="form-control" value="<?=$userdata['password_text']!=''?$userdata['password_text']:''?>" placeholder="password" name="upassword_text" >
                                        </div>
                                       
                                       
                                       <div class="form-group">
                                          <button type="submit" class="btn btn-add update" id = ""><i class="fa fa-check"></i> Submit
                                          </button>
                                          <label class="success_msg" style="padding: 9px;margin: 0;" id="demo_share"></label>
                                       </div>
                                    </form>
                                 </div>
                           </div>
                       </div>
                     
                     
                     <div class="col-lg-6 pinpin">
                           <div class="card lobicard lobicard-custom-control"  data-sortable="true">
                               <div class="card-header">
                                   <div class="card-title custom_title">
                                       <h4>Bank Information</h4>
                                   </div>
                               </div>
                               <div class="card-body">
                                   <form id="userdels_updatefm" method="post" data-action="<?=$path?>common/updateusrprofileeeee">
 
 
                                        <div class="form-group">
                                            <label for="id-number">Beneficiary Name</label>
                                            <input type="text" id="ben_<?= $bank_details['id'] ?>" name="name_in_bank" class="form-control" value="<?= $bank_details['name_in_bank']!=''? $bank_details['name_in_bank']:''?>" placeholder="name_in_bank" readonly>
                                </div>
                                        
                                        <div class="form-group">
                                            <label for="id-number">Account Number</label>
                                              <input type="text" id="accn_<?= $bank_details['id'] ?>" name="account_number" class="form-control" value="<?=$bank_details['account_number']!=''?$bank_details['account_number']:''?>" placeholder="First Name" readonly>
                               </div>
                                       
                                       <div class="form-group">
                                            <label for="id-number">Bank Name</label>
                                          <input type="text" id="bnm_<?= $bank_details['id'] ?>" name="bank_name" class="form-control" value="<?=$bank_details['bank_name']!=''?$bank_details['bank_name']:''?>" placeholder="bank_name" readonly>
                                 </div>
                                       
                                       
                                       
                                       <div class="form-group">
                                            <label for="id-number">Bank Address</label>
                                            <input type="text" id="bha_<?= $bank_details['id'] ?>" name="branch_address" class="form-control" value="<?=$bank_details['branch_address']!=''?$bank_details['branch_address']:''?>" placeholder="bank_name" readonly>
                                </div>
                                       
                                       
                                       <div class="form-group">
                                            <label for="id-number">Branch  IFSC</label>
                                              <input type="text" id="sw_<?= $bank_details['id'] ?>" name="ifsc_code" class="form-control" value="<?=$bank_details['ifsc_code']?$bank_details['ifsc_code']:''?>" placeholder="IFSC" readonly>
                                </div>
                                       
                                       
                                      
                                       
                                       <!--<div class="form-group">-->
                                       <!--   <button class="btn btn-add kyc_update" data-val="2" data-doc="5"><i class="fa fa-check"></i> Approve-->
                                       <!--   </button>-->
                                          
                                       <!--   <button class="btn reject kyc_update" data-val="3" data-doc="5"><i class="fa fa-close"></i> Reject-->
                                       <!--   </button>-->
                                         
                                       <!--   <label class="success_msg" style="padding: 9px;margin: 0;" id="demo_share"></label>-->
                                       <!--</div>-->
                                    </form>
                                 </div>
                           </div>
                       </div>
                     
                     
               </div>
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->