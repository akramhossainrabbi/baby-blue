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
                        //                        $('[data-product_id="' + product_id + '"]').parent('.add-to-cart').html('<button data-product_id="' + product_id + '" class="addToCart" title="Product is added">Product is added</button>');
                        toastr.success(data.message, data.title);
                    }
                }
            });
        });
// -----------updateCart------
        {{--$('body').on('click', '.updateToCart', function (event) {--}}
        {{--var row_id = $(this).data("row_id");--}}
        {{--var qty = $(this).data("qty");--}}
        {{--$.ajax({--}}
        {{--type: 'get',--}}
        {{--dataType: "json",--}}
        {{--url: '{{ URL::route('update_to_cart')}}',--}}
        {{--data: {row_id: row_id, qty: qty},--}}
        {{--success: function (data) {--}}
        {{--$('.header_cart_html').html(data.header_cart_html);--}}
        {{--$('.cart_count').html(data.cart_count);--}}
        {{--$('.cart_sub_total').html(data.cart_sub_total);--}}
        {{--toastr.success(data.message, data.title);--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}
        {{--$('body').on('click', '.incDetail', function (event) {--}}
        {{--event.preventDefault();--}}
        {{--var x;--}}
        {{--var row_id = $(this).data("row_id");--}}
        {{--x = $('#' + row_id).val();--}}
        {{--//            $(this).siblings('input').attr('value', ++x); --}}

        {{--var qty = x;--}}
        {{--$.ajax({--}}
        {{--type: 'get',--}}
        {{--dataType: "json",--}}
        {{--url: '{{ URL::route('update_to_cart')}}',--}}
        {{--data: {row_id: row_id, qty: qty},--}}
        {{--success: function (data) {--}}
        {{--$('.cart_count').html(data.cart_count);--}}
        {{--$('.cart_sub_total').html(data.cart_sub_total);--}}
        {{--$('.cart_table').html(data.cart_table);--}}
        {{--toastr.success(data.message, data.title);--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}
        {{--$('body').on('click', '.decDetail', function (event) {--}}
        {{--event.preventDefault();--}}
        {{--var x;--}}
        {{--var row_id = $(this).data("row_id");--}}
        {{--x = $('#' + row_id).val();--}}
        {{--if (x > 1) {--}}

        {{--var row_id = $(this).data("row_id");--}}
        {{--var qty = x;--}}
        {{--$.ajax({--}}
        {{--type: 'get',--}}
        {{--dataType: "json",--}}
        {{--url: '{{ URL::route('update_to_cart')}}',--}}
        {{--data: {row_id: row_id, qty: qty},--}}
        {{--success: function (data) {--}}
        {{--$('.cart_count').html(data.cart_count);--}}
        {{--$('.cart_sub_total').html(data.cart_sub_total);--}}
        {{--$('.cart_table').html(data.cart_table);--}}
        {{--toastr.success(data.message, data.title);--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
        {{--});--}}
        $('body').on('change', '.weight_change', function (event) {
            event.preventDefault();
            // var x;
            var row_id = $(this).data("row_id");
            // x = $('#' + row_id).val();
            // var qty = ++x;
            var qty = $(this).val();
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('update_to_cart')}}',
                data: {row_id: row_id, qty: qty},
                success: function (data) {
                    $('.header_cart_html').html(data.header_cart_html);
                    $('.cart_count').html(data.cart_count);
                    $('.cart_sub_total').html(data.cart_sub_total);
                    $('.cart_table').html(data.cart_table);
                    toastr.success(data.message, data.title);
                }
            });
        });

        $('body').on('click', '.inc', function (event) {
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            x = $('#' + row_id).val();
//            $(this).siblings('input').attr('value', ++x);
            var qty = ++x;
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('update_to_cart')}}',
                data: {row_id: row_id, qty: qty},
                success: function (data) {
                    $('.header_cart_html').html(data.header_cart_html);
                    $('.cart_count').html(data.cart_count);
                    $('.cart_sub_total').html(data.cart_sub_total);
                    $('.cart_table').html(data.cart_table);
                    toastr.success(data.message, data.title);
                }
            });
        });
        $('body').on('click', '.dec', function (event) {
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            x = $('#' + row_id).val();
            if (x > 1) {

                var row_id = $(this).data("row_id");
                var qty = --x;
                $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: '{{ URL::route('update_to_cart')}}',
                    data: {row_id: row_id, qty: qty},
                    success: function (data) {
                        $('.header_cart_html').html(data.header_cart_html);
                        $('.cart_count').html(data.cart_count);
                        $('.cart_sub_total').html(data.cart_sub_total);
                        $('.cart_table').html(data.cart_table);
                        toastr.success(data.message, data.title);
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

    });</script>
<script type="text/javascript">

    $(document).ready(function () {
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

            $('#ajax_view_product_list').html('<div id="loading"></div>');
            var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
            var brand = get_filter('brand');
            var category = get_filter('category');
            var size = get_filter('size');
            var color = get_filter('color');
            var onChangeProductFilter = $('.onChangeProductFilter').val();
            var limitProduct = $('.limitProduct').val();
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
                    limitProduct: limitProduct,
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


    $('.customDropDown').on('change', function () {
        $(this).parents("form").submit();
    })
</script>
