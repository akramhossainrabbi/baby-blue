@extends("nptl-admin.master")
@section("title","Edit Barcode")
@section("content")
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::model($edit,["method"=>"PATCH","action"=>["Admin\Common\Barcodes@update", $edit->id], 'class' => 'form-horizontal']) !!}
            @include(("nptl-admin.common.barcode.form"),
            ['f_name'=>__("common.edit"), 'btn_name'=>__("common.update")])
            {!! Form::close() !!}

        </div>
        <!-- end row -->
    </section>
@endsection