@extends('frontend.master')
@section('title', '')
@include('frontend.common.popup')
@section('content')

    <section class="all-body-area">

        {{--slider--}}

        @include('frontend.common.slider')
        <div >

            <a href="" data-toggle="modal" class="btn btn-info hello" data-target="#myModal" style="    z-index: 999;
    background: #397d05;
    width: 270px;
    display: block;
    margin: 8px auto;
    border-radius: 25px;">
					 <p style="font-size: 23px" class="text-bling"><i class="fa fa-hand-o-right" aria-hidden="true" style="font-size: 35px;
    margin-top: 7px;
    margin-right: 24px;
    padding: 3px;
    /* border: 1px solid #ab0909; */
    height: 34px;
    width: 25px;
    line-height: 20px;
    border-radius: 50%;
    background: #397d05;"></i>Special Request </p><span style="font-size:17px;">(if not displayed)</span>
				</a></div>

                <br><br>

        @include('frontend.common.from_cart')
        {{--@include('frontend.common.rightCartBar')--}}
        @include('frontend.common.banar')
        @include('frontend.common.popular_category')
        @include('frontend.products.best_sellers')
        @include('frontend.inc.client_slider')


        
        
        {{--footer_top--}}
        @include('frontend.inc.footer_top')
        <section class="mobile-bottom-btn">
            <button>Start Shopping Now</button>
        </section>
        @include('frontend.inc.footer')
    </section>
@endsection