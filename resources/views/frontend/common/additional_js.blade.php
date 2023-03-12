<?php
$max_price = (int)\App\Model\Common\Product::max('regular_price');
$min_price = (int)\App\Model\Common\Product::min('regular_price');
?>
{{--shop rang slider--}}
{!!Html::script('additional/lib/owl.carousel/owl.carousel.min.js')!!}
{!!Html::script('additional/lib/jquery-ui/jquery-ui.min.js')!!}
{{--{!!Html::script('additional/lib/js/theme-script.js')!!}--}}
{!!Html::script('nptl-admin/js/plugin/jquery-validate/jquery.validate.min.js')!!}
{!!Html::script('https://unpkg.com/sweetalert/dist/sweetalert.min.js')!!}
{!!Html::script('additional/toastr/toastr.min.js')!!}
{!!Html::script('additional/js/nptl.js')!!}
{{--blog section--}}


{!!Html::script('additional/js/swiper.jquery.min.js')!!}
{!!Html::script('additional/js/main.js')!!}
{!! Toastr::message() !!}
<script type="text/javascript">
    jQuery(document).ready(function () {
        
        
        
        jQuery('a.newsletterClick.sign_in').click(function () {
            jQuery('#forgotpassworddiv').hide();
            jQuery('#label-popup-signupform').hide();
            jQuery('.magestore-loign-h3.first').hide();
            jQuery('.magestore-loign-h3.second').show();
            jQuery('.magestore-loign-h3.third').hide();
            jQuery('#label-popup-loginform').show();
            return false;
        });
        jQuery('a.newsletterClick.register-link').click(function () {
            jQuery('#forgotpassworddiv').hide();
            jQuery('#label-popup-loginform').hide();
            jQuery('.magestore-loign-h3.first').show();
            jQuery('.magestore-loign-h3.second').hide();
            jQuery('.magestore-loign-h3.third').hide();
            jQuery('#label-popup-signupform').show();
            return false;
        });
        // jQuery('#signupform_email').click(function () {
        //     var email = jQuery('input#email_register').val();
        //     if (email != "") {
        //         jQuery('#forgotpassworddiv').hide();
        //         // jQuery('#label-popup-signupform .signup_email').hide();
        //         jQuery('#registerloginformDiv').fadeIn();
        //     } else {
        //         jQuery('input#email_register').addClass('notBeBlank').attr('placeholder', 'PLease fill a valid email id');
        //     }
        //     return false;
        // });
        jQuery('.backtojoinnow').click(function () {
            jQuery('#registerloginformDiv').hide();
            jQuery('#forgotpassworddiv').hide();
            jQuery('#label-popup-signupform .signup_email').fadeIn();
            return false;

        });

        jQuery('.forgotPass').click(function () {
            jQuery('.magestore-loign-h3.first').hide();
            jQuery('.magestore-loign-h3.second').hide();
            jQuery('.magestore-loign-h3.third').show();
            jQuery('#label-popup-loginform').hide();
            jQuery('#forgotpassworddiv').fadeIn();
            return false;
        });
    });
</script>
<script type="text/javascript">
    // ----currencyFormat---
    var currency = "<?php echo SM::get_setting_value('currency'); ?>";

    function currencyFormat(num) {
        return currency + ' ' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    // ----------toastr alert message--------------
    $(function () {
              
                    $('.addRow').on('click', function () {
  
                      
                        $( "#customersDataShow" ).append( addRow());
                             
                            $('select').select2({ placeholder: "", maximumSelectionSize: 6 });
                    });


                        function addRow() {

                            var tr = '<tr>' +
                                '<td><input name="req_name[]" class="form-control field-validate" type="text"> ' +
                                
                                    '</td>' +
                                    '<td><input name="req_qty[]" class="form-control field-validate" type="text"> ' +
                                
                                    '</td>' +
                                    

                             '<td><a type="button" class="btn btn-success remove_col_pro"><i class="fa fa-minus"></i></a></td></tr>' ;    



                            return tr;



                        };

        $('body').on('click', '.remove_col_pro', function () {

                                var l = $('#customersDataShow tr').length;
                                
                                if(l > 1)
                                {
                                    $(this).parent().parent().remove();
                                }
                                else
                                {
                                    alert('You cant delete last item ');
                                }

                            });
                            
                    
        
                            
        
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "100",
            "hideDuration": "1000",
            "timeOut": "2500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };


        $('body').on('click', '.product_att_size', function (event) {
            var att_id = jQuery(this).data("att_id");
            $(this).siblings('.product_att_size').find('.size_active').removeClass("size_active");
            $(this).children("div").find('.size').addClass('size_active');
            $(this).children("div").find('.product_att_size').prop('checked', true);
            var base = $(this);
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '{{ URL::route('att_size_by_product_price')}}',
                data: {
                    att_id: att_id,
                },
                success: function (data) {
                    base.parents('.best-box').find('.att_price').text(data.attribute_price);
                    $('.att_price1').text(data.attribute_price);
                }
            })
            event.preventDefault();
        });
// ---------------coupon_check---------
        $('body').on('click', '.apply_coupon', function (event) {
            var coupon_code = $('#coupon_code').val();
            var sub_total_price = $('#sub_total_price').val();
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('coupon_check')}}',
                data: {coupon_code: coupon_code, sub_total_price: sub_total_price},
                success: function (data) {
                    if (data.check_coupon == 1) {
                        $('#coupon_amount').html(currencyFormat(data.coupon_amount))
                        $('#grand_total').html(currencyFormat(data.grand_total))
                        $('.coupon_amount').val(data.coupon_amount)
                        $('.grand_total').val(data.grand_total)
                        $('.coupon_code').val(data.coupon_code)
                        toastr.success(data.message, data.title);
                    } else {
                        toastr.error(data.message, data.title);
                    }
                }
            });
        });
// ---------------ajax add to cart---------
        $('body').on('click', '.addToCart', function (event) {
         
            var product_id = $(this).data("product_id");
            var regular_price = $(this).data("regular_price");
            var sale_price = $(this).data("sale_price");
            var qty = $('.productCartQty').val();
            


            var product_attribute_color = $("input[name='product_attribute_color']:checked").val();
            var colorname = $("input[name='product_attribute_color']:checked").data("colorname");
            var product_attribute_size = $(this).siblings('.product_attribute_size').find("input[name='product_attribute_size']:checked").val();
            // var product_attribute_size = $("input[name='product_attribute_size']:checked").val();
            var sizename = $("input[name='product_attribute_size']:checked").data("sizename");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('add_to_cart')}}',
                data: {
                    product_id: product_id,
                    regular_price: regular_price,
                    sale_price: sale_price,
                    qty: qty,
                    product_attribute_size: product_attribute_size,
                    sizename: sizename,
                    product_attribute_color: product_attribute_color,
                    colorname: colorname
                },
                success: function (data) {
                    if (data.exists_cart == 1) {
                        toastr.error(data.message, data.title);
                    } else {
                       
                        $('.header_cart_html').html(data.header_cart_html);
                        $('.cart_count').html(data.cart_count);
                        $('.cart_sub_total').html(data.cart_sub_total);
                            console.log(data);
                        
                        $('[data-product_id="' + product_id + '"]').parent('.custom-heart-extra').html('<input type="button" data-row_id="' + data.row_id + '" data-product_id="' + product_id + '"  value="-" class="button-minus dec"><input type="text" id="pro_' + data.row_id + '" value="'+ data.qty_new +'" data-product_id="' + product_id + '" name="qty" class=" quantity-field qty-inc-dc pro_' + data.row_id + '"><input type="button" data-row_id="' + data.row_id +  '" value="+" class="button-plus inc" data-product_id="' + product_id + '">');
                        $('[data-product_id="' + product_id + '"]').parent('.custom-heart-extra_1').html(



                        `
                            
                            <input type="text" value="৳ ${data.sub_total_new}" name="pro_sub_t_"  data-row_id="${data.row_id}" data-product_id="${product_id}"  class="selected_prod pro_sub_t_${data.row_id}" readonly>
                            <br>

                            <input type="button" data-row_id="${data.row_id}" data-product_id="${product_id}"  value="-" class="button-minus dec">



                            <input type="text" value="${data.qty_new}" data-product_id="${product_id}"  name="qty" class=" quantity-field qty-inc-dc pro_${data.row_id}" readonly>



                            <input type="button" data-row_id="${data.row_id}" data-product_id="${product_id}"  value="+" class="button-plus inc">
                            



                        `);
                        $('#cart_toal_new').html(data.cart_sub_total);
                        $('#cart_shipping_new').html(data.cart_shipping_new);
                        $('#cart_toal_new_all').html(data.cart_toal_new_all);
                        $('#sub_total' + data.p_id).html(data.sub_total_new);
                        
                        toastr.success(data.message, data.title);
                    }
                }
            });
        });
// -----------updateCart------

        $('body').on('click', '.inc', function (event) {
       
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            var product_id = $(this).data("product_id");
            x = $('#' + row_id).val();
            var qty = ++x;
         
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('update_to_cart')}}',
                data: {row_id: row_id, qty: qty, product_id: product_id},
                success: function (data) {
                    $('.header_cart_html').html(data.header_cart_html);
                    $('.cart_count').html(data.cart_count);
                    $('.cart_sub_total').html(data.cart_sub_total);
                    $('.cart_table').html(data.cart_table);
                    $('.pro_' + row_id).val(data.qty_new);
                    $('#cart_toal_new').html(data.cart_sub_total);
                    $('#cart_shipping_new').html(data.cart_shipping_new);
                        $('#cart_toal_new_all').html(data.cart_toal_new_all);
                    $('#sub_total' + data.p_id).html(data.sub_total_new);


                    $('.pro_sub_t_' + row_id).val('৳ '+(data.qty_new * data.price));
                    if(qty == data.qty_new)
                    {
                        toastr.success(data.message, data.title);
                    }
                    else
                    {
                         toastr.error(data.message, data.title);
                    }
                    
                
                    
                }
            });
        });
        $('body').on('click', '.dec', function (event) {
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            var product_id = $(this).data("product_id");
  
            x = $('#' + row_id).val();

            if (x > 1) {

                var row_id = $(this).data("row_id");
                var qty = --x;
             
                $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: '{{ URL::route('update_to_cart')}}',
                    data: {row_id: row_id, qty: qty, product_id: product_id},
                    success: function (data) {

                        $('.header_cart_html').html(data.header_cart_html);
                        $('.cart_count').html(data.cart_count);
                        $('.cart_sub_total').html(data.cart_sub_total);
                        $('.cart_table').html(data.cart_table);
                        $('.pro_' + row_id).val(data.qty_new);
                        $('.pro_sub_t_' + row_id).val('৳ '+(data.qty_new * data.price));
                        $('#cart_toal_new').html(data.cart_sub_total);
                        $('#cart_shipping_new').html(data.cart_shipping_new);
                        $('#cart_toal_new_all').html(data.cart_toal_new_all);
                        $('#sub_total' + data.p_id).html(data.sub_total_new);
                        if(qty == data.qty_new)
                        {
                            toastr.success(data.message, data.title);
                        }
                        else
                        {
                             toastr.error(data.message, data.title);
                        }
                    }
                });
            }
        });
// -----------removeToCart-------------
        $('body').on('click', '.removeToCart', function (event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_cart')}}',
                data: {product_id: product_id},
                success: function (data) {
                    $('.cart_table').html(data.cart_table);
                    $('.header_cart_html').html(data.header_cart_html);
                    $('.cart_count').html(data.cart_count);
                    $('.cart_sub_total').html(data.cart_sub_total);
                    $('[data-product_id="' + product_id + '"]').parents('.removeCartTrLi').addClass('hidden');
                    ($(`[data-row_id='${product_id}']`).parent('.custom-heart-extra').html(`<a data-product_id="${data.lastProdid}" class="addToCart" href="javascript:void(0)"><i
                                         area-hidden="true">Add to Cart</a>`));
                    ($(`[data-row_id='${product_id}']`).parent('.custom-heart-extra_1').html(`<a data-product_id="${data.lastProdid}" class="addToCart" href="javascript:void(0)"><i
                                         area-hidden="true">Add to Cart</a>`));
                    $('.cart_count').text(data.cart_count);
                    toastr.error(data.message, data.title);
                    // $('.compare_data').text(data.compare_count);
                    // toastr.success(data.message, data.title);

                }
            });
        });
// ---------------ajax add to compare---------
        $('body').on('click', '.addToCompare', function (event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('add_to_compare')}}',
                data: {product_id: product_id},
                success: function (data) {
                    if (data.exists_compare == 1) {
                        toastr.error(data.error_message, data.error_title);
                    } else {
                        $('[data-product_id="' + product_id + '"]').parent('.quick-view').find('.addToCompare').addClass('red');
                        $('.compare_count').text(data.compare_count);
                        toastr.success(data.message, data.title);
                    }
                }
            });
        });
        $('body').on('click', '.removeToCompare', function (event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_compare')}}',
                data: {product_id: product_id},
                success: function (data) {
                    $('[data-product_id="' + product_id + '"]').parents('.compareRow').addClass('hidden');
                    $('.compare_count').text(data.compare_count);
                    toastr.error(data.message, data.title);


                }
            });
        });
// ---------------ajax add to Wishlist ---------
        $('body').on('click', '.addToWishlist', function (event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('add_to_wishlist')}}',
                data: {product_id: product_id},
                success: function (data) {
                    if (data.check_wishlist == 1) {
                        toastr.error(data.error_message, data.error_title);
                    } else {
                        $('[data-product_id="' + product_id + '"]').parent('.quick-view').find('.addToWishlist').addClass('red');
                        // $('.compare_data').text(data.compare_count);
                        $('.wishlist_count').html(data.wishlist_count);
                        toastr.success(data.message, data.title);
                    }

                }
            });
        });
        $('body').on('click', '.removeToWishlist', function (event) {
            var wshlist_id = $(this).data("wshlist_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_wishlist')}}',
                data: {wshlist_id: wshlist_id},
                success: function (data) {
                    $('[data-wshlist_id="' + wshlist_id + '"]').parents('.wishlistRow').addClass('hidden');
                    $('.wishlist_count').html(data.wishlist_count);
                    toastr.error(data.message, data.title);
                }
            });
        });
// ----------review-------------
// jQuery(document).ready(function () {
//     jQuery('.ajaxReviewSubmit').click(function (e) {
        $('body').on('click', '.ajaxReviewSubmit', function (e) {
            e.preventDefault();
            $.ajax({
                method: 'get',
                dataType: "json",
                url: "{{ url('add_to_review') }}",
                data: {
                    product_id: $('.product_id').val(),
                    rating: $('.ajaxReviewForm input:checked').val(),
                    description: $('.description').val(),
                },
                success: function (data) {
                    if (data.check_reviewAuth == 1) {
                        toastr.error(data.error_message, data.error_title);
                    } else {
                        toastr.success(data.message, data.title);
                        $(".ajaxReviewForm")[0].reset();
                    }
                    //                    toastr.success(data.message, data.title);

                }
            });
        });
// });

        $('body').on('click', '.removeToReview', function (event) {
            var review_id = $(this).data("review_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_review')}}',
                data: {review_id: review_id},
                success: function (data) {
                    $('[data-review_id="' + review_id + '"]').parents('.reviewRow').addClass('hidden');
                    toastr.error(data.message, data.title);
                }
            });
        });
// ---------------------------

    });
</script>
<script type="text/javascript">

    $(document).ready(function () {
        
        jQuery('.calendar7').Calendar7({
            allowTimeStart: '1:00',
            allowTimeEnd: '60:00'
        });
        
        
        product_search_url = '{{ URL::route('product_search_data')}}';
        filter_data(product_search_url);
        $('body').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            filter_data(url)
//            getArticles(url);
//            window.history.pushState("", "", url);
        });

        function filter_data(product_search_url) {
            // $("#loading").show(),setTimeout(function(){$("#loading").hide()
            var url      = window.location.href;
            
            
            var parts = url.split('/');
            if($.inArray( 'category_list', parts ) > 0)
            {
                var lastSegment = parts.pop() || parts.pop();
                var category = lastSegment;
            }
            else
            {
                var category = get_filter('category');
            }
            
       
            
            // alert(lastSegment);
            $('#ajax_view_product_list').html('<div id="loading"></div>');
            var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
            var brand = get_filter('brand');
            var category = category;
            var size = get_filter('size');
            var color = get_filter('color');
            var onChangeProductFilter = $('.onChangeProductFilter').val();
            // var limitProduct = $('.limitProduct').val();
            $.ajax({
//            url: '{{ URL::route('product_search_data')}}',
                url: product_search_url,
                method: "get",
                data: {
                    action: action,
                    minimum_price: minimum_price,
                    maximum_price: maximum_price,
                    brand: brand,
                    category: category,
                    size: size,
                    color: color,
                    onChangeProductFilter: onChangeProductFilter,
                    // limitProduct: limitProduct,
                },
                success: function (data) {
                    $('#ajax_view_product_list').html(data);
//            alert(data);
//                     $('.sp-wrap').smoothproducts();
                    // $('#defaultProductView').css('display', 'none');
                }
            });
        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function () {
                filter.push($(this).val());
            });
            return filter;
        }
        
       
        $('.common_selector').click(function () {
            product_search_url = '{{ URL::route('product_search_data')}}';
            filter_data(product_search_url);
        });
        $('.onChangeProductFilter').on('change', function () {
            var onChangeProductFilter = $('.onChangeProductFilter').val();
            var limitProduct = $('.limitProduct').val();
            product_search_url = '{{ URL::route('product_search_data')}}';
            filter_data(product_search_url);
        });
        $('.slider-range-price').slider({
            range: true,
            min: <?php echo(isset($min_price) ? $min_price : 0); ?>,
            max: <?php echo(isset($max_price) ? $max_price : 10); ?>,
            values: [<?php echo(isset($min_price) ? $min_price : 0); ?>,<?php echo(isset($max_price) ? $max_price : 10); ?>],
            step: 100,
            stop: function (event, ui) {
                $('.amount-range-price').html(ui.values[0] + ' - ' + ui.values[1]);
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                product_search_url = '{{ URL::route('product_search_data')}}';
                filter_data(product_search_url);
            }
        });
    });

    function search_on_nptl_search() {
        var search_text = $("#search_text").val();
        var _token = $('#table_csrf_token').val();
        // if (search_text.length > 0) {
        $.ajax({
            url: '<?php echo url('main_search') ?>',
            type: 'post',
            data: {search_text: search_text, _token: _token},
            success: function (response) {
                $('.search-html').html(response);
                // $("#searchbtn").html('<i class="fa fa-search"></i>');
            },
            error: function (errors) {
                var errorRes = errors.responseJSON.errors;
                // console.log(errorRes);
                $(".search-html").html('Write Something');
            }
        });
        // } else {
        //     $(".search-html").html('Write Something');
        // }
    }

    if ($("#main_search").length > 0) {
        $("#search_text").on("keyup", function () {
            search_on_nptl_search();
        });
        $("#search_text").on("change", function () {
            search_on_nptl_search();
        });
    }
    $('body').on('click', '.common_selector', function () {
        $(this).parents('.sub-cat').siblings('input').prop("checked", false);
    })
    
    //  $('body').on('click', '.shipping_data', function () {
    //     var id =  $('.shipping_data').val();
    //     alert(id);
    //     var total_price = $('#total_price').val();
    //     var total_price = $('#total_price').val();
    // })
    
    $('body').on('click', '.shipping_data', function () {
        
        // $('#sub_total_js').val(parseInt(0));
        // $('#discount_js').val(parseInt(0));
        // var sh_cost = 0;
        // var grand_total_js = 0;
        // var new_total = 0;
        sh_cost = $('input[name="shipping_method"]:checked').attr('shipping_price');
        grand_total_js = $('#grand_total_js').val();
        new_total = parseInt(grand_total_js) + parseInt(sh_cost);
        $('#right_bar_shipping_cost').html("৳ "+sh_cost);
        $('#total_price').html("৳ "+new_total+".00");
        
        // $('#sub_total_js').val(parseInt(grand_total_js));
        $('#shipping_js').val(sh_cost);
        $('#grand_grand_total_js').val(new_total);
    })
    

    $('.customDropDown').on('change', function () {
        $(this).parents("form").submit();
    })
</script>

<script>
    
    ;(function($){
    'use strict'

    function Calendar (options) {
            var that = this;

            this.trigger = options.trigger
            this.calendarSelector = '#calendar-7'
            this.times = {}

            if (options.allowTimeStart && options.allowTimeEnd) {
                this.times.allowHourStart = parseInt(options.allowTimeStart.split(':')[0], 10)
                this.times.allowHourEnd = parseInt(options.allowTimeEnd.split(':')[0], 10)

                this.times.allowMinuteStart = parseInt(options.allowTimeStart.split(':')[1], 10)
                this.times.allowMinuteEnd = parseInt(options.allowTimeEnd.split(':')[1], 10)
            }

            this.trigger.on('click', function (event) {
                event.stopPropagation()
                if ($(that.calendarSelector).length === 0) {
                    that.init()
                }
            });
            $(document).click(function (event) {
                if ($(event.target).parents('#calendar-7').length === 0) {
                    $(that.calendarSelector).remove()
                }
            });
        }
        Calendar.prototype.init = function () {
            // 未来七天
            var weeksOfzhTW = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
            var today = new Date();
            this.year = today.getFullYear();
            this.month = Number(today.getMonth()) + 1;
            this.day = today.getDate();

            var html = '<div id="calendar-7" class="calendar-7">\
                            <div class="days">';

            for (var i = 0; i < 7; i++) {
                var classNames = i ===0 ? 'calendar-7-day active' : 'calendar-7-day';
                var month = today.getMonth()+1

                html += '<div class="'+classNames+'" data-year="'+today.getFullYear()+'" data-month="'+month+'" data-day="'+today.getDate()+'">\
                            <span>'+today.getDate()+'/'+month+'</span>\
                            <br/>\
                            <span>'+weeksOfzhTW[today.getDay()]+'</span>\
                        </div>';

                today.setDate(today.getDate() + 1);
            }
            
            html +=         '</div>\
                            <div class="hours"></div>\
                            <div class="minutes"></div>\
                        </div>';

            // 渲染日历
            $('body').append(html)
            var positionObj = this.trigger.get(0).getBoundingClientRect()

            // 给日历定位
            if ($(window).width() - positionObj.right < 10 ) {
                $('#calendar-7').css({
                    top: positionObj.top + this.trigger.outerHeight() + 5,
                    right: 0
                });
            } else {
                $('#calendar-7').css({
                    top: positionObj.top + this.trigger.outerHeight() + 5,
                    left: positionObj.left
                });
            }

            this.renderHours();
            this.dateClickHandler();
        }
        Calendar.prototype.getHours = function () {
            var today = new Date();
            var currentHour = today.getHours();
            currentHour = currentHour+2;
            // console.log(currentHour);
            var currentDay = today.getDate();

            var hours24 = [];
            for (var i = 9; i < 22; i++) {
                var hr_1 = i+1;
                if(i < 12)
                {
                    var x = " AM";
                    var a = i;
                }
                else
                {
                    var x = " PM";
                    var a = i-12;
                }
                if(hr_1 <12 )
                {
                    var y = " AM";
                    var b = hr_1;
                }
                else
                {
                    var y = " PM";
                    var b = hr_1-12;
                }
                
                if(i==12)
                {
                    a = 12;
                }
                
                if(hr_1 == 12)
                {
                    b = 12;
                }
                
                if (i > this.times.allowHourEnd || i < this.times.allowHourStart || (i < currentHour && this.day === currentDay)) {
                    
                    hours24.push({
                        disabled: true,
                        hour: a + ':' + '00' + x + ' - ' + b + ':' + '00' + y
                    })
                } else {
                    hours24.push({
                        disabled: false,
                        hour: a + ':' + '00' + x + ' - ' + b + ':' + '00' + y
                    })
                }
            }
            return hours24
        }
        Calendar.prototype.renderHours = function () {
            var hours = this.getHours();
            var html = ''
            for (var i = 0; i < hours.length; i++) {
                if (hours[i].disabled) {
                    html += '<span class="calendar-7-hour disabled" data-hour="' + hours[i].hour + '">' + hours[i].hour + '</span>'
                } else {
                    html += '<span class="calendar-7-hour" data-hour="' + hours[i].hour + '">' + hours[i].hour + '</span>'
                }
            }
            $(this.calendarSelector).find('.hours').html(html).show().siblings('.minutes').hide()
        }
        Calendar.prototype.dateClickHandler = function () {
            var that = this

            // 綁定日期的點擊
            $('.calendar-7-day').click(function (event) {
                $('.calendar-7-day').removeClass('active')
                $(this).addClass('active')
                that.year = $(this).data('year')
                that.month = $(this).data('month')
                that.day = $(this).data('day')
                that.renderHours()
            });
            // 绑定小时的点击
            $(document).on('click', '.calendar-7-hour', function () {
                $('.calendar-7-hour').removeClass('active')
                $(this).addClass('active')
                that.hour = parseInt($(this).data('hour').split(':')[0], 10)
                if (!$(this).hasClass('disabled')) {
                    var time = that.year + '-' + that.month + '-' + that.day + ' ' + that.hour + ':00'

                    if (!$(this).hasClass('disabled')) {
                        that.trigger.val(time);
                        $(that.calendarSelector).remove();
                    }
                    
                    that.destroy();

                }
            });
            
        }
        Calendar.prototype.drawMinutes = function () {
            var html = ''
            var today = new Date()
            var currentDay = today.getDate()
            var currentHour = today.getHours()
            var currentMinute = today.getMinutes()

            for (var i = 0, text = ''; i < 60;) {
                text = i < 10 ? '0' + i : i
                if ((currentHour === this.hour && currentMinute > i && currentDay === this.day) || (this.hour === this.times.allowHourEnd && this.times.allowMinuteEnd < i) || (this.hour === this.times.allowHourStart && this.times.allowMinuteStart > i)) {
                    html += '<span class="calendar-7-minute disabled" data-minute="' + text + '">' + this.hour + ':' + text + '</span>'
                } else {
                    html += '<span class="calendar-7-minute" data-minute="' + text + '">' + this.hour + ':' + text + '</span>'
                }
                i += 5;
            }

            $('#calendar-7 .hours').hide();

            $('#calendar-7 .minutes').html(html).show();

            this.minuteClickHandler();
        }
        Calendar.prototype.minuteClickHandler = function () {
            var that = this

            $('.calendar-7-minute').bind('click', function () {
                that.minute = $(this).data('minute');

                var time = that.year + '-' + that.month + '-' + that.day + ' ' + that.hour + ':' + that.minute

                if (!$(this).hasClass('disabled')) {
                    that.trigger.val(time);
                    $(that.calendarSelector).remove();
                }
                
                that.destroy();

            });
        }

        Calendar.prototype.destroy = function () {
            $('.calendar-7-minute').unbind()
        }

        $.fn.Calendar7 = function (options) {
            this.each(function (index, el) {
                var settings = {
                    trigger: $(this),
                    allowTimeStart: '',
                    allowTimeEnd: ''
                };
                new Calendar($.extend(true, settings, options));
            });
        }
})(jQuery)




</script>
