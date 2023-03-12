@extends("frontend.master")
@section("title", $categoryInfo->title)
@section("content")
    <?php
    $title = $categoryInfo->title;
    $subtitle = "Category";
    $bannerImage = SM::smGetThemeOption("blog_detail_banner_image");
    ?>
    <div class="columns-container">
        <div class="container" id="columns">
            @include('frontend.common.breadcrumb')
            <div class="row">
                <div class="col-sm-8">
                    @if(trim($categoryInfo->description)!='' || $categoryInfo->image != '')
                        <div class="single-blog-post-big single-blog-page category-post-item">
                            @empty(!$categoryInfo->image)
                                <div class="blog-img">
                                    <img src="{!! SM::sm_get_the_src( $categoryInfo->image , 748, 436) !!}"
                                         alt="{{ $categoryInfo->title }}">
                                </div>
                            @endempty
                            @if(trim($categoryInfo->description)!='')
                                <div class="blog-dec2 sm-content">
                                    {!! $categoryInfo->description !!}
                                </div>
                            @endif
                        </div>
                    @endif
                    @include('frontend.blogs.blog_list_item', ['blogPost'=>$blogs])
                </div>
                <div class="col-sm-4">
                    @include("frontend.blogs.blog_sidebar")
                </div>
            </div>
        </div>
    </div>
@endsection