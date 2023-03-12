@extends(('nptl-admin/master'))
@section('title','Barcode Setting')
@section('content')
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">
            <form name="save_category" id="save_category" method="post"
                  action="{{url(config('constant.smAdminSlug').'/barcodes/save_setting')}}"
                  class="form-horizontal"
                  enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-8">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-setting">

                        <header>
                            <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
                            <h2>Barcode Settings</h2>

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
                            <div class="widget-body">
                                <fieldset>
                                    <div class="form-group{{ $errors->has('site_name2') ? ' has-error' : '' }}">
                                        <label class="col-md-2 control-label"
                                               for="site_name2">{{__("setting.siteName")}}</label>
                                        <div class="col-md-10">
                                            <input name="site_name2" id="site_name2" class="form-control"
                                                   placeholder="{{__("setting.siteName")}}" type="text" required=""
                                                   value="{{ old('site_name2')!='' ? old('site_name2') : SM::get_setting_value('site_name2') }}">
                                            @if ($errors->has('site_name2'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('site_name2') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('email2') ? ' has-error' : '' }}">
                                        <label class="col-md-2 control-label"
                                               for="email2">Email</label>
                                        <div class="col-md-10">
                                            <input name="email2" id="email2" class="form-control"
                                                   placeholder="Email" type="email2"
                                                   required=""
                                                   value="{{ old('email2')!='' ? old('email2') : SM::get_setting_value('email2') }}">
                                            @if ($errors->has('email2'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('email2') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('mobile2') ? ' has-error' : '' }}">
                                        <label class="col-md-2 control-label"
                                               for="mobile2">{{__("setting.mobileNo")}}</label>
                                        <div class="col-md-10">
                                            <input name="mobile2" id="mobile2" class="form-control"
                                                   placeholder="{{__("setting.mobileNo")}}" type="text" required=""
                                                   value="{{ old('secondary_email')!='' ? old('mobile2') : SM::get_setting_value('mobile2') }}">
                                            @if ($errors->has('mobile2'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('mobile2') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                                        <label class="col-md-2 control-label"
                                               for="address2">{{__("setting.address")}}</label>
                                        <div class="col-md-10">
                                        <textarea name="address2" id="address2" class="form-control"
                                                  placeholder="{{__("setting.address")}}" rows="4" required="">{{ old('address2')!=''? old('address2') :SM::get_setting_value('address2') }}
                                        </textarea>
                                            @if ($errors->has('address2'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('address2') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    


                                </fieldset>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-save"></i>
                                                Save Barcode Settings
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
            </form>
        </div>

        <!-- end row -->

    </section>
@endsection