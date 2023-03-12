<?php
$productSecondLoop = 1;
?>
@if(count($productLists) > 0)
@foreach($productLists as $product)
@if($product->product_type==2)
<?php
$att_data = SM::getAttributeByProductId($product->id);
if (!empty($att_data->attribute_image)) {
    $attribute_image = $att_data->attribute_image;
} else {
    $attribute_image = $product->image;
}
?>
<li class="col-sx-12 col-sm-4">
    <!-- bootstrap carousel -->
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"
         data-interval="false">
        <!-- Wrapper for slides -->
        <div class="carousel-inner sp-wrap">
            <div class="item active srle">
                <a href="{{ url('product/'.$product->slug) }}">
                    <img src="{{ SM::sm_get_the_src($attribute_image, 303, 455) }}"
                         alt="{{ $product->title }}"
                         class="img-responsive">
                </a>
            </div>

            <?php
            $myString = $product->image_gallery;
            $myArray = explode(',', $myString);

            ?>
            @foreach($myArray as $v_data)
                <div class="item">
                    <a href="{{ url('product/'.$product->slug) }}">
                        <img src="{!! SM::sm_get_the_src( $v_data, 303, 455) !!}"
                             alt="{{ $product->title }}"
                             class="img-responsive">
                    </a>
                </div>
            @endforeach
            <div class="new-tag">
                <img src="{{ asset('/frontend') }}/image/new.png">
            </div>
        </div>
        <a href="" class="wishlist">
            <i class="fa fa-heart"></i>
        </a>
        <div class="">
            <h5 class="product-name"><a href="{{ url('product/'.$product->slug) }}">{{ $product->title }}</a></h5>
            <div class="text-center parice-margin-left">
                <span class="price product-price">{{ SM::currency_price_value($att_data->attribute_price) }}</span>
            </div>
        </div>

        <div class="price-percentage-product">
            -30% OFF
        </div>
    </div>
</li>
@else
    <li class="col-sx-12 col-sm-4">
        <!-- bootstrap carousel -->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"
             data-interval="false">
            <!-- Wrapper for slides -->
            <div class="carousel-inner sp-wrap">
                <div class="item active srle">
                    <a href="{{ url('product/'.$product->slug) }}">
                        <img src="{{ SM::sm_get_the_src($product->image, 303, 455) }}"
                             alt="{{ $product->title }}"
                             class="img-responsive">
                    </a>
                </div>
                <?php
                $myString = $product->image_gallery;
                $myArray = explode(',', $myString);
                ?>
                @foreach($myArray as $v_data)
                    <div class="item">
                        <a href="{{ url('product/'.$product->slug) }}">
                            <img src="{!! SM::sm_get_the_src( $v_data, 303, 455) !!}"
                                 alt="{{ $product->title }}"
                                 class="img-responsive">
                        </a>
                    </div>
                @endforeach
                <div class="new-tag">
                    <img src="{{ asset('/frontend') }}/image/new.png">
                </div>
            </div>
            <a href="" class="wishlist">
                <i class="fa fa-heart"></i>
            </a>
            <div class="">
                <h5 class="product-name"><a href="{{ url('product/'.$product->slug) }}">{{ $product->title }}</a></h5>
                <div class="text-center parice-margin-left">
                    @if($product->sale_price>0)
                        <span class="price product-price"> {{ SM::currency_price_value($product->sale_price) }}</span>
                        <span class="price old-price">{{ SM::currency_price_value($product->regular_price) }}</span>
                    @else
                        <span class="price product-price">{{ SM::currency_price_value($product->regular_price) }}</span>
                    @endif
                </div>
            </div>

            <div class="price-percentage-product">
                -30% OFF
            </div>
        </div>
    </li>
@endif
@endforeach
@else
<div class="alert alert-info"><i class="fa fa-info"></i> No Product Found!</div>
@endif
<div class="col-md-12" style="margin-top: 25px;">
    {!! $productLists->links() !!}
</div>
