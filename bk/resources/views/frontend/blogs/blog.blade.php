@extends("frontend.master")
@section("title", "Blog")
@section("content")
    <?php
    $countStickyPost = count($stickyBlogPost);
    $isBreadcrumbEnable = SM::smGetThemeOption("blog_is_breadcrumb_enable", false);

    $pagination = [
        [
            "title" => "Blog"
        ]
    ];
    $title = SM::smGetThemeOption("blog_banner_title");
    $subtitle = SM::smGetThemeOption("blog_banner_subtitle");
    $bannerImage = SM::smGetThemeOption("blog_banner_image");
    ?>
    <!--BREADCRUMB END-->
    <div class="columns-container">
        <div class="container" id="columns">
            @include('frontend.common.breadcrumb')
            @if($countStickyPost>0)
                <div class="row mb60">
                    @foreach($stickyBlogPost as $blog)
                        <div class="col-lg-12">
                            <div class="blog-featured-post"
                                 style="background: url({!! SM::sm_get_the_src( $blog->image) !!})">
                                <div class="blog-featured-post-content">
                                    <a href="{!! url( "blog/$blog->slug" ) !!}">
                                        <div class="blog-featured-content text-center">
                                            <time>{{date("F d, Y", strtotime($blog->created_at))}}</time>
                                            <h3>{{$blog->title}}</h3>
                                            <p>{{$blog->short_description}}</p>
                                            <small class="doddle-btn "><span></span><b></b>Read More</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-sm-8">
                    <div class="row" id="sm_list">
                        @include('frontend.blogs.blog_list_item')
                    </div>
                </div>
                <div class="col-sm-4">
                    @include("frontend.blogs.blog_sidebar")
                </div>
            </div>
        </div>
    </div>
@endsection