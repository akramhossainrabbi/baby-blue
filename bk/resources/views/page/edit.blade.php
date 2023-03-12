@extends('layouts.app')
@section('title', 'Edit Page')
@section('content')
    <br/>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11 float-left">
                        <h3 class="box-title">Edit Page</h3>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('pageslist')}}" class="btn btn-primary">Back list</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <form method="post" action="{{url('/pagesupdate',$data->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="menu_title" class="col-sm-2 col-form-label">Menu Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="menu_title" id="menu_title" placeholder="Enter Menu Title" value="{{$data->menu_title}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="page_title" class="col-sm-2 col-form-label">Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="page_title" id="page_title" placeholder="Enter Page Title" value="{{$data->page_title}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="slug" class="col-sm-2 col-form-label">URL Slug:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter Slug" value="{{$data->slug}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="page_subtitle" class="col-sm-2 col-form-label">Page Subtitle:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="page_subtitle" id="page_subtitle" placeholder="Enter Page Subtitle" value="{{$data->page_subtitle}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="page_content" class="col-sm-2 col-form-label">Page Content:</label>
                                <div class="col-sm-10">
                                    <textarea name="page_content" id="page_content" cols="30" rows="3" class="form-control" placeholder="Enter Page Content" required>{{$data->page_content}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Page Publish:</label>
                                <div class="col-sm-10">
                                    {!! Form::select('status', [1=>'Publish', 2=>'Pending / Draft', 3=>'Cancel'], (!empty($data->status)?$data->status : ''),
                                                ['class' => 'form-control status','id'=>'status','placeholder'=>'Select One']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="banner_title" class="col-sm-2 col-form-label">Banner Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="banner_title" id="banner_title" placeholder="Enter Banner Title" value="{{$data->banner_title}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="banner_subtitle" class="col-sm-2 col-form-label">Banner Subtitle:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="banner_subtitle" id="banner_subtitle" placeholder="Enter Banner Title" value="{{$data->banner_subtitle}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="banner_image" class="col-sm-2 col-form-label">Page Banner Image:</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="banner_image" id="banner_image">
                                    <div style="position:relative;">
                                        <img id="image" style="width:auto;height:70px;position:absolute;top:-56px;right:0px;border:1px solid #ddd;padding:2px;background:#a1a1a1;" src="{{ (!empty($data->banner_image)? url($data->banner_image) : url('')) }}" alt="">
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-block">Update Page</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">SEO Title:</label>
                                <div class="col-sm-8">
                                    <textarea name="seo_title" id="seo_title" cols="30" rows="3" class="form-control" placeholder="Enter SEO Title" required>{{$data->seo_title}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">Meta Keywords:</label>
                                <div class="col-sm-8">
                                    <textarea name="meta_key" id="meta_key" cols="30" rows="3" class="form-control" placeholder="Enter Meta Keywords" required>{{$data->meta_key}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">Meta Description:</label>
                                <div class="col-sm-8">
                                    <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control" placeholder="Enter Meta Description" required>{{$data->meta_description}}</textarea>
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
        $('#menu_title').change(function(e) {
            $.get('{{ route('slug_generate') }}',
                { 'menu_title': $(this).val() },
                function( data ) {
                    $('#slug').val(data.slug);
                }
            );
        });
    </script>
@endsection