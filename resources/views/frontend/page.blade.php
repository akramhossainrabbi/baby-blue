@extends('frontend.master')
@section("title",$page->page_title)
@section("content")
    <section class="all-body-area">
        <div id="main">
            <section class="about-page-area">
                <div class="header-blog">
                    <h2>{{ $page->menu_title }}</h2>
                    <h6>{{ $page->page_subtitle }}</h6>
                </div>
                <div class="text-page-blog">
                    <p>{!! stripslashes( $page->content ) !!}</p>
                </div>
            </section>
        </div>
    </section>
    @include('frontend.inc.footer')
@endsection