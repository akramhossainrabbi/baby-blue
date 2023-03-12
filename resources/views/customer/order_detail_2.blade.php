@extends('frontend.master')

@section("title", "Order Detail")

@section("content")

    <?php

    $title = SM::smGetThemeOption("invoice_banner_title");

    $subtitle = SM::smGetThemeOption("invoice_banner_subtitle");

    $bannerImage = SM::smGetThemeOption("invoice_banner_image");

    ?>

    <style>.blog-banner-contents.text-center {

            padding-top: 26px;

        }

    </style>



    <section class="all-body-area">

        <div id="main">

            <section class="about-page-area">

                <div class="text-page-blog">

                    @if(!empty($order))

                        <?php

                        $orderId = SM::orderNumberFormat($order);

                        ?>

                        @if(Session::has("orderSuccessMessage"))

                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="order-done-content text-center margin-bottom45">

                                        <i class="fa fa-check"></i>

                                        <h3>{{ Session::get("orderSuccessMessage") }}</h3>

                                        <span class="doodle-order-input">Order ID {{ $orderId }}</span>

                                        <p>Thanks for being cooperative. We hope you enjoy your Service.</p>

                                    </div>

                                </div>

                            </div>

                            <?php

                            Session::forget("orderSuccessMessage");

                            Session::save();

                            ?>

                        @endif

                        @if(request()->input('isAdmin', 0)!=1)

                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="download-item-list text-right">

                                        <a href="{!! url("dashboard/orders/download/$order->id") !!}" class="download"

                                           title="Download"><i

                                                    class="fa fa-cloud-download"></i> Download

                                            Invoice </a>

                                        {{--<a href="{!! url("dashboard/orders") !!}" class="download" title="Order List"><i--}}

                                                    {{--class="fa fa fa-list"></i> Order List </a>--}}

                                    </div>

                                </div>

                            </div>

                        @endif

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="invoice-table-item"

                                     style="width: 100%; padding: 15px 0 10px 15px">

                                <?php

                                $sm_get_site_logo = SM::sm_get_the_src(SM::sm_get_site_logo(), 193, 78);

                                $site_name = SM::get_setting_value('site_name');

                                $orderUser = $order->user;

                                ?>

                                <!-- mobile device -->

                                    <div class="row visible-xs">

                                        <div class="col-lg-6">

                                            <div class="invoice-author-information1">

                                                <h1 class="ab-inv-title">

                                                    invoice

                                                </h1>
                                                <!-- {!! $sm_get_site_logo !!}  -->
                                                <img src="https://virtualshoppersbd.com/storage/uploads/last-logo-final_2.gif" alt="{{ $site_name }}">

                                                <p style="font-weight: 700; ">

                                                    Invoice ID No: {{ $orderId }}

                                                </p>

                                                <p class="date">

                                                    Date : {{ date('d-m-Y', strtotime($order->created_at)) }}



                                                </p>

                                                <p>

                                                    Order Status : <?php

                                                    if ($order->order_status == 1) {

                                                        echo 'Completed';

                                                    } else if ($order->order_status == 2) {

                                                        echo 'Processing';

                                                    } else if ($order->order_status == 3) {

                                                        echo 'Pending';

                                                    } else {

                                                        echo 'Cancel';

                                                    }

                                                    ?>

                                                </p>

                                            </div>

                                        </div>



                                        <div class="col-lg-4 col-lg-offset-2">





                                            <div class="invoice-author-information">

                                            @if(!empty($orderUser))

                                                <?php

                                                $flname = $orderUser->firstname . " " . $orderUser->lastname;

                                                $name = trim($flname != '') ? $flname : $orderUser->username;

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



                                                <!--<img src="images/logo.png" alt="">-->

                                                    <p class="inv_to"> Invoice To :</p>

                                                    <h3>{{ $name }}</h3>

                                                    <p><span>Address </span>:

                                                        {!!  $address !!}.</p>

                                                    <p><span>Phone </span>:

                                                        {{ $orderUser->mobile }}</p>

                                                    <p><span>Email </span>:

                                                        {{ $order->contact_email }}

                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                    <!-- desktop device -->

                                    <div class="row">

                                        <div class="col-lg-6 hidden-xs col-sm-6">

                                            <div class="invoice-author-information">

                                                @if(!empty($orderUser))

                                                    <?php

                                                    $flname = $orderUser->firstname . " " . $orderUser->lastname;

                                                    $name = trim($flname != '') ? $flname : $orderUser->username;

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
                                                    <!-- {{ $sm_get_site_logo }}  -->
                                                    <img src="https://virtualshoppersbd.com/storage/uploads/last-logo-final_2.gif" alt="{{ $site_name }}">

                                                    <p class="inv_to"> Invoice To :</p>

                                                    <h3>{{ $name }}</h3>

                                                    <p><span style="font-weight: bold; ">Address </span>:

                                                        {!!  $address !!}</p>

                                                    <p>

                                                        <span style="font-weight: bold;  font-family: 'Poppins'">Phone </span>:

                                                        {{ $orderUser->mobile }}</p>

                                                    <p><span style="font-weight: bold; ">Email </span>:

                                                        {{ $order->contact_email }}

                                                    </p>



                                                @endif

                                            </div>

                                        </div>



                                        <div class="col-lg-4 col-lg-offset-2 hidden-xs col-sm-6">

                                            <div class="invoice-author-information1">

                                                <h1 class="ab-inv-title hidden-xs">

                                                    invoice

                                                </h1>

                                                <p>

                                                    <label style="font-weight: 700; ">Invoice ID

                                                        No</label>

                                                    : {{ $orderId }}

                                                </p>

                                                <p class="date">

                                                    <label style="font-weight: 700; "> Date</label>

                                                    : {{ date('d-m-Y', strtotime($order->created_at)) }}



                                                </p>

                                                <p>

                                                    <label style="font-weight: 700; ">Order Status</label>

                                                    :

                                                    <span><?php

                                                        if ($order->order_status == 1) {

                                                            echo 'Completed';

                                                        } else if ($order->order_status == 2) {

                                                            echo 'Processing';

                                                        } else if ($order->order_status == 3) {

                                                            echo 'Pending';

                                                        } else {

                                                            echo 'Cancel';

                                                        }

                                                        ?></span>

                                                </p>
                                                    <?php
                                                    $p_details1 = '';
                                                    $p_details2 = '';
                                                    $x_details1 = '';
                                                    $x_details2 = '';
                                                    $y_details = 'Cash On Delivery';
                                                    if ($order->payment_method_id == 6) {
                                                        $y_details = 'Online Payment'; 
                                                        $payment_details = json_decode($order->payment_details);
                                                       
                                                        if(!empty($payment_details))
                                                        {
                                                            foreach ($payment_details as $key => $value) {
                                                                if ($key == 'card_number' || $key == 'card_type' || $key == 'pay_status' || $key == 'bank_txn') {
                                                                    $key_field = str_replace("_", " ", $key);
                                                                    $p_details1 = ucfirst($key_field);
                                                                    $p_details2 =  $value;
                                                                }
                                                                
                                                                
                                                            }
                                                            
                                                            
                                                        }
                                                        if(!empty($payment_details))
                                                        {
                                                            foreach ($payment_details as $key => $value) {
                                                                if ($key == 'tran_id') {
                                                                    $key_field = str_replace("_", " ", $key);
                                                                    $x_details1 = ucfirst($key_field);
                                                                    $x_details2 = $value;
                                                                }
                                                                
                                                                
                                                            }
                                                            
                                                            
                                                        }
                                                        
                                                        
                                                    }
                                                    ?>
                                                <p>
                                                    <label style="font-weight: 700; color: #1d2d5d"> Payment Method :  {{$y_details}} </label>
                                                    <br>
                                                    <label style="font-weight: 700; color: #1d2d5d">
                                                         {{$p_details1}} : 
                                                    </label>  <span>   {{$p_details2}}  </span><br>
                                                    <label style="font-weight: 700; color: #1d2d5d">
                                                        {{$x_details1}} :
                                                    </label> <span>   {{$x_details2}}  </span>
                                                
                                                </p>
                                                @if(!empty($order->delivery_slot))
                                                <p style="font-weight: 700; color: #1d2d5d">
                                                    Delivery Slot :
                                                    
                                                    <span>{{ $order->delivery_slot }}</span>
                                                </p>
                                                @endif
                                                
                                                @if(!empty($order->delivery_address))
                                                <p style="font-weight: 700; color: #1d2d5d">
                                                    Pick Up Point:
                                                    
                                                    <span>{{ $order->delivery_address }}</span>
                                                </p>
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <?php

                                $order_details = $order->detail;

                                ?>

                                @if(!empty($order_details))

                                    <div class="table-responsive hidden-xs">

                                        <table class="table table-bordered table-product-info " width="100%" border="0" cellpadding="0"

                                               cellspacing="0"

                                               style="width: 100%; ">

                                            <tr>

                                                <th style="font-size: 18px; text-align: center; text-transform: uppercase; line-height: 28px; font-weight: 500; text-align: center;">

                                                    Item Description

                                                </th>

                                                <th style="font-size: 18px; text-align: center; text-transform: uppercase; line-height: 28px; font-weight: 500; text-align: center;">

                                                    Image

                                                </th>

                                                <th style="font-size: 18px; text-align: center; text-transform: uppercase; line-height: 28px; font-weight: 500; text-align: center;">

                                                    Quantity

                                                </th>

                                                <th style="font-size: 18px; text-align: center; text-transform: uppercase; line-height: 28px; font-weight: 500; text-align: center;">

                                                    Amount

                                                </th>

                                                <th style="font-size: 18px; text-align: center; text-transform: uppercase; line-height: 28px; font-weight: 500; text-align: center;">

                                                    Total Price

                                                </th>

                                            </tr>

                                            <?php

                                            $order_detail = $order->detail;

                                            $orderTotal = [];

                                            ?>

                                            @foreach($order->detail as $detail)

                                                <?php

                                                $title = $detail->product->title;

                                                $price = $detail->product_price;

                                                $total = $detail->product_qty * $price;

                                                $orderTotal[] = $total;

                                                ?>

                                                <tr style="border-bottom: 1px solid #dddddd;">

                                                    <td style="width: 25%; vertical-align: middle;">

                                                        <h4 style="font-size: 16px; font-weight: 600; line-height: 28px; margin-bottom: 0; text-align: center;">

                                                            {{ $title }}</h4>

                                                        <?php

                                                        if (!empty($detail->product_color)) {

                                                        ?>

                                                        <small style="text-align: center;display: block;">Weight : {{   SM::productWeightCal($detail->product_size) }}</small>

                                                        <?php } ?>



                                                    </td>

                                                    <td style="width: 20%; vertical-align: middle; text-align: center;">

                                                        <img src="{{ SM::sm_get_the_src($detail->product_image, 80, 80) }}"

                                                             style="height: 35px;" alt="{{ $title }}">

                                                    </td>

                                                    <td style="width: 13%; vertical-align: middle;">

                                                        <p style="font-size: 18px; font-weight: 600; text-align: center; line-height: 28px; margin-bottom: 0;">

                                                            {{ $detail->product_qty }}</p>

                                                    </td>

                                                    <td style="width: 13%; vertical-align: middle;" >

                                                        <p style="font-size: 18px; text-align: center; font-weight: 600;  line-height: 28px; margin-bottom: 0;">

                                                            {{ SM::order_currency_price_value($detail->order_id,$price) }}</p>

                                                    </td>

                                                    <td style="width: 13%;vertical-align: middle;">

                                                        <p style="font-size: 18px; font-weight: 600; text-align: center;  line-height: 28px; margin-bottom: 0;">

                                                            {{ SM::order_currency_price_value($detail->order_id,$total) }}</p>

                                                    </td>

                                                </tr>

                                            @endforeach



                                        </table>

                                    </div>

                                    <!-- mobile device start-->

                                    <div class="mo-product-item hidden-sm hidden-md hidden-lg">



                                        @if(count($order->detail)>0)

                                            <h1 class="ab-item-desc-title">

                                                {{-- {{ $order->product->title }}--}}

                                            </h1>

                                        @else

                                            <h1 class="ab-item-desc-title">

                                                Item Description

                                            </h1>

                                        @endif

                                        <ul>

                                            <?php

                                            $orderTotal = [];

                                            ?>

                                            @if(count($order->detail)>0)

                                                @foreach($order->detail as $detail)

                                                    <?php

                                                    $title = $detail->product->title;

                                                    $price = $detail->product_price;

                                                    $total = $detail->product_qty * $price;

                                                    $orderTotal[] = $total;

                                                    ?>

                                                    <li>

                                                        <strong class="item-desc">{{ $title }}</strong>

                                                        <strong> <span>Quantity</span>: {{ $detail->product_qty }}

                                                        </strong>

                                                        <strong>

                                                            <span> Amount </span>: {{ SM::order_currency_price_value($detail->order_id,$price) }}

                                                        </strong>

                                                        <strong>

                                                            <span>Total Price </span>: {{ SM::order_currency_price_value($detail->order_id,$total) }}

                                                        </strong>

                                                    </li>

                                                @endforeach

                                            @else

                                                <?php

                                                $rate = isset($order->detail[0]->rate) ? $order->detail[0]->rate : 0;

                                                $qty = isset($order->detail[0]->qty) ? $order->detail[0]->qty : 0;

                                                $total = $qty * $rate;

                                                $orderTotal[] = $total;

                                                ?>

                                                <li>

                                                    <strong class="item-desc">{{ $order_details->title }}</strong>

                                                    <p>

                                                        @if($order_details->detail[0])

                                                            {{ title_case($order_details->detail[0]->title) }} Plan

                                                        @endif

                                                    </p>

                                                    <strong> <span>Quantity</span>: {{ $qty }}</strong>

                                                    <strong>

                                                        <span> Amount </span>: {{ SM::order_currency_price_value($detail->order_id,$rate) }}

                                                    </strong>

                                                    <strong>

                                                        <span>Total Price </span>: {{ SM::order_currency_price_value($detail->order_id,$total) }}

                                                    </strong>

                                                </li>

                                                <ul>

                                                    <?php

                                                    $orderTotal = [];

                                                    ?>

                                                    @if(count($order->detail)>0)

                                                        @foreach($order->detail as $detail)

                                                            <?php

                                                            $title = $detail->product->title;

                                                            $price = $detail->product_price;

                                                            $total = $detail->product_qty * $price;

                                                            $orderTotal[] = $total;

                                                            ?>

                                                            <li>

                                                                <strong class="item-desc">{{ $title }}</strong>

                                                                <strong>

                                                                    <span>Quantity</span>: {{ $detail->product_qty }}

                                                                </strong>

                                                                <strong>

                                                                    <span> Amount </span>: {{ SM::order_currency_price_value($detail->order_id,$price) }}

                                                                </strong>

                                                                <strong>

                                                                    <span>Total Price </span>: {{ SM::order_currency_price_value($detail->order_id,$total) }}

                                                                </strong>

                                                            </li>

                                                        @endforeach

                                                    @else

                                                        <?php

                                                        $rate = isset($order->detail[0]->rate) ? $order->detail[0]->rate : 0;

                                                        $qty = isset($order->detail[0]->qty) ? $order->detail[0]->qty : 0;

                                                        $total = $qty * $rate;

                                                        $orderTotal[] = $total;

                                                        ?>

                                                        <li>

                                                            <strong class="item-desc">{{ $order_detail->title }}</strong>

                                                            <p>

                                                                @if($order_detail->detail[0])

                                                                    {{ title_case($order_detail->detail[0]->title) }}

                                                                    Plan

                                                                @endif

                                                            </p>

                                                            <strong> <span>Quantity</span>: {{ $qty }}</strong>

                                                            <strong>

                                                                <span> Amount </span>: {{ SM::order_currency_price_value($detail->order_id,$rate) }}

                                                            </strong>

                                                            <strong>

                                                                <span>Total Price </span>: {{ SM::order_currency_price_value($detail->order_id,$total) }}

                                                            </strong>

                                                        </li>

                                                    @endif

                                                </ul>



                                            @endif

                                        </ul>

                                    </div>

                                @endif

                                <div class="total-amount-item row hidden-xs "

                                     style=" margin: 0px;">

                                    <div class="col-lg-6 col-sm-6">

                                        <div class="left-amount-process">

                                            <p><label style="font-weight: 700; ">Amount in Words</label>:

                                                <span>

                                <?php

                                                    $get_currency = DB::table('orders')->where('id', $order->id)->first();

                                                    if (SM::get_setting_value('currency') != $get_currency->currency) {

                                                        $number = $order->grand_total * $get_currency->currencyRate;

                                                    } else {

                                                        $number = $order->grand_total;

                                                    }

                                                    ?>

                                                    {{ title_case(SM::sm_convert_number_to_words($number)) }}

                                Taka only.

                            </span>

                                            </p>

                                            <p><label style="font-weight: 700; "> Payment Status </label>:

                                                <span><?php

                                                    if ($order->payment_status == 1) {

                                                        echo 'Completed';

                                                    } else if ($order->payment_status == 2) {

                                                        echo 'Pending';

                                                    } else {

                                                        echo 'Pending';

                                                    }

                                                    ?></span></p>

                                            <?php

                                            $due = $order->paid - $order->grand_total;

                                            $dueSign = $due < 0 ? "-" : "+";

                                            $dueSign = $due == 0 ? "" : $dueSign;

                                            ?>

                                            @if($due < 0)

                                                <p>Due Status : <span>

                                <?php

                                                        echo SM::order_currency_price_value($order->id, $due);

                                                        ?>

                            </span></p>

                                            <!--<a href="{{ url("dashboard/orders/pay/$order->id") }}">Pay Your Due</a>-->

                                            @endif



                                        </div>

                                    </div>

                                    <div class="col-lg-5 col-lg-offset-1 col-sm-6">

                                        <div class="right-total-amount-process">

                                            <p class="clearfix"

                                               style="">

                                                <span class="pull-left inv-total">Sub Total    </span>:

                                                <span class="pull-right ab-inv-total-price">{{ SM::order_currency_price_value($order->id,$order->sub_total) }}</span>

                                            </p>



                                            @if($order->tax>0)

                                                <p class="clearfix">

                                                    <span class="pull-left inv-total">Tax + Vat  </span>:

                                                    <span class="pull-right ab-inv-total-price">{{ SM::order_currency_price_value($order->id,$order->tax) }}</span>

                                                </p>

                                            @endif
                                            @if($order->discount>0)

                                                <p class="clearfix">

                                                    <span class="pull-left inv-total">Discount  </span>:

                                                    <span class="pull-right ab-inv-total-price">- {{ SM::order_currency_price_value($order->id,$order->discount) }} </span>
                                                </p>
                                            @endif
                                            @if($order->coupon_amount>0)

                                                <p class="clearfix">

                                                    <span class="pull-left inv-total">Coupon </span>:

                                                    <span class="pull-right ab-inv-total-price">{{ SM::order_currency_price_value($order->id,$order->coupon_amount) }}</span>

                                                </p>

                                            @endif

                                            @if($order->shipping_method_charge>0)

                                                <p class="clearfix">

                                                    <span class="pull-left inv-total">Delivery Cost </span>:

                                                    <span class="pull-right ab-inv-total-price">{{ SM::order_currency_price_value($order->id,$order->shipping_method_charge) }}</span>

                                                </p>

                                            @endif
                                            <div class="clearfix ab-total-amount">

                                                <span class="pull-left">Total Amount  </span>

                                                <span class="pull-right ">{{ SM::order_currency_price_value($order->id,$order->grand_total) }}</span>

                                            </div>
                                        </div>

                                        <?php

                                        $invoice_signature = SM::smGetThemeOption("invoice_signature");

                                        $invoice_approved_by_name = SM::smGetThemeOption("invoice_approved_by_name", "NPTL Author");

                                        $invoice_approved_by_designation = SM::smGetThemeOption("invoice_approved_by_designation", "Director of Development");

                                        $src = ($invoice_signature != '') ? SM::sm_get_the_src($invoice_signature) : "additional/images/signature.png";

                                        ?>

                                        <div class="author-signature-content pull-right">

                                            <!-- <img src="{{-- url($src) --}}" alt="{{-- $invoice_approved_by_name --}}"> -->

                                            <h2>{{ $invoice_approved_by_name }}</h2>

                                            <h4>{{ $invoice_approved_by_designation }}</h4>

                                        </div>

                                    </div>

                                </div>



                                <div class="total-amount-item row visible-xs " style="">



                                    <div class="col-lg-12">

                                        <div class="right-total-amount-process">

                                            <p class="clearfix"

                                               style="display: {{ $order->tax>0 || $order->discount>0 || $order->coupon_amount>0 ? 'block' : 'none' }}">

                                                <span class="pull-left inv-total">Sub Total    </span>:

                                                <span class="pull-right ab-inv-total-price">{{ SM::currency_price_value($order->sub_total) }}</span>

                                            </p>



                                            @if($order->tax>0)

                                                <p class="clearfix">

                                                    <span class="pull-left inv-total">Tax + Vat  </span>:

                                                    <span class="pull-right ab-inv-total-price">{{ SM::currency_price_value($order->tax) }}</span>

                                                </p>

                                            @endif



                                            @if($order->discount>0)

                                                <p class="clearfix">

                                                    <span class="pull-left inv-total">Discount  </span>:

                                                    <span class="pull-right ab-inv-total-price">{{ SM::currency_price_value($order->discount) }}</span>

                                                </p>

                                            @endif

                                            @if($order->coupon_amount>0)

                                                <p class="clearfix">

                                                    <span class="pull-left inv-total">Coupon  </span>:

                                                    <span class="pull-right ab-inv-total-price">{{ SM::currency_price_value($order->coupon_amount) }}</span>

                                                </p>

                                            @endif



                                            <div class="clearfix ab-total-amount">

                                                <span class="pull-left">Total Amount  </span>

                                                <span class="pull-right ">{{ SM::currency_price_value($order->grand_total) }}</span>

                                            </div>



                                        </div>

                                        <div class="left-amount-process">

                                            <p>Amount in Words: <span>
                                            {{ title_case(SM::sm_convert_number_to_words($order->grand_total)) }}
                                            USD only.</span>
                                            </p>

                                            <p>Payment Status : <span><?php

                                                    if ($order->payment_status == 1) {

                                                        echo 'Completed';

                                                    } else if ($order->payment_status == 2) {

                                                        echo 'Pending';

                                                    } else {

                                                        echo 'Cancel';

                                                    }

                                                    ?></span></p>

                                            @if($due < 0)

                                                <p>Due Status : <span>

                                <?php

                                                        echo SM::get_setting_value('currency') . ' ' . $dueSign . ' ' . number_format(abs($due), 2);

                                                        ?>

                            </span></p>

                                                <a href="{{ url("dashboard/orders/pay/$order->id") }}">Pay Your Due</a>

                                            @endif

                                        </div>

                                        <div class="author-signature-content pull-right">

                                           

                                            <h2>{{ $invoice_approved_by_name }}</h2>

                                            <h4>{{ $invoice_approved_by_name }}</h4>

                                        </div>

                                    </div>



                                </div>

                                <?php

                                $mobile = SM::get_setting_value('mobile');

                                $email = SM::get_setting_value('email');

                                $address = SM::get_setting_value('address');

                                $country = SM::get_setting_value('country');

                                $website = SM::get_setting_value('website');

                                ?>

                                <div class="single-table-pert-info">

                                    <ul>

                                        <li><i class="fa fa-phone"></i> {{ $mobile }}

                                        </li>

                                        <li><i class="fa fa-envelope"></i> {{ $email }}

                                        </li>

                                        <li><i class="fa fa-globe"></i> {{ $website }}

                                        </li>

                                        <li><i class="fa fa-map-marker"></i> {{ $address }}, {{ $country }}

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="alert alert-warning">

                            <i class="fa fa-warning"></i> No Order Found!

                        </div>

                    @endif

                </div>

            </section>

        </div>

    </section>

    @include('frontend.inc.footer')

@endsection