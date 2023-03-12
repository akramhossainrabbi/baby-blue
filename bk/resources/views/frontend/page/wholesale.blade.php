@extends('frontend.master')
@section("title", "Buy in Bulk")
@section('content')
    <!-- page wapper-->
    <style>
        ul.categories li {
            display: inline-block;
            width: 32%;
            padding: 5px;
        }

    </style>
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
        @include('frontend.common.breadcrumb')
        <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-6 col-md-offset-3" id="center_column">
                    <!-- page heading-->
                    <h2 class="page-heading">
                        <span class="page-heading-title2">Buying In Bulk? We are happy to help!</span>

                    </h2>
                    <!-- Content page -->
                    <div class="content-text clearfix">
                        {!! Form::open(["method"=>"post","action"=>"Front\HomeController@storeWholesale"]) !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::text('name', null,['class'=>'form-control', 'placeholder'=>'Name', 'required']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::text('email', null,['class'=>'form-control', 'placeholder'=>'Email', 'required']) !!}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('contact') ? ' has-error' : '' }}">
                            {!! Form::text('contact', null,['class'=>'form-control', 'placeholder'=>'Contact', 'required']) !!}
                            @if ($errors->has('contact'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            {!! Form::text('location', null,['class'=>'form-control', 'placeholder'=>'Location', 'required']) !!}
                            @if ($errors->has('location'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('location') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('business') ? ' has-error' : '' }}">
                            {!! Form::text('business', null,['class'=>'form-control', 'placeholder'=>'Business / Store / Boutique Name', 'required']) !!}
                            @if ($errors->has('business'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('business') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('business_type') ? ' has-error' : '' }}">
                            {{ Form::select('business_type', ['1'=>'Wholesaler', 'Manufacturer'=>'Manufacturer'], null, array('class'=>'form-control', 'required')) }}
                            @if ($errors->has('business_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('business_type') }}</strong>
                                 </span>
                            @endif
                        </div>
                        @if(count($featured_categories)>0)
                            <div class="form-group">
                                <div style="" id="MyDiv">
                                    <p><strong>CATEGORIES</strong></p>
                                    <ul class="categories">
                                        @foreach($featured_categories as $category)
                                            <li>
                                                <input type="checkbox" name="category_id[]"
                                                       id="category_{{ $category->id }}"
                                                       value="{{ $category->title }}"
                                                       class="categorylist"> <label
                                                        for="category_{{ $category->id }}">
                                                    {{ $category->title }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {!! Form::close() !!}
                    </div>
                    <!-- ./Content page -->
                </div>
                <!-- ./ Center colunm -->
            </div>
            <!-- ./row-->
        </div>
    </div>
    <!-- ./page wapper-->
@endsection