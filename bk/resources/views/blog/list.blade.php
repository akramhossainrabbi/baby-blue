@extends('layouts.app')
@section('title', 'Blogs')
@section('content')
    <br/>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11">
                        <h4>Blogs List</h4>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('blogcreate')}}" class="btn btn-primary float-right">Create Blog</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>SEO Title</th>
                            <th>Short Description</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(function () {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('bloglist') }}",
                columns: [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "seo_title"},
                    {"data": "short_description"},
                    {"data": "status", "orderable": false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        });
    </script>
@endsection