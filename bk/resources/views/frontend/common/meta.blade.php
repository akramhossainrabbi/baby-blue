<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="_token" content="{{csrf_token()}}"/>
<?php
$site_name = SM::sm_get_site_name();
$site_name = SM::sm_string($site_name) ? $site_name : 'Next Page Technology Ltd.';

$seo_title = stripslashes(
    (
        isset($seo_title)
        && SM::sm_string($seo_title)
    )
        ? $seo_title
        : SM::get_setting_value('seo_title')
);
$meta_key = stripslashes(
    (
        isset($meta_key)
        && SM::sm_string($meta_key)
    )
        ? $meta_key
        : SM::get_setting_value('site_meta_keywords')
);
$meta_description = stripslashes(
    (
        isset($meta_description)
        && SM::sm_string($meta_description)
    )
        ? $meta_description
        : SM::get_setting_value('site_meta_description')
);
$image = (isset($image)
    && SM::sm_string($image)) ? $image
    : asset(SM::sm_get_the_src(SM::get_setting_value('site_screenshot')));


?><title>{{ $seo_title }}</title>

<meta name="keywords" content="{!!$meta_key!!}">
<meta name="description" content="{!! $meta_description !!}"/>

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{$seo_title}}">
<meta itemprop="description" content="{!! $meta_description !!}">
<meta itemprop="image" content="{!!$image!!}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{$site_name}}">
<meta name="twitter:title" content="{{ $seo_title }}">
<meta name="twitter:description" content="{!! $meta_description !!}">
<meta name="twitter:image:src" content="{!!$image!!}">

<!-- Open Graph data -->
<meta property="og:title" content="{{ $seo_title }}"/>
<meta property="og:type" content="article"/>
<meta property="og:image" content="{!!$image!!}"/>
<meta property="og:description" content="{!! $meta_description !!}"/>
<meta property="og:site_name" content="{{$site_name}}"/>
<link rel="icon" href="<?php echo SM::sm_get_the_src(SM::sm_get_site_favicon(), 30, 30); ?>" type="image/x-icon">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-180162563-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-180162563-1');
</script>
<!--Start of Tawk.to Script-->
{{--<script type="text/javascript">--}}
    {{--var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();--}}
    {{--(function(){--}}
        {{--var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];--}}
        {{--s1.async=true;--}}
        {{--s1.src='https://embed.tawk.to/5cea3c4d2135900bac1288a8/default';--}}
        {{--s1.charset='UTF-8';--}}
        {{--s1.setAttribute('crossorigin','*');--}}
        {{--s0.parentNode.insertBefore(s1,s0);--}}
    {{--})();--}}
{{--</script>--}}
<!--End of Tawk.to Script-->