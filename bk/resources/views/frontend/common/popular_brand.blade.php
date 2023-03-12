@if(count($featured_brands)>0)
    <div class="box-products ">
        <div class="container">
            <div class="box-product-head">
                <span class="box-title">POPULAR BRANDS</span>
            </div>
            <div class="box-product-content">
                <ul class="product-list owl-carousel " data-dots="false" data-loop="true" data-nav="true"
                    data-margin="30"
                    data-responsive='{"0":{"items":2},"500":{"items":2},"600":{"items":3},"1000":{"items":5}}'>
                    @foreach($featured_brands as $catKey => $brand)
                        <li style="padding-bottom: 0px;">
                            <a href="{{ url('/brand/'.$brand->slug) }}">
                                <img class="img-responsive"
                                     alt="{{ $brand->title }}"
                                     src="{{ SM::sm_get_the_src($brand->image, 200, 80) }}"/></a>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif