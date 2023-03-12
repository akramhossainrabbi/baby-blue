<?php
$product_best_sale_is_enable = SM::smGetThemeOption("product_best_sale_is_enable", 1);
?>
@if($product_best_sale_is_enable==1)
    <?php
    $product_best_sale_per_page = SM::smGetThemeOption("product_best_sale_per_page", 6);
    $bestSaleProducts = SM::getBestSaleProduct($product_best_sale_per_page);
    //        var_dump($bestSaleProducts);
    //        exit();
    ?>
    @if(count($bestSaleProducts)>0)

        <div class="box-products" style="margin-top: 0px!important;">
            <div class="box-product-head">
                <span class="box-title">Bestsellers</span>
            </div>
            <div class="box-product-content">
                <ul class="product-list owl-carousel " data-dots="false" data-loop="true" data-nav="true"
                    data-margin="20"
                    data-responsive='{"0":{"items":2},"500":{"items":2},"600":{"items":4},"800":{"items":4}}'>
                    @foreach ($bestSaleProducts as $product)
                        @if($product->product_type == 2)
                            <?php
                            $att_data = SM::getAttributeByProductId($product->id);
                            if (!empty($att_data->attribute_image)) {
                                $attribute_image = $att_data->attribute_image;
                            } else {
                                $attribute_image = $product->image;
                            }
                            ?>
                            <li>
                                <div class="">
                                    <a href="{{ url('product/'.$product->slug) }}">
                                        <img class="img-responsive carousel-img-height-col5" alt="{{ $product->title }}"
                                             src="{{ SM::sm_get_the_src($attribute_image, 210, 295) }}"/>
                                    </a>
                                </div>
                                <div class="">
                                    <h5 class="product-name">
                                        <a href="{{ url('product/'.$product->slug) }}">
                                            {{ $product->title }}
                                        </a>
                                    </h5>
                                    <div class="text-center parice-margin-left">
                                        <span class="price product-price">{{ SM::currency_price_value($att_data->attribute_price) }}</span>
                                    </div>
                                </div>
                                <div class="new-tag">
                                    <img src="{{ asset('/frontend') }}/image/new.png">
                                </div>
                                @if($product->sale_price>0)
                                    <div class="price-percentage">
                                        {{ SM::productDiscount($product->id) }}% OFF
                                    </div>
                                @endif
                            </li>
                        @else
                            <li>
                                <div class="">
                                    <a href="{{ url('product/'.$product->slug) }}">
                                        <img class="img-responsive carousel-img-height-col5"
                                             alt="{{ $product->title }}"
                                             src="{{ SM::sm_get_the_src($product->image, 210, 295) }}"/></a>
                                </div>
                                <div class="">
                                    <h5 class="product-name">
                                        <a href="{{ url('product/'.$product->slug) }}">
                                            {{ $product->title }}
                                        </a>
                                    </h5>
                                    <div class="text-center parice-margin-left">
                                        @if($product->sale_price>0)
                                            <p class="price product-price"> {{ SM::currency_price_value($product->sale_price) }}</p>
                                        @else
                                            <p class="price product-price">{{ SM::currency_price_value($product->regular_price) }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="new-tag">
                                    <img src="{{ asset('/frontend') }}/image/new.png">
                                </div>
                                @if($product->sale_price>0)
                                    <div class="price-percentage">
                                        {{ SM::productDiscount($product->id) }}% OFF
                                    </div>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endif