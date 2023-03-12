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
                          
                            @if(!empty($order))
                                <?php
                                
                               
                                $name = $order->name;
                                
                                $address = $order->address;
                                $mobile = $order->mobile;
                                
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
                                    {{ $mobile }}</p>

                               

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
                                <span style="color: #1d2d5d; font-weight: 400; ">Invoice no</span> : {{ $order->id }}
                            </p>
                            <p class="text-left"
                               style="font-size: 13px; margin-right: 38px; font-weight: 500; color: #1d2d5d; padding-left: 20px; text-align: left">
                                <span style='color: #1d2d5d; font-weight: 400'>Date :</span>
                                {{ date('d-m-Y', strtotime($order->created_at)) }}
                            </p>
                            

                        </td>
                    </tr>
                </table>
                
                @if(count($order)>0)
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
                                Product Name
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
                            
                        </tr>
                        <?php 

                                                       

                            $product_name = json_decode($order->product_name);

                            $product_qty = json_decode($order->product_qty);
             
                            $i=1;

                        ?>

                        @foreach($product_name as $key=>$detail)
                            
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="width: 5%;border-bottom: 1px solid #dddddd; vertical-align: middle;text-align: center;padding-bottom: 3px; padding-top: 1px;font-size: 12px">{{$i}}</td>
                                <td style="width: 50%;border-bottom: 1px solid #dddddd;vertical-align: middle; text-align: left;padding-bottom: 3px; padding-top: 1px;font-size: 12px">
                                    
                                        {{ $detail }}
                                   

                                </td>
                                <td style="width: 45%; ">
                                    {{$product_qty[$key]  }}
                                </td>

                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </table>
                @endif
                
                
            </td>
        </tr>
    </table>
</center>
</body>
</html>