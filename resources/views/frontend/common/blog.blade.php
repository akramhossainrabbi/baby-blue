<?php
$blog_title = SM::smGetThemeOption("blog_title", "");
$blog_subtitle = SM::smGetThemeOption("blog_subtitle", "");
$blogsCount = count($blogs);
?>
@if($blogsCount>0)
    <!--LATEST BLOG START-->
    <div class="box-products">
        <div class="container">
            <div class="box-product-head">
                <span class="box-title">{{ $blog_title }}</span>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper-container latest-blog">
                        <div class="swiper-wrapper">
                            @foreach($blogs as $blog)
                                <div class="swiper-slide">
                                    <div class="latest-blog">
                                        <div class="blog-top">
                                            <?php
                                            $sdTitle = strip_tags(stripslashes($blog->title), "<br><i><b>");
                                            $sdSubTitle = substr($sdTitle, 0, 50);
                                            $sdTitle = (strlen($sdTitle) > 50) ? $sdSubTitle . " ....." : $sdSubTitle;
                                            $likeInfo['id'] = $blog->id;
                                            $likeInfo['type'] = 'blog';

                                            $blogUrl = url("blog/" . $blog->slug);
                                            ?>
                                            <div class="blog-img">
                                                <a href="#">
                                                    <img
                                                            src="{!! SM::sm_get_the_src($blog->image, 358, 200) !!}"
                                                            alt=" {{ $sdTitle }}">
                                                </a>
                                            </div>
                                            <div class="home-blog-meta">
                                                <a href="javascript:0" class="mrks_like"
                                                   data-id="{{ urlencode(base64_encode($blog->id)) }}"
                                                   data-type="blog">
                                                    <i class="fa fa-heart"></i>
                                                    {{ SM::getCountTitle($blog->likes, 'Like') }}
                                                </a>
                                                <a href="{{ $blogUrl }}">
                                                    <i class="fa fa-comments"></i>
                                                    {{ SM::getCountTitle($blog->comments, 'Comment') }}
                                                </a>
                                                <a href="{{ $blogUrl }}">
                                                    <i class="fa fa-eye"></i>
                                                    {{ SM::getCountTitle($blog->views, 'View') }}
                                                </a>
                                                <div class="b-date">
                                                    <strong>{{ date("d", strtotime($blog->created_at)) }}</strong>
                                                    <b>{{ date("F-y", strtotime($blog->created_at)) }}</b>
                                                </div>
                                            </div>
                                            <h3 class="blog-title"><a
                                                        href="{!! $blogUrl !!}">
                                                    {!! $sdTitle  !!}
                                                </a>
                                            </h3>
                                            <?php
                                            $des = $blog->short_description;
                                            $des = ($des != '') ? $des : $blog->long_description;
                                            $sd = strip_tags(stripslashes($des), "<br><b>");
                                            $sdSub = substr($sd, 0, 140);
                                            $sd = (strlen($sd) > 140) ? $sdSub . " ....." : $sdSub;
                                            ?>
                                            <p>{!! $sd !!}</p>
                                        </div>
                                        <div class="blog-author pull-left">
                                            <img src="{!! SM::sm_get_the_src($blog->user->image, 80, 80) !!}"
                                                 alt="{{ $blog->user->username }}">
                                            <p>Posted by</p>
                                            <?php
                                            $fname = $blog->user->firstname . ' ' . $blog->user->lastname;
                                            $fname = ($fname != '') ? $fname : $blog->user->username;
                                            ?>
                                            <p class="name">{{ $fname }}</p>
                                        </div>
                                        <a href="{!! $blogUrl !!}" class="pull-right b_readMore">Read
                                            More</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="testmonial-control blog-pagi">
                        {{--<div class="owl-prev" style=""><i class="fa fa-angle-left"></i></div>--}}
                        <div class="tbtn tprev">
                            <img src="{!! asset('/additional/images/arrow-left.png') !!}"
                                                     alt="arrow left">
                        </div>
                        {{--<div class="owl-next" style=""><i class="fa fa-angle-right"></i></div>--}}
                        <div class="tbtn tnext">
                            {{--<i class="fa fa-angle-right"></i>--}}
                            <img src="{!! asset('/additional/images/arrow-right.png') !!}"
                                                     alt="arrow left">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--LATEST BLOG END-->
@endif