<?php
$mobile = SM::get_setting_value('mobile');
$email = SM::get_setting_value('email');
$address = SM::get_setting_value('address');
$country = SM::get_setting_value('country');

// dd(SM::get_setting_value('home_left_image'));
if (Auth::check()) {
	$blogAuthor = Auth::user();
	$fname = $blogAuthor->firstname . " " . $blogAuthor->lastname;
	$fname = trim($fname) != '' ? $fname : $blogAuthor->username;
} else {
	$fname = '';
//    $logonMoadal = 'data-toggle="modal" data-target="#loginModal"';
}
?>
<nav class="navbar">

	<!----------Top-Header--------------->
	<section class="header-wrapper">

		<div class="row">
			
				<div class="col-md-6">
					<h4 class="title-top" style="color: #fff;"><i></i></h4>
				</div>
				<div class="col-md-6">
					<p class="text-right carabera" style="color: #fff;"><i class="fa fa-phone-square" area-hidden="true"></i>Hotline:&nbsp;{{ $mobile }}&nbsp;&nbsp;&nbsp; <i class="fa fa-envelope-square" area-hidden="true"></i>Email:&nbsp;{{ $email }}</p>
				
					{{--<a href="#" class="btn btn-language">বাংলা</a>--}}
				</div>

			
		</div>
	</section>

	<!----------Middle-Header--------------->
	<section class="middle-top">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">
				<button type="button" id="sidebarCollapse" class="btn btn-menu-bar">
					<i class="fa fa-bars"></i>
				</button>
				<div class="logo" style="width: 65%;height: 50px;">
					<a href="{{ url('/') }}">
						<img class="img-responsive" alt="{{ SM::get_setting_value('site_name') }}"
						src="{{SM::sm_get_the_src(SM::get_setting_value('logo'))}}"/>

						
					</a>
				</div>
			</div>
			<div class="col-md-6 col-sm-5 col-xs-12" style="position: relative;">
				<div class="search-container">
					
						<div class="input-serach" id="main_search">
							<input autocomplete="off" id="search_text" type="text"
							placeholder="Search for Products" name="search_text">
						</div>
						<button type="">Search</button>
					
				</div>
				</div>
	
			<div class="col-md-2 col-sm-3 col-xs-6 hidden-xs">

				<div class="customer-area">
					
					<div class="wish cart_icon">
					
						<a class="wish-link btn btn-info"  style="cursor:pointer;">
						    Help
					    </a>	
					    <!--<a class="wish-link btn btn-primary"  style="cursor:pointer;">-->
						   <!-- sign in-->
					    <!--</a>-->
					    @if(\Auth::check())
					        @if(\Auth::user()->firstname == '' && \Auth::user()->lastname== '')
					        <a href="{{url('/dashboard')}}"><img src="https://ui-avatars.com/api/?color=ff0000&name=Virtual+Shoppers" style="max-width:34px;"></img></a>
					         
					        @elseif(\Auth::user()->firstname != '' && \Auth::user()->lastname== '')
					        <a href="{{url('/dashboard')}}"><img src="https://ui-avatars.com/api/?color=ff0000&name={{ \Auth::user()->firstname }}+Shoppers" style="max-width:34px;"></img></a>
					        
					        @elseif(\Auth::user()->firstname == '' && \Auth::user()->lastname!= '')
					        <a href="{{url('/dashboard')}}"><img src="https://ui-avatars.com/api/?color=ff0000&name=Virtual+{{ \Auth::user()->lastname }}" style="max-width:34px;"></img></a>
					        
					        @else
                            <a href="{{url('/dashboard')}}"><img src="https://ui-avatars.com/api/?color=ff0000&name={{ \Auth::user()->firstname }}+{{ \Auth::user()->lastname }}" style="max-width:34px;"></img></a>
                            
					        @endif
                            <a href="#" class="wish-link btn btn-primary"  style="cursor:pointer;">Log Out</a>{{--{{ route('ayon_logout') }}--}}
					    @else
					        <a class="wish-link btn btn-primary" href="{{url('/cart')}}"  style="cursor:pointer;">
						        sign in
					        </a>
					    @endif
						</div>
					</div>
				</div>
			</div>
			
		</section>
	</nav>


