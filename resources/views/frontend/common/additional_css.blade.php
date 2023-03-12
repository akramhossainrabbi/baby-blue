{!!Html::style('additional/dashboard/dashboard.css')!!}
{!!Html::style('additional/toastr/toastr.min.css')!!}
{!!Html::style('additional/css/custom.css')!!}
{{--shop rang slider--}}
{{--{!!Html::style('additional/lib/jquery.bxslider/jquery.bxslider.css')!!}--}}
{{--{!!Html::style('additional/lib/owl.carousel/owl.carousel.css')!!}--}}
{{--{!!Html::style('additional/lib/jquery-ui/jquery-ui.css')!!}--}}
{{--{!!Html::style('additional/lib/css/animate.css')!!}--}}
{{--{!!Html::style('additional/lib/css/reset.css')!!}--}}
{{--{!!Html::style('additional/lib/css/style.css')!!}--}}
{{--{!!Html::style('additional/lib/css/responsive.css')!!}--}}
{{--{!!Html::style('additional/lib/css/option3.css')!!}--}}
{{--{!!Html::style('additional/lib/slick/slick.css')!!}--}}
{{--{!!Html::style('additional/lib/slick/slick-theme.css')!!}--}}


{{--blog section--}}
{!!Html::style('additional/css/blog.css')!!}
{!!Html::style('additional/css/shop.css')!!}
{!!Html::style('additional/css/swiper.min.css')!!}
{{--responsive--}}
{!!Html::style('additional/css/responsive.css')!!}
{{--state--}}
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />--}}
{!!Html::script('additional/js/state.js')!!}

<?php $method = strtolower(SM::current_method()); ?>
<script type="text/javascript">
    var url = '<?php echo url('') . '/'; ?>';
    var method = '<?php echo $method; ?>';
</script>
{!! SM::smGetThemeOption( "google_analytic_code"); !!}