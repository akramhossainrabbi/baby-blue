@extends('layouts.app')
@section('title', 'Edit Tag')
@section('content')
    <br/>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11 float-left">
                        <h3 class="box-title">Edit Slider</h3>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('sliderslist')}}" class="btn btn-primary">Back list</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <form method="post" action="{{url('/update',$data->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" value="{{$data->title}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="style" class="col-sm-2 col-form-label">Slider Style:</label>
                                <div class="col-sm-10">
                                    {!! Form::select('style',['slide1'=>'Slide 1','slide2'=>'Slide 2', 'slide3'=>'Slide 3', 'slide4'=>'Slide 4', 'slide5'=>'Slide 5'],$data->style,['required'=>'','class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Slider Description:</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description" required>{{$data->description}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Slider Publish:</label>
                                <div class="col-sm-10">
                                    {!! Form::select('status', [1=>'Publish', 2=>'Pending / Draft', 3=>'Cancel'], (!empty($data->status)?$data->status : ''),
                                                ['class' => 'form-control status','id'=>'status','placeholder'=>'Select One']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Slider Image:</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" id="image" value="{{$data->image}}">
                                    <div style="position:relative;">
                                        <img id="image"
                                             style="width:auto;height:70px;position:absolute;top:-56px;right:0px;border:1px solid #ddd;padding:2px;background:#a1a1a1;"
                                             src="{{ (!empty($data->image)? url($data->image) :
                                                                     url('')) }}" alt="">
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-block">Update Slider</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('javascript')
@endsection