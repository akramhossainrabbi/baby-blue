<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-tag-main" data-widget-editbutton="false"
         data-widget-deletebutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-credit-card"></i> </span>
            <h2>{{ $f_name }} Shipping Method</h2>
        </header>
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
                    <div class="col-sm-12">
                        @include("nptl-admin.common.common.title_n_slug", ['isEnabledSlug'=>false, 'table'=>'payment_methods'])
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('charge') ? ' has-error' : '' }}">
                            {!! Form::label('charge', 'Charge') !!}
                            {!! Form::text('charge', null, ['class'=>'form-control', 'placeholder'=>'Charge']) !!}
                            @if ($errors->has('charge'))
                                <span class="help-block">
                             <strong>{{ $errors->first('charge') }}</strong>
                          </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description','Shipping Method Description')!!}
                            {!! Form::textarea('description', null,['class'=>'form-control ckeditor']) !!}
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                 </span>
                            @endif
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
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-tag-publish" data-widget-editbutton="false"
         data-widget-deletebutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-save"></i> </span>
            <h2>Shipping Method Publish</h2>

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
				<?php
				$permission = SM::current_user_permission_array();
				if (SM::is_admin() || isset( $permission ) && isset( $permission['ShippingMethods']['status_update'] ) && $permission['ShippingMethods']['status_update'] == 1)
				{
				?>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Publication Status') !!}
                    {!! Form::select('status',['1'=>'Publish','2'=>'Pending / Draft', '3'=>'Cancel'], null, ['required'=>'','class'=>'form-control']) !!}
                    @if ($errors->has('status'))
                        <span class="help-block">
                             <strong>{{ $errors->first('status') }}</strong>
                          </span>
                    @endif
                </div>
				<?php
				}
				?>
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit">
                        <i class="fa fa-save"></i>
                        {{ $btn_name }} Shipping Method
                    </button>
                </div>
            </div>
            <!-- end widget content -->
        </div>
        <!-- end widget div -->
    </div>
    <!-- end widget -->
</article>
<!-- WIDGET END -->
<?php
if ( old( 'image' ) ) {
	$image = old( 'image' );
} elseif ( isset( $payment_method_info->image ) ) {
	$image = $payment_method_info->image;
} else {
	$image = '';
}
?>
@include('nptl-admin/common/common/image_form',['header_name'=>'Shipping Method',
'image'=>$image])