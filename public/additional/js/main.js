(function ($) {
    "use strict";

    /*videojs.options.flash.swf = "video-js";*/


    if ($('.video-btn').length > 0) {
        $(".video-btn").on("click", function () {
            $('.video-popup').fadeIn('slow');
        });

    }
    if ($('.video-close-icon').length > 0) {
        $(".video-close-icon").on("click", function () {
            $('.video-popup').fadeOut('slow');
            var myPlayer = videojs("myVideo_html5_api");
            if (!myPlayer.paused()) {
                myPlayer.pause();
            }
        });

    }

    if($('.scrolls_pakg').length > 0){
        $('.scrolls_pakg').on ('click',function () {
            $('html, body').animate({scrollTop: $(this.hash).offset().top -220}, 1000);
            return false;
        });
    }

    if ($('#mrks_package_content').length > 0) {
        var spos = $('#mrks_package_content').offset().top;
        $(window).scroll(function (event) {
            var scroll = $(window).scrollTop();
            if(scroll > spos -700) {
                $('.single_package_btn').fadeOut();
            }else {
                $('.single_package_btn').fadeIn();
            }

        });
    }


    /**-------------------------------------------------
     *Main Slider
     *----------------------------------------------------**/
    if ($('.swiper-container.main').length > 0) {
        new Swiper('.swiper-container.main', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            parallax: true,
            effect: 'fade',
            loop: true,
            spaceBetween: 700,
            speed: 900,
            autoplay: {
                delay: 6000,
            },
        });
    }


    if ($('.swiper-container.testmonial-carousel').length > 0) {
        new Swiper('.swiper-container.testmonial-carousel', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            nextButton: '.tnext',
            prevButton: '.tprev',
            parallax: true,
            speed: 600
        });
    }

    if ($('.swiper-container.latest-blog').length > 0) {
        new Swiper('.swiper-container.latest-blog', {
            slidesPerView: 3,
            pagination: '.swiper-pagination',
            paginationClickable: false,
            nextButton: '.tnext',
            prevButton: '.tprev',
            speed: 600,
            draggable: true,

            breakpoints: {
                1024: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        });
    }

    if ($('.swiper-container.team-slider').length > 0) {
        new Swiper('.swiper-container.team-slider', {
            slidesPerView: 4,
            pagination: '.swiper-pagination',
            paginationClickable: true,
            nextButton: '.ttnext',
            prevButton: '.ttprev',
            speed: 600,
            draggable: true,
            autoplay: {
                delay: 6000,
            },
            breakpoints: {
                1024: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                540: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        });
    }

    if ($('.swiper-container.releted-blog-slider').length > 0) {
        new Swiper('.swiper-container.releted-blog-slider', {
            slidesPerView: 2,
            pagination: '.swiper-pagination',
            paginationClickable: true,
            nextButton: '.tnext',
            prevButton: '.tprev',
            speed: 600,
            draggable: true,
            autoplay: {
                delay: 6000,
            },
            breakpoints: {
                1024: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },
                540: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        });
    }

    if ($('.swiper-container.client-slider').length > 0) {
        new Swiper('.swiper-container.client-slider', {
            slidesPerView: 6,
            pagination: '.swiper-pagination',
            paginationClickable: true,
            speed: 600,
            draggable: true,
            autoplay: {
                delay: 6000,
            },
            breakpoints: {
                1024: {
                    slidesPerView: 4
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
                540: {
                    slidesPerView: 2,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        });
    }

    /**-------------------------------------------------
     *Fixed HEader
     *----------------------------------------------------**/
    $(window).on('scroll', function () {

        /**Fixed header**/
        if ($(window).scrollTop() > 40) {
            $('.main-header').addClass('fixed-header animated fadeInDown');
        } else {
            $('.main-header').removeClass('fixed-header animated fadeInDown');
        }
    });


    /**-------------------------------------------------
     *Back to Top
     *----------------------------------------------------**/
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > $(window).height()) {
            $("#back-to-top").addClass('show-it');
        } else {
            $("#back-to-top").removeClass('show-it');
        }
    });
    $("body, html").on("click", "#back-to-top", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 1200);
    });


    /**-------------------------------------------------
     *MIXItup
     *----------------------------------------------------**/
    if ($('#mixitup').length > 0) {
        var containerEl = document.querySelector('#mixitup');
        var mixer = mixitup(containerEl, {
            animation: {
                effects: 'fade scale stagger(50ms)' // Set a 'stagger' effect for the loading animation
            },
            load: {
                filter: 'none' // Ensure all targets start from hidden (i.e. display: none;)
            }
        });
        // Add a class to the container to remove 'visibility: hidden;' from targets. This
        // prevents any flickr of content before the page's JavaScript has loaded.

        containerEl.classList.add('mixitup-ready');
        // Show all targets in the container
        mixer.show().then(function () {
            // Remove the stagger effect for any subsequent operations
            mixer.configure({
                animation: {
                    effects: 'fade scale'
                }
            });
        });
    }


    /**-------------------------------------------------
     *MAP
     *----------------------------------------------------**/

    if ($("#gmap").length > 0) {
        var map;
        map = new GMaps({
            el: '#gmap',
            lat: 23.797424,
            lng: 90.369409,
            scrollwheel: false,
            zoom: 17,
            zoomControl: true,
            panControl: false,
            streetViewControl: false,
            mapTypeControl: false,
            overviewMapControl: false,
            clickable: false
        });
        map.addMarker({
            lat: 23.797424,
            lng: 90.369409
        });
    }


    /**-------------------------------------------------
     *FUN FACT
     *----------------------------------------------------**/
    if ($('.single-fun-fact').length > 0) {
        var skl = true;
        $('.single-fun-fact').appear();
        $('.single-fun-fact').on('appear', function () {
            if (skl) {
                $('.single-fun-fact h3').each(function () {
                    var $this = $(this);
                    jQuery({Counter: 0}).animate({Counter: $this.attr('data-counter')}, {
                        duration: 6000,
                        easing: 'swing',
                        step: function () {
                            var num = Math.ceil(this.Counter).toString();
                            if (Number(num) > 999) {
                                while (/(\d+)(\d{3})/.test(num)) {
                                    num = num.replace(/(\d+)(\d{3})/, '<span>' + '$1' + '</span>' + '$2');
                                }
                            }
                            $this.html(num);
                        }
                    });
                });
                skl = false;
            }
        });
    }

    /**-------------------------------------------------
     *MOBILE MENU
     *----------------------------------------------------**/
    if ($('.mobile-menu').length > 0) {
        $('.mobile-menu').on('click', function () {
            $(this).toggleClass('active');
            $('.main-menu > ul').toggleClass('mb-menu');
        });
        if ($(window).width() < 991) {

            $(".main-menu li.has-menu-items > a").on('click', function () {
                $(this).parent().toggleClass('active');
                $(this).parent().children('.sub-menu').slideToggle('slow');
                return false;
            });

        }
    }

    /**-------------------------------------------------
     *Login Form
     *----------------------------------------------------**/
    $(".loginFormShow").on('click', function (e) {
        e.preventDefault();
        if ($('.login-form-wraper').hasClass("active")) {
            $('.login-form-wraper').fadeOut('slow');
        }
        $('.login-form-wraper').addClass('active');
        $('.login-form-wraper').toggle();
    });

    $(".signUpFormShow").on('click', function (e) {
        e.preventDefault();
        if ($('.singup-form-wraper').hasClass("active")) {
            $('.singup-form-wraper').fadeOut('slow');
        }
        $('.singup-form-wraper').addClass('active');
        $('.singup-form-wraper').toggle();

    });

    $(".forgot-pass").on('click', function (e) {
        e.preventDefault();
        if ($('.login-form-wraper').hasClass("active")) {
            $('.login-form-wraper').fadeOut('slow');
        }
        if ($('.singup-form-wraper').hasClass("active")) {
            $('.singup-form-wraper').fadeOut('slow');
        }
        if ($('.guest-form-wraper').hasClass("active")) {
            $('.guest-form-wraper').fadeOut('slow');
        }
        $('.forgot-form-wraper, .guest-form-wraper').addClass('active');
        $('.forgot-form-wraper, .guest-form-wraper').toggle();


    });


    $(".close-icon").on('click', function (e) {
        e.preventDefault();
        $('.singup-form-wraper, .login-form-wraper, .forgot-form-wraper, .guest-form-wraper').removeClass('active');
        $('.singup-form-wraper, .login-form-wraper, .forgot-form-wraper, .guest-form-wraper').fadeOut('slow');
    });


    /**-------------------------------------------------
     * Appear
     *----------------------------------------------------**/

    if ($(".web-test-skills").length > 0) {
        $('.web-test-skills').appear();
        $('.web-test-skills').on('appear', loadSkills);
    }
    var coun = true;

    function loadSkills() {
        $(".web-test-skills").each(function () {
            var datacount = $(this).attr("data-parcent");
            $(".skills-bar", this).animate({'width': datacount + '%'}, 2000);
            if (coun) {
                $(this).find('.parcentag').each(function () {
                    var $this = $(this);
                    $({Counter: 0}).animate({Counter: datacount}, {
                        duration: 2000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.ceil(this.Counter) + '%');
                        }
                    });
                });

            }
        });
        coun = false;
    }

    if ($('.ifram_video').length > 0) {
        $('.ifram_video').magnificPopup({
            type: 'iframe'
        });
    }
    ;

    if ($(".search-wrap").length > 0) {
        var todg = true;
        $(".searchIcon").on("click", function (e) {
            e.preventDefault();
            if (todg) {
                $(".search-wrap").fadeIn("slow");
                todg = false;
            } else {
                $(".search-wrap").fadeOut("slow");
                todg = true;
            }
        });

        $(document).on('mouseup', function (e) {
            var container = $(".search-inner");

            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $(".search-wrap").fadeOut("slow");
                todg = true;
            }

        });
    }


    var width = $(window).width();
    resizeSmWindow(width);

    $(window).resize(function () {
        var width = $(window).width();
        resizeSmWindow(width);
    });

    function resizeSmWindow(width) {
        if (width < 990) {
            $(".main-menu > ul").removeClass("menu");
            $(".main-menu > ul").addClass("mobile-ul");
        } else {
            $(".main-menu > ul").removeClass("mobile-ul");
            $(".main-menu > ul").addClass("menu");
        }
    };


    var inputs = document.querySelectorAll('.inputfile');
    Array.prototype.forEach.call(inputs, function (input) {
        var label = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener('change', function (e) {
            var fileName = '';
            if (this.files && this.files.length > 1)
                fileName = ( this.getAttribute('data-multiple-caption') || '' ).replace('{count}', this.files.length);
            else
                fileName = e.target.value.split('\\').pop();

            if (fileName)
                label.querySelector('span').innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });


    if ($("#ab-time-count").length > 0) {
        var $this = $("#ab-time-count"),
            mainTimeInMinutes = parseInt($this.data("minutes")),
            // abday = $("#ab-day"),

            abHours = $("#ab-hours"),
            abMinutes = $("#ab-minutes"),
            abSeconds = $("#ab-seconds");

        // var day = Math.floor(mainTimeInMinutes / 1440);

        var hour = Math.floor(mainTimeInMinutes / 60);
        var minutes = mainTimeInMinutes % 60;
        var second = 60;

        // console.log("mainTimeInMinutes " + mainTimeInMinutes);
        //   abday.text(day);

        abHours.text(hour);
        abMinutes.text(minutes);
        abSeconds.text(second);

        var isLoopNotCompleted = true;
        setInterval(function () {
            if (isLoopNotCompleted) {
                if (second == 0) {
                    second = 60;
                    if (minutes == 0) {
                        minutes = 60;

                        if (hour == 0) {
                            hour = 24;
                            isLoopNotCompleted = false;
                            hour = minutes = second = "00";
                        } else {
                            hour--;
                        }
                        abHours.text(hour);
                    } else {
                        minutes--;
                    }
                    abMinutes.text(minutes);
                } else {
                    second--
                }
                abSeconds.text(second);
            }
        }, 1000);


    }
    /**-------------------------------------------------
     *WOW Scroll animation
     *----------------------------------------------------**/
    // new WOW().init();


    /*---------------------------- offer popup -------------------*/
    setTimeout(function () {
        $('.offer-popup-item').css({
            'opacity': 1,
            'visibility': 'visible'
        });
        $('#doodle-offer-popup').css({
            'transform': 'scale(1) translateY(-50%)',
            '-moz-transform': 'scale(1) translateY(-50%)',
            '-webkit-transform': 'scale(1) translateY(-50%)',
        });

    }, 1000);

    /*---------------------------- newslatter popup -------------------*/

    setTimeout(function () {
        $('.newslatter-popup-item').css({
            'opacity': 1,
            'visibility': 'visible'
        });
        $('#doodle-newslatter-popup').css({
            'transform': 'scale(1) translateY(-50%)',
            '-moz-transform': 'scale(1) translateY(-50%)',
            '-webkit-transform': 'scale(1) translateY(-50%)',
        });

    }, 2000);


    if ($('.closeBar').length > 0) {
        $('.closeBar').on('click', function () {
            $('.newslatter-popup-item').css('display', 'none');
        });
    }
    if ($('.offer-closeBar').length > 0) {
        $('.offer-closeBar').on('click', function () {
            $('.offer-popup-item').css('display', 'none');
        });
    }


    $(".package-hover-item").hover(
        function () {
            $(".package-hover-item").removeClass('active');
            $(this).addClass('active');
        }, function () {
            $(this).removeClass('active');
        }
    );
    if ($(".mouse-leave-pointer").length > 0) {
        $(".mouse-leave-pointer").mouseleave(function () {
            $(".particular-advnce").addClass('active');
        });
    }
})(jQuery);