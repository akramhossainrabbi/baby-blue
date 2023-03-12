@extends('layouts.app')
@section('title', 'Create Slider')
@section('content')
    <br/>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11 float-left">
                        <h3 class="box-title">Add Slider</h3>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('sliderslist')}}" class="btn btn-primary">Back list</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <form method="post" action="{{route('store')}}" enctype="multipart/form-data">
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
                                <label for="style" class="col-sm-2 col-form-label">Slider Style:</label>
                                <div class="col-sm-10">
                                    <select name="style" id="style" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option value="1">Slide 1</option>
                                        <option value="2">Slide 2</option>
                                        <option value="3">Slide 3</option>
                                        <option value="3">Slide 4</option>
                                        <option value="3">Slide 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Slider Description:</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Slider Publish:</label>
                                <div class="col-sm-10">
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Select One</option>
                                        <option value="1">Publish</option>
                                        <option value="2">Pending / Draft</option>
                                        <option value="3">Cancel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Slider Image:</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image" id="image" required>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-block">Save Slider</button>
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