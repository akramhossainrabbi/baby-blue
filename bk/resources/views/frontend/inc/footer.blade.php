<?php
$site_name = SM::sm_get_site_name();
$site_name = SM::sm_string($site_name) ? $site_name : 'E-Commerce';
$mobile = SM::get_setting_value('mobile');
$email = SM::get_setting_value('email');
$address = SM::get_setting_value('address');
$footer_logo = SM::smGetThemeOption("footer_logo", "");
$footer_background_image = SM::smGetThemeOption("footer_background_image", "");
$footer_widget1_title = SM::smGetThemeOption('footer_widget1_title', "Seo Services");
$footer_widget1_description = SM::smGetThemeOption('footer_widget1_description', "");
$footer_widget2_title = SM::smGetThemeOption('footer_widget2_title', "Seo Services");
$footer_widget2_description = SM::smGetThemeOption('footer_widget2_description', "");
$footer_widget3_title = SM::smGetThemeOption('footer_widget3_title', "Company");
$footer_widget3_description = SM::smGetThemeOption('footer_widget3_description', "");
$footer_widget4_title = SM::smGetThemeOption('footer_widget4_title', "Technology");
$footer_widget4_description = SM::smGetThemeOption('footer_widget4_description', "");
$footer_widget5_title = SM::smGetThemeOption('footer_widget5_title', "Technology");
$footer_widget5_description = SM::smGetThemeOption('footer_widget5_description', "");
$contact_branches = SM::smGetThemeOption("contact_branches");
$newsletter_success_title = SM::smGetThemeOption("newsletter_success_title", "Thank You For Subscribing!");
$newsletter_success_description = SM::smGetThemeOption("newsletter_success_description", "You're just one step away from being one of our dear susbcribers.Please check the Email provided and confirm your susbcription.");
$payment_method_image = SM::smGetThemeOption("payment_method_image", "");
$download_app_image = SM::smGetThemeOption("download_app_image", "");

?>
<section class="footer-area">
    <div class="footer-middle-area">
        <div class="footer_top_section_contant">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="content-footer">
                        <h4>{{ $footer_widget1_title }}</h4>
                        {!! stripslashes($footer_widget1_description) !!}
                    </div>
                    <ul class="social-media">
                        @empty(!SM::smGetThemeOption("social_facebook"))
                            <li>
                                <a target="blank" href="{{ SM::smGetThemeOption("social_facebook") }}">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_twitter"))
                            <li>
                                <a target="blank" href="{{ SM::smGetThemeOption("social_twitter") }}">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_google_plus"))
                            <li>
                                <a target="blank" href="{{ SM::smGetThemeOption("social_google_plus") }}">
                                    <i class="fa fa-google" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_linkedin"))
                            <li>
                                <a target="blank" href="{{ SM::smGetThemeOption("social_linkedin") }}">
                                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endempty
                        @empty(!SM::smGetThemeOption("social_youtube"))
                            <li>
                                <a target="blank" href="{{ SM::smGetThemeOption("social_youtube") }}">
                                    <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endempty
                    </ul>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="content-footer">
                        <h4>{{ $footer_widget2_title }}</h4>
                        {!! stripslashes($footer_widget2_description) !!}
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="content-footer">
                        <h4>Contact Us</h4>
                        <li>
                            <p><i class="fa fa-map-marker" aria-hidden="true"></i>{{ $address }}</p>
                        </li>
                        <li>
                            <p><i class="fa fa-envelope" aria-hidden="true"></i>{{$email}}</p>
                        </li>
                        <li>
                            <p><i class="fa fa-phone" aria-hidden="true"></i>{{ $mobile }}</p>
                        </li>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="footer_copyright">
                <h5>{{ SM::smGetThemeOption("copyright") }}
                    Developed by <a style="color: #13007d;" target="blank" href="https://nextpagetl.com/"><b>Next Page Technology Ltd.</b></a>
                </h5>
            </div>
        </div>
    </div>
</section>