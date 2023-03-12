@extends('frontend.master')

@section('title', 'Shop')

@section('content')

    @include('frontend.common.rightCartBar')

    <?php

    $title = SM::smGetThemeOption("product_banner_title");

    $subtitle = SM::smGetThemeOption("product_banner_subtitle");

    $bannerImage = SM::smGetThemeOption("product_banner_image");

    ?>

    <section class="inner-banner">

        <img alt="{{ $title }}" src="{{ SM::sm_get_the_src($bannerImage, 1635, 300) }}">

    </section>
    <section class="all-body-area">

        @include('frontend.products.product_sidebar')

        <section class="best-sellers">

            <div class="left-sellers"> 

                <div class="category-row search-category product-gallery-list">

                    <h2>{{ $title }}</h2>

                    <ul class="product-gallery-ul" id="ajax_view_product_list">



                    </ul>
                    
                </div>



            </div>

        </section>

    </section>

    @include('frontend.inc.footer')

@endsection