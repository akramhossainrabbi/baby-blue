@extends("nptl-admin.master")
@section("title","Edit Order")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($order,["method"=>"PATCH","action"=>["Admin\Common\Orders@update",$order->id]]) !!}
            @include(("nptl-admin.common.order.order_form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection