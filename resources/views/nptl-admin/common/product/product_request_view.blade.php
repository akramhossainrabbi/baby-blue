@extends(('nptl-admin/master'))

@section('title','Product Request')

@section('content')



    

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

    <section id="widget-grid" class="">

        

        

        <!-- row -->

        <div class="row">

            <!-- NEW WIDGET START -->

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->

                <div class="jarviswidget" id="" data-widget-editbutton="false" data-widget-deletebutton="false">

                    <header>

                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>

                        <h2>Product Request</h2>

                    </header>

                    <!-- widget div-->

                    <div>

                        

                        <div id="product_sheet">

                            <!-- widget edit box -->

                            <div class="jarviswidget-editbox">

                                <!-- This area used as dropdown edit box -->

                                <input class="form-control" type="text">

                            </div>

                            <!-- end widget edit box -->

                            <!-- widget content -->

                            <div class="widget-body padding-10">

                                <div class="row">

                                    <section class="invoice" style="background: #fff">

                                        <div class="print-invoice" id="printableArea" style="background: #fff; ">

                                            

                                        <!-- title row -->

                                            <div style="margin-bottom: 20px;">

                                                <table>

                                                    <tbody>

                                                    <tr>

                                                        <td style="font-size: 16px;">Customer Name</td>

                                                        <td style="font-size: 16px;">: {{ $test->name }}</td>

                                                    </tr>

                                                    <tr>

                                                        <td style="font-size: 16px;">Address</td>

                                                        <td style="font-size: 16px;">: {{ $test->address }}</td>

                                                    </tr>

                                                    <tr>

                                                        <td style="font-size: 16px;">Phone Number</td>

                                                        <td style="font-size: 16px;">: {{ $test->mobile }}</td>

                                                    </tr>

                                                    

                                                    </tbody>

                                                </table>

                                            </div>

    

                                        <!-- Table row -->

                                            <div class="row" style="background: #fff;" >

                                                <div class="col-xs-12">

                                                    <table class="table table-bordered" style="background: #fff;">

                                                        <thead>

                                                        <tr>

                                                            <th style="font-size: 16px;">Sl.</th>

                                                            <th style="font-size: 16px;">Item Name</th>

                                                            

                                                            <th style="font-size: 16px;">Qty</th>

                                                            

                                                        </tr>

                                                        </thead>

                                                        <tbody>

                                                       <?php 

                                                       

                                                       $product_name = json_decode($test->product_name);

                                                       $product_qty = json_decode($test->product_qty);

                                                       $i=1;

                                                       ?>

                                                       

                                                        @foreach($product_name as $key=>$item)

                                                            <tr>

                                                                <td style="font-size: 16px;">{{$i}}</td>

                                                                <td style="font-size: 16px;">{{ $item }}</td>

                                                                <td style="font-size: 16px;">{{ $product_qty[$key] }}</td>

                                                            </tr>

                                                        <?php $i++; ?>

                                                        @endforeach

                                                        </tbody>

                                                    </table>

                                                    

                                                </div>

                                                <!-- /.col -->

                                            </div>

                                            <!-- /.row -->

    

                                          

                                            <!-- /.row -->

    

                                        </div>

    

    

                                        <!-- this row will not appear when printing -->

                                      

                                    </section>

                                </div>

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

        

        
        <a href="{{url('vslpanel/orders/download_product_request/'.$test->id  )}}" title="Download Product Request Invoice" class="btn btn-xs btn-default" id="">Download PDF</a>

        <!-- end row -->

    </section>

<script>

    $( "#generate_pdf_btn" ).click(function() {

      make_product_sheet();

    });



function make_product_sheet() {



    console.log("#generate_pdf_btn clicked");

    var pdf = new jsPDF('p', 'pt', 'a4');

    pdf.addHTML(document.getElementById("product_sheet"), function() {



        ps_filename = "product-request-list";

        pdf.save(ps_filename+'.pdf');

    });

}

</script>

@section('footer_script')



@endsection

@endsection