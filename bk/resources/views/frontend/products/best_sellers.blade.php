<?php

$product_title = SM::smGetThemeOption("product_title", "");

$product_subtitle = SM::smGetThemeOption("product_subtitle", "");

$product_show = SM::smGetThemeOption("product_show", 15);



//$bestSaleProducts = SM::getBestSaleProduct($product_show);

$bestSaleProducts = $latestDeals;

//dd($bestSaleProducts);



?>

@if(count($bestSaleProducts)>0)

<section class="best-sellers" style="background: #ffff;">

    <div class="left-sellers">

        <div class="category-row">

            <h2>Our Popular Items</h2>

            {{--<div class="jcarousel-wrapper">--}}

            {{--<div class="jcarousel">--}}

            <ul>

                @foreach($bestSaleProducts as $bestSale)




                @if($bestSale->product_type==2)

                <?php

                $att_data = SM::getAttributeByProductId($bestSale->id);

                $att_datas = \App\Model\Common\AttributeProduct::where('product_id', $bestSale->id)->get();

                ?>

                <li>

                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6">

                        <div class="best-box cat-best-box">

                            <a href="{{ url('product_detail/'.$bestSale->id) }}">

                                <div class="pro-box">

                                    <img alt="{{ $bestSale->title }}"
                                        src="{{ SM::sm_get_the_src($bestSale->image,200,200) }}" class="img-responsive">

                                    <div class="middle">

                                        <i class="fa fa-search fa-2x"></i>

                                        <?php echo SM::wishlistHtml($bestSale->id); ?>

                                    </div>

                                </div>

                            </a>

                            <a href="{{ url('product_detail/'.$bestSale->id) }}">

                                <h3>{{ $bestSale->title }}</h3>
                            </a>

                            <div class="sku-prop-content product_attribute_size">

                                @if(count($att_datas)>0)

                                @foreach($att_datas as $sKe=> $p_size)

                                <label data-att_id="{{ $p_size->id }}" for="size_{{ $sKe }}_{{ $p_size->product_id }}"
                                    class="product_att_size">

                                    <div class="check-box_inr_size">

                                        <div class="size

                                       {{--{!! $sKe==0 ? 'size_active': '' !!}--}}

                                                                    ">

                                            <span class="value"><b>

                                                    <?php echo SM::productWeightCal($p_size->attribute->title); ?>

                                                </b></span>

                                            <input data-price="{{ $p_size->attribute_price }}"
                                                data-id="{{ $p_size->id }}" data-product_id="{{ $p_size->product_id }}"
                                                class="product_att_size hidden"
                                                id="size_{{ $sKe }}_{{ $p_size->product_id }}"
                                                name="product_attribute_size" {{--{!! $sKe==0 ? 'checked': '' !!}--}}
                                                type="radio" value="{{ $p_size->id }}">

                                        </div>

                                    </div>

                                </label>

                                @endforeach
                                @endif
                            </div>
                            <h2 class="att_price">
                                {{-- {{ SM::currency_price_value($att_data->attribute_price) }} --}}
                            </h2>
                            <?php echo SM::addToCartButton($bestSale->id, $bestSale->regular_price, $bestSale->sale_price); ?>
                        </div>
                    </div>
                </li>
                @else
                <li>
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <div class="best-box cat-best-box">
                            <div class="product_card_box">
                                <a href="{{ url('product_detail/'.$bestSale->id) }}">
                                    <div class="pro-box">
                                        <img alt="{{ $bestSale->title }}" src="{{ SM::sm_get_the_src($bestSale->image) }}"
                                            class="img-responsive">
                                        <div class="middle">
                                            <i class="fa fa-search fa-2x"></i>
                                            <?php echo SM::wishlistHtml($bestSale->id); ?>
                                        </div>
                                    </div>
                                </a>
                                <?php
                                $discount_price = 0;
                                $weighted_status = $bestSale->weighted;
                                if ($weighted_status == 1) {
                                    $weight = SM::productWeightCal_new($bestSale->product_weight, $bestSale->unit_id);
                                } else {
                                    $weight = "";
                                } ?>
                                @if($bestSale->discount_type !=3)
                                <?php
                                $discount_price =  SM::getDiscountAmount($bestSale->discount_type, $bestSale->discount_value, $bestSale->variation->regular_price);
                                ?>
                                @if($discount_price>0)
                                <div class="price-card"><span>{{ $discount_price }} Tk</span> OFF </div>
                                @endif
                                @endif
                                <a href="{{ url('product_detail/'.$bestSale->id) }}">
                                    <h3>{{ $bestSale->name }} </h3>
                                </a>
                                <h3 class="product-price">
                                    <span
                                        style="float: left; color: #9cc400"><?php echo SM::productWeightCal($bestSale->product_weight, $bestSale->unit_id); ?></span>
                                    <span style="float: right;">
                                        @if($bestSale->discount_type !=3)
                                        {{ SM::currency_price_value($bestSale->regular_price- $discount_price) }}{{$weight}}
                                        <del>{{ SM::currency_price_value($bestSale->regular_price) }}
                                        </del>
                                        @else
                                        {{ SM::currency_price_value($bestSale->regular_price) }} {{$weight}}
                                        @endif
                                    </span>
                                </h3>
                                <div class="product_card_overlay">
                                    <div class="overlay_title">
                                        @php 
                                            echo SM::addToCartButton3($bestSale->id,$bestSale->product_qty); 
                                         @endphp
                                    </div>
                                    <div class="overlay_product_details">
                                        <a href="{{ url('product_detail/'.$bestSale->id) }" class="btn btn-sm"> View Details</a>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="1" class="productCartQty qty-inc-dc" id="qty ">
                            <?php echo SM::addToCartButton2($bestSale->id, $bestSale->product_qty); ?>
                        </div>
                    </div>
                </li>
                @endif
                @endforeach
            </ul>

            {{--</div>--}}

            {{--<a href="#" class="jcarousel-control-prev"><i class="fa fa-arrow-left"--}}

            {{--area-hidden="true"></i></a>--}}

            {{--<a href="#" class="jcarousel-control-next"><i class="fa fa-arrow-right"--}}

            {{--area-hidden="true"></i></a>--}}

            {{--</div>--}}

        </div>

    </div>

</section>

<!-- 
<script>
    function myShippingCart () {

    }
</script> -->



@endif























