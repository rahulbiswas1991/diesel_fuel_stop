function startloader(divid) { $("#" + divid).show(); }

function stoploader(divid) { $("#" + divid).fadeOut("slow"); } //loader
$("div.enrollmentfee_select").on("click", function() {
    $('.fee_select_tick').remove();
    $(this).children('div').prepend('<img src="' + basepath + 'assets/global/img/tick.png" class="fee_select_tick">');
    var val = $(this).attr('data-val');
    $('#u_enrollfee').val(val);
    $('#user_registration').bootstrapValidator('revalidateField', 'u_enrollfee');
});

console.log("basepath", basepath);
$(document).ready(function() {
    
    
    /// $("#select_usersnot").select2({
    
      function reg_userref(userid){
          $("#ref_uname").html('');
            $.ajax({
                type: "POST",
                url: basepath + 'reg-searchusername',
                data: 'ref_id='+userid, // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                  //var username_full = data.full_name; 
                 var dd =  data.full_name;
                   $("#ref_uname").html(dd);
                }
               
            });
      }
       
       
  //  });
    
    
    $('#user_registration').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                u_email: {
                    validators: {
                        notEmpty: {
                            message: 'The Email is required'
                        },
                        emailAddress: {
                            message: 'Please Enter Valid Email Address(test@test.com)'
                        },
                        remote: {
                            message: 'This frontend Email already Exists--',
                            type: 'POST',
                            url: basepath + 'check-duplicate'
                        }
                    }
                },
                ufirstname: {
                    validators: {
                        notEmpty: {
                            message: 'The First Name is required'
                        },
                        stringLength: {
                            min: 3,
                            max: 50,
                            message: 'Name should be of 5 to 10 characters.'
                        }
                    }
                },
                u_password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        },
                        callback: {
                            //message: 'Both Password should be same.',
                            callback: function(value, validator, $field) {
                                var cpassword = $("input[name=u_cpassword]").val();
                                if (value === '') {
                                    return true;
                                }

                                // Check the password strength
                                if (cpassword != '') {
                                    if (value != cpassword) {
                                        //validator.updateStatus('u_cpassword', 'INVALID');
                                        //validator.revalidateField('u_cpassword');
                                        $('#user_registration').bootstrapValidator('revalidateField', 'u_cpassword');
                                        return true;
                                    } else {
                                        validator.updateStatus('u_cpassword', 'VALID');
                                    }
                                }
                                return true;
                            }
                        }
                    }
                },
                u_cpassword: {
                    validators: {
                        notEmpty: {
                            message: 'The Confirm password is required'
                        },
                        callback: {
                            message: 'Password should be same.',
                            callback: function(value, validator, $field) {
                                var password = $("input[name=u_password]").val();
                                if (value === '') {
                                    return true;
                                }

                                // Check the password strength
                                if (value != password) {
                                    return {
                                        valid: false,
                                        message: 'Password should be same.'
                                    };
                                }
                                return true;
                            }
                        }
                    }
                },
                user_refferal: {
                    validators: {
                        notEmpty: {
                            message: 'The Referral ID is required'
                        },
                        remote: {
                            message: 'This Referral ID is not valid',
                            type: 'POST',
                            url: basepath + 'check-duplicate'
                        },
                        callback: {
                            //message: 'A record with this EPRID already exists!',
                            callback: function (value, validator, $field) {
                                var ref_id = $('#user_refferal').val();
                                reg_userreff = reg_userref(ref_id);
                                return true;
                                //alert(reg_userreff);
                               // $("#ref_uname").html('asa');
                            }
                        }
                    }
                },
                umobile: {
                    validators: {
                        notEmpty: {
                            message: 'The Mobile Number is required'
                        },
                        stringLength: {
                            min: 10,
                            max: 10,
                            message: 'Phone number must be of 10 number character'
                        },
                        integer: {
                            message: 'Please Enter Number value Only'
                        },
                        remote: {
                            message: 'This Mobile Number already Exists',
                            type: 'POST',
                            url: basepath + 'check-duplicate'
                        }
                    }
                },
                customControlAutosizing: {
                    validators: {
                        notEmpty: {
                            message: 'Please Tick above to proceed further.'
                        }
                    }
                },
                /*customControlAutosizing: {
                  validators: {
                    choice: {
                      message: 'Please Tick above to proceed further.'
                    }
                  }
                }*/
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
            // Prevent form submission
            e.preventDefault();
            // Get the form instance
            var $form = $(e.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
            startloader('loader');
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    //console.log(data);
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        //window.location.href = data.url;
                        /*$(".as-register-box").hide();
                        $(".as-otp-box").show();

                        $('body,html').animate({
                          scrollTop: 0
                        }, 500);
            
                        toastr.success(data.message);*/

                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        $form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    } else {
                        toastr.error('Something Went wrong, Try again after sometime.');
                        toastr.error(data.message);
                    }
                    stoploader('loader');
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                    stoploader('loader');
                }
            });
        });




    $('#user_login').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                u_email: {
                    validators: {
                        notEmpty: {
                            message: 'The User Name is required'
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
            //startloader('loader');
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 2) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 3) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else {
                        $form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    }
                    //stoploader('loader');
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                    stoploader('loader');
                }
            });
        });

    $('#userdetails_fm').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                u_address: {
                    validators: {
                        notEmpty: {
                            message: 'Address is required'
                        }
                    }
                },
                u_city: {
                    validators: {
                        notEmpty: {
                            message: 'City is required'
                        }
                    }
                },
                tandc: {
                    validators: {
                        notEmpty: {
                            message: 'Term and Condtion required Acceptable'
                        }
                    }
                },
                u_zipcode: {
                    validators: {
                        notEmpty: {
                            message: 'Zipcode is required'
                        },
                        stringLength: {
                            min: 6,
                            max: 6,
                            message: 'Pincode should be 6 digit Long'
                        },
                        integer: {
                            message: 'Please Enter Numeric value Only'
                        },
                    }
                },
                /*pan_card: {
                        validators: {
                            notEmpty: {
                                message: 'PAN Card is required'
                            },
                            file: {
                            extension: 'jpeg,png,jpg',
                            type: 'image/jpeg,image/png,image/jpg',
                            //maxSize: 2048 * 1024,
                            message: 'Only (jpeg,png and jpg) Image Files are allowed.'
                        }
                      }
                    },
                    aadhar_card: {
                        validators: {
                            notEmpty: {
                                message: 'Aadhar Card is required'
                            },
                            file: {
                            extension: 'jpeg,png,jpg',
                            type: 'image/jpeg,image/png,image/jpg',
                            //maxSize: 2048 * 1024,
                            message: 'Only (jpeg,png and jpg) Image Files are allowed.'
                        }
                      }
                    }*/
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
            startloader('loader');
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        //$form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    } else {
                        //$form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    }
                    stoploader('loader');
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime.');
                    //$form.data('bootstrapValidator').resetForm(true);
                    stoploader('loader');
                }
            });
        });

    $('#loginotp').click(function(e) {
        e.preventDefault();

        var otp = $("#enter-otp").val();

        $("#loginotp").prop("disabled", true);

        $(".loadingBtn").show();
        $(".submitBtn").hide();

        $.ajax({
            type: "POST",
            url: basepath + 'frontend/otp_verification_sighup',
            data: { otp: otp }, // serializes the form's elements.
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data.status == 1) {
                    //$form.data('bootstrapValidator').resetForm(true);
                    console.log(data.url);
                    window.location.href = data.url;
                } else {
                    //$form.data('bootstrapValidator').resetForm(true);
                    toastr.error(data.message);
                    $("#loginotp").prop("disabled", false);
                    $(".loadingBtn").hide();
                    $(".submitBtn").show();
                }
            },
            error: function(data) {
                toastr.error('Something Went wrong, Try again after sometime.');
                //$form.data('bootstrapValidator').resetForm(true);
                console.log("ajaxError");
                console.log(data);
                $("#loginotp").prop("disabled", false);
                $(".loadingBtn").hide();
                $(".submitBtn").show();
            },
            timeout: 10000 // sets timeout to 10 seconds
        });

    });


    $('#otp_verify').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                otp_info: {
                    validators: {
                        notEmpty: {
                            message: 'Please Fill Six Digit OTP.'
                        }
                    }
                }
            }
        })
        .on('keyup', 'input[name="otp"]', function(e) {
            var y = $('#otp_verify').find('[name="otp"]').val();

            // Set the user_info field value
            $('#otp_verify').find('[name="otp_info"]').val(y === '' ? '' : [y]);

            // Revalidate it
            $('#otp_verify').bootstrapValidator('revalidateField', 'otp_info');
        }).on('success.form.bv', function(e) {
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
                dataType: 'json',
                success: function(data) {
                    //console.log(data)
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        $form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    } else {
                        $form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                }
            });
        });

    $('#usercheckout_fm').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                test_cardno: {
                    validators: {
                        notEmpty: {
                            message: 'Card Number is required'
                        }
                    }
                },
                card_month: {
                    validators: {
                        notEmpty: {
                            message: 'Expiry Month is required'
                        }
                    }
                },
                card_year: {
                    validators: {
                        notEmpty: {
                            message: 'Expiry Year is required'
                        }
                    }
                }
            }
        })
        .on('error.validator.bv', function(e, data) {
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
            startloader('loader');
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(), // serializes the form's elements.
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                    stoploader('loader');
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime.');
                    //$form.data('bootstrapValidator').resetForm(true);
                    stoploader('loader');
                }
            });
        });

    $('#forgot_passwordfm').bootstrapValidator({
            fields: {
                u_email: {
                    validators: {
                        notEmpty: {
                            message: 'The Email is required'
                        },
                        // stringLength: {
                        //     min: 5,
                        //     max: 50,
                        //     message: 'Please Enter Valid Username(CL******)'
                        // }
                        emailAddress: {
                            message: 'Please Enter Valid Email Address(test@test.com)'
                        }
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
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        $form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    } else {
                        toastr.error('Something Went wrong, Try again after sometime2.');
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime1.');
                    $form.data('bootstrapValidator').resetForm(true);
                }
            });
        });
    $('#reset_passfm').bootstrapValidator({
            fields: {
                u_password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        },
                        callback: {
                            //message: 'Both Password should be same.',
                            callback: function(value, validator, $field) {
                                var cpassword = $("input[name=u_cpassword]").val();
                                if (value === '') {
                                    return true;
                                }

                                // Check the password strength
                                if (cpassword != '') {
                                    if (value != cpassword) {
                                        $('#reset_passfm').bootstrapValidator('revalidateField', 'u_cpassword');
                                        return true;
                                    } else {
                                        validator.updateStatus('u_cpassword', 'VALID');
                                    }
                                }
                                return true;
                            }
                        }
                    }
                },
                u_cpassword: {
                    validators: {
                        notEmpty: {
                            message: 'The Confirm password is required'
                        },
                        callback: {
                            message: 'Password should be same.',
                            callback: function(value, validator, $field) {
                                var password = $("input[name=u_password]").val();
                                if (value === '') {
                                    return true;
                                }

                                // Check the password strength
                                if (value != password) {
                                    return {
                                        valid: false,
                                        message: 'Password should be same.'
                                    };
                                }
                                return true;
                            }
                        }
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
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        $form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    } else {
                        toastr.error('Something Went wrong, Try again after sometime.');
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                }
            });
        });

    $('#save_referral').bootstrapValidator({
            fields: {
                user_refferal: {
                    validators: {
                        notEmpty: {
                            message: 'The User Referral is required'
                        },
                        remote: {
                            message: 'This Referral ID is not valid',
                            type: 'POST',
                            url: basepath + 'check-duplicate'
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
                    if (data.status == 1) {
                        $form.data('bootstrapValidator').resetForm(true);
                        window.location.href = data.url;
                    } else if (data.status == 0) {
                        $form.data('bootstrapValidator').resetForm(true);
                        toastr.error(data.message);
                    } else {
                        toastr.error('Something Went wrong, Try again after sometime.');
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Something Went wrong, Try again after sometime.');
                    $form.data('bootstrapValidator').resetForm(true);
                }
            });
        });

    $("input.otpFields").on("input", function(evt) {
        var self = $(this);
        var iputid = self.attr('id');
        var idlast = parseInt(iputid[iputid.length - 1]);
        var newval = self.val(self.val().replace(/[^0-9]/g, ''));
        var length = $("#" + iputid).val().length;
        if (length > 0) {
            if (idlast < 6) {
                var nxtelement = 'otp_' + (idlast + 1);
                $("#" + nxtelement + "").focus();
            }
        }
    });
});

function load() {
    document.getElementById("submitbtn").disabled = false;
}

$('#u_country').on('change', function() {
    var country_code = $(this).find(':selected').attr('data-code');
    $('#u_country_code').text('+' + country_code);
});

$("a.cloud_mine_popup").on("click", function() {
    var ref = $(this).attr('data-ref');
    $.ajax({
        type: "POST",
        url: basepath + 'frontend/get_cmPackages',
        data: { 'ref': ref },
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                //$('#cm_img').attr('src',basepath+'assets/frontend/images/'+data.data.img);
                $('#cm_title').text(data.data.title);
                $('#cm_price').text(data.data.price);
                $('#cm_power').text(data.data.power);
                $('#cm_algo').text(data.data.algo);
                $('#cm_duration').text(data.data.duration);
                $('#package_id').val(data.data.id);
                $('#cust_heading').text('Customized');
                $('#cust_power').text(data.data.power);
                $('#cust_power').attr('data-pow', data.data.power);
                $('#cust_value').val(1);
                $('#cust_algo').text(data.data.algo);
                $('#cust_duration').text(data.data.duration);
                $('#etherium-popup').modal('show');
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error('Something Went wrong, Try again after sometime.');
            }

        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});
$('input#cust_value').on('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
    var cust_price = this.value * parseInt($('#cm_price').text());
    var cust_power = this.value * parseInt(($('#cust_power').attr('data-pow').replace('MH/S', '')).trim());
    $('#cust_power').text(cust_power + ' MH/S');
    $('#cust_heading').text('$' + cust_price.toFixed(2));
});

$("a.purchase_cm").on("click", function() {
    var data;
    var ref = $(this).attr('data-type');
    var packageid = $('#package_id').val();
    if (ref == 1) {
        data = { 'type': ref, 'package': packageid, 'unit': 1 };
    } else {
        var unit = $('#cust_value').val();
        data = { 'type': ref, 'package': packageid, 'unit': unit };
    }
    $.ajax({
        type: "POST",
        url: basepath + 'frontend/set_cmPackages',
        data: data,
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                window.location.href = data.url;
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error('Something Went wrong, Try again after sometime.');
            }
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});

$("a.mether_login").on("click", function() {
    var ref = $(this).attr('data-type');
    $.ajax({
        type: "POST",
        url: basepath + 'frontend/set_loginsess',
        data: { 'login': ref }, //1=affiliate,2=mining
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                window.location.href = data.url;
            } else if (data.status == 0) {
                toastr.error(data.message);
                $('#choose-login').modal('hide');
            } else {
                toastr.error('Something Went wrong, Try again after sometime.');
                $('#choose-login').modal('hide');
            }
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
            $('#choose-login').modal('hide');
        }
    });
});

$('.resend_otpcs').click(function() {
    $.ajax({
        type: "POST",
        url: basepath + 'resend-otp',
        data: { 'action': 'resend_otp' }, //1=affiliate,2=mining
        dataType: 'json',
        success: function(data) {
            if (data.status == 1) {
                toastr.success(data.message);
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error('Something Went wrong, Try again after sometime.');
            }
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});