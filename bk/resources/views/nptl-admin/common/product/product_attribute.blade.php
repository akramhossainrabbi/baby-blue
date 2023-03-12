@if(!isset($width))
    <?php $width = "col-md-8 col-lg-8"; ?>
@endif
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 {{$width}}">
    <?php
    //var_dump($product_type);
    if (!empty($product_type) && $product_type == 2) {
        $attribute_active = '';
        $attribute_style = 'attribute_style';
    } else {
        $attribute_active = 'hidden';
        $attribute_style = '';

    }
    ?>
    <style>
        .attribute_style {
            display: block !important;
        }
    </style>
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget {{$attribute_active}} {{$attribute_style}}" style="" id="wid-id-add-prod-attributes"
         data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-search"></i> </span>
            <h2>{{ $header_name }} Attributes</h2>

        </header>

        <!-- widget div-->
        <div>

            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->
                <input class="form-control" type="text">
            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body padding-10">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive table-hover" id="dynamic_field">
                            <thead>
                            <th style="width:15%">Weight</th>
                            <th style="width:10%">Price</th>
                            <th style="width:5%">
                                <button type="button" class="btn btn-success addRow"><i
                                            class="glyphicon glyphicon-plus"></i></button>
                            </th>
                            </thead>
                            <tbody id="customersDataShow">
                            @if(isset($product_info->attributeProduct))
                                @foreach($product_info->attributeProduct as $attKey=> $attribute)

                                    <tr>
                                        <td>
                                            {!! Form::hidden('detail_id[]', $attribute->id,array('class' => 'detail_id')) !!}
                                            {!! Form::select('attribute_id[]', $size_lists, $attribute->attribute_id,['id' =>'attribute_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}
                                        </td>
                                        <td>
                                            {!! Form::number('attribute_price[]', $attribute->attribute_price,array('autocomplete'=>'off', 'class' => 'form-control attribute_price', 'placeholder'=>'Price')) !!}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove"><i
                                                        class="glyphicon glyphicon-remove"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else

                                <tr>
                                    <td>
                                        {!! Form::select('attribute_id[]', $size_lists, null,['id' =>'attribute_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('attribute_price[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_price', 'placeholder'=>'Price')) !!}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove"><i
                                                    class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6">
                                    <button type="button" class="btn btn-success addRow"><i
                                                class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->