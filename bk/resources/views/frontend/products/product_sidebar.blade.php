<?php
$product_special_is_enable = SM::smGetThemeOption("product_special_is_enable", 1);
$product_show_category = SM::smGetThemeOption("product_show_category", 1);
$product_show_price = SM::smGetThemeOption("product_show_price", 1);
$product_show_tag = SM::smGetThemeOption("product_show_tag", 1);
$product_show_brand = SM::smGetThemeOption("product_show_brand", 1);
$product_show_size = SM::smGetThemeOption("product_show_size", 1);
$product_show_color = SM::smGetThemeOption("product_show_color", 1);
$product_show_testimonial = SM::smGetThemeOption("product_show_testimonial", 1);
$product_show_advertisement = SM::smGetThemeOption("product_show_advertisement", 1);
?>
<section class="search-pro-area">
    <div class="pro-search-system">
        <div class="row">
            @if($product_show_category==1)
                <?php
                $getProductCategories = SM::getProductCategories(0);
                ?>
                @if(count($getProductCategories)>0)
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">Select Category
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu check-box-list" role="menu">
                                @foreach($getProductCategories as $cat)
                                    <?php
                                    $segment = Request::segment(3);
                                    if ($segment == $cat->slug) {
                                        $selected = 'checked';
                                    } else {
                                        $selected = '';
                                    }

                                    $category_filter[] = $cat->id;
                                    $subcategory_id = \App\Model\Common\Category::where('parent_id', $cat->id)->get();
                                    $countProduct = 0;
                                    foreach ($subcategory_id as $item) {
                                        $category_filter[] = $item->id;
                                        $countProduct += $item->total_products;
                                    }
                                    ?>
                                    @if(count($countProduct) > 0)
                                        <li>
                                            <a>
                                                <input {{$selected}} type="checkbox" id="c1_{{ $cat->id }}"
                                                       value="{{ $cat->id }}"
                                                       class="common_selector category"/>
                                                <label for="c1_{{ $cat->id }}">
                                                    <span class="button"></span>
                                                    {{$cat->title}}<span
                                                            class="count">( {{ count($cat->products) }} )</span>
                                                </label>
                                                <?php
                                                echo SM::category_tree_for_select_cat_id($cat->id, $segment);
                                                ?>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            @endif
            @if($product_show_price==1)
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <?php
                    $max_price = (int)\App\Model\Common\Product::max('regular_price');
                    $min_price = (int)\App\Model\Common\Product::min('regular_price');
                    ?>
                    <div class="layered-content slider-range">
                        <div data-label-reasult="Range:" data-min="<?php echo $min_price ?>"
                             data-max="<?php echo $max_price ?>"
                             data-unit="{{SM::get_setting_value('currency')}}"
                             class="slider-range-price" data-value-min="<?php echo $min_price ?>"
                             data-value-max="<?php echo $max_price ?>">
                        </div>
                        <input type="hidden" id="hidden_minimum_price" value="<?php echo $min_price ?>"/>
                        <input type="hidden" id="hidden_maximum_price" value="<?php echo $max_price ?>"/>
                        <div class="amount-range-price">
                           <p><b class="pull-left">{{SM::currency_price_value($min_price)}}</b>
                            <b class="pull-right">{{SM::currency_price_value($max_price)}}</b></p>
                        </div>

                    </div>
                </div>
            @endif
            @if($product_show_brand==1)
                <?php
                $getProductBrands = SM::getProductBrands(0);
                ?>
                @if(count($getProductBrands)>0)
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">Select Brand
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu scrollable-menu check-box-list" role="menu">
                                @foreach($getProductBrands as $brand)
                                    <?php
                                    $segment2 = Request::segment(2);
                                    if ($segment2 == $brand->slug) {
                                        $selected2 = 'checked';
                                    } else {
                                        $selected2 = '';
                                    }
                                    ?>
                                    <li>
                                        <a>
                                            <input {{ $selected2 }} type="checkbox" value="{{ $brand->id }}"
                                                   id="brand_{{ $brand->id }}"
                                                   class="common_selector brand"/>
                                            <label for="brand_{{ $brand->id }}">
                                                <span class="button"></span>
                                                {{ $brand->title }}<span
                                                        class="count">( {{ count($brand->products )}})</span>
                                            </label>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>