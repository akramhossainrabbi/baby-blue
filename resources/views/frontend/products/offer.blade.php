<?php

$product_title = SM::smGetThemeOption("product_title", "");

$product_subtitle = SM::smGetThemeOption("product_subtitle", "");

$product_show = SM::smGetThemeOption("product_show", 15);



//$bestSaleProducts = SM::getBestSaleProduct($product_show);

$bestSaleProducts = $latestDeals;

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

                                        <a href="{{ url('product/'.$bestSale->slug) }}">

                                            <div class="pro-box">

                                                <img alt="{{ $bestSale->title }}"

                                                     src="{{ SM::sm_get_the_src($bestSale->image,200,200) }}" class="img-responsive">

                                                <div class="middle">

                                                    <i class="fa fa-search fa-2x"></i>

                                                    <?php echo SM::wishlistHtml($bestSale->id); ?>

                                                </div>

                                            </div>

                                        </a>

                                        <a href="{{ url('product/'.$bestSale->slug) }}">

                                            <h3>{{ $bestSale->title }}</h3></a>

                                        <div class="sku-prop-content product_attribute_size">

                                            @if(count($att_datas)>0)

                                                @foreach($att_datas as $sKe=> $p_size)

                                                    <label data-att_id="{{ $p_size->id }}"

                                                           for="size_{{ $sKe }}_{{ $p_size->product_id }}"

                                                           class="product_att_size">

                                                        <div class="check-box_inr_size">

                                                            <div class="size

              {{--{!! $sKe==0 ? 'size_active': '' !!}--}}

                                                                    ">

                                                                        <span class="value"><b>

                                                                                <?php echo SM::productWeightCal($p_size->attribute->title); ?>

                                                                            </b></span>

                                                                <input data-price="{{ $p_size->attribute_price }}"

                                                                       data-id="{{ $p_size->id }}"

                                                                       data-product_id="{{ $p_size->product_id }}"

                                                                       class="product_att_size hidden"

                                                                       id="size_{{ $sKe }}_{{ $p_size->product_id }}"

                                                                       name="product_attribute_size"

                                                                       {{--{!! $sKe==0 ? 'checked': '' !!}--}}

                                                                       type="radio" value="{{ $p_size->id }}">

                                                            </div>

                                                        </div>

                                                    </label>

                                                @endforeach

                                            @endif

                                        </div>

                                        <h2 class="att_price">

                                                {{-- {{ SM::currency_price_value($att_data->attribute_price) }}   --}}

                                        </h2>

                                        <?php echo SM::addToCartButton($bestSale->id, $bestSale->regular_price, $bestSale->sale_price); ?>

                                    </div>

                                </div>

                            </li>

                        @else
                            
                            <li>

                                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6">

                                    <div class="best-box cat-best-box">
                                   
                                        <a href="{{ url('product/'.$bestSale->slug) }}">

                                            <div class="pro-box">

                                                <img alt="{{ $bestSale->title }}"

                                                     src="{{ SM::sm_get_the_src($bestSale->image,200,200) }}" class="img-responsive">

                                                <div class="middle">

                                                    <i class="fa fa-search fa-2x"></i>

                                                    <?php echo SM::wishlistHtml($bestSale->id); ?>

                                                </div>

                                            </div>

                                        </a>
                                        <?php
                                        $weighted_status = $bestSale->weighted;
                                        if($weighted_status == 1)
                                        {
                                            $weight = SM::productWeightCal_new($bestSale->product_weight, $bestSale->unit_id);
                                        }
                                        else
                                        {
                                            $weight = "";
                                        }?>
                                        @if($bestSale->sale_price>0)
                                        <?php 
                                        
                                        $discount_data =  $bestSale->regular_price - $bestSale->sale_price; 
                                        $discount_percent = ($discount_data / $bestSale->regular_price ) * 100 ;
                                        $discount_percent = number_format($discount_percent, 2) ;
                                        $discount_data = number_format($discount_data, 0) ;
                                        
                                        
                                       
                                        ?>
                                        <div class="price-card"><span>{{$discount_data}} Tk</span>  OFF </div>
                                        @endif
                                        <a href="{{ url('product/'.$bestSale->slug) }}">

                                            <h3>{{ $bestSale->title }} </h3></a>

                                        
                                                    <h3 class="product-price"> 
                                                        <span style="float: left; color: #9cc400"><?php echo SM::productWeightCal($bestSale->product_weight, $bestSale->unit_id); ?></span>
                                                        <span style="float: right;">
                                                            @if($bestSale->sale_price>0)

                                           {{ SM::currency_price_value($bestSale->sale_price) }}{{$weight}}

                                                <del>{{ SM::currency_price_value($bestSale->regular_price) }} </del>

                                            

                                        @else

                                            {{ SM::currency_price_value($bestSale->regular_price) }} {{$weight}}

                                            

                                        @endif
                                                        </span>
                                                    </h3>
                                                      

                                                

                                        

                                    
                                               <input type="hidden" value="1" class="productCartQty qty-inc-dc" id="qty ">

                                        <!--<?php echo SM::addToCartButton($bestSale->id, $bestSale->regular_price, $bestSale->sale_price, $bestSale->product_qty, $bestSale->slug); ?>-->
                                        <?php echo SM::addToCartButton2($bestSale->id,$bestSale->product_qty); ?>



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

@endif