{!!Html::script('frontend/lib/jquery/jquery-1.11.2.min.js')!!}

{!!Html::script('frontend/lib/bootstrap/js/bootstrap.min.js')!!}

{!!Html::script('frontend/lib/select2/js/select2.min.js')!!}

{!!Html::script('frontend/lib/jquery.bxslider/jquery.bxslider.min.js')!!}

{!!Html::script('frontend/lib/owl.carousel/owl.carousel.min.js')!!}

{!!Html::script('frontend/lib/jquery.countdown/jquery.countdown.min.js')!!}

{!!Html::script('frontend/lib/jquery-ui/jquery-ui.min.js')!!}

{{--{!!Html::script('frontend/lib/countdown/jquery.plugin.js')!!}--}}

{{--{!!Html::script('frontend/lib/countdown/jquery.countdown.js')!!}--}}

{{--{!!Html::script('frontend/js/jquery.actual.min.js')!!}--}}

{{--{!!Html::script('frontend/js/theme-script.js')!!}--}}

{{--{!!Html::script('frontend/js/smoothproducts.min.js')!!}--}}

{{--{!!Html::script('frontend/slick/slick.js')!!}--}}



{{--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>--}}

{!!Html::script('frontend/js/slider.js')!!}

<!-- Popper.JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"

        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"

        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>



<!--------Detail Box Slide--------->

<script>
$(document).ready(function(){

  var activeAccordion = localStorage.getItem("accordion");
  if(activeAccordion){
    $('#accordion1 > .panel:eq('+activeAccordion+') .collapse').toggleClass('in');
    localStorage.removeItem("accordion");
  }


    $('#accordion1').find('.panel-heading > a').click(function (){

      localStorage.setItem("accordion", $(this).closest('.panel').index());
      //Expand or collapse this panel
      $(this).next().toggleClass('in');

      //Hide the other panels
      //$(".collapse").not($(this).next()).removeClass('in');
  });
    
    $('#accordion1 .collapse input:checkbox').change(function(){
      if($(this).is(":checked")) {
        $('.collapse').addClass("in");
      } else {
        $('.collapse').removeClass("in");
      }
    });

  
});


    $(document).ready(function(){

      var activeAccordion = localStorage.getItem("accordion");
      if(activeAccordion){
        $('#accordion1 > .panel:eq('+activeAccordion+') .collapse').toggleClass('in');
        localStorage.removeItem("accordion");
      }


        $('#accordion1').find('.panel-heading > a').click(function (){

          localStorage.setItem("accordion", $(this).closest('.panel').index());
          //Expand or collapse this panel
          $(this).next().toggleClass('in');

          //Hide the other panels
          //$(".collapse").not($(this).next()).removeClass('in');
      });
        
        $('#accordion1 .collapse input:checkbox').change(function(){
          if($(this).is(":checked")) {
            $('.collapse').addClass("in");
          } else {
            $('.collapse').removeClass("in");
          }
        });

      
    });


    var slideIndex = 1;

    showDivs(slideIndex);



    function plusDivs(n) {

        showDivs(slideIndex += n);

    }



    function currentDiv(n) {

        showDivs(slideIndex = n);

    }



    function showDivs(n) {

        var i;

        var x = document.getElementsByClassName("mySlides");

        var dots = document.getElementsByClassName("demo");

        if (n > x.length) {

            slideIndex = 1

        }

        if (n < 1) {

            slideIndex = x.length

        }

        for (i = 0; i < x.length; i++) {

            x[i].style.display = "none";

        }

        for (i = 0; i < dots.length; i++) {

            dots[i].className = dots[i].className.replace(" w3-opacity-off", "");

        }

        x[slideIndex - 1].style.display = "block";

        dots[slideIndex - 1].className += " w3-opacity-off";

    }

</script>



<!--------Log-In Popover---->

{{--<script>--}}

{{--$("[data-toggle=popover]").popover({--}}

{{--html: true,--}}

{{--content: function () {--}}

{{--return $('#popover-content').html();--}}

{{--}--}}

{{--});--}}

{{--$(document).ready(function () {--}}

{{--$("input[type=checkbox]").click(function () {--}}

{{--alert('gg8');--}}

{{--if ($(this).prop("checked")) {--}}

{{--$('#loginOrSignupButton').html('Sign up!');--}}

{{--} else {--}}

{{--$('#loginOrSignupButton').html('Log in!');--}}

{{--}--}}

{{--});--}}

{{--});--}}



{{--function btnQQd() {--}}

{{--if ($('#signupCheckbox').is(':checked')) {--}}

{{--alert('gg17');--}}

{{--/*$('#loginOrSignupButton').html('Sign up!');*/--}}

{{--} else {--}}

{{--alert('gg19');--}}

{{--/*$('#loginOrSignupButton').html('Log in!');*/--}}

{{--}--}}

{{--}--}}

{{--</script>--}}



<!-----------Chat Box----------->

<script>

    (function () {

        $('#live-chat header').on('click', function () {

            $('.chat').slideToggle(300, 'swing');

            $('.chat-message-counter').fadeToggle(300, 'swing');

        });

        $('.chat-close').on('click', function (e) {

            e.preventDefault();

            $('#live-chat').fadeOut(300);

        });

    })();

</script>



<!-----------Scroll box---------->

{!!Html::script('frontend/js/jquery.scrollbox.js')!!}

<script>

    $(function () {

        $('#demo2').scrollbox({

            linear: true,

            step: 1,

            delay: 0,

            speed: 40

        });

    });

</script>



<!---------Sidebar---------->

<script type="text/javascript">

    $(document).ready(function () {

        $("#sidebar").mCustomScrollbar({

            theme: "minimal"

        });



        $('#sidebarCollapse').on('click', function () {

            $('#sidebar, #content').toggleClass('active');

            $('.collapse.in').toggleClass('in');

            $('a[aria-expanded=true]').attr('aria-expanded', 'false');

        });

    });

</script>

<script>

    $(document).ready(function () {



        $("#sidebar").mCustomScrollbar({

            theme: "minimal"

        });



        $('#sidebarCollapse').on('click', function () {

            $('#sidebar').toggleClass('active');

        });



    });

</script>

<script>

    $(document).ready(function () {

        $("#sidebar").mCustomScrollbar({

            theme: "minimal"

        });

        $('#sidebarCollapse').on('click', function () {

            // open or close navbar

            $('#sidebar').toggleClass('active');

            // close dropdowns

            $('.collapse.in').toggleClass('in');

            // and also adjust aria-expanded attributes we use for the open/closed arrows

            // in our CSS

            $('a[aria-expanded=true]').attr('aria-expanded', 'false');

        });

    });

</script>



<!---------Add to Cart Modal---------->

<script>

    function hideDiv() {

        document.getElementById('aitcg-control-panel').style.display = "none";

        document.getElementById('ShowDivButton').style.display = "initial";

    }



    function showDiv() {

        document.getElementById('aitcg-control-panel').style.display = "block";

        document.getElementById('ShowDivButton').style.display = "block";

    }


</script>

<!-- <script type="text/javascript">
    $(function () {
    $(".product-gallery-ul .best-box").slice(0, 4).show();
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".product-gallery-ul .best-box:hidden").slice(0, 4).slideDown();
        if ($(".product-gallery-ul .best-box:hidden").length == 0) {
            $("#load").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
});

$('a[href=#top]').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 600);
    return false;
});

$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('.totop a').fadeIn();
    } else {
        $('.totop a').fadeOut();
    }
});
</script> -->