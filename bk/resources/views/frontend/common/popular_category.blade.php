<?php
$product_show_advertisement = SM::smGetThemeOption("product_show_advertisement", 1);



?>
<style>.blink {
        animation: blinker 0.6s linear infinite;
        
        font-weight: bold;
        font-family: sans-serif;
      }
      @keyframes blinker {
        50% {
          opacity: .25;
        }
      }
      
      .blink1 {
        animation: blinker1 0.6s linear infinite;
        
        font-weight: bold;
        font-family: sans-serif;
      }
      @keyframes blinker1 {
        50% {
          opacity: .50;
        }
      }
      </style>

@if($product_show_advertisement==1)
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="addvertise">
                        <div id="demo2" class="scroll-text">
                            <ul>
                                <?php
                                $advertisements = SM::smGetThemeOption("product_sidebar_advertisement", array());
                        
                                ?>

                                @if(count($advertisements)>0)
                                <div class="ss" style=" border:5px solid #e30b13;overflow: hidden; margin-bottom:20px;">
                                    @foreach($advertisements as $advertisement)
                                        <?php
                                       
                                        $ad_title = isset($advertisement["title"]) ? $advertisement["title"] : "";
                                        
                                        $description = isset($advertisement["description"]) ? $advertisement["description"] : "";

                                        $ad_link = isset($advertisement["link"]) ? $advertisement["link"] : "";

                                        $ad_image = isset($advertisement["image"]) ? $advertisement["image"] : "";

                                        ?>
 
                                                <div class="col-md-6" style="padding:0 ">
                                                    <h1 style="text-align:center;color:#f00;line-height: 54px;border: 1px solid #88b502;" class="blink">{{ $ad_title }}</h1>
                                                    <p style="text-align:center;color:#429800;font-size: 20px;margin: 0px 10px;padding-top: 10px;line-height: 32px;" class="blink1">{{ $description }}</p>
                                                    
                                                    <a href="{{ $ad_link }}" target="_blank">

                                                <img class="img-responsive" src="{!! SM::sm_get_the_src($ad_image) !!}"

                                                     alt="">

                                            </a>
                                                    
                                                </div>
                                           
                                        
                                        

                                    @endforeach
                                     </div>

                                @endif

                            </ul>

                        </div>

                    </div>

                </div>

            @endif

@if(count($featured_categories)>0)
    <section class="category-pro">
        <h2>Popular Categories</h2>
        <div class="category-area">
<div class="row">
            @foreach($featured_categories as $catKey => $category)

                <div class="col-md-4 col-sm-4 col-xs-6">

                    <a class="cat-box" href="{{ url('/category-list/'.$category->slug) }}">

                        <h3>{{ $category->name }}</h3>

                        <div class="img-box">

                            <img class="img-responsive" alt="{{ $category->name }}" src="{{ SM::sm_get_the_src('ramadan_grocery_4.png') }}">

                        </div>

                    </a>

                </div>

            @endforeach
            </div>

        </div>

    </section>

@endif