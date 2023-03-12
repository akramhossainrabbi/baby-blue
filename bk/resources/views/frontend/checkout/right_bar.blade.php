<div class="col-md-4 col-sm-12 col-lg-4 checkout-right">
    <div class="order-summary-outer">
        <div class="order-summary">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2">Order Summary</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th><span>SubTotal</span></th>
                        <td align="right"
                            id="subtotal">{{ SM::currency_price_value($sub_total) }}</td>
                    </tr>
                    <tr style="display: none;">
                        <th><span>TOtal Weight</span></th>
                        <td align="right"
                            id="subtotal">{{ $total_weight }}</td>
                    </tr>
                     {{-- @if($shipping_cost > 1) --}}
                        <!--<tr>-->
                        <!--    <th><span>Delivery Cost</br>-->
                        <!--            <small> ডাক মাশুল </small></span></th>-->
                        <!--    <td id="shipping_cost" align="right">{{ SM::currency_price_value($shipping_cost) }}</td>-->
                        <!--</tr>-->
                     {{-- @endif --}}
                    <tr>
                        <th><span>Delivery Cost</br>
                                <small> ডাক মাশুল </small></span></th>
                        <td id="right_bar_shipping_cost" align="right">{{ SM::currency_price_value($shipping_cost) }}</td>
                    </tr>
                    <tr>
                        <th class="last"><span>Total</span></th>
                        <td class="last" align="right"
                            id="total_price">{{ SM::currency_price_value($grand_total) }}
                        </td>
                    </tr>
                    <input type="hidden" name="grand_total_js" id="grand_total_js" value="{{ $grand_total }}">
                    <input type="hidden" name="shipping_js" id="shipping_js" value=0>
                    <input type="hidden" name="grand_grand_total_js" id="grand_grand_total_js" value=0>
                    
                    <tr>
                        <th class="last">
                            <div class="form-group col-md-12 ">
                                <button type="submit" class="btn-block btn btn-success">Submit Order</button>
                            </div>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>