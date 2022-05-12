
function readURL(input, element) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#' + element).attr('src', e.target.result).addClass("image_bg");

    };

    reader.readAsDataURL(input.files[0]);
  }
}


$(document).ready(function() {
    

    $('#sandbox-container .input-daterange').datepicker({
        format: "dd/mm/yyyy",
        endDate: "today",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom left"
    });

    //start select2 Functionality for select user for delete package
    
    $("#select_user_del_package").select2({
        multiple: true,
        minimumInputLength: 3,
        allowClear: false,
        placeholder: "Search for EMP ID/ First name",
        ajax: {
            url: basepath + 'process/searchusername',
            type: "post",
            dataType: 'json',
            delay: 50,
            data: function(params) {
                return {
                    username: params.term, // search term
                    type: 'admin',
                    utype: 'admin'
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    $('#select_user_del_package').on('select2:select', function(e) {
        var data = e.params.data;
        var userid = data.id;
        if ($("#user_id").val() != '') {
            var latest = $("#user_id").val() + ',' + jQuery.trim(userid);
        } else {
            var latest = jQuery.trim(userid);
        }
        $("#user_id").val(latest);
    });



    //start select2 Functionality for select user 
    $("#select_users").select2({
        minimumInputLength: 3,
        allowClear: false,
        placeholder: "Search for EMP ID/ First name",
        ajax: {
            url: basepath + 'process/searchusername',
            type: "post",
            dataType: 'json',
            delay: 50,
            data: function(params) {
                return {
                    username: params.term, // search term
                     type: 'admin',
                     utype: 'admin'
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
   

    //start select2 Functionality for select multiple user 
    $("#select_usersnot").select2({
        multiple: true,
        minimumInputLength: 3,
        allowClear: false,
        placeholder: "Search for EMP ID/ First name",
        ajax: {
            url: basepath + 'process/searchusername',
            type: "post",
            dataType: 'json',
            delay: 50,
            data: function(params) {
                return {
                    username: params.term, // search term
                    type: 'admin',
                    utype: 'admin'
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    $('#select_usersnot').on('select2:select', function(e) {
        var data = e.params.data;
        var userid = data.id;
        if ($("#user_id").val() != '') {
            var latest = $("#user_id").val() + ',' + jQuery.trim(userid);
        } else {
            var latest = jQuery.trim(userid);
        }
        $("#user_id").val(latest);
    });
    //end
    $('#add_faqfm').bootstrapValidator({
            fields: {
                department_id: {
                    validators: {
                        notEmpty: {
                            message: 'Please Select Department'
                        }
                    }
                },
                question: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Question'
                        }
                    }
                },
                answer: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Answer'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            var msg = '';
            var transferuser = $('#select_users :selected').text();
            var transfertype = $('#transaction_type :selected').text();
            var transferamt = $('#amount').val();
            var faq = $('#faq_refidin').val();
            if (typeof faq === "undefined") {
                msg = 'add';
            } else {
                msg = 'Update';
            }
            swal({
                title: 'Are you sure',
                text: "To " + msg + " this as Frequently asked question?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#add_faqfm')[0].submit();
                } else if (result.dismiss === swal.DismissReason.cancel) {

                }
            });
        });
    $('#send_notifiactionfm').bootstrapValidator({
            fields: {
                subject: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Subject'
                        }
                    }
                },
                nmessage: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Message'
                        }
                    }
                },
                filename: {
                    validators: {
                        file: {
                            extension: 'jpeg,png,jpg',
                            type: 'image/jpeg,image/png,image/jpg',
                            //maxSize: 2048 * 1024,
                            message: 'Only (jpeg,png and jpg) Image Files are allowed.'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            $('#send_notifiactionfm')[0].submit();

        });

    $('#mether_usercredits').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                user_id: {
                    validators: {
                        notEmpty: {
                            message: 'The User is required'
                        }
                    }
                },
                amount: {
                    validators: {
                        notEmpty: {
                            message: 'The Transfer Amount is required'
                        },
                        integer: {
                            message: 'Only integer Value allowed'
                        },
                        callback: {
                            callback: function(value, validator, $field) {
                                var cpassword = $("input[name=amount]").val();
                                if (value <= 0) {
                                    return false;
                                }

                                // Check the password strength
                                
                                return true;
                            }
                        }
                    }
                }
            }
        })
        .on('error.validator.bv', function(e, data) {
            // $(e.target)    --> The field element
            // data.bv        --> The BootstrapValidator instance
            // data.field     --> The field name
            // data.element   --> The field element
            // data.validator --> The current validator name

            data.element
                .data('bv.messages')
                // Hide all the messages
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                // Show only message associated with current validator
                .filter('[data-bv-validator="' + data.validator + '"]').show();
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            var transferuser = $('#select_users :selected').text();
            var transfertype = $('#transaction_type :selected').text();
            var transferamt = $('#amount').val();
            swal({
                title: 'Are you sure',
                text: "To " + transfertype + " " + transferamt + " Power credit to " + transferuser + " ?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: true,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    //$form.submit();
                    $('#mether_usercredits')[0].submit();
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    $('#select_users').val(null).trigger('change');
                    $('#mether_usercredits')[0].reset();
                    $form.data('bootstrapValidator').resetForm(true);
                }
            });
        });
    //end select2 functionality

    $('#edbank_delsfrm').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                bnk_beneficery: {
                    validators: {
                        notEmpty: {
                            message: 'The Beneficiary Name is required'
                        }
                    }
                },
                bank_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Bank Name is required'
                        },
                    }
                },
                branch_address: {
                    validators: {
                        notEmpty: {
                            message: 'The Branch Address is required'
                        },
                    }
                },
                
                bnk_accountno: {
                    validators: {
                        notEmpty: {
                            message: 'The Account Number is required'
                        }
                        // ,
                        // remote: 
                        // {
                        //     message: 'This Account No. already Exits.',
                        //     type: 'POST',
                        //     url: basepath + 'check-account',
                        //     data: function(validator) {
                        //         return {
                        //             bnkex: validator.getFieldElements('bank_ref').val(),
                        //             type: 'admin',
                        //             user: $('#userref').text(),
                        //         };
                        //     },
                        // }
                    }
                },
                ifsc_code: {
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
            var bankref = $('#bank_ref').val();
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                   // alert(data.data); die();
                    toastr.clear();
                    if (data.status == 1) {
                        $('#bnm_' + bankref).text(data.data.bank_name);
                        $('#ben_' + bankref).text(data.data.name_in_bank);
                        $('#accn_' + bankref).text(data.data.account_number);
                        $('#bha_' + bankref).text(data.data.branch_address);
                        $('#sw_' + bankref).text(data.data.ifsc_code);
                       // $('#bc_' + bankref).text(data.data.branch_code);
                        toastr.success(data.message);
                        $('#adedit_bank').modal('hide');
                        $form.data('bootstrapValidator').resetForm(true);
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
        
        
        
        
        
        
        
        
        $('#add_ebank_data').bootstrapValidator({
            excluded: ':disabled',
            fields: {
               
                bank_name: {
                    validators: {
                        notEmpty: {
                            message: 'The Bank Name is required'
                        },
                    }
                },
                status: {
                    validators: {
                        notEmpty: {
                            message: 'Please Select Status'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                   // alert(data.data); die();
                    toastr.clear();
                    if (data.status == 1) {
                        
                        toastr.success(data.message);
                        $('#adedit_bank').modal('hide');
                        $form.data('bootstrapValidator').resetForm(true);
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
        
        
        // bank image
        
        $('#edbank_delsfrm_img').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                
                bank_proof: {
                    validators: {
                      notEmpty: {
                        message: 'Bank Proof is required'
                      },
                      file: {
                        extension: 'jpeg,png,jpg',
                        type: 'image/jpeg,image/png,image/jpg',
                        //maxSize: 2048 * 1024,
                        message: 'Only (jpeg,png and jpg) Image Files are allowed.'
                      }
                    }
                  }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
        //    var bankref = $('#bank_ref_img').val();
            $.ajax({
               type: "POST",
                url: $form.attr('data-action'),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    //alert(data); die();
                    toastr.clear();
                    if (data.status == 1) {
                        document.getElementById('bank_div_upd').style.display = 'none';
                      //  document.getElementById('bank_div_upd').style.display = 'block';
                        toastr.success(data.message);
                        $('#adedit_bank_img').modal('hide');
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                },
                error: function(data) {
                    alert(data.error); die();
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });
        });
        
        /////
        
        // pancard image update
        
        $('#edkyc_delsfrm_img').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                
                kyc_proof: {
                    validators: {
                      notEmpty: {
                        message: 'Image is required'
                      },
                      file: {
                        extension: 'jpeg,png,jpg',
                        type: 'image/jpeg,image/png,image/jpg',
                        //maxSize: 2048 * 1024,
                        message: 'Only (jpeg,png and jpg) Image Files are allowed.'
                      }
                    }
                  }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            var bankref = $('#ref_img').val();
            
            var pic_type = $('#pic_type').val();
            
            $.ajax({
               type: "POST",
                url: $form.attr('data-action'),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                   // alert(data); die();
                    toastr.clear();
                    if (data.status == 1) {
                        document.getElementById('pan_div_upd').style.display = 'none';
                   //     document.getElementById('pan_div').style.display = 'block';
                        toastr.success(data.message);
                        $('#adedit_kyc_img').modal('hide');
                        $form.data('bootstrapValidator').resetForm(true);
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
        
        /////
        
       
    $('#reject_kycfm').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                reject_remark: {
                    validators: {
                        notEmpty: {
                            message: 'The Remark is required'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault(); 
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        if (data.type == 1) {
                            if (data.action == 3) {
                                $('#nid_img').attr('src', basepath + 'assets/images/id-card.png');
                                $('.nationid_divst').html('');
                                $('.nationid_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                                $('#nid_div').remove();
                            } else {
                                $('.nationid_divst').html('');
                                $('.nationid_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                            }
                        }  
                        else if (data.type == 4) {
                            if (data.action == 3) {
                                $('#pan_img').attr('src', basepath + 'assets/images/id-card.png');
                                $('.panr_divst').html('');
                                $('.panr_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                                $('#pan_div').remove();
                            } else {
                                $('.panr_divst').html('');
                                $('.panr_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                            }
                            //$('#nid_div').remove();
                        } 
                        else if (data.type == 5) {
                            if (data.action == 3) {
                                $('#bank_img').attr('src', basepath + 'assets/images/id-card.png');
                                $('.bankp_divst').html('');
                                $('.bankp_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                                $('#bank_div').remove();
                            } else {
                                $('.bankp_divst').html('');
                                $('.bankp_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                            }
                            //$('#nid_div').remove();
                      } else {
                            if (data.action == 3) {
                                $('#ap_img').attr('src', basepath + 'assets/images/id-card.png');
                                $('.addressp_divst').html('');
                                $('.addressp_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                                $('#ap_div').remove();
                            } else {
                                $('.addressp_divst').html('');
                                $('.addressp_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                            }
                        }
                        toastr.success(data.message);
                        window.location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                    $('#reject_kycfm').bootstrapValidator('resetForm', true);
                    $('#reject_kyc').modal('hide');
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });
        });


    $('#adedit_bank')
        .on('shown.bs.modal', function() {
            $('#edbank_delsfrm').find('[name="bnk_beneficery"]').focus();
        })
        .on('hidden.bs.modal', function() {
            $('#edbank_delsfrm').bootstrapValidator('resetForm', true); //disableSubmitButtons(disabled)
        });
    $('#reject_kyc')
        .on('shown.bs.modal', function() {
            $('#reject_kycfm').find('[name="reject_remark"]').focus();
        })
        .on('hidden.bs.modal', function() {
            $('#reject_kycfm').bootstrapValidator('resetForm', true); //disableSubmitButtons(disabled)
        });

    $('#bitcoin-card-edit')
        .on('shown.bs.modal', function() {
            $('#crypto_paymentfm').find('[name="cryppayment_val"]').focus();
        })
        .on('hidden.bs.modal', function() {
            $('#cryppayment_type').val('');
            $('#method_name').text('');
            $('#method_image').attr('src', '');
            $('#cryppayment_val').attr('placeholder', '');
            $('#crypto_paymentfm').bootstrapValidator('resetForm', true);
        });
    

    //end tree functions
    $(".checkalluser").change(function() {
        if (this.checked) {
            $(".usercheck").each(function() {
                this.checked = true;
            })
        } else {
            $(".usercheck").each(function() {
                this.checked = false;
            })
        }
    });

    $(".usercheck").click(function() {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;
            $(".usercheck").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            })
            if (isAllChecked == 0) { $(".checkalluser").prop("checked", true); }
        } else {
            $(".checkalluser").prop("checked", false);
        }
    });
    //ends
    $('.submitbttn').prop('disabled', false);
});

/*Initial node open and Toggle between folder open and folder closed Jstree*/


$('#close_ticket').click(function() {
    swal({
        title: 'Are you sure',
        text: "To Close this Ticket?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            var refid = $(this).attr('data-ref');
            $.post(basepath + "process/closeTicket", { ticketid: refid, 'utype': 'admin' }, function(data) {
                toastr.clear();
                if (data.status == 1) {
                    window.location.href = data.url;
                } else if (data.status == 0) {
                    toastr.error(data.message);
                } else {
                    toastr.error(data.message);
                }
            }, "json");
        } else if (result.dismiss === swal.DismissReason.cancel) {}
    });
});






$(".kyc_update").click(function(e) {
    var doc = $(this).attr('data-doc');
    var val = $(this).attr('data-val');
    var userref = $('#userref').text();
    if (val == 2) {
        $.ajax({
            type: "POST",
            url: basepath + 'common/updatekyc',
            data: { 'type': doc, 'val': val, 'ref': userref },
            dataType: "json",
            success: function(data) {
                toastr.clear();
                if (data.status == 1) {
                    if (data.type == 1) {
                        if (data.action == 3) {
                            $('#nid_img').attr('src', basepath + 'assets/images/id-card.png');
                            $('.nationid_divst').html('');
                            $('.nationid_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                            $('#nid_div').remove();
                        } else {
                            $('.nationid_divst').html('');
                            $('.nationid_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                        }
                        toastr.success(data.message);
                        window.location.reload();
                        //$('#nid_div').remove();
                    } 
                    else if (data.type == 4) {
                        if (data.action == 3) {
                            $('#pan_img').attr('src', basepath + 'assets/images/id-card.png');
                            $('.panr_divst').html('');
                            $('.panr_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                            $('#pan_div').remove();
                        } else {
                            $('.panr_divst').html('');
                            $('.panr_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                        }
                        toastr.success(data.message);
                         window.location.reload();
                        //$('#nid_div').remove();
                    } 
                    else if (data.type == 5) {
                        if (data.action == 3) {
                            $('#bank_img').attr('src', basepath + 'assets/images/id-card.png');
                            $('.bankp_divst').html('');
                            $('.bankp_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                            $('#bank_div').remove();
                        } else {
                            $('.bankp_divst').html('');
                            $('.bankp_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                        }
                        //$('#nid_div').remove();
                        toastr.success(data.message);
                         window.location.reload();
                    } else {
                        if (data.action == 3) {
                            $('#ap_img').attr('src', basepath + 'assets/images/id-card.png');
                            $('.addressp_divst').html('');
                            $('.addressp_divst').html('<strong><span class="font-red-thunderbird">Rejected</span><strong>');
                            $('#ap_div').remove();
                        } else {
                            $('.addressp_divst').html('');
                            $('.addressp_divst').html('<strong><span class="font-green-jungle">Approved</span><strong>');
                        }
                        //$('#ap_div').remove();
                        toastr.success(data.message);
                        window.location.reload();
                    }
                    toastr.success(data.message);
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
    } else if (val == 3) {
        $('#type').val(doc);
        $('#val').val(val);
        $('#ref').val(userref);
        $('#reject_kyc').modal('show');
    } else {
        toastr.error('Invalid Selection.');
    }
});


$("#userdels_updatefm").submit(function(e) {
    e.preventDefault();
    var userref = $('#userref').text();
    $.ajax({
        type: "POST",
        url: $('#userdels_updatefm').attr('data-action'),
        data: $('#userdels_updatefm').serialize() + '&ref=' + userref,
        dataType: "json",
        success: function(data) {
            toastr.clear();
            if (data.status == 1) {
                toastr.success(data.message);
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

$(".adbank_popup").click(function(e) {
    
    
    var a = $(this).attr('data-ref');
    if(a > '0'){
     
            $.ajax({
                type: "POST",
                url: basepath + 'process/banks_details',
                data: { 'ref': $(this).attr('data-ref'), 'utype': 'admin' },
                dataType: "json",
                success: function(data) {
                    toastr.clear();
                    //alert(data); die();
                    if (data.status == 1) { 
                        $('#name_in_bank').val(data.data.name_in_bank);
                        $('#bank_name').val(data.data.bank_name);
                        $('#branch_address').val(data.data.branch_address);
                        $('#account_number').val(data.data.account_number);
                        $('#ifsc_code').val(data.data.ifsc_code);
                        $('#branch_code').val(data.data.branch_code);
                        $('#bank_ref').val(data.data.id);
                        
                        $('#b_user_id').val(data.data.user_id);
                        $('#adedit_bank').modal('show');
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
         $('#adedit_bank').modal('show');
    }
});


$(".adbank_popup_img").click(function(e) {
    
          $('#bank_ref_img').val($(this).attr('data-ref'));
          $('#b_img_user_id').val($(this).attr('data-b_img_user_id'));
         $('#adedit_bank_img').modal('show');
});


$(".adkyc_popup_img").click(function(e) {
    
          $('#ref_img').val($(this).attr('data-ref'));
          $('#pic_type').val($(this).attr('data-pic_type'));
          $('#kyc_user_id').val($(this).attr('data-kyc_user_id'));
          
         $('#adedit_kyc_img').modal('show');
});


$(document).on("click", ".cryptocard_popup", function() {
    var type = $(this).attr('data-type');
    var name = $(this).attr('data-name');
    var image = $(this).attr('data-img');
    var placeholder = $(this).attr('data-holder');
    var address = $(this).attr('data-add');
    //alert(name+' '+image);
    $('#cryppayment_type').val(type);
    $('#method_name').text(name);
    $('#method_image').attr('src', basepath + image);
    $('#cryppayment_val').attr('placeholder', placeholder);
    $('#cryppayment_val').val(address);
    //$('#crypto_paymentfm').bootstrapValidator('resetForm', true);
    $('#bitcoin-card-edit').modal('show');
});
window.onload = function() {
    $('.submitbttn').prop('disabled', false);
}

jQuery(".req_action").click(function() {
    var action = jQuery(this).val();
    var tbl = jQuery(this).data("tbl");

    var function_name = "";
    if (jQuery(this).data("action") != "") {
        function_name = jQuery(this).data("action");
    }

    jQuery(".app_req").each(function() {
        var id = jQuery(this).attr("id");
        if (jQuery("#chk_" + id).is(':checked')) {
            requestAction(id, action, tbl, function_name);
        }
    });
});

$('.change_status').click(function(e) {
    toastr.clear();
    var checkarr = [];
    var msg = '';
    var action = $(this).attr('data-status');
    if (action == 0) {
        msg = 'Deactivate';
    } else if (action == 1) {
        msg = 'Activate';
    } else {
        toastr.error('Unknown Status, Something Went Wrong.');
        return false;
    }
    $(".usercheck:checked").each(function() {
        checkarr.push($(this).val());
    });
    if (checkarr.length > 0) {
        swal({
            title: 'Are you sure',
            text: "To " + msg + " selected users?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proceed',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: basepath + 'process/change_status',
                    data: { 'ref': action, 'values': checkarr, 'type': 2, 'utype': 'admin' },
                    dataType: "json",
                    success: function(data) {
                        toastr.clear();
                        if (data.status == 1) {
                            window.location.reload();
                        } else if (data.status == 0) {
                            toastr.error(data.message);
                        } else {
                            toastr.error('Unknown Response, Something Went Wrong.');
                        }

                    },
                    error: function(data) {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                });
            } else if (result.dismiss === swal.DismissReason.cancel) {

            }
        });
    } else {
        toastr.error('Please select some user to ' + msg + '.');
    }
});
$(".table tr").on('click', '.status_up', function(e) {
    
    //alert("sssasdds");
    
     var user = $(this).closest("tr").find(".usercheck").val(); //.find(".pd-price")
   // var user=1;
    var msg = '';
    var text = '';
    var nwstatus = '';
    var addclass = '';
    var removeclass = '';
    var action = $(this).attr('data-status');
    
   // alert(user); 
    
    if (action == 2) {
        msg = 'Deactivate';
        text = 'Inactive';
        nwstatus = 1;
        addclass = 'label-danger';
        removeclass = 'label-success';
    } else if (action == 1) {
        msg = 'Activate';
        text = 'Active';
        nwstatus = 2;
        addclass = 'label-success';
        removeclass = 'label-danger';
    } else {
        toastr.error('Unknown Status, Something Went Wrong.');
        return false;
    }
    if (user != '' && user > 0) {
        swal({
            title: 'Are you sure',
            text: "To " + msg + " selected Agent?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proceed',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: basepath + 'process/change_status',
                    data: { 'ref': action, 'values': user, 'type': 1, 'utype': 'admin' },
                    dataType: "json",
                    success: function(data) {
                        toastr.clear();
                        if (data.status == 1) {
                            toastr.success(data.message);
                            $('#status_span_' + user).text(text);
                            $('#statusa_tag_' + user).attr('data-status', nwstatus);
                            $('#status_span_' + user).removeClass(removeclass);
                            $('#status_span_' + user).addClass(addclass);
                        } else if (data.status == 0) {
                            toastr.error(data.message);
                        } else {
                            toastr.error('Unknown Response, Something Went Wrong.');
                        }

                    },
                    error: function(data) {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                });
            } else if (result.dismiss === swal.DismissReason.cancel) {

            }
        });
    } else {
        toastr.error('Unknown Response, Something Went Wrong.');
    }
});



// delete agent by admin 

$(".table tr").on('click', '#delete_user', function(e) {
    
    //alert("sssasdds");
    
     var user = $(this).closest("tr").find(".usercheck").val(); //.find(".pd-price")
   // var user=1;
    var msg = '';
    var text = '';
    var nwstatus = '';
    var addclass = '';
    var removeclass = '';
    var action_id = $(this).attr('data-agent_id');
    
   // alert(user); 
    
    //if (action == 2) {
    //     msg = 'Deactivate';
    //     text = 'Inactive';
    //     nwstatus = 1;
    //     addclass = 'label-danger';
    //     removeclass = 'label-success';
    // } else if (action == 1) {
    //     msg = 'Activate';
    //     text = 'Active';
    //     nwstatus = 2;
    //     addclass = 'label-success';
    //     removeclass = 'label-danger';
    // } else {
    //     toastr.error('Unknown Status, Something Went Wrong.');
    //     return false;
    // }
    if (action_id != '' && action_id > 0) {
        swal({
            title: 'Are you sure',
            text: "To Delete selected Agent?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: basepath + 'process/delete_agent',
                    data: { 'ref': action_id, 'values': action_id, 'type': 1, 'utype': 'admin' },
                    dataType: "json",
                    success: function(data) {
                        toastr.clear();
                        if (data.status == 1) {
                            toastr.success(data.message);
                        //    location.reload();
                            // $('#status_span_' + user).text(text);
                            // $('#statusa_tag_' + user).attr('data-status', nwstatus);
                            // $('#status_span_' + user).removeClass(removeclass);
                            // $('#status_span_' + user).addClass(addclass);
                        } else if (data.status == 0) {
                            toastr.error(data.message);
                        } else {
                            toastr.error('Unknown Response, Something Went Wrong.');
                        }

                    },
                    error: function(data) {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                });
            } else if (result.dismiss === swal.DismissReason.cancel) {

            }
        });
    } else {
        toastr.error('Unknown Response, Something Went Wrong.');
    }
});



//// vikash kyc approved
$(".table tr").on('click', '.kycapp_up', function(e) {
    var user = $(this).closest("tr").find(".usercheck").val(); //.find(".pd-price")
    var msg = '';
    var text = '';
    var nwstatus = '';
    var addclass = '';
    var removeclass = '';
    var action = $(this).attr('data-status');
    //alert(action); die(); 
    if (action == 2) {
        msg = 'Approve KYC';
        text = 'KYC Approved';
        text1 = 'Reject KYC';
        nwstatus = 3;
        addclass = 'label-success';
        removeclass = 'label-danger';
    } else if (action == 3) {
        msg = 'Rejected KYC';
        text = 'KYC Rejected ';
        text1 = 'Approve KYC';
        nwstatus = 2;
        addclass = 'label-danger';
        removeclass = 'label-success';
    } else {
        toastr.error('Unknown Status, Something Went Wronggg.');
        return false;
    }
    if (user != '' && user > 0) {
        swal({
            title: 'Are you sure',
            text: "To " + msg + " selected users?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proceed',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: basepath + 'process/change_status_kyc',
                    data: { 'ref': action, 'values': user, 'type': 1, 'utype': 'admin' },
                    dataType: "json", 
                    success: function(data) {
                      //  alert(data); die();
                        toastr.clear();
                        if (data.status == 1) {
                            toastr.success(data.message);
                            
                            $('#m_id_' + user).text(text);
                            $('#kycapp_span_' + user).text(text1);
                            $('#kycapp_tag_' + user).attr('data-status', nwstatus);
                            $('#m_id_' + user).removeClass(removeclass);
                            $('#m_id_' + user).addClass(addclass);
                        } else if (data.status == 0) {
                            toastr.error(data.message);
                        } else {
                            toastr.error('Unknown Response, Something Went Wrongg.');
                        }

                    },
                    error: function(data) {
                         //  alert(data); die();
                        toastr.error('Unknown Response, Something Went Wrongss.');
                    }
                });
            } else if (result.dismiss === swal.DismissReason.cancel) {

            }
        });
    } else {
        toastr.error('Unknown Response, Something Went Wrong.');
    }
});
/////vikash kyc approved

//// vikash deactive pckage




$("#faq_table tr").on('click', '.status_change', function(e) {
    var faq = $(this).closest("tr").attr('data-val');
    var msg = '';
    var text = '';
    var nwstatus = '';
    var addclass = '';
    var removeclass = '';
    var action = $(this).attr('data-status');
    if (action == 0) {
        msg = 'Deactivate';
        text = 'Inactive';
        nwstatus = 1;
        addclass = 'btn-warning';
        removeclass = 'btn-success';
    } else if (action == 1) {
        msg = 'Activate';
        text = 'Active';
        nwstatus = 0;
        addclass = 'btn-success';
        removeclass = 'btn-warning';
    } else {
        toastr.error('Unknown Status, Something Went Wrong.');
        return false;
    }
    swal({
        title: 'Are you sure',
        text: "To " + msg + " selected FAQ?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: basepath + 'process/change_faq_status',
                data: { 'ref': action, 'values': faq, 'utype': 'admin' },
                dataType: "json",
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        toastr.success(data.message);
                        $('#status_' + faq).text(text);
                        $('#status_' + faq).attr('data-status', nwstatus);
                        $('#status_' + faq).removeClass(removeclass);
                        $('#status_' + faq).addClass(addclass);
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }

                },
                error: function(data) {
                    toastr.error('Unknown Response, Something Went Wrong.');
                }
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {

        }
    });
});

$("#faq_table tr").on('click', '.delete_faq', function(e) {
    var faq = $(this).closest("tr").attr('data-val');
    swal({
        title: 'Are you sure',
        text: "To Delete selected FAQ?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: basepath + 'process/delete_faq',
                data: { 'values': faq, 'utype': 'admin' },
                dataType: "json",
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }

                },
                error: function(data) {
                    toastr.error('Unknown Response, Something Went Wrong.');
                }
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {

        }
    });
});


// drlete notification by admin   vikash


$("#notification_table tr").on('click', '.delete_unotification_admin', function(e) {
//$('.delete_unotification_admin').click(function(e) {   
   //alert('asasasas'); die(); 
   
   swal({
        title: 'Are you sure',
        text: "To Delete selected Notification ?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            
            //alert('asdsds');die();
            $.ajax({
                type: "POST",
                url: basepath + 'process/delete_notification_admin', 
                data: {
                  'ref': $(this).attr('data-ref')
                },
                dataType: "json",
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        toastr.success(data.message);
                        location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }

                },
                error: function(data) {
                    toastr.error('Unknown Response, Something Went Wrong.');
                }
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {

        }
    });
});



//////////////

$("#faq_table tr").on('click', '.edit_faq', function(e) {
    var faq = $(this).closest("tr").attr('data-val');
    var dep = $(this).closest("tr").find(".department").attr('data-ref');
    var question = $(this).closest("tr").find(".edquestion").text();
    var answer = $(this).closest("tr").find(".edanswer").text();

    $('#faqfm_id').html('');
    $('#faqfm_id').html('<button class="btn blue" type="submit"></i>Update</button> <button class="btn blue" type="button" id="cancel_fqedit"></i>Cancel</button>');
    $('#add_faqfm').bootstrapValidator('resetForm', true);

    $('#department_id option[selected="selected"]').each(
        function() {
            $(this).removeAttr('selected');
        }
    );

    $("#department_id option[value=" + dep + "]").prop('selected', true);
    $("#faq_question").val(question);
    $("textarea#faq_answer").val(answer);
    $('#faq_refidin').remove();
    $('<input>').attr('type', 'hidden').attr('name', 'faq_ref').attr('id', 'faq_refidin').attr('value', faq).appendTo('#add_faqfm');

});
$(document).on("click", "#cancel_fqedit", function() {
    $('#faq_refidin').remove();
    $('#faqfm_id').html('');
    $('#faqfm_id').html('<button class="btn blue" type="submit"></i>Add FAQ</button>');
    $('#add_faqfm').bootstrapValidator('resetForm', true);
    $('#department_id option[selected="selected"]').each(
        function() {
            $(this).removeAttr('selected');
        }
    );
    $("#department_id option:first").prop('selected', true);
});
$(document).on('click', '.clearForm', function() {
    $("input[type=text]").val("");
    $("input[type=file]").val("");
    $(document).find('.emptyarea').val('');
    $(document).find('.help-block').html('input file here');
    $('#send_notifiactionfm').bootstrapValidator('resetForm', true);
    $('.select').val('0');
    $("input[type=checkbox]").removeAttr("checked");
});
$(document).on("input", ".sentto_num", function() {
    this.value = this.value.replace(/([a-zA-Z `~!@#$%^&*()_|+\-=?;:'".<>\{\}\[\]\\\/])/g, '');
    //$(this).val(this.value);
});

$('.user_paid').click(function() {
    var user_ref = $(this).attr('data-ref');
    var fullname = $(this).attr('data-ufname');
    var kycst = $(this).attr('data-kyc');
    var kycmsg = '';
    if (kycst == 0) {
        var kycmsg = 'KYC Process for this User is not Completed Yet.'
    }

    if (user_ref) {
        swal({
            title: 'Are you sure',
            html: "To Convert " + fullname + "(" + user_ref + ") as Paid User?<br>" + kycmsg,
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proceed',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: basepath + 'common/make_user_paid',
                    data: { 'phone': user_ref },
                    dataType: "json",
                    success: function(data) {
                        toastr.clear();
                        if (data.status == 1) {
                            $('.user_paid').remove();
                            toastr.success(data.message);
                        } else if (data.status == 0) {
                            toastr.error(data.message);
                        } else {
                            toastr.error('Unknown Response, Something Went Wrong.');
                        }

                    },
                    error: function(data) {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                });
            } else if (result.dismiss === swal.DismissReason.cancel) {

            }
        });
    } else {
        toastr.error('There is an issue to Paid this User. Please try after Sometime.');
    }
});

$('.loginadmtousr').click(function() {
    var user_ref = $(this).attr('data-ref');
    $.ajax({
        type: "POST",
        url: basepath + 'login-me',
        data: { 'ref': user_ref, 'action': 'user_lookup' },
        dataType: "json",
        success: function(data) {
            toastr.clear();
            if (data.status == 1) {
                window.open(basepath + '' + data.url, '_blank');
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error('Unknown Response, Something Went Wrong.');
            }

        },
        error: function(data) {
            toastr.error('Unknown Response, Something Went Wrong.');
        }
    });
});

$('.Pmstatus_change').click(function() {
    var message = '';
    var status = $(this).attr('data-status');
    var ref = $(this).attr('data-ref');
    if (status == 0) {
        message = 'To Deactivate This Payment Method';
    } else {
        message = 'To Activate This Payment Method';
    }
    swal({
        title: 'Are you sure',
        text: message,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: basepath + 'process/change_paymeth_status',
                data: { 'methref': ref, 'changeto': status, 'utype': 'admin' },
                dataType: "json",
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }

                },
                error: function(data) {
                    toastr.error('Unknown Response, Something Went Wrong.');
                }
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {

        }
    });
});

// vikash

// manage popup

$('#Form_manage_popup').bootstrapValidator({ 
            //excluded: ':disabled',
            fields: {
                popup_name: {
                    validators: {
                        notEmpty: {
                            message: 'Pop Up Name is required'
                        }
                    }
                },
                status: {
                    validators: {
                        notEmpty: {
                            message: 'Please select status'
                        }
                    }
                },
            }
        }).on('error.validator.bv', function(e, data) {
            // $(e.target)    --> The field element
            // data.bv        --> The BootstrapValidator instance
            // data.field     --> The field name
            // data.element   --> The field element
            // data.validator --> The current validator name

            data.element
                .data('bv.messages')
                // Hide all the messages
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                // Show only message associated with current validator
                .filter('[data-bv-validator="' + data.validator + '"]').show();
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            //startloader('loader');
            //$("#ecahsub").hide();
            //var depName = $('#depName').val();
            //console.log(depName);

          //  var data = $('form').serialize();
            //var vurl= basepath + 'apcompundpower/departments';
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) { 
                    // alert(data); die();
                     if (data.status == 1) { 
                       
                        //var dd = JSON.parse(data);
                        $(".error").hide();
                        $('.mymodl_update_mpopup').modal('hide');
                        $("#Form_manage_popup").trigger('reset');
                        
                        toastr.success(data.message);
                        location.reload();
                     } else if (data.status == 0) { 
                        toastr.error(data.message);
                        $('.mymodl_update_mpopup').modal('hide');
                        $("#Form_manage_popup").trigger('reset');
                       // location.reload();
                     } else {
                        toastr.error('Unknown Response, Try again after sometime');
                     }
                },
                error: function(data) {
                    //console.log(data);
                    //alert(data);
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                    //stoploader('loader');
                }
            });
        });


/////////////

$('#newModalForm_dep').bootstrapValidator({ 
            //excluded: ':disabled',
            fields: {
                depName: {
                    validators: {
                        notEmpty: {
                            message: 'Department Name is required'
                        }
                    }
                },
            }
        }).on('error.validator.bv', function(e, data) {
            // $(e.target)    --> The field element
            // data.bv        --> The BootstrapValidator instance
            // data.field     --> The field name
            // data.element   --> The field element
            // data.validator --> The current validator name

            data.element
                .data('bv.messages')
                // Hide all the messages
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                // Show only message associated with current validator
                .filter('[data-bv-validator="' + data.validator + '"]').show();
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            //startloader('loader');
            //$("#ecahsub").hide();
            var depName = $('#depName').val();
            //console.log(depName);

            var data = $('form').serialize();
            var vurl= basepath + 'apcompundpower/departments';
            $.ajax({
               // alert(depName); die();
                
                type: "POST",
                url: basepath + 'apcompundpower/Add_departments',
               // data: $form.serialize(), // serializes the form's elements.
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                     //alert(data); die();
                     if (data.status == 1) { 
                       
                        //var dd = JSON.parse(data);
                        $(".error").hide();
                        $('.mymodl').modal('hide');
                        $("#newModalForm_dep").trigger('reset');
                        
                        toastr.success(data.message);
                      //toastr.success(dd.message);
                      $('#sample_1').load(vurl + ' #sample_1');    
                     } else if (data.status == 0) { 
                        toastr.error(data.message);
                        $('.mymodl').modal('hide');
                        $("#newModalForm_dep").trigger('reset');
                        location.reload();
                     } else {
                        toastr.error('Unknown Response, Try again after sometime');
                     }
                },
                error: function(data) {
                    //console.log(data);
                    //alert(data);
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                    //stoploader('loader');
                }
            });
        });


////////////////
// not in use
// $('.submit').click(function(e) { 
//     alert('asas'); die();
//             e.preventDefault();
//             var depName = $('#depName').val();
//             console.log(depName);

//             var data = $('form').serialize();
//             var vurl= "<?=base_url()?>apcompundpower/departments";
//             $.ajax({
//                 type: "POST",
//                 url: "<?=base_url()?>apcompundpower/Add_departments",
//                 data: data,
//                 success: function(data) {
//                     var dd = JSON.parse(data);
//                     $(".error").hide();
//                     $('.mymodl').modal('hide');
//                     $("#newModalForm").trigger('reset');

//                   toastr.success(dd.message);
//                   $('#sample_1').load(vurl + ' #sample_1');
//                 },
//                 error: function() {
//                     alert('error handling here');
//                 }
//             });
//         });


       

$("#DepModalForm").bootstrapValidator({
    //alert('asdasd'); die();
    rules: {
      username: {
        required: true,
      },
      email: {
        required: true,
        email: true
      },
      mobile: {
        required: true,
        digits: true,
        minlength: 10
      },
      action: "required"
    },
    messages: {
      username: {
        required: "Please enter username.",
      },
      email: {
        required: "Please enter email.",
      },
      mobile: {
        required: "Please enter mobile number.",
      },
      action: "Please provide some data"
    }
});

  $('#submitUser').click(function() {
      
      
          // e.preventDefault();
            var depID       = $('#department_id').val();
            var UserName    = $('#username').val();
            var UserMobile  = $('#mobile').val();
            var UserEmail   = $('#email').val();
//alert(UserEmail); die();
            // console.log(depID,"----",UserEmail,"----",UserName,"----",UserMobile);
            // return false;

            if(UserName == '' && UserMobile == '' && UserEmail == '')
            {
                $("#DepModalForm").valid();
                return false;
            }
            var data = $('form').serialize();
        //    var vurl= "<?=base_url()?>apcompundpower/user_rights/"+depID;
            var vurl= basepath + 'apcompundpower/user_rights/'+depID;  
            $.ajax({
                type: "POST",
                url: basepath + 'apcompundpower/save_depuser',
                data: data, 
            //    dataType: "json",
                success: function(data) {
                   // alert(data); die();
                   // var dd = JSON.parse(data);
                   
                //     $('.mymodl').modal('hide');
                //     $("#DepModalForm").trigger('reset');
                //   toastr.success(dd.message);
                //   $('#sample_1').load(vurl + ' #sample_1');
                  
                  if (data.status == 1) { 
                        //var dd = JSON.parse(data);
                        $('.mymodl').modal('hide');
                        $("#DepModalForm").trigger('reset');
                        
                        toastr.success(data.message);
                      $('#sample_1').load(vurl + ' #sample_1');    
                     } else if (data.status == 0) { 
                        toastr.error(data.message);
                        $('.mymodl').modal('hide');
                        $("#DepModalForm").trigger('reset');
                        location.reload();
                     } else {
                        toastr.error('Unknown Response, Try again after sometime');
                     }
                  
                },
               error: function(data) {
                    //console.log(data);
                    //alert(data);
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                    //stoploader('loader');
                }
            });
        });


    // $(".manageuser").click(function(){
    //     var link = $(this).attr("data-link");
    //     console.log(link);
    //     sweetpopup(link);
    // })

    // function sweetpopup(link)
    // {
    //     swal({
    //             title: 'Error',
    //             text: "You don't have access for "+link+".",
    //             type: 'error',
    //             showCancelButton: false,
    //             confirmButtonColor: '#3085d6',
    //             cancelButtonColor: '#d33',
    //             confirmButtonText: 'OK',
    //             cancelButtonText: 'Cancel',
    //             confirmButtonClass: 'btn btn-success',
    //             cancelButtonClass: 'btn btn-danger',
    //             buttonsStyling: true,
    //             reverseButtons: true
    //         }).then((result) =>{

    //           location.reload();
    //     });
    // }



// custom vkp


// $('#adedit_lead')
//         .on('shown.bs.modal', function() {
//             $('#edlead_delsfrm').find('[name="lead_name"]').focus();
//         })
//         .on('hidden.bs.modal', function() {
//             $('#edlead_delsfrm').bootstrapValidator('resetForm', true); //disableSubmitButtons(disabled)
//         });

$(".table tr").on('click', '.deleteLead', function(e) {
    
    var msg = '';
    var text = '';
    var nwstatus = '';
    var addclass = '';
    var removeclass = '';
    var action_id = $(this).attr('data-id');
    
    if (action_id != '' && action_id > 0) {
        swal({
            title: 'Are you sure',
            text: "To delete selected lead?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: basepath + 'process/delete_lead',
                    data: { 'ref': action_id, 'values': action_id, 'type': 1, 'utype': 'admin' },
                    dataType: "json",
                    success: function(data) {
                        toastr.clear();
                        if (data.status == 1) {
                            toastr.success(data.message);
                            location.reload();
                        } else if (data.status == 0) {
                            toastr.error(data.message);
                        } else {
                            toastr.error('Unknown Response, Something Went Wrong.');
                        }

                    },
                    error: function(data) {
                        toastr.error('Unknown Response, Something Went Wrong.');
                    }
                });
            } else if (result.dismiss === swal.DismissReason.cancel) {

            }
        });
    } else {
        toastr.error('Unknown Response, Something Went Wrong.');
    }
});
    $(".show_fuel_records").click(function(){
    let carrier = $(this).attr("data-carrier");
    let company = $(this).attr("data-company");
    let billing = $(this).attr("data-billing");
    let acct = $(this).attr("data-acct");
    let acctype = $(this).attr("data-acctype");
    let pfj = $(this).attr("data-pfj");
    let fuel = $(this).attr("data-fuel");
    let share = $(this).attr("data-share");
    let totalshare = $(this).attr("data-totalshare");
    let createddate = $(this).attr("data-createddate");
    console.log(carrier,company,billing,acct,pfj,fuel,share,totalshare,createddate);
    $('#carrier').val(carrier);
    $('#company').val(company);
    $('#billing').val(billing);
    $('#acct').val(acct);
    $('#acctype').val(acctype);
    $('#pfj').val(pfj);
    $('#fuel').val(fuel);
    $('#share').val(share);
    $('#totalshare').val(carrier);
    $('#createddate').val(createddate);
    $('#show_fuel_lead').modal('show');

});

$(".adlead_popup").click(function(e) {
//$(".table tr").on('click', '.adlead_popup', function(e) {    
   // alert("aaaa"); 
   // $('#adedit_lead').modal('show'); die();
    var a = $(this).attr('data-ref');

    if(a > '0'){
     
            $.ajax({
                type: "POST",
                url: basepath + 'process/lead_details',
                data: { 'ref': $(this).attr('data-ref'), 'utype': 'admin' },
                dataType: "json",
                success: function(data) {
            //        toastr.clear();
                    if (data.status == 1) {
                        
                        $('#user_id').val(data.data[0].user_id);
                        $('#lead_ref_id').val(data.data[0].lead_id);
                        $('#lead_name').val(data.data[0].lead_name);
                        $('#company_name').val(data.data[0].company_name);
                        $('#phone').val(data.data[0].lead_phone);
                        $('#DOT_number').val(data.data[0].lead_dot_number);
                        $('#email').val(data.data[0].lead_mail);
                        $('#street').val(data.data[0].lead_street);
                        $('#city').val(data.data[0].lead_city);
                        $('#state').val(data.data[0].lead_state);
                        $('#zip_code').val(data.data[0].lead_zip_code);
                        $('#total_trucks').val(data.data[0].lead_total_trucks);
                        $('#potential_gallons').val(data.data[0].lead_potential_gallons);
                        $('#account').val(data.data[0].account);
                        
                    //    $('#status').val(data.data.status);
                        
                        $('#b_user_id').val(data.data[0].user_id);
                        
                        
                         var options = document.getElementById("lead_status").options;
                        for (var i = 0; i < options.length; i++) {
                            
                            
                      //     alert(options[1].value); die();
                          var sts = data.data[0].status;  
                            
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
                            message: 'The Phone No is required'
                        },
                        stringLength: {
                            min: 10,
                            max: 10,
                            message: 'Phone No should be 10 Digit Long'
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
                            message: 'The Designation is required'
                        }
                    }
                },
                status: {
                    validators: {
                        notEmpty: {
                            message: 'The Status is required'
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
        

 $('#addnewagent').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                // username: {
                //     validators: {
                //         notEmpty: {
                //             message: 'The Company Name is required'
                //         },
                //     }
                // },
                
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The Email is required'
                        },
                        emailAddress: {
                            message: 'Please Enter Valid Email Address(test@test.com)'
                        },
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            //var leadref = $('#lead_ref').val();
            
            
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
                        
                        toastr.success(data.message);
                        $('#addnewagentmodel').modal('hide');
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
        


// vkp 


jQuery("#conf_pwd").keyup(function() {
    if (jQuery(this).val() != "") {
        if (jQuery(this).val() === jQuery("#new_password").val()) {
            jQuery(this).css("border", "1px solid green");
            jQuery("#new_password").css("border", "1px solid green");
            jQuery(".change_passwoed").removeAttr("disabled");
        } else {
            jQuery(this).css("border", "1px solid red");
            jQuery("#new_password").css("border", "1px solid red");
            jQuery(".change_passwoed").attr("disabled", "disabled");
        }
    }
});

jQuery("#new_password").keyup(function() {
    if (jQuery(this).val() != "") {
        if (jQuery(this).val() === jQuery("#conf_pwd").val()) {
            jQuery(this).css("border", "1px solid green");
            jQuery("#conf_pwd").css("border", "1px solid green");
            jQuery(".change_passwoed").removeAttr("disabled");
        } else {
            jQuery(this).css("border", "1px solid red");
            jQuery("#conf_pwd").css("border", "1px solid red");
            jQuery(".change_passwoed").attr("disabled", "disabled");
        }
    }
});

$("#changepwd").submit(function(e) {
    e.preventDefault();
    var formdata = new FormData($(this)[0]);
    $.ajax({
        type: "POST",
        url: basepath + "admin/ispwd",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(data) {
            document.getElementById("demo").innerHTML = data;
            $('#changepwd').trigger("reset");
        }
    });
});


