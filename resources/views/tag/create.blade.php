@extends('layouts.app')
@section('title', 'Create Tag')
@section('content')
    <br/>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11 float-left">
                        <h3 class="box-title">Add Tag</h3>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('tags/list')}}" class="btn btn-primary">Back list</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <form method="post" action="{{route('tags.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="slug" class="col-sm-2 col-form-label">URL Slug:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter Slug" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Tag Description:</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Tag Publish:</label>
                                <div class="col-sm-10">
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option value="1">Publish</option>
                                        <option value="2">Pending / Draft</option>
                                        <option value="3">Cancel</option>
                                    </select>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-block">Save Tag</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Tag Image:</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" id="image" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">SEO Title:</label>
                                <div class="col-sm-8">
                                    <textarea name="seo_title" id="seo_title" cols="30" rows="3" class="form-control" placeholder="Enter SEO Title" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">Meta Keywords:</label>
                                <div class="col-sm-8">
                                    <textarea name="meta_key" id="meta_key" cols="30" rows="3" class="form-control" placeholder="Enter Meta Keywords" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">Meta Description:</label>
                                <div class="col-sm-8">
                                    <textarea name="meta_description" id="meta_description" cols="30" rows="3" class="form-control" placeholder="Enter Meta Description" required></textarea>
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