@extends('frontend.master')
@section("title", "Catalogue")
@section('content')
    <!-- page wapper-->
    <style>

        @media (min-width: 768px) {
            .catalog li {
                display: inline-block;
                vertical-align: top;
                padding: 0 9px 18px;
                width: 33.333%;
                font-size: 17px;
                line-height: 22px;
            }

            .catalog img {
                display: block;
                float: none;
                width: 100%;
            }

            .catalog .descr {
                padding: 17px 20px;
            }

            .catalog h2 {
                margin: 0 0 10px;
                font-size: 18px;
                line-height: inherit;
            }
        }

        .catalog {
            font-size: 0;
            /*letter-spacing: -4px;*/
            margin: 0;
            padding: 0;
            list-style: none;
            margin: 0 0 50px;
        }

        .catalog a {
            overflow: hidden;
            display: block;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
            border-radius: 3px;
            color: #a6a6a6;
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
                <div class="center_column col-xs-12" id="center_column">
                    <!-- page heading-->
                    <h2 class="page-heading">
                        <span class="page-heading-title2">{{ SM::get_setting_value('site_name') }} CATALOGUES</span>

                    </h2>
                    <p>
                        Our catalogues help you choose the right products with ease.
                    </p>
                    <!-- Content page -->
                    <div class="content-text clearfix">
                        <ul class="catalog" id="catalog">
                            @foreach($catalogue_featured_categories as $catalogue)
                                <li id="catalog-item-55">
                                    <a href="{!! SM::sm_get_the_src($catalogue->catalogue_pdf) !!}" download="" id="catalog-link-55"
                                       alt="{{ $catalogue->catalogue_title }}">
                                        <img id="catalog-img-55" alt="{{ $catalogue->catalogue_title }}"
                                             src="{!! SM::sm_get_the_src($catalogue->catalogue_image, 369, 258) !!}">
                                        <div class="descr" id="catalog-description-55">
                                            <h2 id="catalog-title-55">{{ $catalogue->catalogue_title }}</h2>
                                            <p id="catalog-text-55">{{ $catalogue->catalogue_description }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
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