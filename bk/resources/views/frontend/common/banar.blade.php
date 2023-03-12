<?php


$property = SM::sm_unserialize(SM::get_setting_value('sm_theme_options_home_setting'));
$left_image = $property['middle_left_add'];
$right_image = $property['middle_right_add'];




?>


<section class="category-pro">

        <div class="category-area">

           
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">

                    
                <div class="banar-image-box">
                     <a href=""><img src="{{ SM::sm_get_the_src($left_image) }}" class="img-responsive"></a>
                </div>
                   
                   
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    
            
                   
                    <div class="banar-image-box">
                    <a href=""><img src="{{ SM::sm_get_the_src($right_image) }}" class="img-responsive"></a>
                </div>
                </div>
                </div>
           

        </div>

    </section>