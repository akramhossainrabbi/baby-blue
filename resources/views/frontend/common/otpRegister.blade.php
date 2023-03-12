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
     {!! Form::open(["method"=>"post","action"=>"Front\Dashboard@otp", 'class' => '']) !!}
        <h2 class="text-center">Sign in</h2>   
        </br>
        </br>
        <div class="text-center social-btn">
            <a href="https://virtualshoppersbd.com/login/facebook" class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a>
			<a href="https://virtualshoppersbd.com/login/google" class="btn btn-danger btn-block"><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
        </div>
        
        
        <div class="or-seperator"><i>or</i></div>
        
        
        
        <div class="form-group">
        	
            <div class="input-group">
    <span class="input-group-addon">+88</span>
    <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required="required" autocomplete="off">
  </div>
        </div>
		      
        <div class="form-group">
            <button type="submit" class="btn btn-primary login-btn btn-block">Sign Up/Login</button>
        </div>
        
		
    {!! Form::close() !!}
    
</div>
    </section>
    
 
@endsection
