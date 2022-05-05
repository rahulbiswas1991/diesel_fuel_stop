<?php
        $this->load->helper('comman_helper');
        //echo '<pre>';print_r($ethereum);//die;
        $path = base_url();
     //  echo '<pre>'; print_r($userdata); //die; 
       $bank_details = $bank_details[0];
	 //  echo '<pre>'; print_r($bank_details); die; 
?>
<style type="text/css">
    .admin-heading-ppc {
    padding: 10px 15px;
    vertical-align: bottom;
    display: inline-block;
    width: 100%;
}
.admin-heading-ppc h2{
    display: inline-block;
    margin: 9px 0;
}

.image_bg{
    width: 100%;
}

</style>


<div id="adedit_bank" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">   
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <form method="post" id="edbank_delsfrm" data-action="<?=$path?>process/adupdate_bank">
                    <input type="hidden" value="" id="bank_ref" name="bank_ref">
                    <input type="hidden" value="" id="b_user_id" name="b_user_id">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?=base_url()?>assets/images/bank1.png" class="wallet-img-icon">
                                <h4>Bank Detail</h4>
                                  </div>
                             </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Beneficiary Name</label>
                                    <input placeholder="Beneficiary Name" id="name_in_bank" name="bnk_beneficery" class="form-control" type="text"> 
								</div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Account Number</label>
                                    <input placeholder="Account Number" id="account_number" name="bnk_accountno" class="form-control"  type="text"> 
								</div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Bank Name</label>
                                    <input placeholder="Account Number" id="bank_name" name="bank_name" class="form-control"  type="text"> 
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Bank Address</label>
                                    <input placeholder="Bank Address" id="branch_address" name="branch_address" class="form-control" type="text"> 
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Branch IFSC</label>
                                    <input  placeholder="Swift Code" id="ifsc_code" name="ifsc_code" class="form-control" type="text"> 
                                </div>
                            </div>
                            
                            
                                <div class="col-md-12 form-group text-center">
                                    <input value="Update" class="btn orange btn-circle submitbttn" type="submit" disabled="disabled"> 
                                </div>
                          
                            
                       </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    
    
    
<div id="bitcoin-card-edit" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">   
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <form method="post" id="crypto_paymentfm" data-action="<?=base_url()?>process/adup_cryppayment">
                    <input type="hidden" id="cryppayment_type" name="cryppayment_type">
                    <div class="row">
                        <div class="col-md-12">
                            <img id="method_image" src="" class="wallet-img-icon">
                            <h4 id="method_name"></h4>
                            <div class="form-group grey-box text-center">
                            <p class="text-center">
                            
                            <input class="form-control" name="cryppayment_val" id="cryppayment_val" type="text">
                            </p>
                            </div>
                            <button class="btn orange btn-circle full-width center submitbttn" type="submit" disabled="disabled">Submit</button>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>

	
	
 <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
		<div class="page-bar">
        </div>
        <!-- END PAGE BAR -->
        <h1 class="page-title"> User Details</h1>
        <div class="row">
			<div class="col-md-12">
                <div class="portlet light bordered">
                <div id="userref" style="display: none;"><?=$userid;?></div>
                 <section class="form">
                   <form id="userdels_updatefm" method="post" data-action="<?=$path?>common/updateusrprofile">
                    <div class="personal-info">
                        <div class="admin-heading-ppc">
                            <h2 style="padding:0px">Personal Information</h2>
                                
                        </div>
                            <hr class="line">
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">User Name</label>
                                    
                                    <input type="text" name="username" class="form-control" value="<?=$userdata['first_name']!=''?$userdata['first_name']:''?>" placeholder="username" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Full Name</label>
                                    <input id="ufname" type="text" name="ufname" class="form-control" value="<?=$userdata['first_name']!=''?$userdata['first_name']:''?>" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Email ID</label>
                                    <input type="email" name="email" class="form-control" value="<?=$userdata['email']!=''?$userdata['email']:''?>" placeholder="Email">
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Phone Number</label>
                                 <input type="number" name="phone" class="form-control" value="<?=$userdata['phone']!=''?$userdata['phone']:''?>" placeholder="Phone">
                                </div>
                            </div>
                           
                         <!--     <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">State</label>
                                    <input type="text" name="ustate" class="form-control" value="<?=$userdata['state']!=''?$userdata['state']:''?>" placeholder="State">
                                </div>
                            </div>
                          <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">District</label>
                                    <input type="text" class="form-control" value="<?=$userdata['district']!=''?$userdata['district']:''?>" placeholder="district" name="udistrict">
                                </div>
                            </div>
                           -->
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">City</label>
                                    <input type="text" class="form-control" value="<?=$userdata['city']!=''?$userdata['city']:''?>" placeholder="City" name="ucity">
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" name="uaddress" value="<?=$userdata['address']!=''?$userdata['address']:''?>" placeholder="Address">
                                </div>
                            </div>
                            
                             <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Password</label>
                                   <input type="text" class="form-control" value="<?=$userdata['password_text']!=''?$userdata['password_text']:''?>" placeholder="password" name="upassword_text" >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group custom">
                                    <button class="btn update" type="submit">Update information</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </section>

                    
					
                        </div>
                        
                </div>
				<section class="form">
                   <form id="userdels_updatefm" method="post" data-action="<?=$path?>common/updateusrprofileeeee">
                    <div class="personal-info">
                        <div class="admin-heading-ppc">
                            <h2 style="padding:0px">Bank Information</h2>
                            <? if($bank_details['isactive']==3 || $bank_details['isactive']==1){ ?> 
                            <a style="text-decoration:none;cursor: default;" href ="javascript:void(0);">
                                <span style="float: right;" class= "label label-xs label-info label-mini adbank_popup" data-ref="<?= $bank_details['id'] ?>" data-b_user_id="<?= $userdata['id'] ?>">Update Bank Information</span> 
                            </a>   
                            <? } ?>
                        </div>
                            <hr class="line">
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Beneficiary Name</label>
                                    
                                    <input type="text" id="ben_<?= $bank_details['id'] ?>" name="name_in_bank" class="form-control" value="<?= $bank_details['name_in_bank']!=''? $bank_details['name_in_bank']:''?>" placeholder="name_in_bank" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Account Number</label>
                                    <input type="text" id="accn_<?= $bank_details['id'] ?>" name="account_number" class="form-control" value="<?=$bank_details['account_number']!=''?$bank_details['account_number']:''?>" placeholder="First Name" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Bank Name</label>
                                    <input type="text" id="bnm_<?= $bank_details['id'] ?>" name="bank_name" class="form-control" value="<?=$bank_details['bank_name']!=''?$bank_details['bank_name']:''?>" placeholder="bank_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Bank Address</label>
                                    <input type="text" id="bha_<?= $bank_details['id'] ?>" name="branch_address" class="form-control" value="<?=$bank_details['branch_address']!=''?$bank_details['branch_address']:''?>" placeholder="bank_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Branch IFSC</label>
                                 <input type="text" id="sw_<?= $bank_details['id'] ?>" name="ifsc_code" class="form-control" value="<?=$bank_details['ifsc_code']?$bank_details['ifsc_code']:''?>" placeholder="IFSC" readonly>
                                </div>
                            </div>
                           
                           
                            
                            <div class="col-md-12">
                                <div class="form-group custom">
                                    <!--<button class="btn update" type="submit">Update information</button>-->
                                </div>
                            </div>
                        </div>
                        </form>
                        
                        <div class="col-md-6 col-sm-6" id="bankp_div">
                               
                                <?php if($bank_details['isactive']!=0 && $bank_details['isactive']!=3){ ?>
                                <div class="radio-custom" id="bank_div">
                                    <button class="btn approve kyc_update" data-val="2" data-doc="5">Approve</button>
                                    <button class="btn reject kyc_update" data-val="3" data-doc="5">Reject</button>
                                </div>
                                <?php }else{ ?>
                                 <div class="radio-custom" id="bank_div_upd">
                                    <button class="btn approve adbank_popup_img" data-ref="<?= $bank_details['id'] ?> " data-b_img_user_id="<?= $userdata['id'] ?>">Update</button>
                                 </div>
                                <?php } ?>
                            </div>
                        
                        
                    </section>	
					
                </div>
            </div>
        </div>
      </div>
     </div>
 


</div>
<style type="text/css">
   #myModal4 .modal-body, #myModal3 .modal-body, #myModal2 .modal-body, #myModal1 .modal-body {
    padding: 0 !important;
     height: 98vh;
     display: flex;
     align-items: center;       
}

#myModal4 .modal-dialog, #myModal1 .modal-dialog, #myModal2 .modal-dialog, #myModal3 .modal-dialog {
    width: 720px;
       margin: 6px auto !important;
}

#myModal4 .modal-dialog img, #myModal1 .modal-dialog img, #myModal2 .modal-dialog img, #myModal3 .modal-dialog img {
    margin: 0 auto;
    display: block;
    padding: 10px;
    max-width: 100%;
    height: 100%;
    object-fit: contain;

}
#myModal4 .modal-body, #myModal3 .modal-body, #myModal2 .modal-body, #myModal1 .modal-body {
    padding: 0 !important;
   
}
.kyc-id img {
    max-width: 100%;
    margin: 0 auto !important;
    display: block;
    width: auto;
    height: 158px;
}
.account-box.kyc-id img {
    max-width: 100%;
    margin: 0 auto !important;
    display: block;
    width: auto;
    height: 242px;
}

</style>

 <script type="text/javascript">
    
var img = document.getElementByClass('profile-content').firstChild;
img.onload = function() {
    if(img.height > img.width) {
        img.height = '100%';
        img.width = 'auto';
    }
    
}
    
   
    
</script>