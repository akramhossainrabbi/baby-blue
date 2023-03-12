@extends('frontend.master')
@section("title", "Order Complete")
@section("content")
    <?php
        //     var_dump(Session::get("grand_total"));
        //     var_dump(Session::get("tax_amount"));
        //     var_dump(Session::get("coupon_amount"));
        // var_dump(Session::get('step'));
        // var_dump(Session::get('shipping'));
        // var_dump(Session::get('billing'));
        // var_dump(Session::get('shipping_method'));
        // var_dump(Session::get('coupon'));
//    exit();
    ?>
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="shipping-methods" style="display: inline-block;">

    <p class="title">Please select a prefered shipping method to use on this order</p>

    {!! Form::open(['method'=>'post', 'url'=>'confirm-order-post', 'id'=>'confirm-order-post', 'name'=>'confirm-order-post']) !!}

 

    <div class="submitButton">

        <button type="submit"

                class="btn btn-danger custom-btn">Confirm Order

        </button>

    </div>

    {{ Form::close() }}

</div>
                </div>
            </div>

        </div>
    </section>
@endsection
