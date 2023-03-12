<style>
    .border {
        border: 1px solid #0000ff;
        min-height: 550px;
        margin: 2px;
        width: 48%;
        float: left;
        padding: 0px 10px;
    }

    .or-seperator {
        margin-top: 20px;
        text-align: left;
        border-top: 1px solid #ccc;
    }

    .or-seperator i {
        padding: 0 10px;
        background: #f7f7f7;
        position: relative;
        top: -16px;
        font-weight: bold;
        font-size: 21px;
        z-index: 1;
    }
</style>
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-user"></i> </span>
            <h2>Barcode Add</h2>
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
                    <div class=" border">
                        <?php
                        $site_name = SM::get_setting_value('site_name2');
                        $mobile = SM::get_setting_value('mobile2');
                        $email = SM::get_setting_value('email2');
                        $address = SM::get_setting_value('address2');
                        ?>
                        <div class="or-seperator"><i>প্রেরক </i></div>
                        <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'কোম্পানি : ', array('class' => 'col-md-3 col-form-label requiredStar')) !!}
                            <div class="col-md-9">
                                {!! $site_name !!}
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('address') ? ' has-error' : '' }}">
                            {!! Form::label('address', 'ঠিকানা: ', array('class' => 'col-md-3 col-form-label')) !!}
                            <div class="col-md-9">
                                {!! $address !!}
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            {!! Form::label('mobile', 'মোবাইল: ', array('class' => 'col-md-3 col-form-label requiredStar')) !!}
                            <div class="col-md-9">
                                {!! $mobile !!}

                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'ইমেইল: ', array('class' => 'col-md-3 col-form-label')) !!}
                            <div class="col-md-9">
                                {!! $email !!}
                            </div>
                        </div>

                    </div>
                    <div class=" border">
                        <div class="or-seperator"><i>প্রাপক </i></div>
                        <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'ক্রেতার নাম: ', array('class' => 'col-md-3 col-form-label requiredStar')) !!}
                            <div class="col-md-9">
                                {!! Form::text('name', null,['class'=>'form-control name','required', 'placeholder'=>__("ক্রেতার নাম")]) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('address') ? ' has-error' : '' }}">
                            {!! Form::label('address', 'ঠিকানা: ', array('class' => 'col-md-3 col-form-label')) !!}
                            <div class="col-md-9">
                                {!! Form::text('address', null,['class'=>'form-control address', 'placeholder'=>__("ঠিকানা")]) !!}
                                @if ($errors->has('address'))
                                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            {!! Form::label('mobile', 'মোবাইল: ', array('class' => 'col-md-3 col-form-label requiredStar')) !!}
                            <div class="col-md-9">
                                {!! Form::text('mobile', null,['class'=>'form-control mobile', 'required','placeholder'=>__("মোবাইল")]) !!}
                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', 'ইমেইল: ', array('class' => 'col-md-3 col-form-label')) !!}
                            <div class="col-md-9">
                                {!! Form::text('email', null,['class'=>'form-control email', 'placeholder'=>__("ইমেইল")]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('invoice_no', 'চালান নং.: ', array('class' => 'col-md-3 col-form-label')) !!}
                            <div class="col-md-9">
                                {!! Form::text('invoice_no', null,['class'=>' form-control invoice_no', 'placeholder'=>__("চালান নং.")]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('create_date', 'তারিখ: ', array('class' => 'col-md-3 col-form-label requiredStar')) !!}
                            <div class="col-md-9">
                                <?php
                                if (isset($edit->create_date) == '') {
                                    $data = 'autoDate';
                                } else {
                                    $data = 'clickDate';
                                }
                                ?>
                                {!! Form::text("create_date", null,["class"=>"form-control $data", "autocomplete" => "off", "required", "placeholder"=>__("তারিখ")]) !!}

                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('grand_total', 'সর্বমোট: ', array('class' => 'col-md-3 col-form-label requiredStar')) !!}
                            <div class="col-md-9">
                                {!! Form::text('grand_total', null,['class'=>' form-control grand_total', 'required', 'placeholder'=>__("সর্বমোট")]) !!}
                                
                            </div>
                        </div>
                         <div class="form-group">
                            {!! Form::label('delivery', 'ডেলিভারি: ', array('class' => 'col-md-3 col-form-label')) !!}
                            <div class="col-md-9">
                                {!! Form::text('delivery', null,['class'=>' form-control delivery', 'placeholder'=>__("ডেলিভারি")]) !!}
                                
                            </div>
                        </div>
                         <div class="form-group">
                            {!! Form::label('order_note', 'UMTS / মানি অর্ডার: ', array('class' => 'col-md-3 col-form-label')) !!}
                            <div class="col-md-9">
                                {!! Form::text('order_note', null,['class'=>' form-control order_note', 'placeholder'=>__("EMTS / মানি অর্ডার")]) !!}
                               
                            </div>
                        </div>
                        <div class="form-group" style="text-align: center">
                            <button class="btn btn-success" id="saleSaveBtn" type="submit">
                                <i class="fa fa-save"></i>
                                বারকোড তৈরি করুন
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

