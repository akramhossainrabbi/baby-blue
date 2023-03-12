<h3><span class="form-option-title">Available Options:</span></h3>

<div class="product_attribute_size">
    @if ($product->product_type == 2)
        <?php
        $att_datas = \App\Model\Common\AttributeProduct::where('product_id', $product->id)->get();
        ?>
        @if(count($att_datas)>0)
            @foreach($att_datas as $sKe=> $p_size)
                <label data-att_id="{{ $p_size->id }}" for="size_{{ $sKe }}" class="product_att_size">
                    <div class="check-box_inr_size">
                        <div class="size {!! $sKe==0 ? 'size_active': '' !!}">
                            <span class="value"><b>{{ SM::productWeightCal($p_size->attribute->title)  }}</b></span>
                            <input data-price="{{ $p_size->attribute_price }}"
                                   data-id="{{ $p_size->id }}"
                                   data-product_id="{{ $p_size->product_id }}"
                                   class="product_att_size hidden"
                                   {!! $sKe==0 ? 'checked': '' !!}
                                   id="size_{{ $sKe }}" name="product_attribute_size"
                                   type="radio" value="{{ $p_size->id }}">
                        </div>
                    </div>
                </label>
            @endforeach
        @endif
    @else
    <?php
        $unit = \App\Model\Common\Unit::where('id', $product->unit_id)->first();
      
        ?>
        <label for="size" class="product_att_size">
            <div class="check-box_inr_size">
                <div class="size size_active">
                    <span class="value"><b>{{ $product->weight }} {{ $unit->short_name }}</b></span>

                </div>
            </div>
        </label>
    @endif
</div>