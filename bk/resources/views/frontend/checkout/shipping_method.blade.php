<div class="shipping-methods">
    <p class="title">একটি পছন্দসই  পাঠানো  পদ্ধতি নির্বাচন করুন  (Please select a prefered shipping method to use on this order)</p>
    {!! Form::open(['method'=>'post', 'url'=>'checkout_shipping_method', 'id'=>'shipping_mehtods_form', 'name'=>'shipping_mehtods']) !!}

    @if(count($shipping_methods)>0)
        <div class="form-check">
            <div class="form-row">
                <ul class="list">
                @foreach($shipping_methods as $shipping_method)
                        <li>
                            <input required class="shipping_data"
                                   id="{{$shipping_method->id}}" type="radio"
                                   name="shipping_method"
                                   value="{{$shipping_method->id}}"
                                   shipping_price="{{$shipping_method->charge}}"
                                   method_name="{{$shipping_method->title}}"
                                   @if(!empty(Session::get('shipping_method')))
                                   @if(Session::get('shipping_method.method_name') == $shipping_method->title) checked
                                    @endif @endif
                            >
                            <label for="{{$shipping_method->id}}">{{$shipping_method->title}}
                                --- {{SM::currency_price_value($shipping_method->charge)}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="alert alert-danger alert-dismissible error_shipping" role="alert"
         style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        পাঠানো  পদ্ধতি নির্বাচন করুন  (Please select a shipping method )
    </div>
    <div class="submitButton">
        <button type="submit"
                class="btn btn-success">Continue
        </button>
    </div>
    {{ Form::close() }}
</div>