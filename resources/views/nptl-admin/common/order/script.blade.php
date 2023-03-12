<script type="text/javascript">
    $('body').delegate('button.applyCoupon', 'click', function () {
        var gross_amount_val = $('input.gross_amount_val').val();
        $.ajax({
            type: 'GET',
            url: '{!!URL::route('adminApplyCoupon')!!}',
            dataType: 'json',
            data: {gross_amount_val: gross_amount_val},
            success: function (optiodata) {
                $('input.shipping_method_charge').val(optiodata);
                calculation();
            }
        });
    });
    $('body').delegate('select.product_id', 'change', function () {
        var tr = $(this).closest('tr');
        var product_id = tr.find('select.product_id').val();
        $.ajax({
            type: 'GET',
            url: '{!!URL::route('findProductBySize')!!}',
            dataType: 'json',
            data: {product_id: product_id},
            success: function (optiodata) {
                tr.find('.attribute_id').html(optiodata);
                calculation();
            }
        });
    });
    $('body').delegate('select.product_id, select.attribute_id', 'change', function () {
        var tr = $(this).closest('tr');
        var product_id = tr.find('select.product_id').val();
        var attribute_id = tr.find('select.attribute_id').val();
        $.ajax({
            type: 'GET',
            url: '{!!URL::route('findProductSizeByColorPrice')!!}',
            dataType: 'json',
            data: {product_id: product_id, attribute_id: attribute_id},
            success: function (data) {
                tr.find('.color_id').html(data.color_data);
                tr.find('input.product_price').val(data.product_price);
                tr.find('input.in_stock_qty').val(data.in_stock_qty);
                tr.find('input.product_qty').val(1);
                tr.find('input.weghited').val(data.produt_weight);
                tr.find('input.weghited_status').val(data.weighted);
                
                if(data.weighted == 1)
                {
                    tr.find('input.weghited').attr('readonly', false);
                    tr.find('input.product_qty').attr('readonly', true);
                }
                else
                {
                    tr.find('input.weghited').attr('readonly', true);
                    tr.find('input.product_qty').attr('readonly', false);
                    
                }
                

                var product_qty = tr.find('input.product_qty').val();
                var in_stock_qty = tr.find('input.in_stock_qty').val();
                var product_price = tr.find('input.product_price').val();
                var sub_total = product_qty * product_price;
                tr.find('input.sub_total').val(sub_total);
                // if (product_qty > in_stock_qty) {
                //     $("#updateOrderBtn").attr("disabled", "disabled");
                //     alert('Total Qty is higher Than In Stock Qty');
                // } else {
                //     $("#updateOrderBtn").removeAttr("disabled");
                // }
                calculation();
            }
        });
    });
    $('tbody').delegate('input.product_qty , input.weghited', 'keyup', function () {
 
        var tr = $(this).closest('tr');
        var product_qty = tr.find('input.product_qty').val();
        var weghited = tr.find('input.weghited').val();
        var weghited_status = tr.find('input.weghited_status').val();
        var in_stock_qty = tr.find('input.in_stock_qty').val();
        var product_price = tr.find('input.product_price').val();
        if(weghited_status == 1)
        {
            var sub_total = weghited * product_price;
        }
        else
        {
            var sub_total = product_qty * product_price;
        }
        tr.find('input.sub_total').val(sub_total);
        // if (in_stock_qty < product_qty) {
        //     $("#updateOrderBtn").attr("disabled", "disabled");
        //     alert('Total Qty is higher Than In Stock Qty');
        // } else {
        //      $("#updateOrderBtn").removeAttr("disabled");
        // }
        calculation();
    });

    $('select#discount_type, input#discount_amount, input#shipping_method_charge').on('keyup change', function (e) {
        calculation();
    });

    function __calculate_amount(calculation_type, calculation_amount, amount) {
        var calculation_amount = parseFloat(calculation_amount);
        calculation_amount = isNaN(calculation_amount) ? 0 : calculation_amount;

        var amount = parseFloat(amount);
        amount = isNaN(amount) ? 0 : amount;

        switch (calculation_type) {
            case 'fixed':
                return parseFloat(calculation_amount);
            case 'percentage':
                return parseFloat((calculation_amount / 100) * amount);
            default:
                return 0;
        }
    }

    function calculation() {
        var calculation_type = $('select#discount_type').val();
        var calculation_amount = $('input#discount_amount').val();

        var total_qty = 0;
        var total = 0;
        $('.sub_total').each(function (i, e) {
            var sub_total = $(this).val() - 0;
            total += sub_total;
        });
        $('.product_qty').each(function (i, e) {
            var product_qty = $(this).val() - 0;
            total_qty += product_qty;
        });
        var discount = __calculate_amount(calculation_type, calculation_amount, total);
        // if (total_amount - discount > 1000) {
        //     $('input#shipping_method_charge').val(0);
        // } else {
        //     $('input#shipping_method_charge').val(70);
        // }
        $('input#total_discount').val(discount.toFixed(0));

        $('.form-group').find('.total_qty').val(total_qty);
        $('input.gross_amount').val(total);
        $('input.gross_amount_val').val(total);
        // $('#gross_amount').val(total.formatMoney(2, ',', '.'));
        $('.total_qty_value').val(total_qty);
        // $('#gross_amount_value').val(total.formatMoney(2, ',', '.'));

        $('.gross_amount_value').val(total);
        // $('#gross_amount_value').val(total.formatMoney(2, ',', '.'));

        $('.grand_total').val(total);

        var transport = $('.transport').val();
        if (!$('.transport').val()) {
            transport = 0;
        }
        var shipping_method_charge = $('.shipping_method_charge').val();
        if (!$('.shipping_method_charge').val()) {
            shipping_method_charge = 0;
        }
        var total_cost1 = parseInt(shipping_method_charge) + total;
        var grandTotal = total_cost1 - parseInt(discount);
        $('.grand_total').val(grandTotal);
        // $('#grand_total').val(grandTotal.formatMoney(2, ',', '.'));
        $(".grand_total_value").val(grandTotal);
        // $("#grand_total_value").val(grandTotal.formatMoney(2, ',', '.'));
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
            '{{ Form::select('product_id[]', $product_lists, null, array('class'=>'select2 product_id', 'required'=>'true', 'placeholder'=>'Please select ...')) }}' +
            '</td>' +
            '<td style="display:none;">' +
            '<select class="attribute_id select2 attribute_id" name="attribute_id[]">' +
            '<option value="" selected="true">Plese Select</option>' +
            '</select>' +
            '</td>' +
            '<td style="display:none;">' +
            '<select class="color_id select2 color_id" name="color_id[]">' +
            '<option value="" selected="true">Plese Select</option>' +
            '</select>' +
            '</td>' +
            '<td>' +
            '<input type="text" name="product_qty[]" value="1" class="form-control product_qty">' +
            '<input type="hidden" name="in_stock_qty[]" class="in_stock_qty">' +
            '</td>' +
            '<td style=""><input autocomplete="off" type="text"  name="weghited[]" value="" class="form-control weghited"> <input type="hidden" value=""name="weghited_status[]" class="weghited_status"></td>' +
            '<td style=""><input autocomplete="off" type="text" readonly name="product_price[]" value="" class="form-control product_price"></td>' +
            '<td style=""><input type="text" name="sub_total[]" value="" class="form-control sub_total" readonly="true"></td>' +
            '<td><button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></button></td>' +
            '</tr>';
        $('#customersDataShow').append(tr);
    };
    //==============End Create Function By User============
    $('body').on('click', '.remove', function () {
        var l = $('#customersDataShow tr').length;
        if (l == 1) {
            alert('You can not Remove last one');
        } else {
            $(this).parent().parent().remove();
            calculation();
        }
    });


    //==============Start Format Number============
    Number.prototype.formatMoney = function (decPlaces, thouSeparator, decSeparator) {
        var n = this,
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
            decSeparator = decSeparator == undefined ? "." : decSeparator,
            sign = n < 0 ? "_" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return sign + (j ? i.substr(0, j) + thouSeparator : "")
            + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
            + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");

    };
</script>