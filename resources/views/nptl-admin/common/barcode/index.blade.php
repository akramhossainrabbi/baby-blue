@extends("nptl-admin/master")
@section("title","Barcode")
@section("content")
    <section id="widget-grid" class="">
    <?php
    $edit_order = SM::check_this_method_access('barcodes', 'edit') ? 1 : 0;
    $order_status_update = SM::check_this_method_access('barcodes', 'order_status_update') ? 1 : 0;
    $delete_order = SM::check_this_method_access('barcodes', 'delete') ? 1 : 0;
    $per = $edit_order + $delete_order;
    ?>
    <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="product_list_wid">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                        <h2>Barcode list </h2>

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
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Grand Total</th>
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
    <section class="invoice print_section" id="receipt_section">
    </section>
@section('footer_script')
    <script type="text/javascript">
        //Used for Purchase & Sell invoice.
        $(document).on('click', 'a.print-invoice', function (e) {
            e.preventDefault();
            var href = $(this).data('href');
            $.ajax({
                method: "GET",
                url: href,
                dataType: "json",
                success: function (result) {
                    $('#receipt_section').html(result.cart_count);
                    setTimeout(function () {
                        window.print();
                    }, 1000);

                }
            });
        });

        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('dataProcessingBarcode') }}",
                "dataType": "json",
                "type": "GET",
                "data": {"_token": "<?= csrf_token() ?>"}
            },
            "columns": [
                {"data": "id"},
                {"data": "create_date"},
                {"data": "name"},
                {"data": "mobile"},
                {"data": "email"},
                {"data": "address"},
                {"data": "grand_total"},
                {"data": "action", "searchable": false, "orderable": false}
            ]
        });
    </script>
@endsection
@endsection