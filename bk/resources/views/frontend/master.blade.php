<!DOCTYPE html>
<html>
<head>
    @include('frontend.common.meta')
    @include('frontend.inc.css')
    @include('frontend.common.additional_css')
    @stack('style')
    <style>
        .middle {
            display: none;
        }

        ul.pagination {
            float: left;
        }
        /*PRELOADING------------ */
#overlayer {
  width:100%;
  height:100%;  
  position:absolute;
  z-index:99999;
  background:#4a4a4a;
}
.loader {
  display: inline-block;
  width: 30px;
  height: 30px;
  position: absolute;
  z-index:3;
  border: 4px solid #Fff;
  top: 50%;
  animation: loader 2s infinite ease;
}

.loader-inner {
  vertical-align: top;
  display: inline-block;
  width: 100%;
  background-color: #fff;
  animation: loader-inner 2s infinite ease-in;
}

@keyframes loader {
  0% {
    transform: rotate(0deg);
  }
  
  25% {
    transform: rotate(180deg);
  }
  
  50% {
    transform: rotate(180deg);
  }
  
  75% {
    transform: rotate(360deg);
  }
  
  100% {
    transform: rotate(360deg);
  }
}

@keyframes loader-inner {
  0% {
    height: 0%;
  }
  
  25% {
    height: 0%;
  }
  
  50% {
    height: 100%;
  }
  
  75% {
    height: 100%;
  }
  
  100% {
    height: 0%;
  }
}
    </style>
</head>
<body>
	
<!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="107048514477512"
  theme_color="#f37920"
  logged_in_greeting="আসসালামু আলাইকুম, “Virtualshoppersbd” এ আপনাকে স্বাগতম । "
  logged_out_greeting="আসসালামু আলাইকুম, “Virtualshoppersbd” এ আপনাকে স্বাগতম । ">
      </div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-142390853-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-142390853-1');
</script>

<input type="hidden" name="_token" id="table_csrf_token" value="{!! csrf_token() !!}">
@include('frontend.common.login_modal')

@include('frontend.inc.header')


<div class="wrapper">
    <!-- Sidebar  -->
@include('frontend.common.rightCartBar')
@include('frontend.inc.sidebar')

<!-- Page Content  -->
    <section id="content">
        @include('frontend.common.s_w_message')
        <div class="search-html">
            @yield('content')
        </div>
    </section>
</div>

<!--------------Begin: Javascript---------------->
@include('frontend.inc.js')
@include('frontend.common.additional_js')
@stack('script')
<script>
    $(window).load(function() {
	$(".loader").delay(2000).fadeOut("slow");
  $("#overlayer").delay(2000).fadeOut("slow");
})
</script>
</body>
</html>