<?php

$home_service_title = SM::smGetThemeOption("home_service_title", "");

$home_service_subtitle = SM::smGetThemeOption("home_service_subtitle", "");

$services = SM::smGetThemeOption("services", array());

$home_service_video_link = SM::smGetThemeOption("home_service_video_link", "");

$product_show_advertisement = SM::smGetThemeOption("product_show_advertisement", 1);

?>

@if(count($services)>0)

    <section class="about-sell" style="background: #8ed4e666;">

        

                <div class="abouter-box">

                    <div class="row">

                        @foreach($services as $service)

                            <?php
                            $title = isset($service["title"]) ? $service["title"] : "";
                            $description = isset($service["description"]) ? $service["description"] : "";
                            $link = isset($service["link"]) ? $service["link"] : "";
                            $service_image = isset($service["service_image"]) ? $service["service_image"] : "";
                            ?>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <div class="ab-box">

                                    <img src="{!! SM::sm_get_the_src($service_image, 80, 80) !!}"

                                         alt="{{ $title }}">

                                    <h2>{{ $title }} </h2>

                                    <p>{!! strip_tags($description, "<br><span><i><b>") !!}</p>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            

    </section>

@endif