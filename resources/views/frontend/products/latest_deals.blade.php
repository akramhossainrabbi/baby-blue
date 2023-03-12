<?php
$product_title = SM::smGetThemeOption("product_title", "");
$product_subtitle = SM::smGetThemeOption("product_subtitle", "");
$productsCount = count($latestDeals);
?>
@if($productsCount>0)
    <div class="box-products ">
        <div class="container">
            <div class="box-product-head">
                <span class="box-title">{{ $product_title }}</span>
            </div>
            <div class="box-product-content">
                <ul class="product-list owl-carousel " data-dots="false" data-loop="true" data-nav="true"
                    data-margin="30"
                    data-responsive='{"0":{"items":2},"500":{"items":2},"600":{"items":3},"1000":{"items":5}}'>
                    @foreach($latestDeals as $latestDeal)

                        @if($latestDeal->product_type==2)
                            <?php
                            $att_data = SM::getAttributeByProductId($latestDeal->id);
                            if (!empty($att_data->attribute_image)) {
                                $attribute_image = $att_data->attribute_image;
                            } else {
                                $attribute_image = $latestDeal->image;
                            }
                            ?>
                            <li>
                                <div class="">
                                    <a href="{{ url('product/'.$latestDeal->slug) }}">
                                        <img class="img-responsive carousel-img-height-col5"
                                             alt="{{ $latestDeal->title }}"
                                             src="{{ SM::sm_get_the_src($attribute_image, 200, 200) }}"/></a>
                                </div>
                                <div class="">
                                    <h5 class="product-name">
                                        <a href="{{ url('product/'.$latestDeal->slug) }}">
                                            {{ $latestDeal->title }}</a></h5>
                                    <div class="text-center parice-margin-left">
                                        <span class="price product-price">{{ SM::currency_price_value($att_data->attribute_price) }}</span>
                                    </div>
                                </div>
                                <div class="new-tag">
                                    <img src="{{ asset('/frontend') }}/image/new.png">
                                </div>
                                @if($latestDeal->sale_price>0)
                                    <div class="price-percentage">
                                        {{ SM::productDiscount($latestDeal->id) }}% OFF
                                    </div>
                                @endif
                            </li>
                        @else
                            <li>
                                <div class="">
                                    <a href="{{ url('product/'.$latestDeal->slug) }}">
                                        <img class="img-responsive carousel-img-height-col5"
                                             alt="{{ $latestDeal->title }}"
                                             src="{{ SM::sm_get_the_src($latestDeal->image, 200, 200) }}"/></a>
                                </div>
                                <div class="">
                                    <h5 class="product-name">
                                        <a href="{{ url('product/'.$latestDeal->slug) }}">
                                            {{ $latestDeal->title }}</a></h5>
                                    <div class="text-center parice-margin-left">
                                        @if($latestDeal->sale_price>0)
                                            <span class="price product-price">{{ SM::currency_price_value($latestDeal->sale_price) }}</span>
                                            <span class="price old-price">{{ SM::currency_price_value($latestDeal->regular_price) }}</span>
                                        @else
                                            <span class="price product-price">{{ SM::currency_price_value($latestDeal->regular_price) }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{ SM::productNew($latestDeal->id) }}

                                @if($latestDeal->sale_price>0)
                                    <div class="price-percentage">
                                        {{ SM::productDiscount($latestDeal->id) }}% OFF
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