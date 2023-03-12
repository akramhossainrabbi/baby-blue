{!!Html::script('additional/toastr/toastr.min.js')!!}
<script type="text/javascript">
    // productNameSale
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

        $('body').delegate('#product_id', 'change', function () {
            var tr = $(this).parent().parent();
            var product_id = tr.find('#product_id').val();
            var sub_total = 0;
            $('select').select2();
            $.ajax({
                type: 'GET',
                url: '{!!URL::route('find_product_by_details')!!}',
                dataType: 'json',
                data: {product_id: product_id},
                success: function (data) {
                    if (data.exists_cart == 1) {
                        toastr.error(data.message, data.title);
                    } else {
                        $('.cart_table').html(data.cart_table);
                        $('.cart_count').html(data.cart_count);
                        toastr.success(data.message, data.title);
                    }
                }

            });

        });
        $('tbody').delegate('.product_qty, .product_price', 'keyup', function () {
            var tr = $(this).parent().parent();
            var product_size = tr.find('.product_size').val();
            var product_qty = tr.find('.product_qty').val();
            var product_price = tr.find('.product_price').val();
            $.ajax({
                type: 'GET',
                url: '{!!URL::route('find_product_by_details')!!}',
                dataType: 'json',
                data: {product_id: product_id},
                success: function (data) {
                    if (data.exists_cart == 1) {
                        toastr.error(data.message, data.title);
                    } else {
                        $('.cart_table').html(data.cart_table);
                        $('.cart_count').html(data.cart_count);
                        toastr.success(data.message, data.title);
                    }
                }
            });
            //  if (qty > in_stock) {
            //     $("#saleSaveBtn").attr("disabled", "disabled");
            //     alert('Total Qty is higher Than In Stock Qty');
            // } else {
            //     $("#saleSaveBtn").removeAttr("disabled");
            // }
            // var total_unit = (product_qty * product_size);
            // var sub_amount = (product_qty * product_price);
            // tr.find('.total_unit').val(total_unit);
            // tr.find('.sub_amount').val(sub_amount);
            // calculation();
        });
        $('body').on('click', '.removeToCart', function (event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('admin_remove_to_cart')}}',
                data: {product_id: product_id},
                success: function (data) {
                    $('.cart_table').html(data.cart_table);
                    $('.cart_count').html(data.cart_count);
                    toastr.success(data.message, data.title);

                }
            });
        });
    });

    function calculation() {
        var total_qty = 0;
        var total_unit_qty = 0;
        var total_commission = 0;
        var total = 0;
        $('.sub_amount').each(function (i, e) {
            var sub_amount = $(this).val() - 0;
            total += sub_amount;
        });
        $('.product_qty').each(function (i, e) {
            var product_qty = $(this).val() - 0;
            total_qty += product_qty;
        });
        $('.total_unit').each(function (i, e) {
            var total_unit = $(this).val() - 0;
            total_unit_qty += total_unit;
        });
        if (total_unit_qty > 9999) {
            var shipping_cost = 120;
        }
        // elseif (total_unit_qty < 1) {
        //     var shipping_cost = 0;
        // }
        else {
            var shipping_cost = 100;
        }

        $('.commission').each(function (i, e) {
            var commission = $(this).val() - 0;
            total_commission += commission;
        });
        $('.form-group').find('.total_qty').val(total_qty);
        $('.form-group').find('.sub_total').val(total);
        $('.form-group').find('.shipping_method_charge').val(shipping_cost);
        $('.form-group').find('.grand_total').val(total);


        var discount = $('.discount').val();
        if (!$('.discount').val()) {
            discount = 0;
        }
        var transport = $('.transport').val();
        if (!$('.transport').val()) {
            transport = 0;
        }
        var total_commission = $('.total_commission').val();
        if (!$('.total_commission').val()) {
            total_commission = 0;
        }
        var grandTotal = total - parseInt(discount);
        var grandTotal1 = grandTotal - parseInt(total_commission);
        // $('.form-group').find('.grand_total').val(grandTotal1);
        $('.form-group').find('.grand_total').val(total);
    }

    //==============Add Row============
    $('.addRow').on('click', function () {
        addRow();
        $('select').select2();
    });

    //==============End Format Number============
    function addRow() {
        var tr = '<tr>' +
            '<td>' +
            '<input type="hidden" value="0" name="detail_id[]">' +
            '{!! Form::select('product_id[]', $product_lists, null,['required', 'id'=>'product_id', 'class'=>'select2 product_id', 'placeholder' => 'Plese Select...' ]) !!}' +
            '</td>' +
            '<td><div class="input-group"><input type="text" class="form-control product_size" readonly name="product_size[]" placeholder="Unit">' +
            '<span class="input-group-btn"><input type="hidden" name="product_color[]" class="form-control product_color">' +
            '<button class="btn btn-default product_color " type="button">Unit</button></span></div>' +
            '</td>' +
            '<td><input type="text" class="form-control total_unit" readonly name="total_unit[]" placeholder="Total Unit"></td>' +
            '<td><input type="text" placeholder="Qty" name="product_qty[]" class="form-control product_qty"></td>' +
            '<td><input placeholder="Price" type="text" name="product_price[]" class="form-control product_price"></td>' +
            '<td><input placeholder="Amount" type="text" required="true" name="sub_amount[]" class="form-control sub_amount" readonly="true"></td>' +
            '<td><button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></button></td>' +
            '</tr>';
        $('#cart_table').append(tr);

    };
    //==============End Create Function By User============
    $('body').on('click', '.remove', function () {
        var l = $('#cart_table tr').length;
        if (l == 1) {
            alert('You can not Remove last one');
        } else {
            $(this).parent().parent().remove();
            calculation();
        }
    });

</script>