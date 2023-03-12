<!-- Modal -->
<div class="modal fade loginModal" id="loginModal" tabindex="-1" role="dialog"
     aria-labelledby="loginModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLongTitle">User Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="loginSigupPopup">
                    <div class="brand-name">
                        <img alt="{{ SM::get_setting_value('site_name') }}"
                             src="{{ SM::sm_get_the_src(SM::sm_get_site_logo(), 300, 63) }}"/>
                    </div>
                    <small class="magestore-loign-h3 first">
                        SIGN-UP
                        {{--&amp; GET 10% OFF*--}}
                    </small>
                    <small class="magestore-loign-h3 second" style="display: none;">
                        SIGN IN
                    </small>
                    <small class="magestore-loign-h3 third" style="display: none;">
                        Forgot Your Password
                    </small>
                    <div class="logo-cont-divider"><span></span></div>
                    <div id="magestore-login-social">
                        <div class="wk_socialsignup_container">
                            <!-- Social Login Links -->
                        @include("frontend.common.register_social")
                        <!-- End Social Login Links -->
                        </div>
                    </div>
                    <div class="label-popup-loginform" id="label-popup-signupform">
                        <div class="" style="clear:both;">
                            <div class="formOr">OR</div>
                            {{ Form::open(['url' => ['/register'], 'id' => 'registrationForm', 'class'=>'smAuthForm']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    {{--<div class="field-area">--}}
                                        <input type="text" placeholder="Your Username" name="username"
                                               id="username"
                                               class="form-control" required>
                                        <span class="error-notice"></span>
                                        <input type="password" placeholder="Password" name="password"
                                               id="password"
                                               class="form-control" required>
                                        <span class="error-notice"></span>
                                    {{--</div>--}}
                                </div>
                                <div class="col-md-6">
                                    {{--<div class="field-area">--}}
                                        <input type="email" placeholder="Your email address" name="email"
                                               id="emmail_login"
                                               class="form-control" required>
                                        <span class="error-notice"></span>
                                        <input type="password" placeholder="Conform Password"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               class="form-control" required>
                                        <span class="error-notice"></span>
                                    {{--</div>--}}
                                </div>
                            </div>
                            <div class="signup_email">
                                <div class="form-list">
                                    <button type="submit" class="labellogin-btn" id="signupform_email"> Join Now
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <div class="popupcondition">
                            <p> Your email address is safe with us</p>
                            {{--<p> Max discount of $50 on your First Purchase.</p>--}}
                            {{--<p> Not Applicable on Sale products</p>--}}
                        </div>
                        <div class="back-signup-link">
                            <span class="already_member">Already a member?</span>
                            <a href="#loginform" class="newsletterClick sign_in">SIGN IN</a>
                        </div>
                    </div>
                    <?php
                    $authCheck = Auth::check();
                    ?>
                    <div class="label-popup-loginform" id="label-popup-loginform" style="display: none;">
                        <div class="c_sign_in" style="clear:both;">
                            <div class="formOr">OR</div>
                            <form id="loginForm1" method="post" action="{{ url('/login') }}"
                                  class="login-form-wraper smAuthHide smAuthForm {{ SM::current_controller()=="LoginController" && SM::current_method()=="index" ? ' active' : '' }}"
                                  style="display: {{ !$authCheck && SM::current_controller()=="LoginController" && SM::current_method()=="index" ? 'block' : 'block' }}">
                                <?php
                                $isLoginController = SM::current_controller() == "LoginController" ? true : false;
                                ?>
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Email Address" name="username"
                                               id="username" class="form-control" required>
                                        <span class="error-notice"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" placeholder="Password" name="password"
                                               id="password_login" class="form-control" required>
                                        <span class="error-notice"></span>
                                    </div>
                                    <div class="form-list label-chekbox col-md-6">
                                        <input type="checkbox" name="" value="" checked="" id="label-check">
                                        <label for="label-check">Remember</label>
                                    </div>
                                </div>
                                <div class="signup_email">
                                    <div class="form-list">
                                        <button type="submit" class="labellogin-btn" id="signupform_email"> LOGIN
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="newuser-link">
                            <span> <a href="#registerpop_up" class="newsletterClick register-link"> Register</a> </span>
                            |
                            <span><a href="#custom_forgrot_pass" class="newsletterClick forgotPass">Forgot Password</a></span>
                        </div>

                    </div>

                    <div class="label-popup-loginform" style="display:none" id="forgotpassworddiv">
                        <div class="forgotParent">

                            <div class="forgot-div">
                                <form method="post" action="{{ url('/password/reset') }}" id="forgotPassword"
                                      class="forgot-form-wraper  smAuthHide smAuthForm {{ !$authCheck && SM::current_controller()=="ForgotPassword" && SM::current_method()=="index" ? ' active' : '' }}"
                                      style="display: {{ SM::current_controller()=="ForgotPassword" && SM::current_method()=="index" ? 'block' : 'none1' }}">
                                    {!! csrf_field() !!}
                                    <?php
                                    $isForgotPassword = SM::current_controller() == "ForgotPassword" ? true : false;
                                    ?>
                                    <span class="forgot-password-message"></span>
                                    <div class="form-list">
                                        {!! Form::email("email",  null, ["id"=>"forgot-email", 'class'=>'input-text form-control', 'required']) !!}
                                        <span class="error-notice"></span>
                                    </div>
                                    <div class="signup_email">
                                        <div class="form-list">
                                            <button type="submit" class="labellogin-btn" id="signupform_email"> Send
                                                Reset Link
                                            </button>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <span class="success-notice"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="back-signup-link"><span class="already_member">Already a member?</span> <a
                                        href="#loginform" class="newsletterClick sign_in">SIGN IN</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

