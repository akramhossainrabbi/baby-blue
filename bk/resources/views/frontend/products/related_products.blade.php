
@if(count($relatedProduct) > 0)
<div class="container-fluid">
    <div class="box-product-head-ez">
        <h2>Similar products</2>
    </div>
    <div class="box-product-content">
        <div class="product-list ">
            <div class="owl-carousel owl-theme related_product_active">
                @foreach($relatedProduct as $rProductSingle)
                    <div class="item">
                        <div class="single_product_box">
                            <div class="product_images_section">
                                <a href="{{ url('product_detail/'.$rProductSingle->id) }}">
                                    <img class="img-responsive carousel-img-height-col6" alt="{{ $rProductSingle->name }}"
                                        src="{!! SM::sm_get_the_src( $rProductSingle->image) !!}">
                                </a>

                                
                            </div>
                            <div class="">
                                <h5 class="product-name">
                                    <a
                                        href="{{ url('product_detail/'.$rProductSingle->id) }}">{{ $rProductSingle->name }}</a>
                                </h5>
                                <div class="text-center parice-margin-left">
                                    <span class="price product-price">{{ $rProductSingle->regular_price }}</span>
                                </div>
                            </div>

                            <div class="adtocard_btn">
                                <a href="#" class="btn btn-sm"> Add To Cart </a>
                            </div>
                            
                            <div class="price-percentage-details">
                                -30% OFF
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>




<script>
 
</script>
@endif