@extends('frontend.master')

@section("title", $categoryInfo->title)

@section('content')

    @include('frontend.common.rightCartBar')

    <?php

    $title = SM::smGetThemeOption("product_banner_title");

    $subtitle = SM::smGetThemeOption("product_banner_subtitle");

    $bannerImage = SM::smGetThemeOption("product_banner_image");

    ?>



    <section class="inner-banner">

        <img alt="{{ $categoryInfo->title }}" src="{{ SM::sm_get_the_src($categoryInfo->image, 1635, 300) }}">

    </section>

    <section class="all-body-area">

        @include('frontend.products.product_sidebar')

        <section class="best-sellers">

            <div class="left-sellers">

                <div class="category-row search-category">

                    <h2>{{ $categoryInfo->title }}</h2>

                    <ul id="ajax_view_product_list">



                    </ul>

                </div>

            </div>

        </section>

    </section>
     {{--footer_top--}}

        @include('frontend.inc.footer_top')



        <section class="mobile-bottom-btn">

            <button>Start Shopping Now</button>

        </section>
    @include('frontend.inc.footer')

@endsection