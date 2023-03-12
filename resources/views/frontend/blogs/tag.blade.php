@extends("frontend.master")
@section("title", $tagInfo->title)
@section("content")
    <?php
    $title = $tagInfo->title;
    $subtitle = "Tag";
    $bannerImage = SM::smGetThemeOption("blog_detail_banner_image");
    ?>
    <div class="columns-container">
        <div class="container" id="columns">
            @include('frontend.common.breadcrumb')
            <div class="row">
                <div class="col-sm-8">
                    @if(trim($tagInfo->description)!='' || $tagInfo->image != '')
                        <div class="single-blog-post-big single-blog-page category-post-item">
                            @empty(!$tagInfo->image)
                                <div class="blog-img">
                                    <img src="{!! SM::sm_get_the_src( $tagInfo->image , 748, 436) !!}"
                                         alt="{{ $tagInfo->title }}">
                                </div>
                            @endempty
                            @if(trim($tagInfo->description)!='')
                                <div class="blog-dec2 sm-content">
                                    {!! $tagInfo->description !!}
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