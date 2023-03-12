@extends("nptl-admin/master")
@section("title","Barcode")
@section("content")
    {!!Html::style('additional/toastr/toastr.min.css')!!}
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::open(["method"=>"post","action"=>"Admin\Common\Barcodes@store", 'class' => 'form-horizontal']) !!}
            @include(("nptl-admin.common.barcode.form"),
            ['f_name'=>__("common.add"), 'btn_name'=>__("common.save")])
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection