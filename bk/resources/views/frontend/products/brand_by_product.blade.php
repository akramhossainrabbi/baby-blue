@extends('frontend.master')
@section("title", $brandInfo->title)
@section('content')
    @push('style')
        <style>
            #loading {
                text-align: center;
                background: url('loader.gif') no-repeat center;
                height: 150px;
            }
        </style>
    @endpush
    <!-- page wapper-->
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
        @include('frontend.common.breadcrumb')
        <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Left colunm -->
            @include('frontend.products.product_sidebar')
            <!-- ./left colunm -->
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-10" id="center_column">
                    <!-- Bestsellers -->
                    <div class="box-products">
                        <div class="box-product-head">
                            <span class="box-title">{{ $brandInfo->title }}</span>
                        </div>
                        @if(!empty($brandInfo->image_gallery))
                            <div class="box-product-content">
                                <ul class="product-list owl-carousel " data-dots="false" data-loop="true"
                                    data-nav="true"
                                    data-margin="30"
                                    data-responsive='{"0":{"items":1},"500":{"items":1},"600":{"items":1},"1000":{"items":1}}'>
                                    <?php
                                    $myString = $brandInfo->image_gallery;
                                    $myArray = explode(',', $myString);
                                    ?>
                                    @foreach($myArray as $v_data)
                                        <li>
                                            <img class="img-responsive carousel-img-height-col4"
                                                 alt="{{ $brandInfo->title }}"
                                                 src="{{ SM::sm_get_the_src($v_data, 970, 300) }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="category-slider">
                                <img src="{{ SM::sm_get_the_src($brandInfo->image, 970, 300) }}"
                                     alt="{{ $brandInfo->title }}">
                            </div>
                        @endif
                    </div>
                    <!-- ./Bestsellers-->
                    <hr>
                    <!-- view-product-list-->
                    <div class="short-list-style">
                        <label class="label-short" for="sorter">Sort By</label>
                        <select data-role="sorter"
                                class="onChangeProductFilter form-inline-style">
                            <option value="">Popularity</option>
                            <option value="1">Product Name</option>
                            <option value="2">New</option>
                            <option value="3">Best Sellers</option>
                            <option value="4">Most Viewed</option>
                            <option value="5">Price low to high</option>
                            <option value="6">Price high to low</option>
                        </select>
                    </div>
                    <hr>
                    <div class="columns-container">
                        <!-- PRODUCT LIST -->
                        <ul class="row product-list" id="ajax_view_product_list">
                            @include('frontend.products.product_list_item', ['productLists'=>$products])
                        </ul>
                        <!-- ./PRODUCT LIST -->
                    </div>
                    <!-- ./view-product-list-->
                </div>
                <!-- ./ Center colunm -->
            </div>
            <!-- ./row-->
        </div>
    </div>
    <!-- ./page wapper-->
    @push('script')

    @endpush
@endsection