@extends('frontend.master')
@section('title', 'Cart')
@section('content')
    <section class="all-body-area">
        <div id="main">
            <section class="about-page-area">
                <div class="header-blog">
                    <h2>Shopping Cart Summary </h2>
                    <h6>Your shopping cart contains: {{ count($cart) }} Product</h6>
                </div>
                <div class="text-page-blog table-responsive">
                    <table class="table table-bordered table-responsive cart_summary cart_table">
                        <thead>
                        <tr>
                            <th class="cart_product">Product</th>
                            <th>Description</th>
                            <th>Unit price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th class="action">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cart as $id => $item)
                            <tr id="tr_{{$item->rowId}}" class="removeCartTrLi">
                                <td class="cart_product">
                                    <a href="{{ url('product/'.$item->options->slug) }}">
                                        <img src="{{ SM::sm_get_the_src($item->options->image, 112, 112) }}"
                                             alt="{{ $item->name }}"></a>
                                </td>
                                <td class="cart_description">
                                    <p class="product-name">
                                        <a href="{{ url('product/'.$item->options->slug) }}"><strong>{{ $item->name }}</strong>
                                        </a>
                                    </p>
                                    <br>
                                    {{--<small class="cart_ref">SKU : {{ $item->options->sku }}</small>--}}
                                    {{--<br>--}}
                                    @if($item->options->sizename != '')
                                        <small>N.W : {{$item->options->sizename}} {{$item->options->colorname}}</small><br>
                                        <small>T.W: <?php echo SM::productWeightCal1($item->options->sizename * $item->qty, $item->options->colorname); ?></small>
                                    @endif
                                </td>
                                <td class="price"><span>{{ SM::currency_price_value($item->price) }} </span></td>
                                <td class="qty">
                                    <style>
                                        .input-group-btn {
                                            font-size: unset;
                                        }
                                    </style>
                                    

                                    <div class="input-group custom-heart-extra" align="center" style="margin:0 auto;">

                                      <input type="button" data-row_id="{{ $item->rowId }}" value="-" data-product_id ="{{ $item->id}}" class="button-minus dec">

                                      <input type="text" id="pro_{{ $item->rowId }}" data-product_id ="{{ $item->id }}" value="{{ $item->qty }}" name="qty" class=" quantity-field qty-inc-dc ">

                                      <input type="button" data-product_id ="{{ $item->id }}" data-row_id="{{ $item->rowId }}" value="+" class="button-plus inc">

                                    </div>
                                </td>
                                <td class="price">
                                    <span>{{ SM::currency_price_value($item->price * $item->qty) }} </span>
                                </td>
                                <td class="action">
                                    <a data-product_id="{{ $item->rowId }}" class="btn btn-danger remove_link removeToCart"
                                       title="Delete item"
                                       href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>

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
                            <td rowspan="4" colspan="3"></td>
                            <td >Sub Total</td>
                            <td >{{SM::currency_price_value(Cart::instance('cart')->subTotal())}}</td>
                        </tr>
                            <?php
                                $total_weight = 0;
                                $cart1 = Cart::instance('cart')->content();
                                foreach ($cart1 as $id => $item) {
                                     if ($item->options->colorname == 'gm') {
                                        $weight = $item->options->sizename;
                                        $qty = $item->qty;
                                        $total_weight += $weight * $qty;
                                    }
                                }
                                if ($total_weight > 9999) {
                                    $shipping_cost = 120;
                                } elseif ($total_weight < 1) {
                                    $shipping_cost = 0;
                                } else {
                                    $shipping_cost = 0;
                                }
                                $shipping_method_charge = Session::get('shipping_method.method_charge');
                                $shipping_method_name = Session::get('shipping_method.method_name');
                                $coupon_code = Session::get('coupon.coupon_code');
                                $coupon_amount = Session::get('coupon.coupon_amount');
                                $sub_total = Cart::instance('cart')->subTotal();
                                $grand_total = $sub_total + $shipping_cost;
                                ?>
                                 @if($shipping_cost > 1)
                           <tr> 
                                
                                <td >DELIVERY COST</td>
                                <td ><strong>{{SM::currency_price_value($shipping_cost)}}</strong> 
                                 </td> 
                             </tr> 
                              @endif
                        <tr>
                           
                            <td ><strong>Total</strong></td>
                            <td >
                                <strong>{{ SM::currency_price_value($grand_total)}}</strong></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="cart_navigation">
                        <a class="next-btn" href="{{url('/checkout')}}">Order Now</a>
                        {{--@if(Auth::check())--}}
                            {{--<a class="next-btn" href="{{url('/checkout')}}">Order Now</a>--}}
                        {{--@else--}}
                            {{--<a class="next-btn" data-toggle="modal" data-target="#loginModal" href="#">Proceed to--}}
                                {{--checkout</a>--}}
                        {{--@endif--}}
                    </div>
                    <div class="cart_navigation">
                        <a class="prev-btn" href="{{url('/shop')}}">Continue shopping</a>
                    </div>
                </div>
            </section>
        </div>
    </section>
    @include('frontend.inc.footer')
@endsection