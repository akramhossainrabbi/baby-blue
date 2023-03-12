<?php
$product_best_sale_is_enable = SM::smGetThemeOption("product_best_sale_is_enable", 1);
$product_show_category = SM::smGetThemeOption("product_show_category", 1);
$product_show_tag = SM::smGetThemeOption("product_show_tag", 1);
$product_show_brand = SM::smGetThemeOption("product_show_brand", 1);
$product_show_size = SM::smGetThemeOption("product_show_size", 1);
$product_show_color = SM::smGetThemeOption("product_show_color", 1);
$product_detail_add = SM::smGetThemeOption("product_detail_add", 1);
?>
<div class="column col-xs-12 col-sm-3" id="left_column">
    <!-- block category -->
    @if($product_show_category==1)
    <?php
    $getMainCategories = SM::getMainCategories(0);
    ?>
    @if(count($getMainCategories)>0)
    <div class="block left-module">
        <p class="title_block">CATEGORIES</p>
        <div class="block_content">
            <!-- layered -->
            <div class="layered layered-category">
                <div class="layered-content">
                    <ul class="tree-menu">
                        @foreach($getMainCategories as $cat)
                        <li class="active">
                            <span></span>
                            <a href="{!! url("category/".$cat->slug) !!}">{{$cat->title}}</a>
                            <?php
                            $getSubCategories = \App\Model\Common\Category::where('parent_id', $cat->id)->get();
                            //                                            SM::getSubCategories($cat->id);
                            ?>
                            @empty(!$getSubCategories)
                            <ul>
                                @foreach($getSubCategories as $getSubCategory)
                                <li><span></span>
                                    <a href="{!! url("category/".$getSubCategory->slug) !!}">{{ $getSubCategory->title }}</a>
                                    <?php
                                    echo SM::category_tree_for_select_cat_id($getSubCategory->id);
                                    ?>
                                </li>
                                @endforeach
                            </ul>
                            @endempty
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- ./layered -->
        </div>
    </div>
    @endif
    @endif
    <!-- ./block category  -->
    <!-- block best sellers -->
    @if($product_best_sale_is_enable==1)
    <?php
    $product_best_sale_per_page = SM::smGetThemeOption("product_best_sale_per_page", 6);
    $bestSaleProducts = SM::getBestSaleProduct($product_best_sale_per_page);
    //        var_dump($bestSaleProducts);
    //        exit();
    ?>
    @if(count($bestSaleProducts)>0)
    <div class="block left-module">
        <p class="title_block">BEST SELLERS</p>
        <div class="block_content">
            <div class="owl-carousel owl-best-sell" data-loop="true" data-nav="false" data-margin="0"
                 data-autoplayTimeout="1000" data-autoplay="true" data-autoplayHoverPause="true"
                 data-items="1">
                @foreach ($bestSaleProducts->chunk(3) as $chunk)
                <ul class="products-block best-sell">
                    @foreach ($chunk as $product)
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
                        <div class="products-block-left">
                            <a href="{{ url('product/'.$product->slug) }}">
                                <img src="{{ SM::sm_get_the_src($attribute_image, 75, 92) }}"
                                     alt="{{ $product->title }}">
                            </a>
                        </div>
                        <div class="products-block-right">
                            <p class="product-name">
                                <a href="{{ url('product/'.$product->slug) }}">{{ $product->title }}</a>
                            </p>
                            <p class="product-price">{{ SM::currency_price_value($att_data->attribute_price) }}</p>
                            <p class="product-star">
                                <?php
                                echo SM::product_review($product->id);
                                ?>
                            </p>
                        </div>
                    </li>
                    @else
                    <li>
                        <div class="products-block-left">
                            <a href="{{ url('product/'.$product->slug) }}">
                                <img src="{{ SM::sm_get_the_src($product->image, 75, 92) }}"
                                     alt="{{ $product->title }}">
                            </a>
                        </div>
                        <div class="products-block-right">
                            <p class="product-name">
                                <a href="{{ url('product/'.$product->slug) }}">{{ $product->title }}</a>
                            </p>
                            @if($product->sale_price>0)
                            <p class="price product-price"> {{ SM::currency_price_value($product->sale_price) }}</p>
                            @else
                            <p class="price product-price">{{ SM::currency_price_value($product->regular_price) }}</p>
                            @endif
                            <p class="product-star">
                                <?php
                                echo SM::product_review($product->id);
                                ?>
                            </p>
                        </div>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endforeach
            </div>
        </div>
    </div>
    <!-- ./block best sellers  -->
    @endif
    @endif
    <?php
    $product_detail_add_link = SM::smGetThemeOption("product_detail_add_link", "#");
    $product_detail_add = SM::smGetThemeOption("product_detail_add");
    ?>
    @empty(!$product_detail_add)
    <div class="col-left-slide left-module">
        <div class="banner-opacity">
            <a href="{!! $product_detail_add_link !!}">
                <img src="{!! SM::sm_get_the_src( $product_detail_add, 319,319 ) !!}" alt="ads-banner"
                     class="image-style"></a>
        </div>
    </div>
    @endempty
    <!--./left silde-->
</div>