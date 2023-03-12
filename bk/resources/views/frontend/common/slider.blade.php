@if(isset($sliders) && count($sliders)>0)

    <?php

    $slider_change_autoplay = (int)SM::smGetThemeOption("slider_change_autoplay", 4);

    $slider_change_autoplay *= 3000;

    ?>
    
    <section class="slider-area">

        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">

            <ol class="carousel-indicators">

                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

                <li data-target="#myCarousel" data-slide-to="1"></li>

                <li data-target="#myCarousel" data-slide-to="2"></li>

            </ol>

            <div class="carousel-inner">

                @forelse($sliders as $key=> $slider)

                    <?php

                    if ($key == 0) {

                        $active = 'active';

                    } else {

                        $active = '';

                    }

                    ?>

                    <div class="item {{ $active }}">
                        <?php
                        
                        $property = SM::sm_unserialize($slider->extra);
                        $button_link = $property['button_link'][0];
                        
                        
                        
                        
                        ?>
                        <a href="{{$button_link}}" target="_blank">
                        <img src="{{SM::sm_get_the_src($slider->image)}}" alt="{!! $slider->title !!}">
                        
                        </a>

                    </div>

                @empty

                    <div class="item active">

                        <img src="{{asset('/frontend/')}}/img/slider/slider-1.png" alt="1">

                    </div>

                    <div class="item">

                        <img src="{{asset('/frontend/')}}/img/slider/slider-2.png" alt="2">

                    </div>

                    <div class="item">

                        <img src="{{asset('/frontend/')}}/img/slider/slider-3.png" alt="3">

                    </div>

                @endforelse

            </div>

            <!-- Left and right controls -->

            <a class="left carousel-control" href="#myCarousel" data-slide="prev">

                <i class="fa fa-chevron-left" area-hidden="true"></i>

                <span class="sr-only">Previous</span>

            </a>

            <a class="right carousel-control" href="#myCarousel" data-slide="next">

                <i class="fa fa-chevron-right" area-hidden="true"></i>

                <span class="sr-only">Next</span>

            </a>

        </div>

    </section> 
            
                <div class="scrolling-sec">
                    <div class="scrolling" style="font-size:45px;">
                         সেরা দামে সেরা বাজার,  ঘরে বসে হবে সবার
                    </div>
                </div>
                
                
                <!--<div class="ss" style=" border:5px solid #e30b13;overflow: hidden;">-->
                <!--    <div class="col-md-6" style="padding:0 ">-->
                <!--        <img src="https://shibleefarms.com/storage/uploads/105035810_910752296060535_2924115470627990249_n_1.jpg" class="img-responsive" style="width: 100%;">-->
                <!--    </div>-->
                <!--    <div class="col-md-6" style="padding:0 ">-->
                <!--    <iframe style="width: 100%;height: 357px;" src="https://www.youtube.com/embed/WcPhYmOfmIw?start=38" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
                <!--    </div>-->
                <!--</div>-->
      
    <style type="text/css">
        .scrolling-sec {
    overflow: hidden;
    padding: 10px;
    border: 1px solid #9bc203;
}
       div.scrolling {
    color: #e30b13;
    font-weight: bold;
    font-size: 18px;
    position: relative;
    -webkit-animation: scroll 20s infinite linear;
    -moz-animation: scroll 20s infinite linear;
    -o-animation: scroll 20s infinite linear;
    animation: scroll 20s infinite linear;
}
        @keyframes scroll{
            0%   {left: 100%;}
            100% {left: -100%;}
        }
        @-webkit-keyframes scroll{
            0%   {left: 100%;}
            100% {left: -100%;}
        }
    </style>

@endif

