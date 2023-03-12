@extends('frontend.master')
@section("title", "About")
@section('content')
    <!-- page wapper-->
    <?php
    $wwrTitle = SM::smGetThemeOption("wwr_title");
    $wwrSubtitle = SM::smGetThemeOption("wwr_subtitle");
    $wwrDescription = SM::smGetThemeOption("wwr_description");
    $ourMission = SM::smGetThemeOption("our_mission");
    $ourVision = SM::smGetThemeOption("our_vision");
    $histories = SM::smGetThemeOption("histories");
    $historiesCount = count($histories);
    $title = SM::smGetThemeOption("about_banner_title");
    $subtitle = SM::smGetThemeOption("about_banner_subtitle");
    $bannerImage = SM::smGetThemeOption("about_banner_image");
    ?>
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
        @include('frontend.common.breadcrumb')
        <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Left colunm -->
                <div class="column col-xs-12 col-sm-3" id="left_column">
                    <!-- block category -->
                    @if(count($pageInfo)>0)
                        <div class="block left-module">
                            <p class="title_block">Infomations</p>
                            <div class="block_content">
                                <!-- layered -->
                                <div class="layered layered-category">
                                    <div class="layered-content">
                                        <ul class="tree-menu">
                                            <li class="active"><span></span><a href="{{ url('/about') }}">About Us</a>
                                            </li>
                                            @foreach($pageInfo as $page)
                                                <li><span></span><a href="{{ $page->slug }}">{{ $page->page_title }}</a>
                                                </li>
                                            @endforeach
                                            <li><span></span><a href="{{ url('/contact') }}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- ./layered -->
                            </div>
                        </div>
                    @endif
                <!-- ./block category  -->
                    <?php
                    $about_page_add_link = SM::smGetThemeOption("about_page_add_link", "#");
                    $about_page_add = SM::smGetThemeOption("about_page_add");
                    ?>
                    @empty(!$about_page_add)
                    <!-- Banner silebar -->
                        <div class="block left-module">
                            <div class="banner-opacity">
                                <a href="{!! $about_page_add_link !!}">
                                    <img src="{!! SM::sm_get_the_src( $about_page_add, 319,389 ) !!}"
                                         alt="ads-banner" class="image-style">
                                </a>
                            </div>
                        </div>
                        <!-- ./Banner silebar -->
                    @endempty
                </div>
                <!-- ./left colunm -->
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-9" id="center_column">
                    <!-- page heading-->
                    <h2 class="page-heading">
                        @empty(!$title)
                            <span class="page-heading-title2">{{$title}}</span>
                        @endempty

                    </h2>
                    <!-- Content page -->
                    <div class="content-text clearfix">
                        <p>{!! stripslashes($wwrDescription) !!}</p>
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