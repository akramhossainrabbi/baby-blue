@extends('layouts.app')
@section('title', 'Edit Tag')
@section('content')
    <br/>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11 float-left">
                        <h4>Edit Tag</h4>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('tags/list')}}" class="btn btn-primary float-right">Back List</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <form method="post" action="{{url('/tags/update',$data->id)}}" enctype="multipart/form-data">
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
                                <label for="slug" class="col-sm-2 col-form-label">URL Slug:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="slug" id="slug" value="{{$data->slug}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Tag Description:</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control" required>{{$data->description}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Tag Publish:</label>
                                <div class="col-sm-10">
                                    {!! Form::select('status', [1=>'Publish', 2=>'Pending / Draft', 3=>'Cancel'], (!empty($data->status)?$data->status : ''),
                                                ['class' => 'form-control status','id'=>'status','placeholder'=>'Select One']) !!}
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-block">Update Tag</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-sm-2 col-form-label">Tag Image:</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" id="image" value="{{$data->image}}">
                                    <div style="position:relative;">
                                        <img id="image"
                                             style="width:auto;height:70px;position:absolute;top:-56px;right:0px;border:1px solid #ddd;padding:2px;background:#a1a1a1;"
                                             src="{{ (!empty($data->image)? url($data->image) :
                                                                     url('')) }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">SEO Title:</label>
                                <div class="col-sm-8">
                                    <textarea name="seo_title" id="seo_title" cols="30" rows="3" class="form-control" required>{{$data->seo_title}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">Meta Keywords:</label>
                                <div class="col-sm-8">
                                    <textarea name="meta_key" id="meta_key" cols="30" rows="3" class="form-control" required>{{$data->meta_key}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">Meta Description:</label>
                                <div class="col-sm-8">
                                    <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control" required>{{$data->meta_description}}</textarea>
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
    <script>
        $('#title').change(function(e) {
            $.get('{{ route('slug_generate') }}',
                { 'title': $(this).val() },
                function( data ) {
                    $('#slug').val(data.slug);
                }
            );
        });
    </script>
@endsection
