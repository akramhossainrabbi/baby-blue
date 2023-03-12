@extends('frontend.master')
@section('title', 'Checkout')
@section('content')
    @include('frontend.common.css2')
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
    $net_sub_total = $sub_total + $tax + $shipping_method_charge - $noraml_discount_amount;
    $grand_total = $sub_total + $shipping_cost;
    ?>
    <section class="all-body-area">
        <div id="main">
            <section class="about-page-area">
                <div class="header-blog">
                    <h2>Shopping Cart Summary</h2>
                    <h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Checkout</a></li>
                            
                        </ol>
                    </h6>
                </div>
                <div class="text-page-blog">
                    <div class="checkout-area">
                        <div class="row">
                            {!! Form::open(['method'=>'post', 'url'=>'place_order', 'id'=>'place_order']) !!}
                            <div class="col-md-8 col-sm-12 col-lg-8 checkout-left">
                                <br>
                                <div class="tab-content" id="pills-tabContent">
                                    {{--@include('frontend.checkout.order_review')--}}
                                    @include('frontend.checkout.shipping_address')
                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                    <input type="hidden" name="shipping_method_charge" value="{{ $shipping_cost }}">
                                    <input type="hidden" name="discount" value="{{ $noraml_discount_amount }}">
                                    <input type="hidden" name="tax" value="{{ $tax }}">
                                    <input type="hidden" name="coupon_code" class="coupon_code"
                                           value="{{ $coupon_code }}">
                                    <input type="hidden" name="coupon_amount" class="coupon_amount"
                                           value="{{ $coupon_amount }}">
                                    <input type="hidden" name="grand_total" class="grand_total"
                                           value="{{ $grand_total }}">
                                </div>
                            </div> <!--CHECKOUT LEFT CLOSE-->
                        @include('frontend.checkout.right_bar')   <!--CHECKOUT RIGHT CLOSE-->
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </div>
    </section>
    @include('frontend.inc.footer')
@endsection