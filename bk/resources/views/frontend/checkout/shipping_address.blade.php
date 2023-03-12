<?php

$shipping = Session::get("shipping");

$user = Auth::user();



if (!empty($shipping["firstname"])) {

    $firstname = $shipping["firstname"];

} elseif (!empty($user->firstname)) {

    $firstname = $user->firstname;

} else {

    $firstname = '';

}

if (!empty($shipping["email"])) {

    $email = $shipping["email"];

} elseif (!empty($user->email)) {

    $email = $user->email;

} else {

    $email = '';

}



if (!empty($shipping["mobile"])) {

    $mobile = $shipping["mobile"];

} elseif (!empty($user->mobile)) {

    $mobile = $user->mobile;

} else {

    $mobile = '';

}



if (!empty($shipping["address"])) {

    $address = $shipping["address"];

} elseif (!empty($user->address)) {

    $address = $user->address;

} else {

    $address = '';

}

?>















<div class="form-row">

    <div>



        <h4> <i class="fa fa-map-marker" aria-hidden="true"></i> Delivery Address</h4>

        <hr>

    </div>

    <div class="form-group col-md-12">

        <label for="firstName">Full Name *</label>

        <input required type="text" placeholder="Full Name" class="form-control field-validate" id="firstname"
            name="firstname" value="{{ $firstname }}">

        <span class="help-block error-content" hidden>Please enter your first name')</span>

    </div>



    <div class="form-group col-md-12">

        <label for="firstName">Mobile *</label>

        <input required type="text" placeholder="Mobile" class="form-control field-validate" id="mobile" name="mobile"
            value="{{ $mobile }}">

        <span class="help-block error-content" hidden>Please enter your mobile number')</span>

    </div>



    <div class="form-group col-md-12">

        {!! Form::label('delivery_address', 'Delivery Address', ['class' => 'requiredStar']) !!}

        {!! Form::select('delivery_address',['Select Delivery Area'=>'Select Delivery Area', 'Aftabnagar'=>'Aftab
        Nagar','banasree'=>'Banasree', 'Kakrail' => 'Kakrail', 'Malibag'=>'Malibag', 'Shantinagar' => 'Shantinagar',
        'Mogbazar' => 'Mogbazar', 'Basabo'=>'Basabo', 'Khilgaon'=>'Khilgaon', 'Rampura'=>'Rampura',
        'siddeshawri'=>'Siddeshawri','eskaton'=>'Eskaton', 'elephant_Road'=>'Elephant Road',
        'poribag'=>'Poribag','palton'=>'Palton', 'hatirpool'=>'Hatirpool', 'badda'=>'Badda', 'merulbadda'=>'Merul
        Badda', 'tikatuli'=>'Tikatuli', 'mugda'=>'Mugda', 'motijheel'=>'Motijheel','tikaotli'=>'Tikaotli',
        'lalbag'=>'Lalbag','nikuja_1'=>'Nikuja 1','nikuja_2'=>'Nikuja 2', 'khelkhet' => 'Khelkhet',
        'bashundhara'=>'Bashundhara', 'notunbazar'=>'Notun Bazar', 'baridhara' => 'Baridhara', 'gulshan' => 'Gulshan',
        'gulshan_1' => 'Gulshan 1', 'gulshan_2' => 'Gulshan 2', 'banani' => 'Banani', 'joarshahara' => 'Joar
        Sahara','jatrabari' => 'Jatra Bari', 'cantonment' => 'Cantonment ' , 'airport' => 'Airport ' , 'ashcona' =>
        'Ashcona ' , 'kuril' => 'Kuril', 'kaula' => 'Kaula ','uttara' => 'Uttara','mirpur_DOHS' => 'Mirpur
        DOHS','mohakhali_dOHS' => 'Mohakhali DOHS','Mirpur_13' => 'Mirpur -13', 'Mirpur_12' => 'Mirpur -12', 'Mirpur_11'
        => 'Mirpur-11', 'Baridhara_DHOS' => 'Baridhara DHOS', 'Banani_DOHS' => 'Banani DOHS','Bashundhara_R/A' =>
        'Bashundhara R/A' ], null, ['required'=>'','class'=>'form-control']) !!}



    </div>

    <div class="form-group col-md-12">

        <label for="firstName">Address *</label>

        <input required type="text" placeholder="Address" class="form-control field-validate" id="address"
            name="address" value="{{ $address }}">

        <span class="help-block error-content" hidden>Please enter your address')</span>

    </div>

    <div class="form-group col-md-12">

        <h4>Email ( Invoice will forward into your mail.)</h4>

        <br>

        <input type="email" placeholder="Email (Optional)" class="form-control field-validate" id="email" name="email"
            value="{{ $email }}">

        <span class="help-block error-content" hidden>Please enter your mobile number')</span>

    </div>
    <div class="form-group col-md-12">
        <h4> <i class="fa fa-truck" aria-hidden="true"></i> Delivery Time</h4>
        <br>
        <div class="row" style="display: none;">
            <div class="col-md-6">
                <div class="delivery_date_day_section">
                    <div class="dropdown">
                        <button class="dropbtn"> Please Select Date <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
                        <div id="delivery_date_day" class="dropdown-content">
                            <ul>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> Today </span>
                                                <span> 3 Oct </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> Today </span>
                                                <span> 3 Oct </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> Today </span>
                                                <span> 3 Oct </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> Today </span>
                                                <span> 3 Oct </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> Today </span>
                                                <span> 3 Oct </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="delivery_date_time_section">
                    <div class="dropdown">
                        <button class="dropbtn"> Please Select Time <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
                        <div id="delivery_date_time" class="dropdown-content">
                            <ul>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> 02PM - 03PM </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> 02PM - 03PM </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> 02PM - 03PM </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> 02PM - 03PM </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li> 
                                    <a href="#">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <span> 02PM - 03PM </span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input class="calendar7 form-control" name="delivery_slot" autocomplete="off">
    </div>
    <div id="clearfix"> </div>
    <div class="form-group col-md-6">
        <h4> <i class="fa fa-truck" aria-hidden="true"></i> Delivery Point</h4>
        <br>
        @if(count($shipping_methods)>0)

        <div class="form-check">

            <div class="form-row">

                <ul class="list">
                    @foreach($shipping_methods as $shipping_method)

                    <li class="">

                        <input required class="shipping_data" id="{{$shipping_method->id}}" type="radio"
                            name="shipping_method" value="{{$shipping_method->id}}"
                            shipping_price="{{$shipping_method->charge}}" method_name="{{$shipping_method->title}}"
                            @if(!empty(Session::get('shipping_method')))
                            @if(Session::get('shipping_method.method_name')==$shipping_method->title) checked

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

    </div>







    <div class="form-group col-md-6">
        <h4> <i class="fa fa-money" aria-hidden="true"></i> Payment Method</h4>

        <br>

        @foreach($payment_methods as $payment_method)

        <li>

            <label for="p_method_{{ $payment_method->id }}">

                <input required type="radio" id="p_method_{{ $payment_method->id }}" name="payment_method_id"
                    class="payment_method" value="{{ $payment_method->id }}">

                {{ $payment_method->title }}

            </label>

        </li>

        @endforeach

    </div>

    <!-- <div class="form-group col-md-12">
        <div class="Order_confirm_btn">
            <a href="#" class="btn btn-sm"> Order Now</a>
        </div>
    </div> -->

</div>


<script>

function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
    
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
            }
        }
    }
</script>