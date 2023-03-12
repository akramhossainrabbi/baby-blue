<?php
$features = SM::smGetThemeOption("features", array());
?>
@if(count($features)>0)
    <div class="hot-deals-row">
        <div class="container">
            <div class="hot-deals-box">
                <div class="row">
                    @foreach($features as $feature)
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            @isset($feature["feature_image"])
                                <div class="hot-deals-tab">
                                    <a href="{{ $feature["feature_link"] }}">
                                        <img alt="{{ $feature["feature_title"] }}"
                                             src="{!! SM::sm_get_the_src($feature["feature_image"], 270,277) !!}">
                                    </a>
                                </div>
                            @endisset
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif