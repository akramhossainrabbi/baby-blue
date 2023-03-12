@extends("nptl-admin/master")
@section("title","Wholesales")
@section("content")
    @include(('nptl-admin/common/media/media_pop_up'))
    <?php
    $edit_wholesale = SM::check_this_method_access('wholesales', 'edit') ? 1 : 0;
    $wholesale_status_update = SM::check_this_method_access('wholesales', 'wholesale_status_update') ? 1 : 0;
    $delete_wholesale = SM::check_this_method_access('wholesales', 'destroy') ? 1 : 0;
    $per = $edit_wholesale + $delete_wholesale;
    ?>
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wholesale_list_wid">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-star"></i> </span>
                        <h2>Subscriber list </h2>

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
                            <div class="row">
                                <form method="get" action="">
                                    <div class="col-md-3 form-group">
                                        <label for="name">Name</label>
                                        <input type="text" placeholder="Name" class="form-control" id="name"
                                               name="name"
                                               value="{{ $name }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="email">Email</label>
                                        <input type="email" placeholder="Email" class="form-control" id="email"
                                               name="name"
                                               value="{{ $email }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="contact">Contact</label>
                                        <input type="text" placeholder="Contact" class="form-control" id="contact"
                                               contact="contact"
                                               value="{{ $contact }}">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="status">Status</label>
                                        <select name="sstatus" id="sstatus" class="form-control ">
                                            <option value="">Select Subscriber Status</option>
                                            <option value="1" {{ $status == '1' ? "selected" : "" }}>Published
                                            </option>
                                            <option value="2" {{ $status == '2' ? "selected" : "" }}>Pending
                                            <option value="3" {{ $status == '3' ? "selected" : "" }}>Canceled
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <button type="submit" name="submit" value="submit"
                                                class="btn btn-primary margin-bottom-5 margin-top-22"><i
                                                    class="fa fa-recycle"></i> Sort
                                        </button>
                                        <button type="submit" name="excel" value="excel"
                                                class="btn btn-default margin-bottom-5 margin-top-22"><i
                                                    class="fa fa-file-excel-o"></i> Download Excel
                                        </button>
                                        <button style="display: none;" type="button" name="submit" value="submit" id="showOfferMailPopUp"
                                                class="btn btn-success margin-bottom-5 margin-top-22"><i
                                                    class="fa fa-envelope"></i> Send Mail
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- this is what the user will see -->
                            <table id="" class="table table-striped table-bordered sm_table" width="100%">

                                <thead>
                                <tr>
                                    <th width="5"><label><input type="checkbox" class="allCheck"></label></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Business</th>
                                    <th>Business Type</th>
                                    <th>Category</th>
                                    <?php if ($wholesale_status_update != 0): ?>
                                    <th class="text-center">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </thead>
                                <tbody id="dataBody">
                                @include('nptl-admin.common.wholesale.wholesales')
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Select</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Business</th>
                                    <th>Business Type</th>
                                    <th>Category</th>
                                    <?php if ($wholesale_status_update != 0): ?>
                                    <th class="text-center">Status</th>
                                    <?php endif; ?>
                                    <?php if ($per != 0): ?>
                                    <th class="text-center">Action</th>
                                    <?php endif; ?>
                                </tr>
                                </tfoot>

                            </table>
                            @include('nptl-admin.common.common.pagination_links', ['smPagination'=>$all_wholesale])
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
    <!-- Button trigger modal -->
    <div class="modal fade" id="sm_mail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {!! Form::open(["method"=>"post", "route"=>"wholesaleMail", "id"=>"mailForm"]) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="myModalLabel">{{SM::sm_get_site_name()}} Mail Service</h2>
                </div>
                <div class="modal-body">
                    <h5>Mail to</h5>
                    <ul id="mailTo">
                    </ul>
                    <div class="form-group">
                        <label for="discount_title">Discount Title</label>
                        <input type="text" class="form-control" id="discount_title" name="discount_title"
                               value="30% OFF ALL SERVICES PACKAGES"/>
                    </div>
                    <div class="form-group">
                        <label for="available_title">Available Title</label>
                        <input type="text" class="form-control" id="available_title" name="available_title"
                               value="OFFER AVAILABLE ONLY 5 DAY"/>
                    </div>
                    <div class="form-group">
                        <label for="of_message">Mail Message</label>
                        <textarea class="form-control" rows="4" id="of_message" name="message">ALL {{SM::sm_get_site_name()}} Products
UP TO 30% OFF</textarea>
                    </div>
                    <div class="form-group">
                        <label for="of_btn_title">Button Title</label>
                        <input type="text" class="form-control" id="of_btn_title" name="btn_title" value="Order Now"/>
                    </div>
                    <div class="form-group">
                        <label for="of_btn_link">Button Link</label>
                        <input type="text" class="form-control" id="of_btn_link" name="btn_link"
                               value="{{ url('/') }}"/>
                    </div>
                    <div class="row">
                        @include('nptl-admin/common/common/image_form',['header_name'=>'Offer Title', 'image'=>'', 'grid'=>'col-xs-12 col-sm-12 col-md-12'])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="fa fa-times"></i> Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary" id="sendOfferMain"><i class="fa fa-envelope-o"></i>
                        Send Mail
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection