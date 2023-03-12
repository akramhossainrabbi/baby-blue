@extends('layouts.app')
@section('title', 'Tags')
@section('content')
    <br/>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-11">
                        <h4>Tags List</h4>
                    </div>
                    <div class="col-md-1">
                        <a href="{{url('tags/create')}}" class="btn btn-primary float-right">Create Tag</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="35%">Title</th>
                            <th width="15%">Total Products</th>
                            <th width="15%" class="text-center">Status</th>
                            <th width="30%" class="text-center">Action</th>
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
                ajax: "{{ route('list') }}",
                columns: [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "total_products", "orderable": false},
                    {"data": "status", "orderable": false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        });
    </script>
@endsection