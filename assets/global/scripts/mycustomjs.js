function startloader(divid) {
    $("." + divid).show();
}

function stoploader(divid) {
    $("." + divid).fadeOut("slow");
}

function readURL(input, element) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#' + element).attr('src', e.target.result).addClass("image_bg");

        };

        reader.readAsDataURL(input.files[0]);
    }
}
$('.modedisabled').click(function() {
    toastr.clear();
    var mode = $(this).attr('data-type');
    if (mode == 1) {
        toastr.error('Bitcoin mode of payment not active.');
    } else if (mode == 2) {
        toastr.error('Ethereum mode of payment not active.');
    } else {
        toastr.error('This mode is not valid selection');
    }
});


if (("#pxl-revinst-chartcontainer").length) {
    
    var type = '';
    var chartype = Cookies.get('revchart-type');
    if (typeof chartype === "undefined") {
        type = 'month';
    } else {
        type = chartype;
    }
    var url = basepath + 'Process/chart_data'
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'chart_type': type
        }, // serializes the form's elements.
        dataType: 'json',
        success: function(data) {
            $('#pxl-revinst-chartcontainer').highcharts(JSON.parse(data.jsonval));
            $("#site_activities_loading").hide();
            $('#charttype').text(data.type);
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
}
$("#chart_action_area .actions .dropdown-menu a").click(function() {
    var type = '';
    var row = $(this);
    var type = row.attr('data-type');
    Cookies.set('revchart-type', type, {
        expires: 7
    });
    var chartype = Cookies.get('revchart-type');
    if (typeof chartype === "undefined") {
        type = 'month';
    } else {
        type = chartype;
    }
    var url = basepath + 'process/chart_data'
    $.ajax({
        type: "POST",
        url: url,
        data: {
            'chart_type': type
        }, // serializes the form's elements.
        dataType: 'json',
        success: function(data) {
            if (data.status == true) {
                $('#pxl-revinst-chartcontainer').highcharts(JSON.parse(data.jsonval));
                $('#pxl-revinst-chartcontainer').highcharts().redraw();
                $('#charttype').text(data.type);
            } else {
                toastr.error('Something Went Wrong, Please Try again after sometime.');
            }
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});
$('#copy_link').click(function() {
    //alert(basepath);
    toastr.clear();
    var copyText = document.getElementById("referral_input");
    copyText.select();
    document.execCommand("copy");
    //toastr.success('Referral Link ' + copyText.value + ' Copied Successfully.');
});

//copy to clipboard function
function copyToClipboard(elementId, leg) {
    // Create a "hidden" input
    var aux = document.createElement("input");
    var string = (document.getElementById(elementId).value).replace(basepath + 'referral-link/', '');

    // Assign it the value of the specified element
    aux.setAttribute("value", basepath + 'referral-link/' + encodeURIComponent(string + '&' + btoa(leg)));

    // Append it to the body
    document.body.appendChild(aux);

    // Highlight its content
    aux.select();

    // Copy the highlighted text
    document.execCommand("copy");

    // Remove it from the body
    document.body.removeChild(aux);
    return document.getElementById(elementId).value;
}
//end



$('.ticket_block').click(function() {
    toastr.clear();
    toastr.error('Only one Ticket allowed at a time.');
});

$('.alert_modal').click(function() {
    $("#load").show();
    $.ajax({
        type: "POST",
        url: basepath + 'process/show_notification',
        data: {
            'ref': $(this).attr('data-ref')
        },
        dataType: 'json',
        success: function(data) {
            $('div#alert_popimg').remove();
            toastr.clear();
            if (data.status == 1) {
                $('#alert_popmessage').text(data.data.notification_message);
                $('#alert_popsubject').text(data.data.subject);
                if (data.data.upimage > 0) {
                  $('.modal-body').append('<div id="alert_popimg">Image: <span><img height="100" width="100" src="' + data.data.path + '/' + data.data.image + '"></span></div>');
                    //$('.modal-body').append('<div id="alert_popimg">Image: <span><img height="100" width="100" src="' + basepath + '' + data.data.path + '/' + data.data.image + '"></span></div>');
                }

                if (data.unread > 0) {
                    $('.unread_alerts').text(data.unread + ' unread'); //alert_bellico
                    $('#alert_bellico').text(data.unread);
                } else {
                    $('.unread_alerts').html('');
                    $('#alert_bellico').text('');
                }

                $('#todo-members-modal').modal('show');
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error(data.message);
            }
            $("#load").fadeOut("slow");
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});

$('.delete_unotification').click(function() {
    $("#load").show();
    $.ajax({
        type: "POST",
        url: basepath + 'process/delete_notification',
        data: {
            'ref': $(this).attr('data-ref')
        },
        dataType: 'json',
        success: function(data) {
            toastr.clear();
            if (data.status == 1) {
                window.location.href = data.url;
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error(data.message);
            }
            $("#load").fadeOut("slow");
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});



$(document).ready(function() {
    $('.example').hover(function(e) {
        //alert(); 
            var row = $(this);
            var leftcount = row.attr('data-leftcount');
            var rightcount = row.attr('data-rightcount');
            var fullname = row.attr('data-fullname');
            var regdate = row.attr('data-regdate');
            var sponsor = row.attr('data-sponsor');
            var fullname = fullname +' ( Sponsor : '+ sponsor +')';
            
            var cbleft = row.attr('data-cbleft') == '' || row.attr('data-cbleft') <= 0 ? '0.00' : row.attr('data-cbleft');
            var cbright = row.attr('data-cbright') == '' || row.attr('data-cbright') <= 0 ? '0.00' : row.attr('data-cbright');
            var carryl = row.attr('data-carryl') == '' || row.attr('data-carryl') <= 0 ? '0.00' : row.attr('data-carryl');
            var carryr = row.attr('data-carryr') == '' || row.attr('data-carryr') <= 0 ? '0.00' : row.attr('data-carryr');
            var tbleft = row.attr('data-tbleft') == '' || row.attr('data-tbleft') <= 0 ? '0.00' : row.attr('data-tbleft');
            var tbright = row.attr('data-tbright') == '' || row.attr('data-tbright') <= 0 ? '0.00' : row.attr('data-tbright');
            //alert(cbleft+'  '+cbright+'  '+carryl+'  '+carryr+'  '+tbleft+'  '+tbright);
            $('#ufullname').text(fullname);
            $('#uleftcount').text(leftcount);
            $('#urightcount').text(rightcount);
            $('#uregdate').text(regdate);
            $('#cbsleft').text(cbleft);
            $('#cbsright').text(cbright);
            $('#carryleft').text(carryl);
            $('#carryright').text(carryr);
            $('#totbleft').text(tbleft);
            $('#totbright').text(tbright);
            $("#showDiv").show();
        },
        function(e) {
            $("#showDiv").hide();
        });
    

    $('#dob_calender').datepicker({
        endDate: '-1y',
        startDate: '-100y'
    }).on('changeDate', function(selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#dob_calender').datepicker('setStartDate', minDate);
        $('#update_profile').bootstrapValidator('revalidateField', 'u_dob')
    });


// vikash comomnet this its already in matherapp.js
    // //add and update bank details function
    // $('#addbank_delsfrm').bootstrapValidator({
    //         excluded: ':disabled',
    //         fields: {
    //             bnk_beneficery: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: 'The Beneficiary Name is required'
    //                     }
    //                 }
    //             },
    //             bnk_name: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: 'The Bank Name is required'
    //                     },
    //                 }
    //             },
    //             branch_address: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: 'The Branch Address is required'
    //                     },
    //                 }
    //             },
    //             bnk_branchcode: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: 'The Branch Code is required'
    //                     }
    //                 }
    //             },
    //             bnk_accountno: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: 'The Account Number is required'
    //                     },
    //                     remote: {
    //                         message: 'This Account No. already Exits.',
    //                         type: 'POST',
    //                         url: basepath + 'check-account'
    //                     }
    //                 }
    //             },
    //             bnk_ifsc: {
    //                 validators: {
    //                     notEmpty: {
    //                         message: 'The Bank IFSC/SWIFT Code is required'
    //                     }
    //                 }
    //             }
    //         }
    //     })
    //     .on('success.form.bv', function(e) {
    //         e.preventDefault();
    //         var $form = $(e.target);
    //         var bv = $form.data('bootstrapValidator');
    //         swal({
    //             title: 'Are you sure?',
    //             text: "To Add " + $('#bnk_name').val() + ".",
    //             type: 'question',
    //             showCancelButton: true,
    //             confirmButtonColor: '#3085d6',
    //             cancelButtonColor: '#d33',
    //             confirmButtonText: 'Proceed',
    //             cancelButtonText: 'Cancel',
    //             confirmButtonClass: 'btn btn-success',
    //             cancelButtonClass: 'btn btn-danger',
    //             buttonsStyling: true,
    //             reverseButtons: true
    //         }).then((result) => {
    //             if (result.value) {
    //                 $.ajax({
    //                     type: "POST",
    //                     url: $form.attr('data-action'),
    //                     data: $form.serialize(), // serializes the form's elements.
    //                     dataType: 'json',
    //                     success: function(data) {
    //                         //console.log(data)
    //                         toastr.clear();
    //                         var html = '';
    //                         if (data.status == 1) {
    //                             location.reload();
                                
    //                         } else if (data.status == 0) {
    //                             toastr.error(data.message);
    //                             $form.data('bootstrapValidator').resetForm(true);
    //                         } else {
    //                             toastr.error('Unknown Response, Try again after sometime.');
    //                             $form.data('bootstrapValidator').resetForm(true);
    //                         }
    //                     },
    //                     error: function(data) {
    //                         toastr.error('Unknown Response, Try again after sometime.');
    //                         $form.data('bootstrapValidator').resetForm(true);
    //                     }
    //                 });
    //             } else if (result.dismiss === swal.DismissReason.cancel) {
    //                 $form.data('bootstrapValidator').disableSubmitButtons(false);
                    
    //             }
    //         });
    //     });
    // //ends

    $('#send_wallet_otp').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                wallet_otp: {
                    validators: {
                        notEmpty: {
                            message: 'The OTP is required'
                        },
                        regexp: {
                            regexp: /^\d{6}$/i,
                            message: 'Please Enter Six Digit Numeric OTP.'
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
            $.ajax({
                type: "POST",
                url: $form.attr('data-action'),
                data: $form.serialize(),
                dataType: 'json',
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        $('#mether_creditfm')[0].submit();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error('Unknown Response, Try again after sometime');
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });

        });


    //Load jstree Function
    $('#team_tree').jstree({
        'core': {
            'data': {
                "url": basepath + 'network',
                "data": function(node) {
                   
                    return {
                        'id': node.id
                            
                    };
                },
                "dataType": "json"
            },
        },
        'massload': {
            'url': basepath + 'network',
            'data': function(ids) {
                return {
                    'id': ids.join(',')
                };
            }
        },
        'plugins': ["types", "massload"],
        'types': {
            'default': {
                'icon': 'glyphicon glyphicon-folder-close'
            },
            'f-open': {
                'icon': 'glyphicon glyphicon-folder-open'
            },
            'f-closed': {
                'icon': 'glyphicon glyphicon-folder-close'
            }
        }
    });
    $('#team_tree1').jstree({
        'core': {
            'data': {
                "url": basepath + 'network',
                "data": function(node) {
                    return {
                        'id': node.id,
                        'action': '1'
                    };
                },
                "dataType": "json"
            },
        },
        'massload': {
            'url': basepath + 'network',
            'data': function(ids) {
                return {
                    'id': ids.join(',')
                };
            }
        },
        'plugins': ["types", "massload"],
        'types': {
            'default': {
                'icon': 'glyphicon glyphicon-folder-close'
            },
            'f-open': {
                'icon': 'glyphicon glyphicon-folder-open'
            },
            'f-closed': {
                'icon': 'glyphicon glyphicon-folder-close'
            }
        }
    });
    //ends
    $('#referralp_table').dataTable({
        language: {
            aria: {
                sortAscending: ": activate to sort column ascending",
                sortDescending: ": activate to sort column descending"
            },
            emptyTable: "No data available in table",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            infoEmpty: "No records found",
            infoFiltered: "(filtered1 from _MAX_ total records)",
            lengthMenu: "Show _MENU_",
            search: "Search:",
            zeroRecords: "No matching records found",
            paginate: {
                previous: "Prev",
                next: "Next",
                last: "Last",
                first: "First"
            }
        },
        bStateSave: !0,
        lengthMenu: [
            [5, 15, 20, -1],
            [5, 15, 20, "All"]
        ],
        pageLength: 5,
        pagingType: "bootstrap_full_number",
        columnDefs: [{
            orderable: !1,
            targets: [0]
        }, {
            searchable: !1,
            targets: [0]
        }, {
            className: "dt-right"
        }],
        
    });
    $('.detailspopup').prop("disabled", false);

    $('#add-account')
        .on('shown.bs.modal', function() {
            $('#addbank_delsfrm').find('[name="bnk_beneficery"]').focus();
        })
        .on('hidden.bs.modal', function() {
            $('#addbank_delsfrm').bootstrapValidator('resetForm', true); //disableSubmitButtons(disabled)
        });

    $('#reject_kyc')
        .on('shown.bs.modal', function() {
            $('#send_wallet_otp').find('[name="wallet_otp"]').focus();
        })
        .on('hidden.bs.modal', function() {
            $("#select_users").val('').trigger('change');
            $('#mether_creditfm').bootstrapValidator('resetForm', true);
            $('#mether_creditfm')[0].reset();
            $('#send_wallet_otp').bootstrapValidator('resetForm', true);
        });


    $('#crypto_paymentfm').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                cryppayment_val: {
                    validators: {
                        callback: {
                            callback: function(value, validator, $field) {
                                var type = $("input[id=cryppayment_type]").val();
                                if (value === '' || value.trim().length == 0) {
                                    if (type == 3) {
                                        return {
                                            valid: false,
                                            message: 'Please Enter Paytm Address.'
                                        }
                                    } else if (type == 4) {
                                        return {
                                            valid: false,
                                            message: 'Please Enter UPI Address.'
                                        }
                                    } else {

                                    }
                                }
                                return true;
                            }
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
                        location.reload();
                    } else if (data.status == 0) {
                        $form.data('bootstrapValidator').disableSubmitButtons(false);
                        toastr.error(data.message);
                    } else {
                        $form.data('bootstrapValidator').disableSubmitButtons(false);
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });

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

    //start select2 Functionality
    $("#select_users").select2({
        minimumInputLength: 3,
        allowClear: false,
        placeholder: "Search for Username",
        ajax: {
            url: basepath + 'process/searchusername',
            type: "post",
            dataType: 'json',
            delay: 50,
            data: function(params) {
                return {
                    username: params.term, // search term
                    type:1
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
    $('#select_users').on('select2:select', function(e) {
        var data = e.params.data;
        var userid = data.id;
        $("#user_id").val(jQuery.trim(userid));
        $('#mether_creditfm').bootstrapValidator('revalidateField', 'user_id');
    });
    //end select2 functionality

    $('#request-withdrawal')
        .on('shown.bs.modal', function() {})
        .on('hidden.bs.modal', function() {
            $('#withdraw_amount').text('');
            $('#request_ref').val('');
            $('#withdraw_form').attr('action', '');
        });
    $('#responsive')
        .on('shown.bs.modal', function() {
            //$('#addbank_delsfrm').find('[name="bnk_beneficery"]').focus();
        })
        .on('hidden.bs.modal', function() {
            $('#nwticket_fm')[0].reset();
            $("#photos").html('');
        });
});

// $('#profile_pic').change(function() {
    // var fileExtension = ['jpeg', 'jpg', 'png'];

    // if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only '.jpeg','.jpg', '.png' formats are allowed.");
    // } else {
        // startloader('dploader');
        // $.ajax({
            // type: "POST",
            // url: $('#dp_upload').attr('data-action'),
            // data: new FormData($('#dp_upload')[0]),
            // contentType: false,
            // cache: false,
            // processData: false,
            // dataType: "json",
            // success: function(data) {
                // toastr.clear();
                // if (data.status == 1) {
                    // $thumb_img = data.thumb;
                    // $("#dp_icon").attr("src", $thumb_img);
                    // $("#blah2").attr("src", $thumb_img);
					// toastr.remove();
                    // toastr.success(data.message);
                // } else if (data.status == 0) {
					// toastr.remove();
                    // toastr.error(data.message);
                // } else {
					// toastr.remove();
                    // toastr.error('Unknown Response, Try again after sometime');
                // }
                // stoploader('dploader');
            // },
            // error: function(data) {
				// toastr.remove();
                // toastr.error('Unknown Response, Try again after sometime.');
            // }
        // });
    // }
// });

$(document.body).on('click', '.delete_account', function() {
    var divid = $(this).parent().parent().parent().parent().attr('id');
    var banktots = $('.bank_lst_div').length;
    $.ajax({
        type: "POST",
        url: basepath + 'process/delete_bank',
        data: {
            'ref': $(this).attr('data-ref')
        },
        dataType: 'json',
        success: function(data) {
            toastr.clear();
            if (data.status == 1) {
                if (banktots == 1) {
                    $('.all_bnk_div').remove();
                    $('#bank_page_heading').text('Add Bank');
                } else {
                    $('div[id*=divid]').remove();
                    document.getElementById(divid).remove();
                }
                toastr.success(data.message);
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error('Unknown Response, Try again after sometime');
            }
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});

$('#uppertab li a').click(function() {
    var that = $(this); //cache when you can
    $('#change_upass').bootstrapValidator('resetForm', true); //disableSubmitButtons(disabled)
    var tabpaneid = $(this).attr('href').substr(1);
    $('a[href="#' + tabpaneid + '"]').parent().parent().find("*").removeClass("active");
    $('a[href="#' + tabpaneid + '"]').parent().addClass('active');
    $('#' + tabpaneid).parent().find("*").removeClass("active");
    $('#' + tabpaneid).addClass('active');
    $('.primary').prop('checked', true);
});
$('#sidetab li a').click(function() {
    var that = $(this); //cache when you can
    var current_tab = $('#sidetab').find('li.active a').attr('href');
    var selected_tab = that.attr('href');
    //alert(current_tab+' '+selected_tab);
    if (current_tab != selected_tab) {
        $('#change_upass').bootstrapValidator('resetForm', true); //disableSubmitButtons(disabled)
        var tabpaneid = $(this).attr('href').substr(1);
        $('a[href="#' + tabpaneid + '"]').parent().parent().find("*").removeClass("active");
        $('a[href="#' + tabpaneid + '"]').parent().addClass('active');
        $('#' + tabpaneid).parent().find("*").removeClass("active");
        $('#' + tabpaneid).addClass('active');
        $('.primary').prop('checked', true);
        $("html, body").animate({
            scrollTop: $("#profile_sec_heading").offset().top
        }, "slow");
        return false;
    } else {
        return false;
    }
    //return false;
});

/*Initial node open and Toggle between folder open and folder closed Jstree*/
$(window).load(function() {
    setTimeout(function() {
        $parentid = $('#team_tree ul:first li:first').attr('id');
        $("#team_tree").jstree("open_node", $("#" + $parentid + ""));
    }, 800);
});
$("#team_tree").on('open_node.jstree', function(event, data) {
    data.instance.set_type(data.node, 'f-open');
});
$("#team_tree").on('close_node.jstree', function(event, data) {
    data.instance.set_type(data.node, 'f-closed');
});

$(window).load(function() {
    setTimeout(function() {
        $parentid = $('#team_tree1 ul:first li:first').attr('id');
        $("#team_tree1").jstree("open_node", $("#" + $parentid + ""));
    }, 800);
});
$("#team_tree1").on('open_node.jstree', function(event, data) {
    data.instance.set_type(data.node, 'f-open');
});
$("#team_tree1").on('close_node.jstree', function(event, data) {
    data.instance.set_type(data.node, 'f-closed');
});
//ends
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
            $.post(basepath + "process/closeTicket", {
                ticketid: refid
            }, function(data) {
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
$("#referralp_table").on("click", ".detailspopup", function() {

    $.ajax({
        type: "POST",
        url: basepath + 'process/getprofts_dels',
        data: {
            'ref': $(this).closest("tr.referaltr").attr('data-from'),
            'type': $(this).closest("tr.referaltr").attr('data-type')
        },
        dataType: 'json',
        success: function(data) {
            var html = '';
            $.each(data, function(key, value) {
                html += '<tr><td>' + value.title + '</td><td>' + moment(value.purchased_on).format('DD-MMM-YYYY h:mm:ss') + '</td><td  class="text-right">' + value.p_amount + '</td><td  class="text-right">' + value.amount + '</td></tr>';
            });
            //alert(html);
            $("#refdelspoptable tbody").html('');
            $("#refdelspoptable tbody").append(html);
            $('#total-purchase').modal('show');
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});

$(document).on("click", "#add_bank_popup", function() {
    $('#add-account').modal('show');
});
$(document).on("click", ".cryptocard_popup", function() {
    var type = $(this).attr('data-type');
    var name = $(this).attr('data-name');
    var image = $(this).attr('data-img');
    var placeholder = $(this).attr('data-holder');
    //alert(name+' '+image);
    $('#cryppayment_type').val(type);
    $('#method_name').text(name);
    $('#method_image').attr('src', basepath + image);
    $('#cryppayment_val').attr('placeholder', placeholder);
    $('#crypto_paymentfm').bootstrapValidator('resetForm', true);
    $('#bitcoin-card-edit').modal('show');
});

$(document).on("click", ".show_cryptoadd", function() {
    var name = $(this).attr('data-name');
    var image = $(this).attr('data-img');
    var address = $(this).attr('data-add');
    $('#method_name_show').text(name);
    $('#maincryp_address').text(address);
    $('#method_image_show').attr('src', basepath + image);
    $('#bitcoin-card').modal('show'); //maincryp_address
});

$("#bitcoin-card").on("hidden.bs.modal", function() {
    $('#method_name_show').text('');
    $('#maincryp_address').text('');
    $('#method_image_show').attr('src', '');
});

$('#resetpasswordfrm').click(function() {
    $('#change_upass').bootstrapValidator('resetForm', true);
});

$(document).on("click", "#bank_disabledadd", function() {
    toastr.clear();
    toastr.error('Only 1 Banks allowed to add, Please delete for add new bank.');
});

//delete_banks
$(document).on("click", ".delete_banks", function() {
    var refbnk = $(this).attr('dataref');
    var bankname = $('#name_' + refbnk).text();
    var accno = $('#acc_' + refbnk).text();
    swal({
        title: 'Are you sure',
        text: "To Delete " + bankname + " with Account No. " + accno + " ?",
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
                url: basepath + 'process/delete_banks',
                data: {
                    'ref': $(this).attr('dataref')
                },
                dataType: 'json',
                success: function(data) {
                    toastr.clear();
                    var html = '';
                    if (data.status == 1) {
                        location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {

        }
    });
});
//delete crypto currency
$(document).on("click", ".delete_cryptoadd", function() {
    var message = '';
    var crypref = $(this).attr('data-ref');
    var cryptype = $(this).attr('data-type');
    var crytoadd = $(this).closest('div').find('.show_cryptoadd').attr('data-add');
    if (cryptype == 3) {
        message = 'Paytm';
    } else if (cryptype == 4) {
        message = 'UPI';
    } else {}
    swal({
        title: 'Are you sure',
        text: "To Delete " + message + " Address " + crytoadd + " ?",
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
                url: basepath + 'process/delete_crypaddress',
                data: {
                    'ref': crypref,
                    'type': cryptype
                },
                dataType: 'json',
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        location.reload();
                        
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {

        }
    });
});


$(document).on("click", ".notprimary", function() {
    var pripayment = $(this).attr('data-type');
    //alert(pripayment);
    if (pripayment == 2) {
        message = 'Money Order';
    } else if (pripayment == 3) {
        message = 'Paytm';
    } else if (pripayment == 4) {
        message = 'UPI';
    } else if (pripayment == 5) {
        message = 'Bank';
    } else {
        toastr.error('Selected Type is not correct.');
        $('.primary').prop('checked', true);
        return false;
    }
    swal({
        title: 'Are you sure',
        text: "To Select " + message + " as your payment method?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            if (pripayment == 5) {
                $.ajax({
                    type: "POST",
                    url: basepath + 'process/get_banksdata',
                    data: {
                        'type': pripayment
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.banksno > 0) {
                            location.reload();
                        } else {
                            toastr.error('Please add bank to make this payment option default.');
                            $('.tab-pane').removeClass('active');
                            $('#tab_1_5').addClass('active');
                        }

                    },
                    error: function(data) {
                        toastr.error('Unknown Response, Try again after sometime.');
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: basepath + 'process/change_primary',
                    data: {
                        'type': pripayment
                    },
                    dataType: 'json',
                    success: function(data) {
                        toastr.clear();
                        if (data.status == 1) {

                            location.reload();
                        } else if (data.status == 0) {
                            toastr.error(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        toastr.error('Unknown Response, Try again after sometime.');
                    }
                });
            }
        } else if (result.dismiss === swal.DismissReason.cancel) {
            //$('.primary').prop('checked',true);
        }
    });
});


//start check remove payment 
$(document).on("click", ".checkremove", function() {
    var pripayment = $(this).attr('data-type');
    //alert(pripayment);
    if (pripayment == 2) {
        message = 'Money Order';
    } else if (pripayment == 3) {
        message = 'Paytm';
    } else if (pripayment == 4) {
        message = 'UPI';
    } else if (pripayment == 5) {
        message = 'Bank';
    } else {
        toastr.error('Selected Type is not correct.');
        $('.primary').prop('checked', true);
        return false;
    }
    swal({
        title: 'Are you sure',
        text: "To Remove " + message + " as your payment method?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: basepath + 'process/change_primary',
                data: {
                    'type': pripayment,
                    'mode': 1
                },
                dataType: 'json',
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        location.reload();
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });

        } else if (result.dismiss === swal.DismissReason.cancel) {}
    });
});
//end check remove payment 





$(document).on("click", ".notprimary_bank", function() {
    var pripayment = $(this).attr('data-type');
    var bankid = $(this).attr('data-ref');
    var bankname = $(this).attr('data-name');
    swal({
        title: 'Are you sure',
        text: "To Select " + bankname + " as your default Bank?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: basepath + 'process/change_primary_bank',
                data: {
                    'type': pripayment,
                    'bankref': bankid
                },
                dataType: 'json',
                success: function(data) {
                    toastr.clear();
                    if (data.status == 1) {
                        toastr.success(bankname + ' set as default successfully.');
                        $('.primary').prop('checked', false);
                        $('.primary').closest('.inner-package-payment1').removeClass('inner-package-selected');
                        $('.primary').addClass('notprimary');
                        $('.primary').removeClass('primary');
                        $('#primpay_' + pripayment).removeClass('notprimary');
                        $('#primpay_' + pripayment).addClass('primary');
                        $('#primpay_' + pripayment).closest('.inner-package-payment1').addClass('inner-package-selected');

                        $('.primary_bank').prop('checked', false);
                        $('.primary_bank').closest('.inner-package-payment1').removeClass('inner-package-selected');
                        $('.primary_bank').addClass('notprimary_bank');
                        $('.primary_bank').removeClass('primary_bank');
                        $('#primbank' + bankid).removeClass('notprimary_bank');
                        $('#primbank' + bankid).addClass('primary_bank');
                        $('#primbank' + bankid).closest('.inner-package-payment1').addClass('inner-package-selected');

                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {
            $('.primary').prop('checked', true);
            $('.primary_bank').prop('checked', true);
        }
    });
});

//request_withdrawal
$(document).on("click", ".request_withdrawal", function() {
    var dataid = $(this).attr('data-id');
    $.ajax({
        type: "POST",
        url: basepath + 'process/get_freelook',
        data: {
            'ref': dataid
        },
        dataType: 'json',
        success: function(data) {
            toastr.clear();
            if (data.status == 1) {
                $('#withdraw_amount').text(data.amount);
                $('#request_ref').val(dataid);
                $('#withdraw_form').attr('action', basepath + 'user/RequestWithdFreeLook');
                $('#request-withdrawal').modal('show');
            } else if (data.status == 1) {
                toastr.error(data.message);
            } else {
                toastr.error('Unknown Response, Try again after sometime.');
            }
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});

$(document).on("click", "#buy_pack", function() {
    swal({
        title: 'Are you sure',
        text: "To Purchase this package?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: true,
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $('#buy_pack').attr('disabled', true);
            $('#buy_packfrm')[0].submit();
        } else if (result.dismiss === swal.DismissReason.cancel) {
            //$('.primary').prop('checked',true);
            //$('.primary_bank').prop('checked',true);
        }
    });
});

function multiple_upload(input) {
    $("#photos").html('');
    counter = input.files.length;
    for (x = 0; x < counter; x++) {
        if (input.files && input.files[x]) {
            var mime = input.files[x].type;
            var name = input.files[x].name;
            var reader = new FileReader();
            if (mime.split("/")[1] == "pdf") {
                $("#photos").append('<div class="col-md-3 col-sm-3 col-xs-3"><img src="https://i.gadgets360cdn.com/large/pdf_pixabay_1493877090501.jpg" class="img-thumbnail"><p>' + name + '</p></div>');
            } else {
                reader.onload = function(e) {
                    $("#photos").append('<div class="col-md-3 col-sm-3 col-xs-3"><img src="' + e.target.result + '" class="img-thumbnail"><p>' + name + '</p></div>');
                };
            }

            reader.readAsDataURL(input.files[x]);
        }
    }
}

$(document).on("click", "#ticket_rplycncl", function() {
    $('#ticketreply_form')[0].reset();
    $("#photos").html('');
});

$('#submit_help').click(function() {
    var helparr = [];
    var table = $("table tbody");
    table.find('tr').each(function(i) {
        var $tds = $(this).find('td');
        var user = $(this).attr('id');
        var cond = $(this).find("td.amounttd").attr('data-cond');
        var mode = $(this).find("td.paymentmethtd").attr('data-mode');
        helparr.push({
            ref: user,
            cond: cond,
            mode: mode
        });
        console.log(helparr);
    });
    var helpjson = JSON.stringify(helparr);
    $.ajax({
        type: "POST",
        url: basepath + 'submit-help',
        data: {
            'helpjson': helpjson,
            'actionjs': 'send-help'
        },
        dataType: 'json',
        success: function(data) {
            toastr.clear();
            if (data.status == 1) {
                location.reload();
            } else if (data.status == 0) {
                toastr.error(data.message);
            } else {
                toastr.error('Unknown Response, Try again after sometime.');
            }
        },
        error: function(data) {
            toastr.error('Unknown Response, Try again after sometime.');
        }
    });
});


$(function() {
    $(document).on("click", "#sendhelp_tb button.submit_transaction", function() {
        $(this).prop('disabled', true);
        var helparr = [];
        var tr = $(this).closest('tr');
        var user = tr.attr('id');
        var cond = tr.find("td.amounttd").attr('data-cond');
        var mode = tr.find("td.paymentmethtd").attr('data-mode');
        var form_data = new FormData();
        helparr.push({
            ref: user,
            cond: cond,
            mode: mode
        });
        var helpjson = JSON.stringify(helparr);
        form_data.append("helpjson", helpjson);
        form_data.append("actionjs", 'send-help');

        if (tr.find('input.image_class').length > 0) {
            var image = tr.find("td.payment_details").find("input.image_class").prop("files")[0];
            var image_l = tr.find("td.payment_details").find("input.image_class")[0].files.length;
            if (image_l > 0) {
                var fileType = image["type"];
                var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
                if ($.inArray(fileType, ValidImageTypes) < 0) {
                    toastr.clear();
                    toastr.error('Only jpg/jpeg/png Image Type Allowed to Upload.');
                    return false;
                } else {
                    form_data.append("file", image);
                }
            } else {
                toastr.clear();
                toastr.error('Please Upload Receipted image');
                return false;
            }
        }

        if (tr.find('input.transaction_number').length > 0) {
            var pnr = tr.find("td.payment_details").find("input.transaction_number").val();
            if (pnr.length > 0) {
                form_data.append("pnr", pnr);
            } else {
                toastr.clear();
                toastr.error('Please Enter Txn number.');
                return false;
            }
        }

        $.ajax({
            type: "POST",
            url: basepath + 'submit-help',
            data: form_data, //{'helpjson': helpjson,'actionjs':'send-help'},
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                toastr.clear();
                if (data.status == 1) {
                    location.reload();
                } else if (data.status == 0) {
                    toastr.error(data.message);
                } else {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            },
            error: function(data) {
                toastr.error('Unknown Response, Try again after sometime.');
            }
        });
    });
});

$(function() {
    $(document).on("change", "#sendhelp_tb select.mode_select", function() {
        var tr = $(this).closest('tr');
        var user = tr.attr('id');
        var mode = this.value;
        $(this).parents('td').last().attr('data-mode', mode);
        $.ajax({
            type: "POST",
            url: basepath + 'get-mode-data',
            data: {
                'mode': mode,
                'user': user,
                'actionjs': 'get-mode-data'
            },
            dataType: 'json',
            success: function(data) {
                var particulars = data.particulars;
                var payment_details = data.payment_details;
                tr.find("td.pay_particulars").html(particulars);
                tr.find("td.payment_details").html(payment_details);
            },
            error: function(data) {
                toastr.error('Unknown Response, Try again after sometime.');
            }
        });
    });
});


$(function() {
    $(document).on("click", "#gethelp_tb button.approve_transaction", function() {
        var tr = $(this).closest('tr');
        var transaction = tr.attr('id');

        $.ajax({
            type: "POST",
            url: basepath + 'approve-help',
            data: {
                'transaction': transaction,
                'actionjs': 'approve-transaction'
            },
            dataType: 'json',
            success: function(data) {
                toastr.clear();
                if (data.status == 1) {
                    location.reload();
                } else if (data.status == 0) {
                    toastr.error(data.message);
                } else {
                    toastr.error('Unknown Response, Try again after sometime.');
                }
            },
            error: function(data) {
                toastr.error('Unknown Response, Try again after sometime.');
            }
        });
    });
});

$(function() {
    $(document).on("click", "#gethelp_tb a.view_receipetimg", function() {
        var tr = $(this).closest('tr');
        var img = tr.find("td.payment_details").find("img.recipt_realimg").attr('src');
        $('#upload_receiptmod').attr('src', img);
        $('#myModal9').modal('show');
    });
});

$('.send_helpkyc').click(function() {
    toastr.clear();
    toastr.error('Your KYC Process is Incomplete.');
});



$('a[rel=popover]').popover().click(function(e) {
    e.preventDefault();
    var open = $(this).attr('data-easein');
    if (open == 'shake') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'pulse') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'tada') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'flash') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'bounce') {
        $(this).next().velocity('callout.' + open);
    } else if (open == 'swing') {
        $(this).next().velocity('callout.' + open);
    } else {
        $(this).next().velocity('transition.' + open);
    }
});

// add the animation to the modal
$(".modal").each(function(index) {
    $(this).on('show.bs.modal', function(e) {
        var open = $(this).attr('data-easein');
        if (open == 'shake') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'pulse') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'tada') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'flash') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'bounce') {
            $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'swing') {
            $('.modal-dialog').velocity('callout.' + open);
        } else {
            //$('.modal-dialog').velocity('transition.' + open);
        }

    });
});

var myAjaxSetting = {
    context: {
        index: -1
    },
    success: myCallback,
    responseType: "xml"
};

function myCallback(response, context) {
    var x = response.documentElement.getElementsByTagName("cd")[context.index];
    var title = x.getElementsByTagName("title")[0].childNodes[0].nodeValue;
    var artist = x.getElementsByTagName("artist")[0].childNodes[0].nodeValue;
    var price = x.getElementsByTagName("price")[0].childNodes[0].nodeValue;
    var image = "<img src='src/tooltips-cd" + context.index + ".jpg' style='float:right;margin-left:12px;width:75px;height:75px;' />";
    return "<div style='width:220px;'>" + image + "<b>" + title + "</b><br /><i>" + artist + "</i><br /><br />Price: <span class='red'>$" + price + "</span></div>";
}
//////////////////////////////
//
//
//
/////////////////////////////
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
        url: basepath + "user/ispwd",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(data) {
            document.getElementById("demo").innerHTML = data;
        }
    });
});

$(".bntreebtnser").click(function() {

    var ref_id = $('#ref_id').val();

    if (ref_id != '') {
        $.ajax({
            type: "POST",
            url: basepath + 'user/get_on_node',
            data: {
                'ref': ref_id
            },
            dataType: 'json',
            success: function(data) {
                toastr.clear();
                if (data.status == 1) {
                    window.location.href = data.url;
                } else if (data.status == 0) {
                    toastr.error(data.message);
                } else {
                    toastr.error('Something Went Wrong, Try again after sometime.');
                }
            },
            error: function(data) {
                toastr.error('Something Went Wrong, Try again after sometime.');
            }
        });
    }
})



/****Rakesh Code***/
function sendbtcotp(){
	
	$.ajax({
		type: "POST",
		url: basepath + 'user/send_bit_otp',
		
		dataType: 'json',
		success: function(data) {
			 console.log(data);
			//toastr.clear();
			if (data.status == 1) {
				$('#otp_modal').modal('show');
			    toastr.success(data.message);
			 } else if (data.status == 0) {
				 $('#checkbtcotp').hide();
				 toastr.error(data.message);
			 } else {
				$('#checkbtcotp').hide();
				toastr.error('Unknown Response, Try again after sometime.');
			}
		},
		error: function(data) {
			toastr.error('Unknown Response, Try again after sometime.');
		}
	});
	
}

function check_btc_otp(){
	var btc_otp = $('#btc_otp').val();
	
	$.ajax({
		type: "POST",
		url: basepath + 'user/verify_bit_otp',
		data: {
			'btc_otp': btc_otp,
		},
		dataType: 'json',
		success: function(data) {
			
			 if (data.status == 1) {
				// $('#checkbtcotp').hide();
				$('#otp_modal').modal('hide');
				$('#btc_otp').val('');
				$('#bit_address').prop('readonly',false);
				$('#editbitBtn').hide();
				$('#bitBtn2').show();
			    toastr.success(data.message);
			 }else if (data.status == 400) {
				// $('#checkbtcotp').show();
				$('#otp_modal').modal('show');
				$('#editbitBtn').show();
				$('#bitBtn2').hide();
				toastr.error(data.message);
			 }else if (data.status == 0) {
				 // $('#checkbtcotp').hide();
				 $('#otp_modal').modal('hide');
				 toastr.error(data.message);
			 } else {
				// $('#checkbtcotp').hide();
				$('#otp_modal').modal('hide');
				toastr.error('Unknown Response, Try again after sometime.');
			}
		},
		error: function(data) {
			toastr.error('Unknown Response, Try again after sometime.');
		}
	});
}

/****End rakesh code****/