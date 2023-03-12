@extends('frontend.master')
@section("title", $categoryInfo->name)
@section('content')
@push('style')
<style>
    #loading {
        text-align: center;
        background: url('loader.gif') no-repeat center;
        height: 150px;
    }
    .box img {
    width: auto;
}
</style>
@endpush
<!-- page wapper-->
<section class="site-content">
    <div class="container-fluid">
        <div class="shop-area">
            <div class="row category-margin-left-top">
                <div class="col-12 col-md-12">
                    <div class="products " id="listing-products">
                        <div class="product col-md-12">
                            <div class="row">
                                <?php
                                if (!empty($category_list)) {
                                    foreach ($category_list as $key => $category) {
                                    //  var_dump($category);
                                        
                                         $child_child_subcategory_id = \App\Model\Common\Category::where('parent_id', $category->id)->get();
                                          if(count($child_child_subcategory_id)>0){
                                              $url = url('category_list/' . $category->id);
                                          }else{
                                               $url = url('category_list/'.$category->id);
                                          }
                                        ?>
                                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                            <div class="box">
                                                <a href="{{$url}}" >
                                                    <!-- <img src="{!! SM::sm_get_the_src( $category->image) !!}" class="img-responsive"> -->
                                                    <div class="box-content">
                                                        <h3 class="" style="color:{{$category->color_code}}">{{$category->name}}</h3>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <h2 style="text-align: center;">{{$categoryInfo->name}}</h2>
                    <hr> 

                    <div class="box-product-content">
                        <ul >
                            @foreach($products as $latestDeal)
                                <li class="col-md-3">
                                    <div class="best-box cat-best-box">
                                    <div class="product_card_box">
                                        <div>
                                        <a href="{{ url('product_detail/'.$latestDeal->id) }}">
                                            <img class="img-responsive carousel-img-height-col5"
                                                 alt="{{ $latestDeal->name }}"
                                                 src="{{ SM::sm_get_the_src($latestDeal->image) }}"/></a>
                                        </div>
                                    <div class="">
                                        <h5 class="product-name">
                                            <a href="{{ url('product_detail/'.$latestDeal->id) }}">
                                                {{ $latestDeal->name }}</a></h5>

                                        
                                        <div class="product_card_overlay">
                                            <div class="overlay_title">
                                                @php 
                                                    echo SM::addToCartButton3($latestDeal->id,1); 
                                                 @endphp
                                            </div>
                                            <div class="overlay_product_details">
                                                <a href="{{ url('product_detail/'.$latestDeal->id) }}" class="btn btn-sm"> View Details</a>
                                            </div>
                                        </div>
                                        <input type="hidden" value="1" class="productCartQty qty-inc-dc" id="qty ">
                                    </div>
                                </div>
                                    <?php echo SM::addToCartButton2($latestDeal->id,2); ?>
                                </div>
                                    
                                </li>
                            @endforeach

                        </ul>
                    </div>
                
            
                      
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ./page wapper-->
 {{--footer_top--}}

        @include('frontend.inc.footer_top')



        <section class="mobile-bottom-btn">

            <button>Start Shopping Now</button>

        </section>
         @include('frontend.inc.footer')
@push('script')

@endpush
@endsection