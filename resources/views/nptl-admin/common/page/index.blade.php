@extends(('nptl-admin/master'))
@section('title','Admin Page list')
@section('content')

    <?php
    $edit_page = SM::check_this_method_access('page', 'edit_page') ? 1 : 0;
    $page_status_update = SM::check_this_method_access('page', 'page_status_update') ? 1 : 0;
    $delete_page = SM::check_this_method_access('page', 'delete_page') ? 1 : 0;
    $per = $edit_page + $delete_page;
    ?>
    <section id="widget-grid" class="">

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="page_list_wid">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-pagelines"></i> </span>
                        <h2>Page list </h2>

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
                        <div class="widget-body table-responsive">

                            <!-- this is what the user will see -->
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-striped table-bordered">

                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Menu Title</th>
                                        <th>Page Title</th>
                                        <?php if ($page_status_update != 0): ?>
                                        <th class="text-center">Status</th>
                                        <?php endif; ?>
                                        <?php if ($per != 0): ?>
                                        <th class="text-center">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->

            </article>
            <!-- WIDGET END -->

        </div>

        <!-- end row -->

    </section>
@section('footer_script')
    <script type="text/javascript">
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('dataProcessingPage') }}",
                "dataType": "json",
                "type": "GET",
                "data": {"_token": "<?= csrf_token() ?>"}
            },
            "columns": [
                {"data": "id"},
                {"data": "menu_title"},
                {"data": "page_title"},
                {"data": "status", "orderable": false},
                {"data": "action", "searchable": false, "orderable": false}
            ]
        });
    </script>
@endsection
@endsection

