<?php
$fb_api_enable = SM::get_setting_value('fb_api_enable') == 'on' ? true : false;
$gp_api_enable = SM::get_setting_value('gp_api_enable') == 'on' ? true : false;
$tt_api_enable = SM::get_setting_value('tt_api_enable') == 'on' ? true : false;
$li_api_enable = SM::get_setting_value('li_api_enable') == 'on' ? true : false;
?>
@if($fb_api_enable || $gp_api_enable || $tt_api_enable || $li_api_enable)
    <div id="fb-root" class=" fb_reset">
        <div style="position: absolute; top: -10000px; width: 0px; height: 0px;">
            <div></div>
            <div>
                <iframe name="fb_xdm_frame_https" frameborder="0" allowtransparency="true"
                        allowfullscreen="true" scrolling="no" allow="encrypted-media"
                        id="fb_xdm_frame_https" aria-hidden="true"
                        title="Facebook Cross Domain Communication Frame" tabindex="-1"
                        src="https://staticxx.facebook.com/connect/xd_arbiter/r/d_vbiawPdxB.js?version=44#channel=fdb589fc405c7c&amp;origin=https%3A%2F%2Fwww.kalkifashion.com"
                        style="border: none;"></iframe>
            </div>
        </div>
    </div>

    <div class="fixblocksocial">
    @if($fb_api_enable)
        <!-- Facebook login -->
            <div id="fblogin" class="wksocialsignup fb_button_ps">
                <a href="{{ url('login/facebook') }}">
                    <img src="{{ asset('additional/images/icon-facebook.png') }}"
                         alt="Facebook" title="Connect with Facebook">
                </a>
            </div>
            <!-- End Facebook login -->
    @endif
    @if($gp_api_enable)
        <!-- google login -->
            <div id="googlelogin" class="wksocialsignup">
                <a href="{{ url('login/google') }}">
                    <img src="{{ asset('additional/images/icon-google-plus.png') }}"
                         alt="Google" title="Connect with Google">
                </a>
            </div>
            <!-- ENd google login -->
    @endif
    @if($tt_api_enable)
        <!-- twitter login -->
            <div id="twitterlogin" class="wksocialsignup">
                <a href="login/twitter">
                    <img src="https://d8evit4zy2nlo.cloudfront.net/static/version1557148352/frontend/Kalki/default/en_US/Webkul_SocialSignup/images/icon-twitter.png"
                         alt="Twitter" title="Connect with Twitter">
                </a>
            </div>
            <!-- ENd twitter login -->
    @endif
    @if($li_api_enable)
        <!-- linkedin login -->
            <div id="linkedinlogin" class="wksocialsignup">
                <a href="login/linkedin">
                    <img src="https://d8evit4zy2nlo.cloudfront.net/static/version1557148352/frontend/Kalki/default/en_US/Webkul_SocialSignup/images/icon-linkedin.png"
                         alt="Linkedin" title="Connect with Linkedin">
                </a>
            </div>
            <!-- ENd linkedin login -->
        @endif
    </div>
@endif


