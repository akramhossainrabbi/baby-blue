@extends('layouts.app')
@section('title', __('lang_v1.product_ledger'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ __('lang_v1.product_ledger')}}</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('ir_product_id','Product:') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-product-hunt"></i>
                        </span>
                        {!! Form::select('ir_product_id', $products, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.all')]); !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="display: none;">
                <div class="form-group">
                    {!! Form::label('ir_purchase_date_filter', __('purchase.purchase_date') . ':') !!}
                    {!! Form::text('ir_purchase_date_filter', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                </div>
            </div>
            <div class="col-md-3" style="display: none;">
                <div class="form-group">
                    {!! Form::label('ir_customer_id', __('contact.customer') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        {!! Form::select('ir_customer_id', $customers, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.all')]); !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    {!! Form::label('ir_sale_date_filter', 'Date:') !!}
                    {!! Form::text('ir_sale_date_filter', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('ir_location_id', __('purchase.business_location').':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </span>
                        {!! Form::select('ir_location_id', $business_locations, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
                    </div>
                </div>
            </div>
            
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary'])
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" 
                    id="product_report_table">
                        <thead>
                            <tr>
                                <th>@lang('sale.product')</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>@lang('lang_v1.quantity')</th>
                            </tr>
                        </thead>
                       
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
</section>
<!-- /.content -->
<div class="modal fade view_register" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

@endsection

@section('javascript')
    <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>
@endsection