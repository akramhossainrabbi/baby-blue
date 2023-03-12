<style>
    .panel-heading {
        padding: 10px 15px;
    }
</style>
<div class="alaminsha-list">
    <ul>
        <li>
            <a href="#" target="_blank">
                <img src="{{ asset('/frontend') }}/image/icon/icon1.png" alt="Assured Quality">
                <span class="whykalki-link">Assured Quality</span>
            </a>
        </li>
        <li>
            <a href="#" target="_blank">
                <img src="{{ asset('/frontend') }}/image/icon/icon2.png"
                     alt="100% purchase protection">
                <span class="whykalki-link">100% purchase protection</span>
            </a>
        </li>
        <li>
            <a href="#" target="_blank">
                <img src="{{ asset('/frontend') }}/image/icon/icon3.png" alt="30 days easy return">
                <span class="whykalki-link">30 days easy return</span>
            </a>
        </li>
        <li>
            <a href="#" target="_blank">
                <img src="{{ asset('/frontend') }}/image/icon/icon4.png" alt="Free shipping">
                <span class="whykalki-link">Free shipping</span>
            </a>
        </li>
        <li>
            <a href="#" target="_blank">
                <img src="{{ asset('/frontend') }}/image/icon/icon5.png" alt="Custom fitting">
                <span class="whykalki-link">Custom fitting </span>
            </a>
        </li>
        <li>
            <a href="#" target="_blank">
                <img src="{{ asset('/frontend') }}/image/icon/icon6.png" alt="Exclusive collection">
                <span class="whykalki-link"> Exclusive collection</span>
            </a>
        </li>
    </ul>
</div>
<p class="details-p-styl-extra">Want to try before ordering? <a href="">Come visit our store! Locate
        Address</a>
</p>
<div class="row">
    <div class="col-md-12">
        <!-- Defaults -->
        <div class="panel-group d-accordion">
            @empty(!$product->long_description)
                <div class="panel">
                    <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion"
                         href="#aboutus">
                        <h5 class="panel-title-ex">MORE DETAILS <i class="fa fa-plus pull-right"></i>
                        </h5>
                    </div>
                    <div id="aboutus" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <p class="collups-text-p"> {!! $product->long_description !!}</p>
                        </div>
                    </div>
                </div>
            @endempty
            <div class="panel">
                <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion"
                     href="#whoweare">
                    <h5 class="panel-title-ex">RETURN POLICY<i class="fa fa-plus pull-right"></i>
                    </h5>
                </div>
                <div id="whoweare" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p class="collups-text-p">Nec tristique! Odio sit turpis ac sit magna, non.
                            Elementum
                            ultrices tristique, rhoncus lectus, turpis ac, purus magna! Et massa
                            pulvinar
                            ridiculus dignissim. Egestas</p>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion"
                     href="#contactus">
                    <h5 class="panel-title-ex">KEY SPECIFICATIONS <i
                                class="fa fa-plus pull-right"></i></h5>
                </div>
                <div id="contactus" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p class="collups-text-p">Nec tristique! Odio sit turpis ac sit magna, non.
                            Elementum
                            ultrices tristique, rhoncus lectus, turpis ac, purus magna! Et massa
                            pulvinar
                            ridiculus dignissim. Egestas</p>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading" data-toggle="collapse" data-parent=".d-accordion"
                     href="#contactus">
                    <h5 class="panel-title-ex">FAQ <i class="fa fa-plus pull-right"></i></h5>
                </div>
                <div id="contactus" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p class="collups-text-p">Nec tristique! Odio sit turpis ac sit magna, non.
                            Elementum
                            ultrices tristique, rhoncus lectus, turpis ac, purus magna! Et massa
                            pulvinar
                            ridiculus dignissim. Egestas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$url = URL::to('/product/' . $product->slug);
$encode = urlencode($url);
?>
<div class="col-md-12 margin-div-ex">
    <a href="javascript:void(0)"
       onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo $encode ?>')"
       class="social-media-icon"><i class="fa fa-facebook"></i> </a>
    <a href="javascript:void(0)"
       onclick="javascript:genericSocialShare('http://twitter.com/share?text=<?php echo $product->title; ?>&amp;url=<?php echo $url ?>')"
       title="Twitter Share" class="social-media-icon"><i class="fa fa-twitter"></i> </a>
    <a href="javascript:void(0)"
       onclick="javascript:genericSocialShare('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $encode ?>')"
       class="social-media-icon"><i class="fa fa-linkedin"></i> </a>
    <a href="javascript:void(0)"
       onclick="javascript:genericSocialShare('http://pinterest.com/pin/create/button/?url=<?php echo $encode ?>&media=<?php echo SM::sm_get_the_src($product->image, 860, 1200) ?>&description=<?php echo $product->title; ?>')"
       title="Pinterest Share" class="social-media-icon"><i class="fa fa-pinterest"></i> </a>
    <a href="javascript:void(0)" class="social-media-icon"
       onclick="javascript:genericSocialShare('https://plus.google.com/share?url=<?php echo $encode ?>')"
       title="Google Plus Share"><i class="fa fa-google-plus"></i> </a>

</div>


<script type="text/javascript" async>
    function genericSocialShare(url) {
        window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        return true;
    }
</script>