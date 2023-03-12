<?php
$recommended_product_title = SM::smGetThemeOption("recommended_product_title", "");
$recommended_product_subtitle = SM::smGetThemeOption("recommended_product_subtitle", "");
$recommendedProductsCount = count($recommendedProducts);
?>
@if($recommendedProductsCount>0)
    <div class="box-products ">
        <div class="container">

            <div class="box-product-head">
                <span class="box-title">{{ $recommended_product_title }}</span>
            </div>
            <div class="box-product-content">
                <ul class="product-list owl-carousel " data-dots="false" data-loop="true" data-nav="true"
                    data-margin="30"
                    data-responsive='{"0":{"items":2},"500":{"items":2},"600":{"items":3},"1000":{"items":4}}'>
                    @foreach($recommendedProducts as $recommended)
                        @if($recommended->product_type==2)
                            <?php
                            $att_data = SM::getAttributeByProductId($recommended->id);
                            if (!empty($att_data->attribute_image)) {
                                $attribute_image = $att_data->attribute_image;
                            } else {
                                $attribute_image = $recommended->image;
                            }
                            ?>
                            <li>
                                <div class="">
                                    <a href="{{ url('product/'.$recommended->slug) }}">
                                        <img class="img-responsive carousel-img-height-col4"
                                             alt="{{ $recommended->title }}"
                                             src="{{ SM::sm_get_the_src($attribute_image, 270, 390) }}"></a>
                                </div>
                                <div class="">
                                    <h5 class="product-name">
                                        <a href="{{ url('product/'.$recommended->slug) }}">{{ $recommended->title }}</a>
                                    </h5>
                                    <div class="text-center parice-margin-left">
                                        <span class="price product-price">{{ SM::currency_price_value($att_data->attribute_price) }}</span>
                                    </div>
                                </div>
                                <div class="new-tag">
                                    <img src="{{ asset('/frontend') }}/image/new.png">
                                </div>
                                @if($recommended->sale_price>0)
                                    <div class="price-percentage-home">
                                        {{ SM::productDiscount($recommended->id) }}% OFF
                                    </div>
                                @endif
                            </li>
                        @else
                            <li>
                                <div class="">
                                    <a href="{{ url('product/'.$recommended->slug) }}">
                                        <img class="img-responsive carousel-img-height-col4"
                                             alt="{{ $recommended->title }}"
                                             src="{{ SM::sm_get_the_src($recommended->image, 270, 390) }}"></a>
                                </div>
                                <div class="">
                                    <h5 class="product-name">
                                        <a href="{{ url('product/'.$recommended->slug) }}">{{ $recommended->title }}</a>
                                    </h5>
                                    <div class="text-center parice-margin-left">
                                        @if($recommended->sale_price>0)
                                            <span class="price product-price">{{ SM::currency_price_value($recommended->sale_price) }}</span>
                                            <span class="price old-price">{{ SM::currency_price_value($recommended->regular_price) }}</span>
                                        @else
                                            <span class="price product-price">{{ SM::currency_price_value($recommended->regular_price) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="new-tag">
                                    <img src="{{ asset('/frontend') }}/image/new.png">
                                </div>
                                @if($recommended->sale_price>0)
                                    <div class="price-percentage-home">
                                        {{ SM::productDiscount($recommended->id) }}% OFF
                                    </div>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif