@extends('layouts.app')
@section('title', 'Order')
@section('content')
<?php
    $delivery_man = SM::get_delivery_man();
?>
    <br/>
    <section class="content">
        <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters')])
            
            <div class="col-md-3">
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
            <div class="col-md-3" style="display: none;">
                <div class="form-group">
                    {!! Form::label('ir_sale_date_filter', __('lang_v1.sell_date') . ':') !!}
                    {!! Form::text('ir_sale_date_filter', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                </div>
            </div>
            <?php
                $order_status = ['1'=>'Completed','2'=>'Progress', '3' => 'Pending', '4' =>  'Canceled'];
            ?>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('ir_order_status', 'Order Status:') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-shopping-cart"></i>
                        </span>
                        {!! Form::select('ir_order_status', $order_status, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
                    </div>
                </div>
            </div>

            <?php
                $payment_status = ['1'=>'Published','2' => 'Pending', '3' =>  'Canceled'];
            ?>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('ir_payment_status', 'Payment Status:') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-credit-card"></i>
                        </span>
                        {!! Form::select('ir_payment_status', $payment_status, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
                    </div>
                </div>
            </div>

            <?php
                $delivery_status = ['1'=>'Completed','2'=>'Processing', '3' => 'Not Assigned', '4' =>  'Canceled'];
            ?>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('ir_delivery_status', 'Delivery Status:') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-truck"></i>
                        </span>
                        {!! Form::select('ir_delivery_status', $delivery_status, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
                    </div>
                </div>
            </div>
           
            @endcomponent
        </div>
    </div>

        <div class="box box-primary jarviswidget" id="order_list_wid">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11">
                        <h4>Order List</h4>
                    </div>
                    
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="10%">Date</th>
                            <th width="5%">ID</th>
                            <th width="15%">Customer</th>
                            <th width="10%">Amount</th>
                            <th width="12%">Others Info</th>
                            <th width="10%">Payment Method</th>
                            <th width="10%">Order Status</th>
                            <th width="10%">Payment Status</th>
                            <th width="5%">Delivery Status</th>
                            <th width="13%">Action</th>
                           
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="sm_delivery_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                {!! Form::open(["method"=>"post", "route"=>"delivery_info_update", "id"=>"delivery_status_form"]) !!}
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Delivery Man Assign</h2>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="od_order_id_new" name="order_id">
                    <input type="hidden" id="od_order_status_new" name="order_status">
                    <select class="form-control select2" name="delivery_man">
                        <option value="">Please Select Delivery Man</option>
                    @foreach($delivery_man as $value)
                     
                      <option value="{{$value->id}}">{{$value->firstname}}  {{$value->lastname}}</option>
                                       
                                        
                    
                    @endforeach
                       </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save_delivery_info"><i class="fa fa-save"></i>
                        Save Delivery Info
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="sm_order_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {!! Form::open(["method"=>"post", "route"=>"order_info_update", "id"=>"order_status_form"]) !!}
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Order</h2>
            </div>
            <div class="modal-body">
                <div class="form-group" id="od_pay_div">
                    <input type="hidden" id="od_order_id" name="order_id">
                    <input type="hidden" id="od_row">
                    <input type="hidden" id="od_order_status" name="order_status">
                    <label for="od_pay">Pay Due</label>
                    <input type="number" class="form-control" step="any" id="od_pay" name="pay">
                    <span class="help-block">
                              <strong></strong>
                        </span>
                </div>
                <div class="form-group hidden">
                    <label for="od_mail_message">Mail Message</label>
                    <textarea class="form-control" id="od_mail_message" name="message" rows="8"></textarea>
                    <span class="help-block">
                              <strong></strong>
                        </span>
                </div>
                <div class="row hidden">
                    @include('nptl-admin/common/common/gallary_form',['header_name'=>'Mail Files', 'image'=>'', 'grid'=>'col-xs-12 col-sm-12 col-md-12'])
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="save_order_info"><i class="fa fa-save"></i>
                    Save Order Info and Send Mail
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="sm_order_payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {!! Form::open(["method"=>"post", "route"=>"payment_info_update", "id"=>"payment_status_form"]) !!}
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Order</h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="pm_order_id" name="order_id">
                    <input type="hidden" id="pm_row">
                    <input type="hidden" id="pm_payment_status" name="payment_status">
                    <label for="pm_pay">Pay Due</label>
                    <input type="number" class="form-control" step="any" id="pm_pay" name="pay" min="1">
                    <span class="help-block">
                              <strong></strong>
                        </span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="save_payment_info"><i class="fa fa-save"></i> Save
                    Order Info
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('javascript')
    <script type="text/javascript">
        var table;
        $(function () {
             table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('order_list') }}',
                    data: function(d) {
                        var sale_start = '';
                        var sale_end = '';
                        if ($('#ir_sale_date_filter').val()) {
                            sale_start = $('input#ir_sale_date_filter')
                                .data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            sale_end = $('input#ir_sale_date_filter')
                                .data('daterangepicker')
                                .endDate.format('YYYY-MM-DD');
                        }
                        d.sale_start = sale_start;
                        d.sale_end = sale_end;
                        d.customer_id = $('select#ir_customer_id').val();
                        d.order_status = $('select#ir_order_status').val();
                        d.delivery_status = $('select#ir_delivery_status').val();
                        d.payment_status = $('select#ir_payment_status').val();
                    },
                },
                columns: [
                    {"data": "created_at"},
                    {"data": "id"},
                    {"data": "customer_name"},
                    {"data": "grand_total"},
                    {"data": "other_info"},
                    {"data": "payment_method"},
                    {"data": "order_status"},
                    {"data": "payment_status"},
                    {"data": "delivery_status"},
                    {"data": "action"},
                ]
            });
            if ($('#ir_sale_date_filter').length == 1)
            {
                $('#ir_sale_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
                    $('#ir_sale_date_filter').val(
                        start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                    );
                    table.ajax.reload();
                });
                $('#ir_sale_date_filter').on('cancel.daterangepicker', function(ev, picker) {
                    $('#ir_sale_date_filter').val('');
                    table.ajax.reload();
                });
            }
        });
        $(document).on('change', '#ir_supplier_id, #ir_customer_id, #ir_order_status, #ir_payment_status, #ir_delivery_status', function(){
            table.ajax.reload();
        });

    </script>
@endsection