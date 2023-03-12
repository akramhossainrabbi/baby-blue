@extends('frontend.master')
@section("title", "Buy in Bulk")
@section('content')
    <!-- page wapper-->
    <style>
        ul.categories li {
            display: inline-block;
            width: 32%;
            padding: 5px;
        }

    </style>
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
        @include('frontend.common.breadcrumb')
        <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-6 col-md-offset-3" id="center_column">
                    <!-- page heading-->
                    <h2 class="page-heading">
                        <span class="page-heading-title2">Thank You!</span>

                    </h2>
                    <!-- Content page -->
                    <div class="content-text clearfix">
                        We have recieved your enquiry and have sent you an acknowledgement mail to your email address.

                        We will go through the details you have provided and will get back to you soon...
                    </div>
                    <!-- ./Content page -->
                </div>
                <!-- ./ Center colunm -->
            </div>
            <!-- ./row-->
        </div>
    </div>
    <!-- ./page wapper-->
@endsection