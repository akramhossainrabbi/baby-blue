@extends('frontend.master')
@section('title', 'OTP')
@section('content')
    
<style>
    .login-form {
    background: #d4d9e6;
    left: 50px;
    padding: 43px 25px;
    position: absolute;
    right: 0;
  
    width: 400px;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    z-index: 1;
}

</style>
    
    
    <section class="inner-banner">
       <div class="login-form">
     {!! Form::open(["method"=>"post","action"=>"Front\Dashboard@otplogin", 'class' => '']) !!}
     
     <h2 class="text-center">One time password</h2>  
        </br>
        </br>
        
        
        
                <div class="input-group" style="margin-bottom:20px;">
    <span class="input-group-addon">00</span>
     <input type="text" class="form-control" name="otp" placeholder="OTP" required="required" autocomplete="off">				
                <input type="hidden" class="form-control" name="phone_number" placeholder="phone number" required="required" autocomplete="off" value="{{$number}}">
  </div>
        
		      
        <div class="form-group">
            <button type="submit" class="btn btn-primary login-btn btn-block">Login</button>
        </div>
        
		
    {!! Form::close() !!}
</div>
    </section>
    
 
@endsection
