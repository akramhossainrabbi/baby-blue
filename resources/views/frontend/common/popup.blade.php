<?php
$authCheck = Auth::check();
$newsletter_pop_is_enable = SM::smGetThemeOption( "newsletter_pop_is_enable", 0 );
$offer_is_enable = SM::smGetThemeOption( "offer_is_enable", 0 );

echo Cookie::get( "smSubscribe" );
?>
@if($newsletter_pop_is_enable==1)
	<?php
	$nptlSubscriber = Cookie::get( "nptlSubscriber" );
	if ( !$nptlSubscriber && $authCheck ) {
		$nptlSubscriber = SM::isSubscribed( Auth::user()->email );
	}
	?>
    @if(!$nptlSubscriber)
        <div class="newslatter-popup-item">
            <div class="newslatter-content" id="doodle-newslatter-popup">
                <div class="newslatter-popup-header">
                    <img src="<?php echo SM::sm_get_the_src( SM::sm_get_site_logo(), 193, 78 ); ?>" alt="Logo">
                    <div class="closeBar subscriptionClosedForADay" data-id="#newsletter">
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="newslatter-popup-content pull-left">
                    <h3>{{ SM::smGetThemeOption( "newsletter_pop_title",  'Join Our Newsletter') }}</h3>
                    {!!  SM::smGetThemeOption( "newsletter_pop_description",  '<p>
                    We really care about you and your website as much as you do. from us you get 100% free support.
                </p>') !!}

                    {!! Form::open(["method"=>"post", "action"=>'Front\HomeController@subscribe', 'id'=>"newsletterPopUpForm"]) !!}
                    <div class="newslatter-popup-form">
                        <input type="email" class="popup-email-type" name="email" value="" placeholder="Your E-mail">
                        <button type="submit" id="newsletterPopUpFormSubmit">Submit</button>
                    </div>
                    {!! Form::close() !!}
                    <ul class="newslatter-popup-socail">
                        @empty(!SM::smGetThemeOption("social_facebook"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_facebook") }}"><i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_twitter"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_twitter") }}"><i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_linkedin"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_linkedin") }}"><i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_github"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_github") }}"><i class="fa fa-github"></i> </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_behance"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_behance") }}"><i class="fa fa-behance"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_pinterest"))
                            <li>
                                <a href="{{ SM::smGetThemeOption("social_pinterest") }}"><i
                                            class="fa fa-pinterest-p"></i>
                                </a>
                            </li>
                        @endempty
                    </ul>
                </div>
                <div class="newslatter-popup-img pull-right">
                    <img src="{{ asset('additional/images/newslatter-popup.png') }}" alt="{{ SM::get_setting_value('site_name') }}">
                </div>
            </div>
        </div>
    @endif
@endif
@if($offer_is_enable==1)
	<?php
	$nptlOffer = Cookie::get( "nptlOffer" );
	?>
    @if(!$nptlOffer)
        <div class="offer-popup-item">
            <div class="offer-popup-content" id="doodle-offer-popup">
                <div class="newslatter-popup-header offer-popup-header clearfix">
                    <div class="offer-closeBar pull-right offerClosedForADay">
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="newslatter-popup-content offer-popup-cont text-center pull-left">
                    <h3>{{ SM::smGetThemeOption( "offer_title",  '1st Order To 30% Off') }}</h3>
                    {!!  SM::smGetThemeOption( "offer_description",  '<p>
                        As content marketing continues to drive results for businesses trying to reach their audience
                    </p>
                    <a href="#">Get More</a>') !!}
                </div>
                <div class="offer-popup-img pull-right">
                    <img src="{{ asset('additional/images/offer-popup.png') }}" alt="{{ SM::get_setting_value('site_name') }}">
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    @endif
@endif
