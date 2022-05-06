<?php
        $this->load->helper('comman_helper');
        //echo '<pre>';print_r($ethereum);//die;
        $path = base_url();
      // echo '<pre>'; print_r($bank_details); die; 
       $bank_details = $bank_details[0];
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

</style>


<div id="adedit_bank" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">   
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <form method="post" id="edbank_delsfrm" data-action="<?=$path?>process/adupdate_bank">
                    <input type="hidden" value="" id="bank_ref" name="bank_ref">
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

<div id="reject_kyc" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">   
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <form method="post" id="reject_kycfm" data-action="<?=base_url()?>common/updatekyc">
                    <input type="hidden" id="type" name="type">
                    <input type="hidden" id="val" name="val">
                    <input type="hidden" id="ref" name="ref">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group grey-box text-center">
                            <p class="text-center">
                            <label>Enter Remark</label>
                            <input class="form-control" name="reject_remark" id="reject_remark" type="text">
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
                            <span style="float: right;">
                            <?php if(empty($userdata['paid_status'])){?>
                                <button class="btn btn-primary user_paid" type="button" data-ref="<?=$userdata['id']!=''?$userdata['id']:''?>" data-ufname="<?=$userdata['f_name']!=''?$userdata['f_name']:''?>" data-kyc="<?=$userdata['kycst']?>">Set As Paid User</button>
                            <?php }?> 
                            <button class="btn btn-primary admin78-login loginadmtousr" data-ref="<?=urlencode($this->encryption->encrypt($userdata['id']))?>" type="button">User Login</button>      
                            </span>    
                        </div>
                            <hr class="line">
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">User Name</label>
                                    
                                    <input type="text" name="username" class="form-control" value="<?=$userdata['username']!=''?$userdata['username']:''?>" placeholder="username" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Full Name</label>
                                    <input id="ufname" type="text" name="ufname" class="form-control" value="<?=$userdata['f_name']!=''?$userdata['f_name']:''?>" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Pancard No</label>
                                    <input type="text" name="pancard_no" class="form-control" value="<?=$userdata['pancard_no']!=''?$userdata['pancard_no']:''?>" placeholder="Pancard no">
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
                                    <label class="control-label">Country Code</label>
                                <span class="disableinput"><?=$userdata['country_code']!=''?'+'.$userdata['country_code']:'Not Available'?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Phone Number</label>
                                 <input type="number" name="phone" class="form-control" value="<?=$userdata['phone']!=''?$userdata['phone']:''?>" placeholder="Phone">
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
                                    <label class="control-label">City</label>
                                    <input type="text" class="form-control" value="<?=$userdata['city']!=''?$userdata['city']:''?>" placeholder="City" name="ucity">
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Zip code</label>
                                    <input type="text" class="form-control" value="<?=$userdata['zip_code']!=''?$userdata['zip_code']:''?>" placeholder="Zipcode" name="uzipcode">
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

                    <section class="form">
                        <div class="personal-info">
                            <h2 style="padding:15px">KYC</h2>

                            <?php
                                  $addressthimg ='';
                                  $nationidthimg ='';
                                  $pancardthimg ='';
                                  $addressproof='';
                                  $nationalid='';
                                  $pancard='';
                                  $lightbox='';
                                  $kyc_class='';
                                  if(!empty($userdata['addressproofthumb']) && $userdata['address_id_status']!=3)
                                  {
                                    $addressthimg = $path.$userdata['addressproofpath'].$userdata['addressproofthumb'];
                                    $addressproof = $path.$userdata['addressproofpath'].$userdata['addressproof'];
                                    $lightbox='lightbox';
                                    $kyc_class='kyc_image';
                                  }
                                  else
                                  {
                                    $addressproof = $path.'assets/images/id-card.png';
                                  }
                                  if(!empty($userdata['nationalidthumb']) && $userdata['national_id_status']!=3)
                                  {
                                    $nationidthimg = $path.$userdata['nationalidpath'].$userdata['nationalidthumb'];
                                    $nationalid = $path.$userdata['nationalidpath'].$userdata['nationalid'];
                                    $lightbox='lightbox';
                                    $kyc_class='kyc_image';
                                  }
                                  else
                                  {
                                    $nationalid = $path.'assets/images/id-card.png';
                                  }
                                  
                                  if(!empty($userdata['pancardidthumb']) && $userdata['pancard_status']!=3)
                                  {
                                    $pancardthimg = $path.$userdata['pancardidpath'].$userdata['pancardidthumb'];
                                    $pancard = $path.$userdata['pancardidpath'].$userdata['pancardid'];
                                    $lightbox='lightbox';
                                    $kyc_class='kyc_image';
                                  }
                                  else
                                  {
                                    $pancard = $path.'assets/images/id-card.png';
                                  }

                            ?>
                            <hr class="line">
                            <div class="col-md-6 col-sm-6" id="nationid_div">
                                <div class="main-id">
                                     <h4>National Id 
                                        <div class="nationid_divst pull-right" style="font-size:15px;"><strong>
                                            <?php if($userdata['national_id_status']==2){?>
                                            <span class="font-green-jungle">Approved</span>
                                            <?php }elseif($userdata['national_id_status']==3){?>
                                            <span class="font-red-thunderbird">Rejected</span>
                                            <?}elseif($userdata['national_id_status']==1){?>
                                            <span class="font-yellow-crusta">Pending</span>
                                            <?}elseif($userdata['national_id_status']==0){?>
                                            <span class="font-blue">Not Upload Yet</span>
                                            <?}else{}?>
                                        </strong></div>
                                        </h4>
                                    <div class="kyc-id">
                                       
                                        
                                        <img id="nid_img" data-toggle="modal" data-target="#myModal1"  class="img-fluid <?php echo $kyc_class ?>"  src="<?=$nationalid?>" alt="image-id" />
                                   

                                    </div>
                                </div>
                                <?php if($userdata['national_id_status']!=0 && $userdata['national_id_status']!=3){?>
                                <div class="radio-custom" id="nid_div">
                                     <button class="btn approve kyc_update" data-val="2" data-doc="1">Approve</button>
                                    <button class="btn reject kyc_update" data-val="3" data-doc="1">Reject</button>
                                </div>
                                <?php }?>
                            </div>
                            <div class="col-md-6 col-sm-6" id="addressp_div">
                                <div class="main-id">
                                    <h4>Address Proof
                                        <div class="addressp_divst pull-right" style="font-size:15px;"><strong>
                                            <?php if($userdata['address_id_status']==2){?>
                                            <span class="font-green-jungle">Approved</span>
                                            <?php }elseif($userdata['address_id_status']==3){?>
                                            <span class="font-red-thunderbird">Rejected</span>
                                            <?}elseif($userdata['address_id_status']==1){?>
                                            <span class="font-yellow-crusta">Pending</span>
                                            <?}elseif($userdata['address_id_status']==0){?>
                                            <span class="font-blue">Not Upload Yet</span>
                                            <?}else{}?>
                                        </strong></div>
                                        </h4>
                                    <div class="kyc-id">
                                        
                                     
                                         <img data-toggle="modal" data-target="#myModal2"  id="ap_img" src="<?=$addressproof?>" class="img-fluid <?php echo $kyc_class ?>" alt="image-id"/>
                                       
                                    </div>
                                </div>
                                <?php if($userdata['address_id_status']!=0 && $userdata['address_id_status']!=3){?>
                                <div class="radio-custom" id="ap_div">
                                    <button class="btn approve kyc_update" data-val="2" data-doc="2">Approve</button>
                                    <button class="btn reject kyc_update" data-val="3" data-doc="2">Reject</button>
                                </div>
                                <?php }?>
                            </div>
                            
                            <div class="col-md-6 col-sm-6" id="panr_div">
                                <div class="main-id">
                                    <h4>Pancard
                                        <div class="panr_divst pull-right" style="font-size:15px;"><strong>
                                            <?php if($userdata['pancard_status']==2){?>
                                            <span class="font-green-jungle">Approved</span>
                                            <?php }elseif($userdata['pancard_status']==3){?>
                                            <span class="font-red-thunderbird">Rejected</span>
                                            <?}elseif($userdata['pancard_status']==1){?>
                                            <span class="font-yellow-crusta">Pending</span>
                                            <?}elseif($userdata['pancard_status']==0){?>
                                            <span class="font-blue">Not Upload Yet</span>
                                            <?}else{}?>
                                        </strong></div>
                                        </h4>
                                    <div class="kyc-id">
                                        
                                     
                                         <img data-toggle="modal" data-target="#myModal4"  id="pan_img" src="<?=$pancard?>" class="img-fluid <?php echo $kyc_class ?>" alt="image-id"/>
                                       
                                    </div>
                                </div>
                                <?php if($userdata['pancard_status']!=0 && $userdata['pancard_status']!=3){?>
                                <div class="radio-custom" id="pan_div">
                                    <button class="btn approve kyc_update" data-val="2" data-doc="4">Approve</button>
                                    <button class="btn reject kyc_update" data-val="3" data-doc="4">Reject</button>
                                </div>
                                <?php }?>
                            </div>
                            
                        </div>
                    </section>  
					
					 <!--section class="from">
                        <div class="personal-info">
                            <h2 style="padding:15px">Bitcoin Details</h2>
                            <hr class="line">

                            <div class="col-md-12 col-sm-12 ">
                                <h5> <strong>Address </strong> </h5>



                                

                                <div class="col-md-12 col-sm-12 bank-info-box">
                                    <div class="account-box">
                                        <div class="account-inner-box-data">
                                            <h4 class="inner-package-heading"><span id="bnm_<?= $userdata['bit_address'] ?>"><?= $userdata['bit_address'] ?></span></h4>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <?php if ($userdata['bit_address_status'] != 0 && $userdata['bit_address_status'] != 3) { ?>
                            <div class="radio-custom" id="bnk_d">
                               
                            </div>
                        <?php } ?>
                </div>


                </section--> 
				<section class="form">
                   <form id="userdels_updatefm" method="post" data-action="<?=$path?>common/updateusrprofileeeee">
                    <div class="personal-info">
                        <div class="admin-heading-ppc">
                            <h2 style="padding:0px">Bank Information</h2>
                                
                        </div>
                            <hr class="line">
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Beneficiary Name</label>
                                    
                                    <input type="text" name="name_in_bank" class="form-control" value="<?= $bank_details['name_in_bank']!=''? $bank_details['name_in_bank']:''?>" placeholder="name_in_bank" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Account Number</label>
                                    <input type="text" name="account_number" class="form-control" value="<?=$bank_details['account_number']!=''?$bank_details['account_number']:''?>" placeholder="First Name" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control" value="<?=$bank_details['bank_name']!=''?$bank_details['bank_name']:''?>" placeholder="bank_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Bank Address</label>
                                    <input type="text" name="branch_address" class="form-control" value="<?=$bank_details['branch_address']!=''?$bank_details['branch_address']:''?>" placeholder="bank_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group custom">
                                    <label class="control-label">Branch IFSC</label>
                                 <input type="text" name="ifsc_code" class="form-control" value="<?=$bank_details['ifsc_code']?$bank_details['ifsc_code']:''?>" placeholder="IFSC" readonly>
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
                                <div class="main-id">
                                    <h4>Bank Proof
                                        <div class="bankp_divst pull-right" style="font-size:15px;"><strong>
                                            <?php if($bank_details['isactive']==2){ ?>
                                            <span class="font-green-jungle">Approved</span>
                                            <?php }elseif($bank_details['isactive']==3){?>
                                            <span class="font-red-thunderbird">Rejected</span>
                                            <?}elseif($bank_details['isactive']==1){?>
                                            <span class="font-yellow-crusta">Pending</span>
                                            <?}elseif($bank_details['isactive']==0){?>
                                            <span class="font-blue">Not Upload Yet</span>
                                            <?}else{}?>
                                        </strong></div>
                                        </h4>
                                    <div class="kyc-id">
                                        <?  
                                        if(!empty($bank_details['cheque_receipt']) && $bank_details['isactive']!=3)
                                          {
                                            $bankproof = $path.$bank_details['cheque_receipt'];
                                            $lightbox='lightbox';
                                            $kyc_class='kyc_image';
                                          }
                                          else
                                          {
                                            $bankproof = $path.'assets/images/id-card.png';
                                          }
                                        
                                        ?>
                                     
                                         <img data-toggle="modal" data-target="#myModal3"  id="ap_img" src="<?=$bankproof?>" class="img-fluid <?php echo $kyc_class ?>" alt="image-id"/>
                                       
                                    </div>
                                </div>
                                <?php if($bank_details['isactive']!=0 && $bank_details['isactive']!=3){?>
                                <div class="radio-custom" id="bank_div">
                                    <button class="btn approve kyc_update" data-val="2" data-doc="5">Approve</button>
                                    <button class="btn reject kyc_update" data-val="3" data-doc="5">Reject</button>
                                </div>
                                <?php }?>
                            </div>
                        
                        
                    </section>	
					
                </div>
            </div>
        </div>
      </div>
     </div>
 
     <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
           <img src="<?=$nationalid?>">
        </div>
    </div>
  </div>
</div>

 <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
           <img src="<?=$addressproof?>">
        </div>
    </div>
  </div>
</div>

 <div id="myModal4" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
           <img src="<?=$pancard?>">
        </div>
    </div>
  </div>
</div>


 <div id="myModal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
           <!--<img src="<?=base_url().$value['cheque_receipt']?>">-->
           <img src="<?=$bankproof?>">
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
</script>