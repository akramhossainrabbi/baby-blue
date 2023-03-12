<?php
$orderUser = $order->orderaddress;
$flname = $orderUser->firstname . " " . $orderUser->lastname;
$name = trim($flname != '') ? $flname : $orderUser->username;
$mobile = $orderUser->mobile;
$address = "";
$address .= !empty($orderUser->address) ? $orderUser->address . ", " : "";
if (strlen($address) > 30) {
    $address .= '<br>';
}
$address .= !empty($orderUser->city) ? $orderUser->city . ", " : "";
$address .= !empty($orderUser->state) ? $orderUser->state . " - " : "";
$address .= !empty($orderUser->zip) ? $orderUser->zip . ", " : "";
$address .= $orderUser->country;
?>
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-user"></i> </span>
            <h2>Supplier info</h2>
        </header>
        <!-- widget div-->
        <div>
            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->
                <input class="form-control" type="text">
            </div>
            <!-- end widget edit box -->
            <!-- widget content -->
            <div class="widget-body padding-10">
                <!-- info row -->
                <div class="row" style="width: 100%;">
                    <div class="col-md-6" style="width: 50%; float: left;">
                        <table border="0" cellpadding="0" cellspacing="0" style="">
                            <tbody>
                            <tr>
                                <td style="height:23px; width:150px;">Invoice To :</td>
                                <td style="width:300px;">
                                    : {{ $name }}</td>
                            </tr>
                            <tr>
                                <td>Address.</td>
                                <td>: {!!  $address !!}</td>
                            </tr>
                            <tr>
                                <td>Phone.</td>
                                <td>: {{ $mobile }}</td>
                            </tr>
                            <tr>
                                <td>Email.</td>
                                <td>: {{ $order->contact_email }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-md-6" style="width: 50%; float: left;">
                        <table border="0" cellpadding="0" cellspacing="0" style="">
                            <tbody>
                            <tr>
                                <td style="height:23px; width:150px;">MRR</td>
                                <td style="width:300px;">: {{ $order->mrr }}</td>
                            </tr>
                            <tr>
                                <td>Purchase No.</td>
                                <td>: {{ $order->id }}</td>
                            </tr>

                            <tr>
                                <td>Date:</td>
                                <td>: {{ SM::showDateTime($order->create_date) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- end widget content -->
        </div>
        <!-- end widget div -->
    </div>
    <!-- end widget -->
</article>
<!-- WIDGET END -->

<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-shopping-cart"></i> </span>
            <h2>Product List</h2>
        </header>
        <!-- widget div-->
        <div>
            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->
                <input class="form-control" type="text">
            </div>
            <!-- end widget edit box -->
            <!-- widget content -->
            <div class="widget-body padding-10">
                <div class="row">
                    <div class="text-page-blog">
                        <table class="table table-bordered table-responsive cart_summary cart_table">
                            <thead>
                            <tr>
                                <th style="width:22%">Product</th>
                                <th style="width:15%; display: none;">Size</th>
                                <th style="width:10%; display: none;">Color</th>
                                <th style="width:6%">Qty</th>
                                <th style="width:7%">Weight</th>
                                <th style="width:10%; ">Price</th>
                                <th style="width:15%; ">Amount</th>
                                <th style="width:8%">
                                    <button type="button" class="btn btn-success addRow"><i
                                                class="glyphicon glyphicon-plus"></i></button>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="customersDataShow">
                            @forelse($order->detail as $id => $orderItem)
                                <input type="hidden" value="{{ $orderItem->id }}" name="detail_id[]">
                                <tr id="tr_{{$orderItem->id}}" class="removeCartTrLi">
                                    <td class="cart_product">
                                        {{ Form::select('product_id[]', $product_lists, $orderItem->product_id, array('class'=>' select2 product_id','required'=>'true', 'placeholder'=>'Please select ...')) }}
                                    </td>
                                    <td style="display: none;">
                                        <select name="attribute_id[]" class="select2 attribute_id">
                                            @isset($orderItem->attribute->title)
                                                <option value="{{ $orderItem->attribute_id }}">{{ $orderItem->attribute->title }}</option>
                                            @else
                                                <option value="">Select</option>
                                            @endisset
                                        </select>
                                    </td>
                                    <td style="display: none;">
                                        <select name="color_id[]" class="select2 color_id">
                                            @isset($orderItem->colorName->title)
                                                <option value="{{ $orderItem->color_id }}">{{ $orderItem->colorName->title }}</option>
                                            @else
                                                <option value="">Select</option>
                                            @endisset
                                        </select>
                                    </td>
                                    <td class="qty">
                                        
                                        @if($orderItem->product->weighted == 1)
                                        <input readonly autocomplete="off" type="text" name="product_qty[]"
                                               class="form-control input-sm product_qty"
                                               placeholder="Qty" value="{{ $orderItem->product_qty }}">
                                        @else
                                        <input autocomplete="off" type="text" name="product_qty[]"
                                               class="form-control input-sm product_qty"
                                               placeholder="Qty" value="{{ $orderItem->product_qty }}">
                                        @endif
                                        
                                        
                                        <input type="hidden" value="{{ $orderItem->product->product_qty }}"
                                               name="in_stock_qty[]"
                                               class="in_stock_qty">
                                    </td>
                                    <td>
                                        
                                        @if($orderItem->product->weighted == 0)
                                        <input readonly autocomplete="off" type="text" placeholder="Weight" name="weghited[]"
                                       class="form-control weghited" value="{{ $orderItem->weghited }}">
                                       @else
                                       <input autocomplete="off" type="text" placeholder="Weight" name="weghited[]"
                                       class="form-control weghited" value="{{ $orderItem->weghited }}">
                                       @endif
                                       
                                       <input type="hidden" value="{{$orderItem->product->weighted}}"name="weghited_status[]" class="weghited_status">
                                       
                                    </td>
                                    <td class="price" style="">
                                        <input autocomplete="off" readonly type="text"
                                               value="{{ $orderItem->product_price }}"
                                               name="product_price[]"
                                               class="form-control product_price">
                                    {{--                                        <span>{{ SM::currency_price_value($orderItem->product_price) }} </span></td>--}}

                                    <td class="price" style="">
                                        <input type="text" value="{{ $orderItem->sub_total }}" name="sub_total[]"
                                               class="form-control sub_total"
                                               readonly="true">
                                        {{--                                        <span>{{ SM::currency_price_value($orderItem->sub_total) }} </span>--}}
                                    </td>
                                    <td class="action">
                                        <button type="button" class="btn btn-danger remove"><i
                                                    class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <p class="product-name" style="color: red">No data found!</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">
                                    <button type="button" class="btn btn-success addRow"><i
                                                class="glyphicon glyphicon-plus"></i></button>
                                </td>

                            </tr>

                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-6 col-xs-12 pull pull-left">
                        <div class="form-group">
                            <label>Note</label><br>
                            {!! Form::textarea('order_note', null,['rows' => '5', 'cols' => '56']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 pull pull-right ">
                        <div class="form-group hidden">
                            <label for="total_qty" class="col-sm-5 control-label">Total Qty</label>
                            <div class="col-sm-7">
                                {!! Form::text('total_qty', null,['class' => 'form-control total_qty', 'readonly']) !!}
                            </div>
                            <br>
                            <br>
                        </div>

                        <div class="form-group">
                            <label for="discount" class="col-sm-5 control-label">Gross Amount</label>
                            <div class="col-sm-7">
                                {!! Form::text('gross_amount', null,['class'=>'form-control gross_amount', 'readonly', 'autocomplete' => 'off']) !!}
                                {!! Form::hidden('gross_amount_val', $order->gross_amount,['class'=>'form-control gross_amount_val', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="discount" class="col-sm-5 control-label">Discount Type</label>
                            <div class="col-sm-7">
                                {{ Form::select('discount_type', ['fixed'=>'Fixed', 'percentage'=>'Percentage',], null, array('class'=>'form-control discount_type', 'id'=>'discount_type')) }}

                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="discount" class="col-sm-5 control-label">Discount</label>
                            <div class="col-sm-7">
                                {!! Form::text('input_discount', 0,['autocomplete'=>'off', 'class'=>'form-control discount', 'id'=>'discount_amount',  'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="discount" class="col-sm-5 control-label">Total Discount</label>
                            <div class="col-sm-7">
                                {!! Form::text('discount', null,['autocomplete'=>'off', 'readonly', 'class'=>'form-control total_discount', 'id'=>'total_discount',  'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group hidden">
                            <label for="transport" class="col-sm-5 control-label">Transport</label>
                            <div class="col-sm-7">
                                {!! Form::text('transport', null,['autocomplete'=>'off', 'class'=>'form-control transport', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <label for="gross_amount" class="col-sm-5 control-label"><strong>Gross
                                    Amount</strong></label>
                            <div class="col-sm-7">
                                <input autocomplete="off" type="hidden" value="{{ $order->gross_amount }}"
                                       name="gross_amount"
                                       class="form-control gross_amount">
                                {!! Form::text('gross_amount', null,['class'=>'form-control gross_amount', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shipping_method_charge" class="col-sm-5 control-label">Shipping Charge</label>
                            <div class="col-sm-5">
                                <span id="swho_shipping_method_charge"></span>
                                {!! Form::text('shipping_method_charge', null,['class'=>'form-control shipping_method_charge', 'id'=>'shipping_method_charge']) !!}
                            </div>
                            <div class="col-sm-2">
                            <div class="input-group-btn">
                                <button class="btn btn-primary applyCoupon" type="button">
                                    Apply Coupon
                                </button>
                            </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="grand_total" class="col-sm-5 control-label"><strong>Grand Total</strong></label>
                            <div class="col-sm-7">
                                <input autocomplete="off" type="hidden" value="{{ $order->grand_total }}"
                                       name="grand_total"
                                       class="form-control grand_total">
                                {!! Form::text('grand_total', null,['class'=>'form-control grand_total','readonly']) !!}

                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-success" id="updateOrderBtn" type="submit">
                                <i class="fa fa-save"></i>
                                {{ $btn_name }} Order
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end widget content -->
        </div>
        <!-- end widget div -->
    </div>
    <!-- end widget -->
</article>
<!-- WIDGET END -->

@include('nptl-admin.common.order.script')