<?php
$this->load->helper('comman_helper');
$searchby = '';
$condition = '';
$query = '';
$searchby   = isset($_GET['search_by']) ? $_GET['search_by'] : '';
$condition  = isset($_GET['condition']) ? $_GET['condition'] : '';
if (isset($_GET['query']) && $_GET['query'] != '') {
    $query      = $_GET['query'];
}

$path = base_url();

?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>-->

<div id="adedit_lead" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">   
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <form method="post" id="edlead_delsfrm" data-action="<?= base_url() ?>process/adupdate_lead"> 
                    <input type="hidden" value="" id="lead_ref" name="lead_ref">
                    <input type="hidden" value="" id="b_user_id" name="b_user_id">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?=base_url()?>assets/images/bank1.png" class="wallet-img-icon"> 
                                <h4>Lead Details</h4>
                                  </div>
                             </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Name</label>
                                    <input placeholder="Lead Name" id="lead_name" name="lead_name" class="form-control" type="text" required/> 
								</div>
                                </div>
                                
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Company Name</label>
                                    <input placeholder="company name" id="company_name" name="company_name" class="form-control" type="text" required/> 
								</div>
                                </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Phone No</label>
                                    <input placeholder="phone" id="phone" name="phone" class="form-control"  type="text" required/> 
								</div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input placeholder="Email" id="email" name="email" class="form-control"  type="text" required/> 
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input placeholder="City" id="city" name="city" class="form-control" type="text" required/> 
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Designation</label>
                                    <input  placeholder="designation" id="designation" name="designation" class="form-control" type="text" required/> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Currunt Status</label>
                                    <!--<input  placeholder="Status" id="status" name="status" class="form-control" type="text"> -->
                                    <select class="form-control status" id="status" name="status" required/>
                                        <option value="0"> IN Process</option>
                                        <option value="1">Complete</option>
                                        <option value="2">Cancelled</option>
                                        <option value="3">Hold</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                                <div class="col-md-12 form-group text-center">
                                    <input value="Update" class="btn orange btn-circle submitbttnn" type="submit" disabled="disabled"> 
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
        <h1 class="page-title"> Manage Leads
        </h1>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet">
                        <div class="caption font-dark">
                            <form method="get" action="<?= base_url() ?>apcompundpower/ManageLeads">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Search Options</label>
                                        <select class="form-control" name="search_by">
                                            <option value="">All</option>
                                            <option <?= $searchby == 'name' ? 'selected="selected"' : ''; ?> value="name">Name</option>
                                            <option <?= $searchby == 'username' ? 'selected="selected"' : ''; ?> value="username">EMP ID</option>
                                            <option <?= $searchby == 'email' ? 'selected="selected"' : ''; ?> value="email">Email</option>
                                            <option <?= $searchby == 'mobile' ? 'selected="selected"' : ''; ?> value="mobile">Mobile</option>
                                            <!-- <option>KYC Pending</option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" name="condition">
                                            <option value="">All</option>
                                            <option <?= $condition == 1 ? 'selected="selected"' : ''; ?> value="1">Credited</option>
                                            <option <?= $condition == 2 ? 'selected="selected"' : ''; ?> value="2">Debited</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Enter your choice...</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search for..." name="query" value="<?= trim($query) ?>">
                                            <span class="input-group-btn">
                                                <button class="btn blue" type="submit">Search</button>
                                                <a class="btn red" href="<?= base_url() ?>apcompundpower/ManageLeads"><i class="fa fa-refresh"></i> </a>
                                                <button class="btn green" type="button" id="excel_button"><i class="fa fa-file-excel-o"></i> </button>
                                            </span>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Form to credir Or debit amount in user wallet -->
                 <!--   <form method="POST" action="<?= base_url('apcompundpower/ManageCreditInsert') ?>" id="mether_usercredits">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Send to User1...</label>
                                <input type="hidden" name="user_id" id="user_id" value="">
                                <select class="form-control populate" id="select_usersnot">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Enter Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control input-default" placeholder="Enter Amount"> </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Enter Remarks</label>
                                <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks.....">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Select Action</label>
                                <div class="input-group input-group-default">
                                    <select class="form-control" name="type" id="transaction_type">
                                        <option value="1">Credit</option>
                                        <option value="2">Debit</option>
                                    </select>
                                    <span class="input-group-btn">
                                        
                                        <button class="btn green" type="submit"><i class="fa fa-send"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
                -->
                
                <div class=row>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="<?=base_url()?>apcompundpower/ManageLeads">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            
                                            <span data-counter="counterup" data-value="<?=number_format($today_fund_transfer['today_fund_transfer'])?>"> </span>
                                        </div>
                                        <div class="desc"> Today's Leads
 </div>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="<?=base_url()?>apcompundpower/ManageLeads">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number"> 
                                            
                                            <span data-counter="counterup" data-value="<?=number_format($total_fund_transfer['total_fund_transfer'])?>"> </span>

                                        </div>
                                        <div class="desc"> Total Leads
 </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                
                
                <!-- Listing for transactions -->
                <?php //die; 
                ?>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Lead Date / Update Date</th>
                                <th>User Info</th>
                                <th>Company Name</th>
                                <th>Phone</th>
								 <th>Email</th>
								 <th>City</th>
                                <th class="text-center">Status</th>
								<th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //$i=1;
                            $sno = $row + 1;
                            foreach ($history as $record) {
								
								if($record['lead_status'] == 0){
									$sts = '<span class="label label-sm label-danger"> In Process </span>';
								}elseif($record['lead_status'] == 1){
									$sts = '<span class="label label-sm label-success"> Complete </span>';
								}elseif($record['lead_status'] == 2){
									$sts = '<span class="label label-sm label-danger"> Cancelled </span>';
								}elseif($record['lead_status'] == 3){
									$sts = '<span class="label label-sm label-danger"> Hold </span>';
								}
								
							$cdate = $record['updated_date'] !="0000-00-00 00:00:00" ? change_date_format($record['updated_date'], 'd M,Y h:i:s') : " ";
								
								
                                echo '
                                                        <tr class="odd gradeX">
                                                         
                                                        <td class="text-center"> ' . $sno++ . ' </td>
                                                        <td class="text-center"> ' . change_date_format($record['created_date'], 'd M,Y h:i:s') . '</br>
                                                        ' .  $cdate . '
                                                        </td>
                                                        <td>
                                                            <a href="' . base_url() . 'apcompundpower/user-details/' . $record['id'] . '" class="tooltips" data-original-title="View User Info"> ' . $record['user_name'] . '</a>
                                                            <span class="label label-sm label-success label-mini tooltips" data-original-title="Username"> ' . $record['emp_id'] . ' </span><br>
                                                            <i class="fa fa-envelope"></i> ' . $record['user_mail'] . '<br>
                                                            <i class="fa fa-phone"></i> ' . $record['user_phone'] . '
                                                        </td>
                                                        
                                                        <td class="text-left">' . $record['company_name'] . '</td>
														<td class="text-left">' . $record['lead_phone'] . '</td>
														<td class="text-left">' . $record['lead_mail'] . '</td>
														<td class="text-left">' . $record['lead_city'] . '</td>
                                                        <td class="text-center">
                                                            ' . $sts . '
                                                            
                                                        </td>
														<td>
														<a style="text-decoration:none;cursor: default;" href ="javascript:void(0);">
															<span style="float: right;" class= "label label-xs label-info label-mini adlead_popup" data-ref="'.$record['lead_id'].'" data-b_user_id="'.$record['id'].'">Update</span> 
														</a> 
														</td>
                                                    </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-right"><?php echo $pagination; ?></div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<script type="text/javascript">

$('#adedit_lead')
        .on('shown.bs.modal', function() {
            $('#edlead_delsfrm').find('[name="lead_name"]').focus();
        })
        .on('hidden.bs.modal', function() {
            $('#edlead_delsfrm').bootstrapValidator('resetForm', true); //disableSubmitButtons(disabled)
        });




$(".adlead_popup").click(function(e) {
    
    
    var a = $(this).attr('data-ref');
    if(a > '0'){
     
            $.ajax({
                type: "POST",
                url: basepath + 'process/lead_details',
                data: { 'ref': $(this).attr('data-ref'), 'utype': 'admin' },
                dataType: "json",
                success: function(data) {
                    toastr.clear();
                   // alert(data); die();
                    if (data.status == 1) {
                        
                        $('#lead_name').val(data.data.name);
                        $('#company_name').val(data.data.company_name);
                        $('#phone').val(data.data.phone);
                        $('#email').val(data.data.email);
                        $('#city').val(data.data.city);
                        $('#designation').val(data.data.designation);
                        
                    //    $('#status').val(data.data.status);
                        
                        $('#lead_ref').val(data.data.id);
                        
                        $('#b_user_id').val(data.data.user_id);
                        
                        
                         var options = document.getElementById("status").options;
                        for (var i = 0; i < options.length; i++) {
                            
                            
                       //     alert(options[1].value); die();
                          var sts = data.data.status;  
                            
                          if (options[i].value == sts) {
                            options[i].selected = true;
                            break;
                          }
                        }
                        
                        
                        $('#adedit_lead').modal('show');
                    } else if (data.status == 0) {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });
    }else{
         $('#b_user_id').val($(this).attr('data-b_user_id'));
         $('#adedit_lead').modal('show');
    }
});



 $('#edlead_delsfrm').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                lead_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Lead Name is required'
                        }
                    }
                },
                company_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Company Name is required'
                        },
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: 'The Phone is required'
                        },
                        stringLength: {
                            min: 10,
                            max: 10,
                            message: 'Phone NO should be 10 digit Long'
                        },
                        integer: {
                            message: 'Only integer Value allowed'
                        },
                    }
                },
                
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The Email is required'
                        },
                        emailAddress: {
                            message: 'Please Enter Valid Email Address(test@test.com)'
                        },
                    }
                },
                city: {
                    validators: {
                        notEmpty: {
                            message: 'The City is required'
                        }
                    }
                },
                designation: {
                    validators: {
                        notEmpty: {
                            message: 'The designation is required'
                        }
                    }
                },
                status: {
                    validators: {
                        notEmpty: {
                            message: 'The Bank IFSC/SWIFT Code is required'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            var leadref = $('#lead_ref').val();
            
            
          //  alert(leadref); die(); 
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    //alert(data.data); die();
                    toastr.clear();
                    if (data.status == 1) {
                        // $('#bnm_' + bankref).text(data.data.bank_name);
                        // $('#ben_' + bankref).text(data.data.name_in_bank);
                        // $('#accn_' + bankref).text(data.data.account_number);
                        // $('#bha_' + bankref).text(data.data.branch_address);
                        // $('#sw_' + bankref).text(data.data.ifsc_code);
                       // $('#bc_' + bankref).text(data.data.branch_code);
                        toastr.success(data.message);
                        $('#adedit_lead').modal('hide');
                       // $form.data('bootstrapValidator').resetForm(true);
                        window.location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });
        });
        
        



    var segment = <?= $this->uri->segment($this->config->item('uri_segment')) != '' ? $this->uri->segment($this->config->item('uri_segment')) : 0 ?>;
    if (segment == 'ManageCredit') {
        segment = '';
    }
    var search_by = '<?= isset($_GET['search_by']) ? $_GET['search_by'] : 0 ?>';
    var condition = '<?= isset($_GET['condition']) ? $_GET['condition'] : 0 ?>';
    var query = '<?= isset($_GET['query']) ? $_GET['query'] : 0 ?>';
    document.getElementById("excel_button").onclick = function() {
        window.open(basepath + "apcompundpower/leads_excel/" + segment + "?search_by=" + search_by + "&condition=" + condition + "&query=" + query, "_self");
    }
</script>