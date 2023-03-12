<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Mail</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800"
          rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        table {
            border-collapse: collapse !important;
        }

        .itemTable {
            width: 760px;
            max-width: 760px;
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #ddd;
    vertical-align: middle!important;
}
.table-bordered>tbody>tr>td span, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td span, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td span , .table-bordered>thead>tr>th {
   
    vertical-align: middle!important;
}
        * {
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Raleway", "Helvetica", 'Arial', sans-serif;
        }

        .collapse {
            margin: 0;
            padding: 0;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
        }

        a {
            color: #f68c26;
            text-decoration: none;
        }

        table {
            width: 100%;
        }

        .container table td.logo {
            padding: 15px;
        }

        .container table td.label {
            padding: 15px;
            padding-left: 0px;
        }

        table {
            width: 100%;
            clear: both !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            line-height: 1.1;
            margin-bottom: 18px;
            color: #1d2d5d;
        }

        h1 {
            font-weight: 400;
            font-size: 24px;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 16px;
        }

        h4 {
            font-size: 14px;
        }

        h5 {
            font-size: 12px;
        }

        .collapse {
            margin: 0 !important;
        }
        p.last {
            margin-bottom: 0px;
        }

        ul li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            max-width: 1000px !important;
            margin: 0 auto !important; /* makes it centered */
            clear: both !important;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            padding: 15px;
            max-width: 700px;
            margin: 0 auto;
            display: block;
        }

        /* Let's make sure tables in the content area are 100% wide */
        .content table {
            width: 100%;
        }

        .clearfix {
            display: block;
            clear: both;
        }
        @media only screen and (max-width: 480px) {

            .no-padding {
                padding-left: 0px !important;
            }

            .offer-img {
                width: 80%;
            }

            .width100 {
                width: 100% !important;
            }

            .column-heading-bg {
                background-color: #1d2d5d !important;
                background-image: none !important;
            }

            .single-table-pert1 {
                padding-bottom: 0 !important;
            }

            .padding-left30 {
                padding-left: 30px !important;
            }

            .text-left {
                text-align: left !important;
                padding-left: 30px !important;
            }
        }

        .logo img {
            width: 240px;
            height: 30px;
        }
    </style>
</head>
<body bgcolor="#f5f5f5" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<?php


$sm_get_site_logo = url(SM::sm_get_the_src(SM::sm_get_site_logo(), 193, 78));
$site_name = SM::get_setting_value('site_name');
$orderUser = $order->user;
$orderId = SM::orderNumberFormat($order);
?>

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
<center>
    <table bgcolor="#ffffff" style="background: #ffffff; padding-bottom: 0" class="container"
           align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="left" valign="top">

                <table width="100%" border="0" cellpadding="0" bgcolor="#f9fdff" cellspacing="0"
                       style="width: 100%;margin-bottom: 10px; margin-top: 15px;" >
                    <tr>
                        <td align="left" width="80%" style="padding-bottom: 30px; padding-left: 28px;"
                            class="single-table-pert column">
                            {{--@if(count($orderUser)>0)--}}
                            @if(!empty($orderUser))
                                <?php
                                
                                $flname = $orderUser->firstname . " " . $orderUser->lastname;
                                $name = trim($flname != '') ? $flname : $orderUser->username;
                                 $email = $orderUser->email;
                                $address = "";
                                $address .= !empty($orderUser->address) ? $orderUser->address . ", " : "";
                                if (strlen($address) > 300) {
                                    $address .= '';
                                }
                                // $address .= !empty($orderUser->city) ? $orderUser->city . ", " : "";
                                // $address .= !empty($orderUser->state) ? $orderUser->state . " - " : "";
                                // $address .= !empty($orderUser->zip) ? $orderUser->zip . ", " : "";
                                // $address .= $orderUser->country;
                                ?>
                                <div class="logo" style="width: 100%;">
                                     <img src="https://virtualshoppersbd.com/storage/uploads/last-logo-final_2.gif" style="margin-bottom: 10px;">
                                </div>
                               
                                <h4 style=" font-size: 15px; font-weight: 400; color: #1d2d5d; margin-bottom: 0px; padding-top: 0px;">
                                    Invoice to :
                                </h4>
                                <h3 style="font-size: 16px; font-weight: 600;color: #1d2d5d; margin-bottom: 0px;padding-top: 0px;">
                                    {{ $name }}</h3>
                                <p style="font-size: 12px; font-weight: 400; color: #1d2d5d; margin-bottom: 0px;padding-top: 0px; width: 60%">
                                    <span class="width8" style="font-weight: bold; color:#1d2d5d">Delivery address </span>:
                                    <span style="position: relative;"> {!!  $address !!}</span>
                                </p>
                                <p style="font-size: 12px; font-weight: 400; color: #1d2d5d; margin-bottom: 0px;padding-top: 0px;">
                                    <span class="width8" style="font-weight: bold; color:#1d2d5d">Phone </span>:
                                    {{ $orderUser->mobile }}</p>

                                @if(!empty($email))
                                <p style="font-size: 12px; font-weight: 400; color: #1d2d5d; margin-bottom: 0px;padding-top: 0px;">
                                    <span class="width8" style="font-weight: bold; color:#1d2d5d">Email </span>:
                                    {{ $email }}</p>
                                @endif
                                
                                @if(!empty($order->delivery_slot))
                                <p style="font-size: 12px; font-weight: 400; color: #1d2d5d; margin-bottom: 0px;padding-top: 0px;">
                                    <span class="width8" style="font-weight: bold; color:#1d2d5d">Delivery Slot </span>:
                                    
                                    {{ $order->delivery_slot }} 
                                </p>
                                @endif
                                
                                <span style="font-weight: 300"> Payment Method :  {{$y_details}} </span>

                            @endif
                        </td>
                        <td align="left" valign="top" style=" padding-right: 0px;"
                            class="single-table-pert column">
                            <h1 class="column-heading-bg" style="  font-size: 22px;
                                    padding: 9px 82px 9px 95px;
                                    margin-bottom: 0;
                                    text-align: center;
                                    font-weight: 600;
                                    color: #222;
                                    text-transform: uppercase;
                                    background-repeat: no-repeat;">
                                invoice
                            </h1>
                            <p class="text-left"
                               style="font-size: 13px; margin-right: 38px; font-weight: 500; color: #1d2d5d; padding-left: 20px; text-align: left">
                                <span style="color: #1d2d5d; font-weight: 400; ">Invoice no</span> : {{ $orderId }}
                            </p>
                            <p class="text-left"
                               style="font-size: 13px; margin-right: 38px; font-weight: 500; color: #1d2d5d; padding-left: 20px; text-align: left">
                                <span style='color: #1d2d5d; font-weight: 400'>Date :</span>
                                {{ date('d-m-Y', strtotime($order->created_at)) }}
                            </p>
                            <p class="text-left"
                               style="font-size: 13px; margin-right: 38px; font-weight: 500; color: #1d2d5d; padding-left: 20px; text-align: left">
                                <span style='color: #1d2d5d; font-weight: 400'>Delivery by :</span>
                                
                                <?php 
                                if(!empty($order->delivery_man_id))
                                {
                                    $man_name =  DB::table('admins')->where('id', $order->delivery_man_id)->first();
                                }
                                
                                
                                ?>
                                @if(!empty($order->delivery_man_id))
                                {{ $man_name->firstname }} {{ $man_name->lastname }} 
                                @endif
                            </p>
                            
                            <p class="text-left"
                               style="font-size: 12px; font-weight: 500; color: #1d2d5d; padding-left: 20px; text-align: left">
                                <span style="font-weight: 300">Order status</span> : <span style="color: #f68c26;"><?php
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
                                                    
                                                <p class="text-left" style="font-size: 12px; font-weight: 500; color: #1d2d5d; padding-left: 20px; text-align: left">
                                                    
                                                    <span style="font-weight: 300">
                                                         {{$p_details1}} : 
                                                    </span>  <span>   {{$p_details2}}  </span><br>
                                                    <span style="font-weight: 300">
                                                        {{$x_details1}} :
                                                    </span> <span>   {{$x_details2}}  </span>
                                                
                                                </p>

                        </td>
                    </tr>
                </table>
                <?php
                
               
                $order_detail = $order->detail;
                ?>
                @if(count($order_detail)>0)
                    <table class="table-product-info table-border" width="100%" border="0" cellpadding="0" cellspacing="0"
                           style="width: 100%; border-bottom: 1px solid #dddddd; background: #fff;margin-top: -20px;">
                        <tr>
                            <th style="font-size: 12px;
                            width: 5%;
                                text-align: center;
                                padding:5px 15px;
                                text-transform: capitalize;
                                line-height: 21px;
                                font-weight: 600;
                                background: #ccc;
                                color: #222;">
                                SL
                            </th>
                            <th style="font-size: 12px;
                                text-align: left;
                                padding:5px 15px;
                                text-transform: capitalize;
                                line-height: 21px;
                                font-weight: 600;
                                background: #ccc;
                                color: #222;">
                                Product Description
                            </th>
                            <th style="font-size: 18px; text-align: left; text-transform: uppercase; line-height: 16px; font-weight: 600; background: #1d2d5d; color: #ffffff; display:none;">
                                Image
                            </th>
                            <th style="font-size: 12px;
                                text-align: center;
                                padding:5px 15px;
                                text-transform: capitalize;
                                line-height: 21px;
                                font-weight: 600;
                                background: #ccc;
                                color: #222;">
                                Quantity
                            </th>
                            <th style="font-size: 12px;
                                text-align: center;
                                padding:5px 15px;
                                text-transform: capitalize;
                                line-height: 21px;
                                font-weight: 600;
                                background: #ccc;
                                color: #222;">
                                Unit
                            </th>
                            <th style="font-size: 12px;
                                text-align: center;
                                padding:5px 15px;
                                text-transform: capitalize;
                                line-height: 21px;
                                font-weight: 600;
                                background: #ccc;
                                color: #222;">
                                Rate
                            </th>
                            <th style="font-size: 12px;
                                text-align: center;
                                padding:5px 15px;
                                text-transform: capitalize;
                                line-height: 21px;
                                font-weight: 600;
                                background: #ccc;
                                color: #222;">
                                Total TK
                            </th>
                        </tr>


                        @foreach($order->detail as $k => $detail)
                            <?php

                            $title = $detail->product->title;
                            $price = $detail->product_price;
                            $total = $detail->product_qty * $price;

                            ?>
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="width: 5%;border-bottom: 1px solid #dddddd; vertical-align: middle;text-align: center;padding-bottom: 3px; padding-top: 1px;font-size: 12px">{{ $k+1 }}</td>
                                <td style="width: 25%;border-bottom: 1px solid #dddddd;vertical-align: middle; text-align: left;padding-bottom: 3px; padding-top: 1px;font-size: 12px">
                                    
                                        {{ $title }}
                                    <?php
                                    if (!empty($detail->product_color)) {
                                    ?>
                                    
                                    <?php } ?>

                                </td>
                                <td style="width: 20%; display:none;" valign="top">
                                    <img style="width:200px"
                                         src="{{url(SM::sm_get_the_src($detail->product_image, 112, 112)) }}"
                                         alt="{{ $title }}">
                                </td>

                                {{--<td style="width: 45%; border-bottom: 1px solid #dddddd;"--}}
                                {{--valign="top">--}}
                                {{--<h4 style="font-size: 16px; font-weight: 600; color: #1d2d5d; line-height: 16px; margin-bottom: 0;">--}}
                                {{--{{ $title }}</h4>--}}
                                {{--<p style="font-size: 14px; line-height: 24px; font-weight: 400; margin-bottom: 0; color: #575757;">--}}
                                {{--Aug 4, 2015 - Here are 50 examples of awesome invoice designsan easily--}}
                                {{--navigable and easyes to use.</p>--}}
                                {{--</td>--}}

                                <td style="width: 13%;border-bottom: 1px solid #dddddd;vertical-align: middle; text-align: center;padding-bottom: 3px; padding-top: 1px;font-size: 12px">
                            
                                        {{ $detail->product_qty }}
                                </td>
                                <td style="width: 13%;border-bottom: 1px solid #dddddd;vertical-align: middle; text-align: center;padding-bottom: 3px; padding-top: 1px;font-size: 12px">
                            
                                        {{ $detail->product_size }} {{ $detail->product_color }}
                                </td>
                                <td style="width: 13%;border-bottom: 1px solid #dddddd;vertical-align: middle; text-align: center;padding-bottom: 3px; padding-top: 1px;font-size: 12px">
                                    
                                        {{SM::order_currency_price_value($detail->order_id,$price)}}
                                </td>
                                <td style="width: 13%;border-bottom: 1px solid #dddddd;vertical-align: middle; text-align: center;padding-bottom: 3px; padding-top: 1px;font-size: 12px">
                                    
                                        {{ SM::order_currency_price_value($detail->order_id,$total) }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                
                <?php
                
                $invoice_signature = SM::smGetThemeOption("invoice_signature");
                $invoice_approved_by_name = SM::smGetThemeOption("invoice_approved_by_name", "NPTL Author");
                $invoice_approved_by_designation = SM::smGetThemeOption("invoice_approved_by_designation", "Director of Development");
                $src = ($invoice_signature != '') ? SM::sm_get_the_src($invoice_signature) : "additional/images/signature.png";
                
                $to_tal_grnd = (int)$order->grand_total;
                ?>
                
                @if($order->order_status != "4")
                <table width="100%" bgcolor="#f9fdff" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%; background: #f9fdff;" class="table-responsive">
                    <tr>
                        <td valign="top" class="column" align="left"
                            style="padding-left: 27px; padding-bottom: 20px;">
                            <p style="font-size: 13px; color: #1d2d5d; margin-bottom: 0; font-weight: 500;"><span
                                        style="font-weight: 700">In
                                words</span> : <span style="color: #222;">BDT {{ title_case(SM::sm_convert_number_to_words($to_tal_grnd)) }}
                                     only.</span></p>
                            <p style="font-size: 14px; color: #1d2d5d; margin-bottom: 0; font-weight: 500;"><span
                                        style="font-weight: 700">Payment
                                status</span> : <span style="color: #222;"><?php
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
                                <p style="font-size: 14px; color: #605f5f; margin-bottom: 10px; font-weight: 500;">Due
                                    Status : <span
                                            style="color: #f68c26;">{{ SM::order_currency_price_value($order->id,$due)}}</span>
                                </p>
                                {{--<a href="{{ url("dashboard/orders/pay/$order->id") }}"--}}
                                {{--style="color: #FFFFFF; background: #f68c26; padding: 6px 20px; display: inline-block; border-radius: 20px;">Pay--}}
                                {{--Your Due</a>--}}
                            @endif
                            <?php
                            //                            $payment_method = SM::get_payment_method_by_id($order->payment_method_id);
                            ?>
                            {{--<label style="font-weight: 700; color: #1d2d5d"> Payment Method </label>:--}}
                            {{--<span>{{ $payment_method->title }}</span>--}}
                            {{--<br>--}}
                            <?php
                            if ($order->payment_method_id == 3) {
                                  
                                $payment_details = json_decode($order->payment_details);
                                
                                if(!empty($payment_details))
                                {
                                   foreach ($payment_details as $key => $value) {
                                        if ($key == 'card_number' || $key == 'card_type' || $key == 'pay_status' || $key == 'bank_txn') {
                                            $key_field = str_replace("_", " ", $key);
                                            echo '<label style="font-weight: 700; color: #1d2d5d">' . ucfirst($key_field) . ': </label> <span>' . $value . '</span><br>';
                                        }
                                    } 
                                }
                                
                            }
                            ?>

                        </td>
                        <td valign="middle" class="column no-padding" align="left"
                            style=" padding-top: 0px; padding-bottom: 20px; background: #f9fdff; padding-left: 180px;">

                            <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; border-bottom: 1px solid #dddddd; font-weight: 600; padding: 5px 30px 5px 27px;">
                                Sub total : <span
                                        style="text-align: right; float: right">BDT {{ SM::order_currency_price_value($order->id,$order->sub_total) }}</span>
                            </p>
                            @if($order->tax>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; border-bottom: 1px solid #dddddd;  font-weight: 600; padding: 5px 30px 5px 27px;">
                                    Tax + Vat : <span
                                            style="text-align: right; float: right">{{SM::order_currency_price_value($order->id,$order->tax)}}</span>
                                </p>
                            @endif
                            @if($order->discount>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 30px 10px 27px;">
                                    Discount :<span
                                            style="text-align: right; float: right">-{{ SM::order_currency_price_value($order->id,$order->discount)}}</span>
                                </p>
                            @endif
                            @if($order->coupon_amount>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 30px 10px 27px;">
                                    Coupon :<span
                                            style="text-align: right; float: right"> -{{ SM::order_currency_price_value($order->id,$order->coupon_amount)}}</span>
                                </p>
                            @endif
                            @if($order->shipping_method_charge>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 30px 10px 27px;">
                                    Delivery charge :<span
                                            style="text-align: right; float: right">BDT {{ $order->shipping_method_charge}}</span>
                                </p>
                            @endif

                            <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 7px 30px 12px 27px; background-image: url(<?php echo asset('additional/images/total-bar.png');?>);
                                    background-repeat: no-repeat;
                                    ">Total amount
                                    
                                    <span style="text-align: right; float: right;">BDT {{ $order->grand_total  }}</span>
                            </p>
                        </td>
                    </tr>
                </table>
                <table width="100%" bgcolor="#f9fdff" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%; background: #f9fdff;" class="table-responsive">
                    <tr>
                        <td style="width: 60%;" class="column">

                        </td>
                        <td valign="middle" class="width100 padding-left30"
                            style="width: 40%; text-align: right; padding-right: 20px;">
                            <!-- <p> -->
                                <!-- <img src="{{ url($src) }}" alt="{{ $invoice_approved_by_name }}" style="width: 100%;"> -->
                            <!-- </p> -->
                            
                            <h3 style="font-size: 12px; font-weight: 700; color: #1d2d5d;">
                                {{ $invoice_approved_by_name }}
                            </h3>
                        </td>
                    </tr>
                </table>
                @endif
                <?php
                $email = SM::get_setting_value('email');
                $address = SM::get_setting_value('address');
                $country = SM::get_setting_value('country');
                ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%;margin-top: 0; padding-bottom: 0; margin-bottom: 0;"
                       class="table-responsive">
                    <tbody>
                    <tr style="background-color: #ccc;">
                        <!--<td class="single-table-pert" style="font-size: 16px; font-weight: 600; color: #fefefe; padding: 20px 0; text-align: center;" valign="middle">M : +01753 656542-->
                        <!--</td>-->
                    <!--     <td class="single-table-pert1"
                            style="font-size: 16px; font-weight: 300; vertical-align: middle; color: #222; padding-left: 30px;"> {{ $email }}
                        </td>
                        <td class="single-table-pert"
                            style="font-size: 16px; font-weight: 300; vertical-align: middle; color: #222; padding-right:20px; text-align: right;"
                            valign="middle"> {{ $address }}

                        </td> -->
                        <td class="single-table-pert" style="font-size: 13px; padding-top: 1px;padding-bottom: 3px font-weight: 300; vertical-align: middle; color: #222;text-align: center;">Powered by Next Page Technology Ltd. (Contact: +880 1300 446868)</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</center>
</body>
</html>