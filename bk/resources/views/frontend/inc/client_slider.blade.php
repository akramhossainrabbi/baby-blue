<?php
$product_show_testimonial = SM::smGetThemeOption("product_show_testimonial", 1);
?>
@if($product_show_testimonial==1)
    <?php
    $testimonialTitle = SM::smGetThemeOption("testimonial_title");
    $testimonials = SM::smGetThemeOption("testimonials");
    $testimonialsCount = count($testimonials);
    ?>
    @if(!empty($testimonials))
    <section class="client-slider">

   <h1>{{ $testimonialTitle }}</h1>
    <div id="clientCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#clientCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#clientCarousel" data-slide-to="1"></li>
            <li data-target="#clientCarousel" data-slide-to="2"></li>
            <li data-target="#clientCarousel" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
             @foreach($testimonials as $tKey=> $testimonial)
                        <?php
                        if ($tKey == 0) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        ?>
            <div class="item {{ $active }}">
                <div class="blog-area">
                     <div class="client_profile_img">
                        <img alt="{{ $testimonial["title"] }}"
                                        src="{!! SM::sm_get_the_src($testimonial["testimonial_image"], 146, 146) !!}">
                     </div>
                    <div class="txt-area">
                        <h2>{{ $testimonial["title"] }}</h2>
                         @empty(!$testimonial["description"])
                                        <p>{{ $testimonial["description"] }}</p>
                                    @endif
                    </div>
                </div>
            </div>
            
                    @endforeach
            
            
            
        </div>
        <a class="left carousel-control" href="#clientCarousel" data-slide="prev">
            <span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#clientCarousel" data-slide="next">
            <span><i class="fa fa-angle-right" aria-hidden="true"></i> </span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>



       
    @endif
@endif