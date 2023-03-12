@extends("nptl-admin/master")
@section("title","Barcode")
@section("content")
    <?php
    $site_name = SM::get_setting_value('site_name2');
    $mobile = SM::get_setting_value('mobile2');
    $email = SM::get_setting_value('email2');
    $address = SM::get_setting_value('address2');
    ?>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print, #section-to-print * {
                visibility: visible;
                /*color: white;*/
                /*font-size: 5rem;*/
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;

            }
        }

        #section-to-print {
            /*color: pink;*/
            /*background: #AAAAAA;*/
        }
    </style>
    <!-- row -->
@section('header_style')
    <link rel="stylesheet" type="text/css" media="print"
          href="http://kkshutki.nextpagetl.com/bootstrap/css/bootstrap.min.css?v=31">
@endsection
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
       <div class="container" id="section-to-print">
                                <div class="row" style="padding-bottom: 20px;border-bottom-style: dotted;">
                                    <div class="col-xs-4">
                                        <h3 style="border-bottom-style: dotted;"> প্রেরক </h3>
                                        <p>
                                            @if(!empty($site_name))
                                                <strong>কোম্পানি : </strong>{{$site_name}}
                                            @endif
                                        </p>
                                        @if(!empty($address))
                                            <p>
                                                <strong>ঠিকানা :</strong>
                                                <small class="text-center">
                                                    {!! $address !!}
                                                </small>
                                            </p>
                                        @endif
                                        <p>
                                            <small class="text-center">
                                                <strong>মোবাইল: </strong> {!! $mobile !!}
                                            </small>

                                            <small class="text-center">
                                                <br><strong>ইমেইল: </strong> {!! $email !!}
                                            </small>
                                        </p>


                                    </div>
                                    <div class="col-xs-4 text-center center-block">
                                        @if(!empty($barcode->invoice_no))
                                            <strong>চালান নং: </strong>{!! $barcode->invoice_no !!}
                                        @endif
                                        @if(!empty($barcode->create_date))
                                            <br><strong>তারিখ: </strong>{!! SM::showDateTime($barcode->create_date) !!}
                                        @endif
                                        <div style="padding: 20px 0; text-align: center;">
                                            <?php
                                            $bar_code_data = 'চালান নং: ' . $barcode->invoice_no . ' ক্রেতার নাম: ' . $barcode->name . ' ঠিকানা: ' . $barcode->address . ' সর্বমোট: ' . SM::barcode_currency_price_value($barcode->grand_total);
                                            ?>
                                            <img style=" height: 100px" class="center-block"
                                                 src="data:image/png;base64,{{DNS2D::getBarcodePNG($bar_code_data, "QRCODE",33,33)}}">
                                        </div>

                                    </div>
                                    <div class="col-xs-4">
                                        <h3 style="border-bottom-style: dotted;"> প্রাপক </h3>
                                        @if(!empty($barcode->name))
                                            <strong>ক্রেতার নাম: </strong>{!! $barcode->name !!}
                                        @endif

                                        <p>
                                            @if(!empty($barcode->address))

                                                <strong>ঠিকানা :</strong>
                                                <small class="text-center">
                                                    {!! $barcode->address !!}
                                                </small>
                                            @endif
                                            @if(!empty($barcode->mobile))
                                                <small class="text-center">
                                                    <br><strong>মোবাইল: </strong> {!! $barcode->mobile !!}
                                                </small>
                                            @endif
                                            @if(!empty($barcode->email))
                                                <small class="text-center">
                                                    <br><strong>ইমেইল: </strong> {!! $barcode->email !!}
                                                </small>
                                            @endif

                                            @if(!empty($barcode->grand_total))
                                                <br>
                                                <small class="text-center">
                                                    <strong>সর্বমোট: </strong> {!! SM::barcode_currency_price_value($barcode->grand_total) !!}
                                                </small>
                                            @endif
                                            @if(!empty($barcode->delivery))
                                                <br>
                                                <small class="text-center">
                                                    <strong>ডেলিভারি: </strong> {!! $barcode->delivery !!}
                                                </small>
                                            @endif
                                            @if(!empty($barcode->order_note))
                                                <br>
                                                <small class="text-center">
                                                    <strong>EMTS/মানি অর্ডার: </strong> {!! $barcode->order_note !!}
                                                </small>
                                            @endif

                                        </p>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </div>

    </div>
    <!-- end row -->
</section>
@endsection
@section('footer_script')
    <script>
        $(document).ready(function () {
            $(window).load(function () {
                //This execute when entire finished loaded
                window.print();
            });
        });
    </script>
@endsection
