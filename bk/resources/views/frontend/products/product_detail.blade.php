@extends('frontend.master')
@section("title", $product->title)
@section("content")

<!-- Add the slick-theme.css if you want default styling -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css"/> -->
<!-- Add the slick-theme.css if you want default styling -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css"/> -->


<?php
// echo "<pre>";
// print_r($product);
// die;


?>
<section class="all-body-area">
    <section class="product-details-page">
        <div class="detail-section">
            <div class="row">
                <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                    <div class="slide-product">
                        <div class="w3-content" style="max-width:1200px">
                            <img alt="{{ $product->title }}" class="mySlides"
                                src="{!! SM::sm_get_the_src( $product->image) !!}" style="width:100%">
                            @if (!empty($product->image_gallery))
                            <?php
                            $myString = $product->image_gallery;
                            $myArray = explode(',', $myString);
                            ?>
                            @foreach($myArray as $v_data)
                            <img alt="{{ $product->title }}" class="mySlides"
                                src="{!! SM::sm_get_the_src( $v_data , 600, 600) !!}">
                            @endforeach
                            @endif
                            <div class="w3-row-padding w3-section">
                                <div class="w3-col s4">
                                    <img class="demo w3-opacity w3-hover-opacity-off"
                                        src="{!! SM::sm_get_the_src( $product->image , 600, 600) !!}" style="width:100%"
                                        onclick="currentDiv(1)">
                                </div>
                                @if (!empty($product->image_gallery))
                                <?php
                                $myString = $product->image_gallery;
                                $myArray = explode(',', $myString);
                                ?>
                                @foreach($myArray as $pGKey=> $v_data)
                                @if ($product->image == $v_data)
                                @continue
                                @endif
                                <div class="w3-col s4">
                                    <img class="demo w3-opacity w3-hover-opacity-off"
                                        src="{!! SM::sm_get_the_src( $v_data , 600, 600) !!}" style="width:100%"
                                        onclick="currentDiv({{ $loop->index+2 }})">
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $discount = 0;
                ?>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="detail-product">
                        <h2 class="product-title" style="margin-bottom:15px;">{{$product->name}}</h2>
                        {{-- <h5>Product Code: {{ $product->sku }}</h5>--}}
                        @if(!empty($product->short_description))
                        <p>
                            {!! $product->short_description !!}
                        </p>
                        @endif
                        @if ($product->product_type == 2)
                        <?php
                        $att_data = SM::getAttributeByProductId($product->id);
                        ?>
                        <h3 class="product-price">
                            <span
                                class="price product_price att_price1">{{ SM::currency_price_value($att_data->attribute_price) }}</span>
                        </h3>
                        @else
                        <h2 style="font-size:17px">
                            <?php
                            $discount_price = 0;
                            ?>
                            @if($product->discount_type !=3)
                            <?php

                            $discount_price =  SM::getDiscountAmount($product->discount_type, $product->discount_value, $product->variation->sell_price_inc_tax);


                            // $value = $product->regular_price - $product->sale_price;
                            // $discount = $value * 100 / $product->regular_price;
                            ?>
                            {{ SM::currency_price_value($product->variation->sell_price_inc_tax- $discount_price) }}
                            <del>{{ SM::currency_price_value($product->variation->sell_price_inc_tax) }}</del>

                            {!! Form::hidden('price',$product->sale_price, ['class' => 'price']) !!}
                            @else
                            {{ SM::currency_price_value($product->variation->sell_price_inc_tax) }}
                            {!! Form::hidden('price',$product->regular_price, ['class' => 'price']) !!}
                            @endif
                            @if($discount_price>0)
                            -<span class="discount">{{ ceil($discount_price) }} TK </span>off
                            @endif
                        </h2>
                        @endif
                        @include('frontend.products.product_attribute')
                       


                        <input type="hidden" value="1" class="productCartQty qty-inc-dc" id="qty">
                        <?php echo SM::addToCartButton2($product->id,  $product->product_qty); ?>

                        {{--<a data-product_id="{{ $product->id }}" href="javascript:void(0);"--}}
                        {{--class="btn btn-buyer addToWishlist" title="Add to Wishlist"><i--}}
                        {{--class="fa fa-heart" area-hidden="true"></i></a>--}}

                        {{--<a data-product_id="{{ $product->id }}" href="javascript:void(0);"--}}
                        {{--class="btn btn-buyer addToCompare" title="Add to Compare"><i--}}
                        {{--class="fa fa-retweet" area-hidden="true"></i></a>--}}

                        <p>{!! $product->product_description !!}</p>

                        <div class="social_media_share">
                            <div class="social_title">
                                <h4> Social Share : </h4>
                            </div>
                            <a href="#"> <i class="fa fa-facebook"></i></a>
                            <a href="#"> <i class="fa fa-twitter"></i></a>
                            <a href="#"> <i class="fa fa-linkedin"></i></a>
                            <a href="#"> <i class="fa fa-instagram"></i></a>
                            <a href="#"> <i class="fa fa-youtube"></i></a>
                        </div>
                        <div class="payment_method_option">
                            <div class="social_title">
                                <h4> Payment Method : </h4>
                            </div>
                            <ul>
                                <li> <img src="https://www.logo.wine/a/logo/BKash/BKash-Icon-Logo.wine.svg" alt=""></li>
                                <li> <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd4aO94rFApPTiA4ScM9xo3EgWSinhDxpduA&usqp=CAU" alt=""></li>
                                <li> <img src="https://play-lh.googleusercontent.com/Iks014Ul-atatMhWs8rLbtG7cIZLPfpeMDdkLtmq5o7D5_MlFNu5mmIqRHAY45aOhapp" alt=""></li>
                                <li> <img src="https://cdn-icons-png.flaticon.com/512/179/179457.png" alt=""></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('frontend.products.product_review')
        
        @include('frontend.products.related_products')
      
        @include('frontend.inc.footer_top')
    </section>
</section>

@include('frontend.inc.footer')
 
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script> -->

@endsection