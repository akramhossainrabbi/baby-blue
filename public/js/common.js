//This file contains all common functionality for the application
function generateInput(html, value, formattedValue) {
    $("body").append('<div id="mrks">' + html + '</div>>');
    $("#mrks").find("input").val(value);
    $("#mrks").find("input").attr('data-formattedvalue', formattedValue);
    var returnval = $("#mrks").html();
    $("#mrks").remove();
    return returnval;
}


$(document).ready(function() {
    $.ajaxSetup({
        beforeSend: function(jqXHR, settings) {
            if (settings.url.indexOf('http') === -1) {
                settings.url = base_path + settings.url;
            }
        },
    });

    update_font_size();
    if ($('#status_span').length) {
        var status = $('#status_span').attr('data-status');
        if (status === '1') {
            toastr.success($('#status_span').attr('data-msg'));
        } else if (status == '' || status === '0') {
            toastr.error($('#status_span').attr('data-msg'));
        }
    }

    //Default setting for select2
    $.fn.select2.defaults.set('minimumResultsForSearch', 6);
    if ($('html').attr('dir') == 'rtl') {
        $.fn.select2.defaults.set('dir', 'rtl');
    }
    $.fn.datepicker.defaults.todayHighlight = true;
    $.fn.datepicker.defaults.autoclose = true;
    $.fn.datepicker.defaults.format = datepicker_date_format;

    //Toastr setting
    toastr.options.preventDuplicates = true;

    //Play notification sound on success, error and warning
    toastr.options.onShown = function() {
        if ($(this).hasClass('toast-success')) {
            var audio = $('#success-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if ($(this).hasClass('toast-error')) {
            var audio = $('#error-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        } else if ($(this).hasClass('toast-warning')) {
            var audio = $('#warning-audio')[0];
            if (audio !== undefined) {
                audio.play();
            }
        }
    };


    if ($("#order_list_wid").length > 0) {
        $("#order_list_wid").on("change", '.payment_change_status', function () {

            var $this = $(this),
                payment_status = parseInt($this.val()),
                due = parseInt($this.data('due')),
                row = parseInt($this.data('row')),
                post_id = parseInt($(this).data('post_id'));
               
            if (due > 0 && payment_status === 1) {
                $("#pm_order_id").val(post_id);
                $("#pm_pay").val(due);
                $("#pm_payment_status").val(payment_status);
                $("#pm_row").val(row);
                $("#sm_order_payment_modal").modal("show");
            } else {
                var _token = $('#table_csrf_token').val();
                var message = "";
                if (payment_status === 1) {
                    message = "Are you sure to confirm this?";
                } else if (payment_status === 2) {
                    message = "Are you sure to pending this?";
                } else {
                    message = "Are you sure to cancel this?";
                }

                swal({
                    title: "Warning?",
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: '/orders/payment_status_update',
                            data: {_token: _token, post_id: post_id, payment_status: payment_status},
                            success: function (response) {
                                if (parseInt(response) == 1) {
                                    swal({
                                        type: 'success',
                                        icon: "success",
                                        title: 'Payment Status Updated Successfully',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    swal({
                                        type: 'warning',
                                        icon: "warning",
                                        title: 'Status Update Cancelled',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                                setTimeout(function () {
                                    window.location.reload(true);
                                }, 1000);
                            },
                            error: function (error) {
                                var text = '';
                                var errors = error.responseJSON.errors;
                                for (var err in errors) {
                                    text += errors[err][0];
                                    text += "\n";
                                }
                                swal({
                                    type: 'error',
                                    icon: "error",
                                    title: 'Error',
                                    text: text,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                            
                            
                        });
                    } else {
                        swal({
                            type: 'warning',
                            icon: "warning",
                            title: 'Status Update Cancelled',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });

        $("#payment_status_form").on("submit", function () {
            var $this = $(this),
                row = parseInt($("#pm_row").val());
            $("#save_payment_info").html('<i class="fa fa-refresh fa-spin"></i> Save Order Info');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                    //console.log(response);
                    $("#paid_" + row).text("$" + response.order.paid);
                    $("#due_" + row).text(response.due);
                    $("#sm_order_payment_modal").modal("hide");
                    if (response.hasError == 1) {
                        $("#payment_change_status_" + row).val(2);
                    }
                    swal({
                        type: 'success',
                        icon: "success",
                        title: 'Update Status',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $("#save_payment_info").html('<i class="fa fa-save"></i> Save Order Info');
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#save_payment_info").html('<i class="fa fa-save"></i> Save Order Info');
                }
            });
            return false;
        });
        
        $("#order_list_wid").on("change", '.delivery_change_status', function () {
           
            var $this = $(this),
            delivery_status = parseInt($this.val()),
            post_id = parseInt($(this).data('post_id'));
            
            
            var _token = $('#table_csrf_token').val();
            var message = "";
            message = "Are you sure to confirm this delivery status?";
      
            swal({
                    title: "Warning?",
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: '/orders/delivery_status_update',
                            data: {_token: _token, post_id: post_id, delivery_status: delivery_status},
                            success: function (response) {
                                if (parseInt(response) == 1) {
                                    swal({
                                        type: 'success',
                                        icon: "success",
                                        title: 'Order Delivery Status Updated Successfully',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    swal({
                                        type: 'warning',
                                        icon: "warning",
                                        title: 'Status Update Cancelled',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            // error: function (error) {
                            //     var text = '';
                            //     var errors = error.responseJSON.error;
                            //     for (var err in errors) {
                            //         text += errors[err][0];
                            //         text += "\n";
                            //     }
                            //     swal({
                            //         type: 'error',
                            //         icon: "error",
                            //         title: 'Error',
                            //         text: text,
                            //         showConfirmButton: false,
                            //         timer: 3000
                            //     });
                            // }
                        });
                    } else {
                        swal({
                            type: 'warning',
                            icon: "warning",
                            title: 'Status Update Cancelled',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
        });
        $("#order_list_wid").on("change", '.order_change_status', function () {

            var $this = $(this),
          
                order_status = parseInt($this.val()),
                  
                row = parseInt($this.data('row')),
                due = parseInt($this.data('due')),
                delivery_change_status = parseInt($this.data('delivery_change_status')),
                post_id = parseInt($(this).data('post_id'));
              
            if (order_status === 1) {
                $("#od_order_id").val(post_id);
                $("#od_pay").val(due);
                $("#od_order_status").val(order_status);
                $("#od_row").val(row);
                if (due < 1) {
                    $("#od_pay_div").fadeOut();
                }
                $("#image").val('');
                $("#od_mail_message").val('');
                $("#first_ph").html('');
                $("#sm_order_status_modal").modal("show");
            } 
            else if(order_status == 2)
            {
                  
                $("#od_order_id_new").val(post_id);
                $("#od_order_status_new").val(order_status);
                $("#sm_delivery_status_modal").modal("show");
            }
            else {
                var _token = $('#table_csrf_token').val();
                var message = "";
                if (order_status === 1) {
                    message = "Are you sure to confirm this order status?";
                } else if (order_status === 2) {
                    message = "Are you sure to progress this order status?";
                } else if (order_status === 3) {
                    message = "Are you sure to pending this order status?";
                } else {
                    message = "Are you sure to cancel this order status?";
                }

                swal({
                    title: "Warning?",
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            type: 'post',
                            url: '/orders/order_status_update',
                            data: {_token: _token, post_id: post_id, order_status: order_status},
                            success: function (response) {
                                if (parseInt(response) == 1) {
                                    swal({
                                        type: 'success',
                                        icon: "success",
                                        title: 'Order Status Updated Successfully',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    swal({
                                        type: 'warning',
                                        icon: "warning",
                                        title: 'Status Update Cancelled',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            },
                            error: function (error) {
                                var text = '';
                                var errors = error.responseJSON.errors;
                                for (var err in errors) {
                                    text += errors[err][0];
                                    text += "\n";
                                }
                                swal({
                                    type: 'error',
                                    icon: "error",
                                    title: 'Error',
                                    text: text,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        });
                    } else {
                        swal({
                            type: 'warning',
                            icon: "warning",
                            title: 'Status Update Cancelled',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });
        $("#delivery_status_form").on("submit", function () {
            var $this = $(this),
                row = parseInt($("#od_row").val());
            $("#save_delivery_info").html('<i class="fa fa-refresh fa-spin"></i> Saving Delivery Info');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                 
                    
                    
                    if (parseInt(response) == 1) {
                                swal({
                                        type: 'success',
                                        icon: "success",
                                        title: 'Order Status Updated Successfully',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    swal({
                                        type: 'warning',
                                        icon: "warning",
                                        title: 'Status Update Cancelled',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                    $("#save_delivery_info").html('<i class="fa fa-save"></i> Save Delivery Info');
                }
            });
            return false;
        });        
        $("#order_status_form").on("submit", function () {
            var $this = $(this),
                row = parseInt($("#od_row").val());
            $("#save_order_info").html('<i class="fa fa-refresh fa-spin"></i> Saving Order Info and Sending Mail');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                    //console.log(response);
                    $("#paid_" + row).text("$" + response.order.paid);
                    $("#due_" + row).text(response.due);
                    if (response.filesHtml != '') {
                        $("#files_" + row).html(response.filesHtml);
                    }
                    if (response.hasError == 1) {
                        $("#order_change_status_" + row).val(2);
                    }
                    $("#sm_order_status_modal").modal("hide");
                    swal({
                        type: 'success',
                        icon: "success",
                        title: 'Update Status',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#save_order_info").html('<i class="fa fa-save"></i> Save Order Info and Send Mail');
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#save_order_info").html('<i class="fa fa-save"></i> Save Order Info and Send Mail');
                }
            });
            return false;
        });
        $("#order_status_form").on("submit", function () {
            var $this = $(this),
                row = parseInt($("#od_row").val());
            $("#save_order_info").html('<i class="fa fa-refresh fa-spin"></i> Saving Order Info and Sending Mail');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                    //console.log(response);
                    $("#paid_" + row).text("$" + response.order.paid);
                    $("#due_" + row).text(response.due);
                    if (response.filesHtml != '') {
                        $("#files_" + row).html(response.filesHtml);
                    }
                    if (response.hasError == 1) {
                        $("#order_change_status_" + row).val(2);
                    }
                    $("#sm_order_status_modal").modal("hide");
                    swal({
                        type: 'success',
                        icon: "success",
                        title: 'Update Status',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                    $("#save_order_info").html('<i class="fa fa-save"></i> Save Order Info and Send Mail');
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#save_order_info").html('<i class="fa fa-save"></i> Save Order Info and Send Mail');
                }
            });
            return false;
        });

        $("#order_mail_form").on("submit", function () {
            var $this = $(this);
            $("#send_order_info").html('<i class="fa fa-refresh fa-spin"></i> Sending Mail');
            $.ajax({
                type: 'post',
                url: $this.attr("action"),
                data: $this.serialize(),
                success: function (response) {
                    $("#sm_mail_modal").modal("hide");
                    swal({
                        type: 'success',
                        icon: "success",
                        title: 'Update Status',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#send_order_info").html('<i class="fa fa-envelope"></i> Send Mail');
                },
                error: function (error) {
                    var text = '';
                    var errors = error.responseJSON.errors;
                    for (var err in errors) {
                        text += errors[err][0];
                        text += "\n";
                    }
                    swal({
                        type: 'error',
                        icon: "error",
                        title: 'Error',
                        text: text,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $("#send_order_info").html('<i class="fa fa-envelope"></i> Send Mail');
                }
            });
            return false;
        });
    }


        if ($('#sm_media_tab_content').length > 0) {
        $('#sm_media_tab_content').on('click', '.sm_media_file_delete', function () {
            var selector = $(this).parent('span').siblings('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            swal({
                title: "Warning?",
                text: 'Are you sure delete this file?',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var _token = $('#table_csrf_token').val();
                    $.ajax({
                        type: 'post',
                        url: smAdminUrl + 'media/delete',
                        data: {_token: _token, id: id},
                        success: function (response) {
                            $('#sm_media_tab_content .sm_file_' + id).remove();
                            $('.superbox-show').slideUp();
                        },
                        error: function (error) {
                            //console.log(error);
                        }
                    });
                } else {
                    swal({
                        type: 'warning',
                        icon: "warning",
                        title: 'Delete Cancelled',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });

        });
        $('#sm_media_tab_content').on('click', '.sm_media_file_download', function () {
            var selector = $(this).parent('span').siblings('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            window.location.href = smAdminUrl + 'media/download/' + id;
        });
        $('#sm_media_tab_content').on('click', '.sm_media_file_copy', function () {
            var selector = $(this).attr("copy");
            var copyText = document.getElementById(selector);
            copyText.select();
            document.execCommand("Copy");
            swal({
                type: 'success',
                icon: 'success',
                title: 'Successfully Copied!',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        });
        $('#sm_media_tab_content').on('click', '#sm_galary_meta_save', function () {
            var selector = $(this).parent('.sm_galay_file_meta');
            var id = selector.find('#file_id').val();
            var title = selector.find('#file_title').val();
            var alt = selector.find('#file_alt').val();
            var caption = selector.find('#file_caption').val();
            var description = selector.find('#file_description').val();
            var _token = $('#table_csrf_token').val();
            $.ajax({
                type: 'post',
                url: smAdminUrl + 'media/update',
                data: {_token: _token, id: id, title: title, alt: alt, caption: caption, description: description},
                success: function (response) {
                    swal({
                        type: 'success',
                        icon: "success",
                        title: "Success!",
                        text: 'File Meta Saved successfully!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                error: function (error) {
                    //console.log(error);
                }
            });

        });
        $("#sm_media_load_more").on('click', function (e, $affected) {
            var $this = $(this);
            var btnHtml = $this.html();
            $this.html('<i class="fa fa-refresh fa-spin"></i> Loading..');

            var loaded = $this.data("loaded");
            var need_to_load = $this.data("need_to_load");
            $.ajax({
                type: 'get',
                url: smAdminUrl + 'media/' + loaded,
                success: function (response) {
                    var data = JSON.parse(response);
                    loaded = data.load;
                    $('.superbox').find('.superbox-float').before(data.media);
                    loaded = $this.data("loaded", loaded);
                    $this.html(btnHtml);
                    // console.log("need_to_load = "+need_to_load+" data.count ="+data.count);
                    if (need_to_load > data.count) {
                        $this.fadeOut();
                    }
                }
            });

        });

    }
    if ($('#sm_media_modal').length > 0) {
        $('#media_library_tab .superbox').on('click', '.superbox-list', function () {
            
            var is_multiple = parseInt($('#media_insert').attr('is_multiple'));
            if (is_multiple == 0) {
                $('#media_library_tab .superbox').find('.sm_media_selected').removeClass('sm_media_selected');
                $(this).addClass('sm_media_selected');
            } else {
                if ($(this).hasClass('sm_media_selected')) {
                    $(this).removeClass('sm_media_selected');
                } else {
                    $(this).addClass('sm_media_selected');
                }
            }
        });
        $('body').on('click', '.sm_media_modal_show', function () {
            var input_holder = $(this).attr('input_holder');
            var img_holder = $(this).attr('img_holder');
            var is_multiple = parseInt($(this).attr('is_multiple'));
            $('#media_insert').attr('input_holder', input_holder);
            $('#media_insert').attr('img_holder', img_holder);
            $('#media_insert').attr('is_multiple', is_multiple);
            if ($(this).attr('media_width')) {
                $('#media_insert').attr('media_width', $(this).attr('media_width'));
            }
            if ($(this).attr('img_width')) {
                $('#media_insert').attr('img_width', $(this).attr('img_width'));
            }
            $('#sm_media_modal').modal('show');
        });


        $('#media_insert').on('click', function () {

            var input_holder = $(this).attr('input_holder');
            var img_holder = $(this).attr('img_holder');
            var is_multiple = parseInt($(this).attr('is_multiple'));
            var media_width = parseInt($(this).attr('media_width'));
            var img_width = parseInt($(this).attr('img_width'));

            if (is_multiple === 0) {
                var selector = $('#media_library_tab .superbox').find('.sm_media_selected').find('img');
                var id = selector.attr('img_id');
                var img_slug = selector.attr('img_slug');
                var src = get_the_file_width(selector.attr('src'), media_width);
                console.log(selector);
                console.log("dfsf");
                $('#' + input_holder).val(img_slug);
//            $('#' + img_holder + ' .media_img').attr('src', src);
                $('#' + img_holder).html('<img class="media_img" src="' + src + '" width="' + img_width + 'px" />');
            } else {
                var id = '', images = '', slug = '';
                $('#media_library_tab .superbox .sm_media_selected').each(function (index) {
                    var selector = $(this).find('img');
                    if (index > 0) {
                        id += ',';
                        slug += ',';
                    }
                    var img_id = selector.attr('img_id');
                    var img_slug = selector.attr('img_slug');
                    id += img_id;
                    slug += img_slug;
                    var src = get_the_file_width(selector.attr('src'), media_width);
                    images += '<span class="gl_img"><img class="" src="' + src + '" width="' + img_width + 'px" /><span class="displayNone remove"><i class="fa fa-times-circle remove_img" data-img="' + img_slug + '"  data-input_holder="' + input_holder + '"></i></span></span>';
                });
                var old_ids = $('#' + input_holder).val();
                //console.log('old=' + old_ids);
                if (old_ids.trim() == '') {
                    $('#' + input_holder).val(slug);
                } else {
                    $('#' + input_holder).val(old_ids + ',' + slug);
                }

                $('#' + img_holder).html($('#' + img_holder).html() + images);
            }
            $('#sm_media_modal').modal('hide');
        });
    }

    //Default setting for jQuey validator
    jQuery.validator.setDefaults({
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else if (element.hasClass('select2')) {
                error.insertAfter(element.next('span.select2-container'));
            } else if (element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else if (element.parent().hasClass('multi-input')) {
                error.insertAfter(element.closest('.multi-input'));
            } else if (element.parent().hasClass('input_inline')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },

        invalidHandler: function() {
            toastr.error(LANG.some_error_in_input_field);
        },
    });

    jQuery.validator.addMethod(
        'max-value',
        function(value, element, param) {
            return this.optional(element) || !(param < __number_uf(value));
        },
        function(params, element) {
            return $(element).data('msg-max-value');
        }
    );

    jQuery.validator.addMethod('abs_digit', function(value, element) {
        return this.optional(element) || Number.isInteger(Math.abs(__number_uf(value)));
    });

    //Set global currency to be used in the application
    __currency_symbol = $('input#__symbol').val();
    __currency_thousand_separator = $('input#__thousand').val();
    __currency_decimal_separator = $('input#__decimal').val();
    __currency_symbol_placement = $('input#__symbol_placement').val();
    if ($('input#__precision').length > 0) {
        __currency_precision = $('input#__precision').val();
    } else {
        __currency_precision = 2;
    }

    if ($('input#__quantity_precision').length > 0) {
        __quantity_precision = $('input#__quantity_precision').val();
    } else {
        __quantity_precision = 2;
    }

    //Set page level currency to be used for some pages. (Purchase page)
    if ($('input#p_symbol').length > 0) {
        __p_currency_symbol = $('input#p_symbol').val();
        __p_currency_thousand_separator = $('input#p_thousand').val();
        __p_currency_decimal_separator = $('input#p_decimal').val();
    }

    __currency_convert_recursively($(document), $('input#p_symbol').length);

    var buttons = [
        // {
        //     extend: 'copy',
        //     text: '<i class="fa fa-files-o" aria-hidden="true"></i> ' + LANG.copy,
        //     className: 'btn-sm',
        //     exportOptions: {
        //         columns: ':visible',
        //     },
        //     footer: true,
        // },
        {
            extend: 'csv',
            text: '<i class="fa fa-file-csv" aria-hidden="true"></i> ' + LANG.export_to_csv,
            className: 'btn-sm',
            exportOptions: {
                columns: ':visible',
            },
            footer: true,
        },
        {
            extend: 'excel',
            text: '<i class="fa fa-file-excel" aria-hidden="true"></i> ' + LANG.export_to_excel,
            className: 'btn-sm',
            exportOptions: {
                columns: ':visible',
            },
            footer: true,
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print" aria-hidden="true"></i> ' + LANG.print,
            className: 'btn-sm',
            exportOptions: {
                columns: ':visible',
                stripHtml: true,
            },
            footer: true,
            customize: function ( win ) {
                if ($('.print_table_part').length > 0 ) {
                    $($('.print_table_part').html()).insertBefore($(win.document.body).find( 'table' ));
                }
                if ($(win.document.body).find( 'table.hide-footer').length) {
                    $(win.document.body).find( 'table.hide-footer tfoot' ).remove();
                }
                __currency_convert_recursively($(win.document.body).find( 'table' ));
            }
        },
        {
            extend: 'colvis',
            text: '<i class="fa fa-columns" aria-hidden="true"></i> ' + LANG.col_vis,
            className: 'btn-sm',
        },
    ];

    var pdf_btn = {
        extend: 'pdf',
        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i> ' + LANG.export_to_pdf,
        className: 'btn-sm',
        exportOptions: {
            columns: ':visible',
        },
        footer: true,
    };

    if (non_utf8_languages.indexOf(app_locale) == -1) {
        buttons.push(pdf_btn);
    }

    //Datables
    jQuery.extend($.fn.dataTable.defaults, {
        fixedHeader: true,
        dom:
            '<"row margin-bottom-20 text-center"<"col-sm-2"l><"col-sm-7"B><"col-sm-3"f> r>tip',
        buttons: buttons,
        aLengthMenu: [[25, 50, 100, 200, 500, 1000, -1], [25, 50, 100, 200, 500, 1000, LANG.all]],
        iDisplayLength: __default_datatable_page_entries,
        language: {
            searchPlaceholder: LANG.search + ' ...',
            search: '',
            lengthMenu: LANG.show + ' _MENU_ ' + LANG.entries,
            emptyTable: LANG.table_emptyTable,
            info: LANG.table_info,
            infoEmpty: LANG.table_infoEmpty,
            loadingRecords: LANG.table_loadingRecords,
            processing: LANG.table_processing,
            zeroRecords: LANG.table_zeroRecords,
            paginate: {
                first: LANG.first,
                last: LANG.last,
                next: LANG.next,
                previous: LANG.previous,
            },
        },
    });

    if ($('input#iraqi_selling_price_adjustment').length > 0) {
        iraqi_selling_price_adjustment = true;
    } else {
        iraqi_selling_price_adjustment = false;
    }

    //Input number
    $(document).on('click', '.input-number .quantity-up, .input-number .quantity-down', function() {
        var input = $(this)
            .closest('.input-number')
            .find('input');
        var qty = __read_number(input);
        var step = 1;
        if (input.data('step')) {
            step = input.data('step');
        }
        var min = parseFloat(input.data('min'));
        var max = parseFloat(input.data('max'));

        if ($(this).hasClass('quantity-up')) {
            //if max reached return false
            if (typeof max != 'undefined' && qty + step > max) {
                return false;
            }

            __write_number(input, qty + step);
            input.change();
        } else if ($(this).hasClass('quantity-down')) {
            //if max reached return false
            if (typeof min != 'undefined' && qty - step < min) {
                return false;
            }

            __write_number(input, qty - step);
            input.change();
        }
    });

    $('div.pos-tab-menu>div.list-group>a').click(function(e) {
        e.preventDefault();
        $(this)
            .siblings('a.active')
            .removeClass('active');
        $(this).addClass('active');
        var index = $(this).index();
        $('div.pos-tab>div.pos-tab-content').removeClass('active');
        $('div.pos-tab>div.pos-tab-content')
            .eq(index)
            .addClass('active');
    });

    $('.scroll-top-bottom').each( function(){
        $(this).topScrollbar();
    });
});

//Default settings for daterangePicker
var ranges = {};
ranges[LANG.today] = [moment(), moment()];
ranges[LANG.yesterday] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
ranges[LANG.last_7_days] = [moment().subtract(6, 'days'), moment()];
ranges[LANG.last_30_days] = [moment().subtract(29, 'days'), moment()];
ranges[LANG.this_month] = [moment().startOf('month'), moment().endOf('month')];
ranges[LANG.last_month] = [
    moment()
        .subtract(1, 'month')
        .startOf('month'),
    moment()
        .subtract(1, 'month')
        .endOf('month'),
];
ranges[LANG.this_month_last_year] = [
    moment()
        .subtract(1, 'year')
        .startOf('month'),
    moment()
        .subtract(1, 'year')
        .endOf('month'),
];
ranges[LANG.this_year] = [moment().startOf('year'), moment().endOf('year')];
ranges[LANG.last_year] = [
    moment().startOf('year').subtract(1, 'year'), 
    moment().endOf('year').subtract(1, 'year') 
];
ranges[LANG.this_financial_year] = [financial_year.start, financial_year.end];
ranges[LANG.last_financial_year] = [
    moment(financial_year.start._i).subtract(1, 'year'), 
    moment(financial_year.end._i).subtract(1, 'year')
];

var dateRangeSettings = {
    ranges: ranges,
    startDate: financial_year.start,
    endDate: financial_year.end,
    locale: {
        cancelLabel: LANG.clear,
        applyLabel: LANG.apply,
        customRangeLabel: LANG.custom_range,
        format: moment_date_format,
        toLabel: '~',
    },
};

//Check for number string in input field, if data-decimal is 0 then don't allow decimal symbol
$(document).on('keypress', 'input.input_number', function(event) {
    var is_decimal = $(this).data('decimal');

    if (is_decimal == 0) {
        if (__currency_decimal_separator == '.') {
            var regex = new RegExp(/^[0-9,-]+$/);
        } else {
            var regex = new RegExp(/^[0-9.-]+$/);
        }
    } else {
        var regex = new RegExp(/^[0-9.,-]+$/);
    }

    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

//Select all input values on click
$(document).on('click', 'input, textarea', function(event) {
    $(this).select();
});

$(document).on('click', '.toggle-font-size', function(event) {
    localStorage.setItem('upos_font_size', $(this).data('size'));
    update_font_size();
});
$(document).on('click', '.sidebar-toggle', function() {
    var sidebar_collapse = localStorage.getItem('upos_sidebar_collapse');
    if ($('body').hasClass('sidebar-collapse')) {
        localStorage.setItem('upos_sidebar_collapse', 'false');
    } else {
        localStorage.setItem('upos_sidebar_collapse', 'true');
    }
});

//Ask for confirmation for links
$(document).on('click', 'a.link_confirmation', function(e) {
    e.preventDefault();
    swal({
        title: LANG.sure,
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    }).then(confirmed => {
        if (confirmed) {
            window.location.href = $(this).attr('href');
        }
    });
});

//Change max quantity rule if lot number changes
$('table#stock_adjustment_product_table tbody').on('change', 'select.lot_number', function() {
    var qty_element = $(this)
        .closest('tr')
        .find('input.product_quantity');
    if ($(this).val()) {
        var lot_qty = $('option:selected', $(this)).data('qty_available');
        var max_err_msg = $('option:selected', $(this)).data('msg-max');
        qty_element.attr('data-rule-max-value', lot_qty);
        qty_element.attr('data-msg-max-value', max_err_msg);

        qty_element.rules('add', {
            'max-value': lot_qty,
            messages: {
                'max-value': max_err_msg,
            },
        });
    } else {
        var default_qty = qty_element.data('qty_available');
        var default_err_msg = qty_element.data('msg_max_default');
        qty_element.attr('data-rule-max-value', default_qty);
        qty_element.attr('data-msg-max-value', default_err_msg);

        qty_element.rules('add', {
            'max-value': default_qty,
            messages: {
                'max-value': default_err_msg,
            },
        });
    }
    qty_element.trigger('change');
});
$('button#btnCalculator').hover(function() {
    $(this).tooltip('show');
});
$(document).on('mouseleave', 'button#btnCalculator', function(e) {
    $(this).tooltip('hide');
});

jQuery.validator.addMethod(
    'min-value',
    function(value, element, param) {
        return this.optional(element) || !(param > __number_uf(value));
    },
    function(params, element) {
        return $(element).data('min-value');
    }
);

$(document).on('click', '.view_uploaded_document', function(e) {
    e.preventDefault();
    var src = $(this).data('href');
    var html =
        '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><img src="' +
        src +
        '" class="img-responsive" alt="Uploaded Document"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> <a href="' +
        src +
        '" class="btn btn-success" download=""><i class="fa fa-download"></i> Download</a></div></div></div>';
    $('div.view_modal')
        .html(html)
        .modal('show');
});

$(document).on('click', '#accordion .box-header', function(e) {
    if (e.target.tagName == 'A' || e.target.tagName == 'I') {
        return false;
    }
    $(this)
        .find('.box-title a')
        .click();
});




$(document).on('shown.bs.modal', '.contains_select2', function(){
    $(this).find('.select2').each( function(){
        var $p = $(this).parent();
        $(this).select2({ dropdownParent: $p });
    });
});

    /**
     * -----------------------------------------------------------------------------
     * Main menu section
     * -----------------------------------------------------------------------------
     */
    if ($('#nestable_main_menu').length > 0) {
        $('#nestable_main_menu').on('click', '.dd3-content', function () {
            var icon = $(this).children('.show_menu_content').children('i').attr('class');
            if (icon == 'fa fa-chevron-down') {
                $(this).children('.show_menu_content').children('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                $(this).children('.show_menu_content').children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
            $(this).siblings('.menu_content').slideToggle();
        });

        $('#nestable_main_menu').on('keyup', '.menu_content_title', function () {
            var menu_content_title = $(this).val();
            $(this).parent('.input').parent('.menu_content').siblings('.dd3-content').children('.menu_content_title_display').text(menu_content_title);
        });
        $('#nestable_main_menu').on('change', '.menu_content_title', function () {
            var menu_content_title = $(this).val();
            $(this).parent('.input').parent('.menu_content').siblings('.dd3-content').children('.menu_content_title_display').text(menu_content_title);
        });


        $('#add_custom_menu_button').on('click', function () {

            var item_l = parseInt($('#menu_item_count').val());
            item_l++;
            var add_custom_menu_title = $('#add_custom_menu_title').val();
            var add_custom_menu_link = $('#add_custom_menu_link').val();
            var data = '<li class="dd-item li_' + item_l + '" data-id="' + item_l + '">';
            data += '<input class="id" type="hidden" name="menu_item[' + item_l + '][id]" value="' + item_l + '">';
            data += '<input class="p_id" type="hidden" name="menu_item[' + item_l + '][p_id]" value="0">';
            data += '<input class="menu_type" type="hidden" name="menu_item[' + item_l + '][menu_type]" value="cl">';
            data += '<div class="dd-handle dd3-handle">';
            data += '&nbsp;';
            data += '</div>';
            data += '<div class="dd3-content">';
            data += '<span class="menu_content_title_display">' + add_custom_menu_title + '</span>';
            data += '<span class="pull-right show_menu_content"><i class="fa fa-chevron-down"></i></span>';
            data += '</div>';
            data += '<div class="menu_content smart-form">';
            data += '<label class="input">';
            data += '<i class="icon-append fa fa-navicon" title="Add your Title here"></i>';
            data += '<input class="form-control menu_content_title title" name="menu_item[' + item_l + '][title]" type="text" placeholder="title" value="' + add_custom_menu_title + '">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append fa fa-link" title="Add your Link here"></i>';
            data += '<input class="form-control link" type="url" name="menu_item[' + item_l + '][link]" placeholder="Url like http://nextpagetl.com" value="' + add_custom_menu_link + '">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append" title="Add your Link Wrapper Class here">Cls</i>';
            data += '<input class="form-control cls" type="text" name="menu_item[' + item_l + '][cls]" placeholder="Add your Link Wrapper class here like home, smddtech" value="">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append" title="Add your Link Class here">Cls</i>';
            data += '<input class="form-control link_cls" type="text" name="menu_item[' + item_l + '][link_cls]" placeholder="Add your Link class here like home, smddtech" value="">';
            data += '</label>';
            data += '<label class="input">';
            data += '<i class="icon-append" title="Add your Icon Class here">Cls</i>';
            data += '<input class="form-control icon_cls" type="text" name="menu_item[' + item_l + '][icon_cls]" placeholder="Add your Icon class here like  fa fa-plus-square" value="">';
            data += '</label>';
            data += '<a href="javascript:void(0)" class="btn btn-sm btn-danger menu_remove"><i class="fa fa-minus"></i> Remove menu</a>  <a href="javascript:void(0)" class="pull-right btn btn-sm btn-warning menu_cancel"><i class="fa fa-reply"></i> Cancel</a>';
            data += '</div>';
            data += '</li>';
            $('#menu_item_count').val(item_l);
            $('#nestable_main_menu>ol').append(data);
        });
    }
    // $('#nestable_main_menu').nestable();

    $('.add_posts_menu_button').on('click', function () {

       
        var container = $(this).parents(".add_custom_menu").attr("id");
        var checkedProperty = $('#' + container + ' input:checkbox:checked').map(function () {
            return $(this).val();
        }).get();
        var data = '';
        if (checkedProperty.length > 0) {
            var item_l = parseInt($('#menu_item_count').val());
            for (var loop = 0; loop < checkedProperty.length; loop++) {
                item_l++;
                var row = checkedProperty[loop];
                var add_custom_menu_title = $('#page_checkbox_' + row).attr('menu_title');
                var menu_type = $('#page_checkbox_' + row).attr('menu_type');
                var add_custom_menu_link = $('#page_checkbox_' + row).val();
                data += '<li class="dd-item li_' + item_l + '" data-id="' + item_l + '">';
                data += '<input class="id" value="' + item_l + '" type="hidden" name="menu_item[' + item_l + '][id]">';
                data += '<input class="p_id" type="hidden" name="menu_item[' + item_l + '][p_id]" value="0">';
                data += '<input class="menu_type" type="hidden" name="menu_item[' + item_l + '][menu_type]" value="' + menu_type + '">';
                data += '<div class="dd-handle dd3-handle">';
                data += '&nbsp;';
                data += '</div>';
                data += '<div class="dd3-content">';
                data += '<span class="menu_content_title_display">' + add_custom_menu_title + '</span>';
                data += '<span class="pull-right show_menu_content"><i class="fa fa-chevron-down"></i></span>';
                data += '</div>';
                data += '<div class="menu_content smart-form">';
                data += '<label class="input">';
                data += '<i class="icon-append fa fa-navicon" title="Add your Title here"></i>';
                data += '<input class="form-control menu_content_title title" name="menu_item[' + item_l + '][title]" type="text" placeholder="title" value="' + add_custom_menu_title + '">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append fa fa-link" title="Add your Link here"></i>';
                data += '<input class="form-control link" type="url" name="menu_item[' + item_l + '][link]" placeholder="Url like http://nextpagetl.com" value="' + add_custom_menu_link + '">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append" title="Add your Link Wrapper Class here">Cls</i>';
                data += '<input class="form-control cls" type="text" name="menu_item[' + item_l + '][cls]" placeholder="Add your Link Wrapper class here like home, smddtech" value="">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append" title="Add your Link Class here">Cls</i>';
                data += '<input class="form-control link_cls" type="text" name="menu_item[' + item_l + '][link_cls]" placeholder="Add your Link class here like home, smddtech" value="">';
                data += '</label>';
                data += '<label class="input">';
                data += '<i class="icon-append" title="Add your Icon Class here">Cls</i>';
                data += '<input class="form-control icon_cls" type="text" name="menu_item[' + item_l + '][icon_cls]" placeholder="Add your Icon class here like  fa fa-plus-square" value="">';
                data += '</label>';
                data += '<a href="javascript:void(0)" class="btn btn-sm btn-danger menu_remove"><i class="fa fa-minus"></i> Remove menu</a>  <a href="javascript:void(0)" class="pull-right btn btn-sm btn-warning menu_cancel"><i class="fa fa-reply"></i> Cancel</a>';
                data += '</div>';
                data += '</li>';
            }
        }
        $('#menu_item_count').val(item_l);
        $('#add_page_div input:checkbox:checked').map(function () {
            $(this).attr('checked', false);
        });
        $('#nestable_main_menu>ol').append(data);
    });

    $('#nestable_main_menu').on('click', '.menu_remove', function () {
        $(this).parent('.menu_content').parent('li').remove();
    });
    $('#nestable_main_menu').on('click', '.menu_cancel', function () {
        $(this).parent('.menu_content').siblings('.dd3-content').children('.show_menu_content').children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        $(this).parent('.menu_content').slideToggle();
    });


    $('#save_menu').on('click', function () {



        var save_menu = $(this);
        save_menu.attr('disabled', true);
        var loop = 0;
        $('#nestable_main_menu .id').each(function () {
            loop++;
            var id = $(this).val();
            $(this).val(loop);
            $(this).attr('name', 'menu_item[' + loop + '][id]');
            $('.li_' + id).attr('data-id', loop);
            $('.li_' + id).children('.p_id').attr('name', 'menu_item[' + loop + '][p_id]');
            $('.li_' + id).children('.menu_type').attr('name', 'menu_item[' + loop + '][menu_type]');
            $('.li_' + id).children('.menu_content').children('.input').children('.title').attr('name', 'menu_item[' + loop + '][title]');
            $('.li_' + id).children('.menu_content').children('.input').children('.link').attr('name', 'menu_item[' + loop + '][link]');
            $('.li_' + id).children('.menu_content').children('.input').children('.cls').attr('name', 'menu_item[' + loop + '][cls]');
            $('.li_' + id).children('.menu_content').children('.input').children('.link_cls').attr('name', 'menu_item[' + loop + '][link_cls]');
            $('.li_' + id).children('.menu_content').children('.input').children('.icon_cls').attr('name', 'menu_item[' + loop + '][icon_cls]');
        });
        var loop = 0;
        $('#nestable_main_menu>.dd-list>.dd-item').each(function () {
            var $this = $(this),
                parent_id = $this.attr('data-id');
            $this.children('.p_id').val('0');
            set_parent_id($this, parent_id);
        });

        function set_parent_id($this, parent_id) {
            if ($this.children('.dd-list').length > 0) {
                $this.children('.dd-list').children('.dd-item').each(function () {
                    var parent_id1 = $(this).attr('data-id');
                    $(this).children('.p_id').val(parent_id);
                    set_parent_id($(this), parent_id1);
                });
            }
        }

        $('#nestable_main_menu').wrapInner('<form></form>');
        var _token = $('#table_csrf_token').val();

        var data = $('#nestable_main_menu > form').serialize()
        if (data != '') {
            data += '&' + $.param({'_token': _token});
            $.ajax({
                type: 'post',
                url: '/save_menus',
                data: data,
                success: function (response) {
                    if (parseInt(response) == 1) {
                        swal({
                            type: 'success',
                            icon: "success",
                            title: "Success!",
                            text: 'Menu Saved successfully!',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }

                    save_menu.attr('disabled', false);
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                },
                error: function (error) {
                    //console.log(error);
                }
            });
        } else {
            window.location.reload();
        }
        return false;
    });
    /* nptl theme option js start */
    if ($(".smThemeAddablePopUp").length > 0) {

        $(".smThemeOptionPopupModal .col-md-7").each(function () {
            $(this).addClass("col-md-12").removeClass("col-md-7");
        });
        $(".smThemeOptionPopupModal .col-md-9").each(function () {
            $(this).addClass("col-md-10").removeClass("col-md-9");
        });
        $(".smThemeAddablePopUp").on("click", ".sm_theme_remove_popup_item", function () {
            //console.log("sm_theme_edit_popup_item clicked");
            $(this).parent("li").remove();
        });
        $(".smThemeAddablePopUp").on("click", ".add_more_popup", function () {
            var info = $(this).attr('data-info');
            var modal = $(this).data("target");
            var formattedvalue = $(this).attr('data-formattedvalue');
            // console.log("info = " + info + " modal = " + modal);
            var saveId = 'save_sm_theme_popup';
            if ($("#" + modal).find(".update_sm_theme_popup").length) {
                saveId = 'update_sm_theme_popup';
            }
            $("#" + modal).find('.sortable').html('');
            $("#" + modal + ' .sm_theme_popup_field').each(function () {
                var type = $(this).attr('type');
                if (type !== 'radio' && type !== 'checkbox') {
                    $(this).val('');
                    $(this).removeAttr('name');
                }
            });
            // $("#" + modal).find('.sm_theme_popup_field').removeAttr('name');
            $("#" + modal).find("." + saveId).attr('data-formattedvalue', formattedvalue);
            $("#" + modal).find("." + saveId).attr('data-value', "");
            $("#" + modal).find("." + saveId).attr('data-info', info);
            if (saveId == 'update_sm_theme_popup') {
                $("#" + modal).find(".update_sm_theme_popup").addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
            }
            $("#" + modal).modal("show");
            return false;
        });
        $(".smThemeAddablePopUp").on("click", ".sm_theme_edit_popup_item", function () {
            //console.log("sm_theme_edit_popup_item clicked");
            var info = $(this).attr('data-info');
            var mainid = $(this).data("mainid");
            var children = $(this).data("children");
            var modal = mainid + "_Modal";
            var value = $(this).siblings('.sm_theme_popup_field').val();
            value = typeof value == 'string' ? value : JSON.stringify(value);
            var formattedvalue = $(this).siblings('.sm_theme_popup_field').attr('data-formattedvalue');
            formattedvalue = typeof formattedvalue == 'string' ? formattedvalue : JSON.stringify(formattedvalue);
            // console.log("mainId = " + mainid + " modal = " + modal + " info = " + info + " children= " + children);
            // console.log("value = " + value + " formattedValue= " + formattedvalue);
            // console.log(formattedvalue);
            remove_sm_theme_option_active_sortable(children);
            $(this).parent(".ui-state-default").addClass("sm_theme_option_active_sortable" + children);
            $("#" + modal).find('.sortable').html('');
            $("#" + modal).find(".save_sm_theme_popup").attr('data-value', value);
            $("#" + modal).find(".update_sm_theme_popup").attr('data-value', value);
            $("#" + modal).find(".save_sm_theme_popup").attr('data-formattedvalue', formattedvalue);
            $("#" + modal).find(".update_sm_theme_popup").attr('data-formattedvalue', formattedvalue);

            value = typeof value === 'string' ? JSON.parse(value) : value;
            // console.log(value);
            formattedvalue = typeof formattedvalue == 'string' ? JSON.parse(formattedvalue) : formattedvalue;
            // console.table(formattedvalue);
            for (var index in formattedvalue) {
                // for (var infoId in formattedvalue[index]) {
                var single = formattedvalue[index];
                // var single = formattedvalue[index][infoId];
                // console.log("loop index "+index+" single = "+JSON.stringify(single));
                var id = single["id"];
                var type = single["type"];
                var val = single["value"];
                var name = single["name"];
                var selector = single["selector"];


                // console.log("modal = " + modal + " type = " + type + " id = " + id + " val = " + val + " name = " + name + " selector = " + selector);

                if (type !== undefined && type.length > 0) {
                    if (type === "upload") {
                        mrksGetImageResponse(modal, selector, val);
                    } else if (type === 'radio' || type === 'checkbox') {
                        $("#" + modal).find(".sm_theme_popup_" + id).each(function () {
                            var currentVal = $(this).val();
                            // console.log("val = "+val+" currentVal = "+currentVal);
                            if (val === currentVal) {
                                // console.log("ok");
                                $(this).prop("checked", true);
                            } else {
                                $(this).prop("checked", false);
                            }
                        });
                    } else if (type === 'addable-popup') {
                        // console.log('addable-popup');
                        var itemTemplate = $('#' + mainid + "_" + id + '__add_more').data('template');
                        // console.log("id = " + id + " mainid = " + mainid + " itemTemplate = " + itemTemplate + " value = " + value);
                        // console.table(val);
                        var html = '';
                        if (val != '') {
                            for (var pIndes in val) {
                                // console.log("val "+JSON.stringify(val));
                                var jsonformattedvalue = val[pIndes];
                                var newValue = typeof value == 'string' ? JSON.parse(value) : value;
                                var jsonvalue = newValue[id][pIndes];
                                // console.log("itemTemplate = " + itemTemplate + " jsonvalue = " + jsonvalue);

                                jsonvalue = typeof jsonvalue == 'string' ? JSON.parse(jsonvalue) : jsonvalue;

                                var title = jsonvalue[itemTemplate] || "title";
                                html += '<li class="ui-state-default">\n' +
                                    '<i class="fa fa-sort"></i>';

                                var jsonvalue = typeof jsonvalue === 'string' ? jsonvalue : JSON.stringify(jsonvalue);
                                var jsonformattedvalue = typeof jsonformattedvalue === 'string' ? jsonformattedvalue : JSON.stringify(jsonformattedvalue);

                                html += generateInput('<input type="hidden" ' +
                                    'value="" ' +
                                    'data-formattedvalue="" ' +
                                    'class="sm_theme_popup_field sm_theme_popup_' + id + ' ' + mainid + "_" + id + '_value" ' +
                                    'data-selector="' + selector + '" ' +
                                    'data-info="' + id + '" ' +
                                    '>', jsonvalue, jsonformattedvalue);


                                html += '<span class="sm_theme_popup_title"> ' + title + '</span>';
                                html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
                                    '<i class="fa fa-times"></i>\n' +
                                    '</a>\n' +
                                    '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
                                    ' data-children="2"\n' +
                                    ' data-template="' + id + '"\n' +
                                    ' data-info="' + id + '"\n' +
                                    ' data-mainid="' + mainid + "_" + id + '_">\n' +
                                    '<i class="fa fa-pencil"></i>\n' +
                                    '</a>\n' +
                                    '</li>';
                            }
                        }
                        $("#" + modal).find('.sortable').html(html);

                    } else {
                        $("#" + modal).find(".sm_theme_popup_" + id).val(val);
                    }
                } else {
                    $("#" + modal).find(".sm_theme_popup_" + id).val(val);
                }
                // }
            }

            $("#" + modal).find(".save_sm_theme_popup").attr('data-info', info);
            $("#" + modal).find(".update_sm_theme_popup").attr('data-info', info);
            $("#" + modal).find(".save_sm_theme_popup").addClass("update_sm_theme_popup").removeClass("save_sm_theme_popup");
            $("#" + modal).modal("show");
            return false;
        });

        $(".smThemeAddablePopUp").on("click", ".update_sm_theme_popup", function () {
            // console.log("update_sm_theme_popup");
            var template = $(this).data("template");
            var info = $(this).data("info");
            var children = $(this).data("children");
            var modal = $(this).data("insert");
            var formattedvalue = $(this).data("formattedvalue");
            var value = $(this).data("value");

            value = typeof value == 'string' ? JSON.parse(value) : value;
            formattedvalue = typeof formattedvalue == 'string' ? JSON.parse(formattedvalue) : formattedvalue;
            var pcReturn = processPopUpInfo(modal, formattedvalue, template, children, info);

            var jsonvalue = typeof pcReturn.value === 'string' ? pcReturn.value : JSON.stringify(pcReturn.value);
            var jsonformattedvalue = typeof pcReturn.formattedvalue === 'string' ? pcReturn.formattedvalue : JSON.stringify(pcReturn.formattedvalue);
            $('.sm_theme_option_active_sortable' + children).find(".sm_theme_popup_field").val(jsonvalue);
            $('.sm_theme_option_active_sortable' + children).find(".sm_theme_popup_field").attr('data-formattedvalue', jsonformattedvalue);
            $(this).addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
            remove_sm_theme_option_active_sortable(children);
            $("#" + modal + "_Modal").modal("hide");
            return false;
        });


        $(".smThemeAddablePopUp").on("click", ".save_sm_theme_popup", function () {
            // console.log("save_sm_theme_popup");
            var id = $(this).data("insert");
            var info = $(this).attr("data-info");
            var children = $(this).data("children");
            var inputname = $(this).data("inputname");
            var template = $(this).data("template");
            var iteration = $(this).data("formattedvalue");
            var count = parseInt($("#" + id + "_count").val());
            var title = "Title";
            // console.log(iteration);
            // console.log("template " + template + " save_sm_theme_popup " + id + " info =" + info);

            var html = '<li class="ui-state-default">\n' +
                '                            <i class="fa fa-sort"></i>';
            var value = {}, formattedvalue = [], parentname;


            // for (var index in iteration) {
            //     var single = iteration[index];
            //     console.log("\n\nsingle =" + JSON.stringify(single));
            //     if (single.type != 'addable-popup') {
            //
            //         var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id);
            //         parentname = single.name;
            //         var name = $this.data("name");
            //         var selector = $this.data("selector");
            //         var val = $this.val();
            //         // $(this).val("");
            //         if (template === single.id) {
            //             title = val;
            //         }
            //         value[single.id] = val;
            //         var newformattedvalue = {}, newformattedvalue2 = {};
            //         newformattedvalue.id = single.id;
            //         newformattedvalue.type = single.type;
            //         newformattedvalue.name = name;
            //         newformattedvalue.value = val;
            //         newformattedvalue.selector = selector;
            //         newformattedvalue2[single.id] = newformattedvalue;
            //
            //         formattedvalue.push(newformattedvalue2);
            //
            //         // console.log("in loop info = "+info+" type = "+single.type+" name = "+name+" val= "+val+" selector = "+selector+" newformattedvalue2 ="+JSON.stringify(newformattedvalue2));
            //         console.log("in loop value =" + JSON.stringify(value));
            //         console.log("in loop newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
            //     } else {
            //         var newInput = [];
            //         var newFormatttedValue = [];
            //         $("#" + id + "_Modal .sm_theme_popup_" + single.id).each(function () {
            //             var singleInfo = $(this).val();
            //             var singleFV = $(this).attr('data-formattedvalue');
            //             newInput.push(singleInfo);
            //             newFormatttedValue.push(singleFV);
            //         });
            //
            //
            //         parentname = single.name;
            //         var name = single.name;
            //         var selector = single.selector + "__" + single.id + "_";
            //         var val = newInput;
            //         // $(this).val("");
            //         if (template === single.id) {
            //             title = val;
            //         }
            //         value[single.id] = val;
            //         var newformattedvalue = {}, newformattedvalue2 = {};
            //         newformattedvalue.id = single.id;
            //         newformattedvalue.type = single.type;
            //         newformattedvalue.name = name;
            //         newformattedvalue.value = newFormatttedValue;
            //         newformattedvalue.selector = selector;
            //         newformattedvalue2[single.id] = newformattedvalue;
            //
            //         formattedvalue.push(newformattedvalue2);
            //
            //         // console.log("in loop info = "+info+" type = "+single.type+" name = "+name+" val= "+val+" selector = "+selector+" newformattedvalue2 ="+JSON.stringify(newformattedvalue2));
            //         console.log("in loop else single =" + JSON.stringify(value));
            //         console.log("in loop else newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
            //     }
            //
            // }

            var pcReturn = processPopUpInfo(id, iteration, template, children);

            var jsonvalue = typeof pcReturn.value === 'string' ? pcReturn.value : JSON.stringify(pcReturn.value);
            var jsonformattedvalue = typeof pcReturn.formattedvalue === 'string' ? pcReturn.formattedvalue : JSON.stringify(pcReturn.formattedvalue);
            // console.log('\n\njsonvalue ' + jsonvalue);
            // console.log('jsonformattedvalue ' + jsonformattedvalue);
            var nameFiled = '';
            if (children == 1) {
                nameFiled = 'name="' + inputname + '"';
            }
            // console.log("info = "+info);
            html += generateInput('<input type="hidden" ' +
                'value="" ' +
                'data-formattedvalue="" ' +
                'class="sm_theme_popup_field sm_theme_popup_' + info + ' ' + id + 'value" ' +
                'data-selector="' + id + '" ' +
                'data-info="' + info + '" ' +
                nameFiled + '>', jsonvalue, jsonformattedvalue);


            html += '<span class="sm_theme_popup_title"> ' + pcReturn.title + '</span>';
            html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
                '<i class="fa fa-times"></i>\n' +
                '</a>\n' +
                '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
                ' data-children="' + children + '"\n' +
                ' data-template="' + template + '"\n' +
                ' data-info="' + info + '"\n' +
                ' data-mainid="' + id + '">\n' +
                '<i class="fa fa-pencil"></i>\n' +
                '</a>\n' +
                '                        </li>';
            $("#" + id + "_count").val(++count);
            $("#" + id).find('.sortable').append(html);
            $("#" + id + "_Modal").modal("hide");
            return false;
        });


        // $(".smThemeAddablePopUp").on("click", ".sm_theme_edit_popup_item", function () {
        //
        //     var modal = $(this).data("modal");
        //     remove_sm_theme_option_active_sortable();
        //     $(this).parent(".ui-state-default").addClass("sm_theme_option_active_sortable");
        //
        //     $(this).siblings(".sm_theme_popup_input").each(function () {
        //         var val = $(this).val();
        //         var id = $(this).data("id");
        //         var type = $(this).data("type");
        //         // console.log("modal = " + modal + " type = " + type + " id = " + id + " val = " + val);
        //
        //         if (type !== undefined && type.length > 0) {
        //             if (type === "upload") {
        //                 var _token = $('#table_csrf_token').val();
        //                 $.ajax({
        //                     url: smAdminUrl + "get_image_src",
        //                     data: {is_upload: 1, ids: val, _token: _token},
        //                     type: 'post',
        //                     success: function (response) {
        //                         $("#" + modal).find(".smthemesingleimagediv#" + id + "_ph").html(response);
        //                     }
        //                 });
        //             } else if (type === 'radio') {
        //                 $("#" + modal).find(".sm_theme_popup_" + id).each(function () {
        //                     var currentVal = $(this).val();
        //                     // console.log("val = "+val+" currentVal = "+currentVal);
        //                     if (val === currentVal) {
        //                         // console.log("ok");
        //                         $(this).prop("checked", true)
        //                     }
        //                 });
        //             } else {
        //                 $("#" + modal).find(".sm_theme_popup_" + id).val(val);
        //             }
        //         } else {
        //             $("#" + modal).find(".sm_theme_popup_" + id).val(val);
        //         }
        //     });
        //     $("#" + modal).find(".save_sm_theme_popup").addClass("update_sm_theme_popup").removeClass("save_sm_theme_popup");
        //     $("#" + modal).modal("show");
        // });


        // $(".smThemeAddablePopUp").on("click", ".update_sm_theme_popup", function () {
        //     // console.log("update_sm_theme_popup");
        //     var template = $(this).data("template");
        //     var modal = $(this).data("insert");
        //     $("#" + modal + "_Modal .sm_theme_popup_field").each(function () {
        //         var info = $(this).data("info");
        //         var inputType = $(this).attr("type");
        //         if (inputType === 'radio') {
        //             var val = $("#" + modal + "_Modal .sm_theme_popup_" + info + ":checked").val();
        //             // console.log("radio info=" + info + " val=" + val + " type = " + inputType);
        //         } else {
        //             var val = $(this).val();
        //             // console.log("info=" + info + " val=" + val + " type = " + inputType);
        //         }
        //         if (template == info) {
        //             $(".sm_theme_option_active_sortable").find(".sm_theme_popup_title").text(val);
        //         }
        //
        //         $(".sm_theme_option_active_sortable").find(".sm_theme_popup_input_" + info).val(val);
        //     });
        //     $(this).addClass("save_sm_theme_popup").removeClass("update_sm_theme_popup");
        //     remove_sm_theme_option_active_sortable();
        //     $("#" + modal + "_Modal").modal("hide");
        //
        // });


        // $(".smThemeAddablePopUp").on("click", ".save_sm_theme_popup", function () {
        //     // console.log("save_sm_theme_popup");
        //     var id = $(this).data("insert");
        //     var template = $(this).data("template");
        //     var count = parseInt($("#" + id + "_count").val());
        //     var title = "Title";
        //
        //     console.log("template " + template + " save_sm_theme_popup " + id);
        //
        //     var html = '<li class="ui-state-default">\n' +
        //         '                            <i class="fa fa-sort"></i>';
        //     $("#" + id + "_Modal .sm_theme_popup_field").each(function () {
        //         var info = $(this).data("info");
        //         var basename = $(this).data("name");
        //         var val = $(this).val();
        //         $(this).val("");
        //         if (template == info) {
        //             title = val;
        //         }
        //         html += '<input class="sm_theme_popup_input sm_theme_popup_input_' + info + '" ' +
        //             'type="hidden" value="' + val + '" data-id="' + info + '" ' +
        //             'data-basename="' + basename + '" name=""> ';
        //     });
        //     html += '<span class="sm_theme_popup_title">' + title + '</span>';
        //     html += '<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-popup sm_theme_remove_popup_item">\n' +
        //         '<i class="fa fa-times"></i>\n' +
        //         '</a>\n' +
        //         '<a href="javascript:void(0)" class="btn btn-xs btn-success btn-popup sm_theme_edit_popup_item"\n' +
        //         ' data-modal="' + id + '_Modal">\n' +
        //         '<i class="fa fa-pencil"></i>\n' +
        //         '</a>\n' +
        //         '                        </li>';
        //     console.log(html);
        //     $("#" + id + "_count").val(++count);
        //     $("#" + id).find('.sortable').append(html);
        //     $("#" + id + "_Modal").modal("hide");
        // });

        $(".sm_theme_option_save").on("click", function () {
            var $this = $(this), html = $this.html();
            $this.html('<i class="fa fa-refresh fa-spin"></i> Saving...');
            $this.attr("disabled", true);
            sorting_position_change();
            $("#smThemeOptionPopupModal").remove();
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            // $("#sm_theme_option_form").submit();
            var formData = $("#sm_theme_option_form").serialize();
            var action = $("#sm_theme_option_form").attr('action');
            $.ajax({
                url: action,
                data: formData,
                type: 'post',
                success: function (response) {
                    $this.removeAttr("disabled");
                    $this.html(html);
                    swal({
                        type: 'success',
                        icon: "success",
                        title: response,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
            return false;
        });


    }


    function processPopUpInfo(id, iteration, template, children, info) {
        var title = "Title";
        // console.log("id "+id);
        // console.log("iteration");
        // console.log(iteration);
        // console.log("template "+template);
        // console.log("children " +children);
        var value = {}, formattedvalue = {}, parentname;
        for (var index in iteration) {
            // console.log("index "+index);
            var single = iteration[index];
            var newformattedvalue = {}, newformattedvalue2 = {};

            if (single.type !== 'addable-popup') {
                parentname = single.name;
                if (single.type == 'radio') {
                    var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id + ':checked');
                } else {
                    var $this = $("#" + id + "_Modal").find('.sm_theme_popup_' + single.id);
                }
                var name = $this.data("name");
                var selector = $this.data("selector");
                var val = $this.val();
                if (single.type === 'checkbox') {
                    if ($this.is(':checked')) {
                        val = $this.val();
                    } else {
                        val = "";
                    }
                }
                // console.log("single.type " + single.type + " single.id " + single.id + " val " + val);
                // $(this).val("");
                if (template === single.id) {
                    title = val;
                    $(".sm_theme_option_active_sortable" + children).find(".sm_theme_popup_title").text(val);
                }
                value[single.id] = val;
                newformattedvalue.id = single.id;
                newformattedvalue.type = single.type;
                newformattedvalue.name = name;
                newformattedvalue.value = val;
                newformattedvalue.selector = selector;
                // newformattedvalue2[single.id] = newformattedvalue;

                formattedvalue[single.id] = (newformattedvalue);

                // console.log("in loop info = "+info+" type = "+single.type+" name = "+name+" val= "+val+" selector = "+selector+" newformattedvalue2 ="+JSON.stringify(newformattedvalue2));
                //console.log("in loop value =" + JSON.stringify(value));
                //console.log("in loop newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
            } else {
                var newInput = [];
                var newFormatttedValue = [];
                var currentModalField = "#" + id + "_Modal .sm_theme_popup_" + single.id;
                // console.log("single.type " + single.type + " single.id " + single.id+" currentModalField "+currentModalField);
                $(currentModalField).each(function () {
                    var singleInfo = $(this).val();
                    // console.log("singleInfo "+singleInfo);
                    var singleFV = $(this).attr('data-formattedvalue');
                    newInput.push(singleInfo);
                    newFormatttedValue.push(singleFV);
                });


                parentname = single.name;
                var name = single.name;
                var selector = single.selector + "__" + single.id + "_";
                var val = newInput;
                // $(this).val("");
                if (template === single.id) {
                    title = val;
                    $(".sm_theme_option_active_sortable" + children).find(".sm_theme_popup_title").text(val);
                }
                value[single.id] = val;
                newformattedvalue.id = single.id;
                newformattedvalue.type = single.type;
                newformattedvalue.name = name;
                newformattedvalue.value = newFormatttedValue;
                newformattedvalue.selector = selector;
                // newformattedvalue2[single.id] = newformattedvalue;

                formattedvalue[single.id] = (newformattedvalue);

                // console.log("in loop id = " + single.id + " type = " + single.type + " name = " + name + " val= " + val + " selector = " + selector + " newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
                // console.log("in loop else single =" + JSON.stringify(value));
                // console.log("in loop else newformattedvalue2 =" + JSON.stringify(newformattedvalue2));
                // console.log("in loop "+"#" + id + "_Modal .sm_theme_popup_" + single.id);
                // console.table(newFormatttedValue);
            }

        }
        var fnReturun = {};
        fnReturun.title = title;
        fnReturun.value = value;
        fnReturun.parentname = parentname;
        fnReturun.formattedvalue = formattedvalue;
        return fnReturun;
    }

    function remove_sm_theme_option_active_sortable(children) {
        $(".sm_theme_option_active_sortable" + children).each(function () {
            $(this).removeClass("sm_theme_option_active_sortable" + children);
        });
    }

    function sorting_position_change() {
        $(".smThemeAddablePopUp ul").each(function () {
            var loop = 0;
            $(this).children("li").each(function () {
                $(this).children(".sm_theme_popup_input").each(function () {
                    var id = $(this).data("id");
                    var basename = $(this).data("basename");
                    if (basename.length > 0) {
                        //console.log("basename = " + basename + "[" + loop + "]" + "[" + id + "]");
                        $(this).attr("name", basename + "[" + loop + "]" + "[" + id + "]");
                    }
                });
                loop++;
            });
        });
    }

    $(".sm_post_save_process").on("click", function () {
        sorting_position_change();
    });
    $('.colorpicker').colorpicker({
        colorSelectors: {
            'black': '#000000',
            'white': '#ffffff',
            'red': '#FF0000',
            'default': '#777777',
            'primary': '#337ab7',
            'success': '#5cb85c',
            'info': '#5bc0de',
            'warning': '#f0ad4e',
            'danger': '#d9534f'
        }
    });


    /* end nptl theme option js */
//common configuration : tinyMCE editor
tinymce.overrideDefaults({
    height: 300,
    theme: 'silver',
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'table template paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |' +
      ' bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor',
    menu: {
      favs: {title: 'My Favorites', items: 'code | searchreplace'}
    },
    menubar: 'favs file edit view insert format tools table help'
});

// Prevent Bootstrap dialog from blocking focusin
$(document).on('focusin', function(e) {
  if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
    e.stopImmediatePropagation();
  }
});


//search parameter in url
function urlSearchParam(param){
    var results = new RegExp('[\?&]' + param + '=([^&#]*)').exec(window.location.href);
    if (results == null){
       return null;
    } else{
       return results[1];
    }
}


function get_the_file_width(str, width) {
    return str.replace('112x112', width + 'x' + width);
}
function imagePrev(imageID, imageHolder) {
    var imgPath = $('#' + imageID)[0].value;
    var extn = imgPath.substring(imgPath.lastIndexOf(".") + 1).toLowerCase();
//        alert(imageID + " " + imageHolder + " " + imgPath + " " + extn);
    if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
        if (typeof (FileReader) !== "undefined") {
            var image_holder = $("#" + imageHolder);
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "image-prev"
                }).appendTo(image_holder);

            };
            image_holder.show();
            reader.readAsDataURL($('#' + imageID)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    } else {
        alert("Pls select only images");
    }
}


function mrksGetImageResponse(modal, selector, val) {
    var imagePlaceholder = selector + "_ph";
    var _token = $('#table_csrf_token').val();
    $("#" + modal).find("#" + selector).val(val);
    $.ajax({
        url: 'get_image_src',
        data: {is_upload: 1, ids: val, _token: _token},
        type: 'post',
        success: function (response) {
            $("#" + modal).find(".smthemesingleimagediv#" + imagePlaceholder).html(response);
        }
    });
}