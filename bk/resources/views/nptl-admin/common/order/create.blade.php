@extends("nptl-admin/master")
@section("title","Order")
@section("content")
    {!!Html::style('additional/toastr/toastr.min.css')!!}
     <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::open(["method"=>"post","action"=>"Admin\Common\Orders@store", 'class' => 'form-horizontal']) !!}
            @include(("nptl-admin.common.order.form"),
            ['f_name'=>__("common.add"), 'btn_name'=>__("common.save")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection
@section('footer_script')
    @include('nptl-admin.common.order.calculation')
@endsection