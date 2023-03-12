@extends("frontend.master")
@section("title", "Search result for '".htmlentities($s)."'")
@section("content")
    <!--BREADCRUMB START-->
    <section class="page-banner-section ab-banner-sec dod-search-banner">
        <div class="page-banner-section-inner">
            <div class="container">
                <div class="s-b-content">
                    <div class="blog-banner-contents text-center clearfix">
                        <div class="error-search-form">
                            <form action="{!! url("search") !!}" method="get">
                                <input name="s" type="search" placeholder="Search your keyword..."
                                       value="{!! htmlentities($s) !!}">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="ab-page-breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-breadcrumb text-center">
                            <h2 class="ab-search-result-title">SEARCH RESULTS FOR "{!! htmlentities($s) !!}"</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--BREADCRUMB END-->
    <section class="common-section contact-us-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    @if(count($results)>0)
                        @foreach($results as $single)
                            <?php
                            $singleInfo['info'] = $single;
                            if ($type == 'Blog') {
                                $singleInfo["description"] = $single->short_description;
                                $singleInfo["image"] = SM::sm_get_the_src($single->image, 358, 263);
                                $singleInfo['url'] = url('blog/' . $single->slug);
                            } else {
                                $singleInfo["description"] = "";
                                $singleInfo["image"] = "";
                                $singleInfo['url'] = "";
                            }
                            ?>
                            @include("frontend.blogs.search_item", $singleInfo)
                        @endforeach
                </div>
                <div class="col-sm-4">
                    @include("frontend.blogs.blog_sidebar")
                </div>
            </div>

            @else
                <div class="alert alert-info">
                    <i class="fa fa-info"></i> No Results Found!
                </div>
            @endif
        </div>
    </section>
@endsection