@extends('frontend.master')
@section("title", "Contact")
@section('content')
    <!-- page wapper-->
    <?php
    $contact_form_title = SM::smGetThemeOption("contact_form_title");
    $contact_title = SM::smGetThemeOption("contact_title");
    $contact_subtitle = SM::smGetThemeOption("contact_subtitle");
    $contact_des_title = SM::smGetThemeOption("contact_des_title");
    $contact_description = SM::smGetThemeOption("contact_description");
    $title = SM::smGetThemeOption("contact_banner_title");
    $subtitle = SM::smGetThemeOption("contact_banner_subtitle");
    $bannerImage = SM::smGetThemeOption("contact_banner_image");

    $contact_location_title = SM::smGetThemeOption("contact_location_title");
    $contact_location_subtitle = SM::smGetThemeOption("contact_location_subtitle");
    $contact_location_iframe = SM::smGetThemeOption("contact_location_iframe");

    $mobile = SM::get_setting_value('mobile');
    $email = SM::get_setting_value('email');
    $address = SM::get_setting_value('address');
    ?>
    <section class="all-body-area">
        <div id="main">
            <section class="about-page-area">
                <div class="header-blog">
                    <h2>{{$title}}</h2>
                    <h6>Contact Us Any Time to Support!</h6>
                </div>
                <div class="text-page-blog">
                    <div id="contact" class="page-content page-contact">
                        <div id="message-box-conact"></div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="page-subheading">CONTACT FORM</h3>
                                <div class="contact-form-box">
                                    {!! Form::open(['method'=>'post', 'action'=>'Front\HomeController@send_mail', 'id'=>'contactMail']) !!}
                                    <div class="form-selector">
                                        {{ Form::label('fullname', 'Name', ['class' => 'requiredStar']) }}
                                        {{ Form::text("fullname", null, ['class' => 'form-control input-sm', 'placeholder' => 'Your Name']) }}
                                        @if ($errors->has('fullname'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('fullname') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <div class="form-selector">
                                        {{ Form::label('email', 'Email address', ['class' => 'requiredStar']) }}
                                        {{ Form::text("email", null, ['class' => 'form-control input-sm', 'placeholder' => 'Your E-mail']) }}
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif

                                    </div>
                                    <div class="form-selector">
                                        {{ Form::label('subject', 'Subject', ['class' => 'requiredStar']) }}
                                        {{ Form::text("subject", null, ['class' => 'form-control input-sm', 'placeholder' => 'Subject']) }}
                                        @if ($errors->has('subject'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('subject') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <div class="form-selector">
                                        {{ Form::label('message', 'Message', ['class' => 'requiredStar']) }}
                                        {{ Form::textarea("message", null, ['rows'=>'7', 'class' => 'form-control input-sm', 'placeholder' => 'Your massage']) }}
                                        @if ($errors->has('message'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('message') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <div class="form-selector">
                                        <div class="single-input form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            {!! app('captcha')->display() !!}
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-selector">
                                        <br>
                                        <button type="submit" id="btn-send-contact" class="btn">
                                      <span class="loading" style="display: none;"><i
                                                  class="fa fa-refresh fa-spin"></i></span> Submit
                                        </button>

                                    </div>
                                    <ul class="serviceMailErrors mailErrorList concatMailErrors">
                                    </ul>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6" id="contact_form_map" style="margin-bottom: 10px">
                                @empty(!$contact_des_title)
                                    <h3 class="page-subheading">{{ $contact_des_title }}</h3>

                                @endempty
                                @empty(!$contact_description)
                                    <p>{!! $contact_description  !!}</p>
                                @endempty
                                <br/>

                                <ul class="store_info">
                                    <li><i class="fa fa-home"></i> {{ $address }}
                                    </li>
                                    <li><i class="fa fa-phone"></i><span> {{ $mobile }}</span></li>
                                    <li><i class="fa fa-envelope"></i> Email: <span><a
                                                    href="mailto:{{ $email }}"> {{ $email }}</a></span>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="col-xs-12 col-sm-6" id="contact_form_map">
                                @empty(!$contact_location_title)
                                    <h3 class="page-subheading">{{ $contact_location_title }}</h3>
                                @endempty
                                @empty(!$contact_location_subtitle)
                                    <p>{!! $contact_location_subtitle  !!}</p>
                                @endempty
                                <br/>
                                <iframe src="{!! $contact_location_iframe !!}" width="600" height="350" frameborder="0"
                                        style="border:0;" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    @include('frontend.inc.footer')
@endsection