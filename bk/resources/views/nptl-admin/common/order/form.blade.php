<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-user"></i> </span>
            <h2>Customer info</h2>
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
                    <div class="col-md-6">

                        <div class="form-group row{{ $errors->has('user_id') ? ' has-error' : '' }}">
                            {!! Form::label('user_id', 'Company Name: ', array('class' => 'col-md-5 col-form-label requiredStar')) !!}
                            <div class="col-md-7">
                                <div class="input-group">
                                    {!! Form::select('user_id', $customer_lists, null, ['class'=>'select2', 'id' => 'user_id', 'required'=>'true', 'placeholder' => 'Plese Select...']) !!}
                                    @if ($errors->has('user_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default"
                                                id="myBtn" title="Add Hospital"><i class="fa fa-plus"></i></button>
                                     </span>
                                </div>
                            </div>
                            {!! Form::hidden('company', null,['class'=>'company']) !!}
                        </div>

                        <div class="form-group row{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            {!! Form::label('mobile', 'Mobile: ', array('class' => 'col-md-5 col-form-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('mobile', null,['class'=>'form-control mobile', 'placeholder'=>__("Mobile")]) !!}
                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('contact_email') ? ' has-error' : '' }}">
                            {!! Form::label('contact_email', 'Mobile: ', array('class' => 'col-md-5 col-form-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('contact_email', null,['class'=>'form-control contact_email', 'placeholder'=>__("Mobile")]) !!}
                                @if ($errors->has('contact_email'))
                                    <span class="help-block">
                        <strong>{{ $errors->first('contact_email') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('address') ? ' has-error' : '' }}">
                            {!! Form::label('address', 'Address: ', array('class' => 'col-md-5 col-form-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('address', null,['class'=>'form-control address', 'placeholder'=>__("Address")]) !!}
                                @if ($errors->has('address'))
                                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('invoice_no', 'Invoice No.: ', array('class' => 'col-md-5 col-form-label')) !!}
                            <div class="col-md-7">
                                {!! Form::text('invoice_no', null,['class'=>' form-control invoice_no', 'placeholder'=>__("Invoice No.")]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('create_date', 'Date: ', array('class' => 'col-md-5 col-form-label requiredStar')) !!}
                            <div class="col-md-7">
                                <?php
                                if (isset($sale_info->create_date) == '') {
                                    $data = 'autoDate';
                                } else {
                                    $data = 'clickDate';
                                }
                                ?>
                                {!! Form::text("create_date", null,["class"=>"form-control $data", "autocomplete" => "off", "required", "placeholder"=>__("Date")]) !!}

                                {{--                                {!! Form::text('create_date', null,['class'=>'autoDate form-control create_date', ' autocomplete' =>'off', 'required'=>'true', 'placeholder'=>__("Date")]) !!}--}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end widget content -->
            <!-- widget content -->
            <div class="widget-body padding-10">
                <div class="row">
                    <table class="table table-bordered table-responsive table-hover">
                        <thead>
                        <th style="width:18%">Product Name</th>
                        <th style="width:12%">Unit</th>
                        <th style="width:10%">Total Unit</th>
                        <th style="width:10%">Qty</th>
                        <th style="width:10%">Price</th>
                        <th style="width:10%">Amount</th>
                        <th style="width:10%">
                            <button type="button" class="btn btn-success addRow"><i
                                        class="glyphicon glyphicon-plus"></i></button>
                        </th>
                        </thead>
                        <tbody id="cart_table" class="cart_table">
                        <tr>
                            <td>
                                {!! Form::select('product_id[]', $product_lists, null,['required', 'id'=>'product_id', 'class'=>'select2 product_id', 'placeholder' => 'Plese Select...' ]) !!}
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control product_size" readonly name="product_size[]"
                                           placeholder="Unit">
                                    <span class="input-group-btn">
                                        <input type="hidden" name="product_color[]"
                                               class="form-control product_color">
                                        <button class="btn btn-default product_color" type="button">Unit</button>
                                      </span>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control total_unit" readonly name="total_unit[]"
                                       placeholder="Total Unit">
                            </td>
                            <td>
                                <input autocomplete="off" type="text" placeholder="Qty" name="product_qty[]"
                                       class="form-control product_qty">
                            </td>
                            <td>
                                <input autocomplete="off" placeholder="Price" type="text" name="product_price[]"
                                       class="form-control product_price">
                            </td>
                            <td>
                                <input placeholder="Amount" type="text" required="true" name="sub_amount[]"
                                       class="form-control sub_amount" readonly="true">
                            </td>
                            <td>
                                <button type="button" class="btn btn-success addRow"><i
                                            class="glyphicon glyphicon-plus"></i></button>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tfoot>
                        <tr>
                            <td colspan="8">
                                <button type="button" class="btn btn-success addRow"><i
                                            class="glyphicon glyphicon-plus"></i>
                                </button>
                            </td>
                        </tr>
                        </tfoot>
                        </tfoot>
                    </table>
                    <div class="col-md-6 col-xs-12 pull pull-left">
                        <div class="form-group">
                            <label>Note</label><br>
                            {!! Form::textarea('note', null,['rows' => '5', 'cols' => '56']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 pull pull-right">
                        <div class="form-group">
                            <label for="total_qty" class="col-sm-5 control-label">Total Qty</label>
                            <div class="col-sm-7">
                                <input type="text" name="total_qty" placeholder="Total Qty"
                                       class="form-control total_qty"
                                       readonly="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sub_total" class="col-sm-5 control-label">Sub Total</label>
                            <div class="col-sm-7">
                                <input type="text" name="sub_total" placeholder="Sub Total"
                                       class="form-control sub_total"
                                       readonly="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shipping_method_charge" class="col-sm-5 control-label">DELIVERY COST /
                                ডাক মাশুল</label>
                            <div class="col-sm-7">
                                <input type="text" name="shipping_method_charge" placeholder="DELIVERY COST / ডাক মাশুল"
                                       class="form-control shipping_method_charge"
                                       readonly="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grand_total" class="col-sm-5 control-label">Grand Total</label>
                            <div class="col-sm-7">
                                <input type="text" name="grand_total" placeholder="Grand Total"
                                       class="form-control grand_total"
                                       readonly="true">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-5">
                        <div class="form-group">
                            <button class="btn btn-success" id="saleSaveBtn" type="submit">
                                <i class="fa fa-save"></i>
                                Add Order
                            </button>
                        </div>
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

