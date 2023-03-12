<style>
    .add-product-area {
        padding-top: 5px;
    }

    .image-emty {
        height: 200px;
        width: 200px;
        padding: 33px;
        border-radius: 200px;
    }

    .image-emty-busket {
        height: 230px;
        width: 230px;
        background: #ededed;
        padding: 60px;
        border-radius: 200px;
    }
    .weightHide{
        display: none;
    }
</style>
<button class="bttn-cart" id="ShowDivButton" onclick="showDiv()">
    <i class="fa fa-cart-plus"></i>
    <h3><span class="cart_count">{{ Cart::instance('cart')->count() }}</span> Items</h3>
    <h5><span class="cart_sub_total">{{ SM::currency_price_value(Cart::instance('cart')->subTotal()) }}</span></h5>
</button>

<div id="aitcg-control-panel">
    <button class="bttn-close" id="ShowDivButton" onclick="hideDiv()">Close</button>
    <h1><i class="fa fa-shopping-bag"></i> <span class="cart_count">{{ Cart::instance('cart')->count() }}</span> Items
    </h1>
    <h4>Trusted Online Shopping Site</h4>
    <div class="add-product-area header_cart_html">
        <?php
        $items = Cart::instance('cart')->content();
        ?>
        @forelse($items as $id => $item)
            <div class="add-pro-liner">
                <div class="counting">
                    <a class="inc" data-row_id="{{ $item->rowId }}" href="JavaScript:Void(0)"><i
                                class="fa fa-plus-circle"></i></a>
                    <input type="hidden" name="qty" class="qty-inc-dc" id="{{ $item->rowId }}"
                           value="{{ $item->qty }}">
                    <h3>{{ $item->qty }}</h3>
                    @if($item->qty>1)
                        <a class="dec" data-row_id="{{ $item->rowId }}" href="JavaScript:Void(0)"><i
                                    class="fa fa-minus-circle"></i></a>
                    @endif
                </div>
                <img alt="" src="{{ SM::sm_get_the_src($item->options->image, 50, 56) }}">
                <div class="pro-head">
                    <h3>{{ $item->name }}</h3>
                    @if($item->options->sizename != '')
                        <h5>Weight: <?php echo SM::productWeightCal($item->options->sizename * $item->qty); ?></h5>
                    @endif
                    <span>Wt:</span>
                    <select class="weight_change" data-row_id="{{ $item->rowId }}" name="weight_change" style="float: right;">
                        <option value="1" {{ ( $item->options->sizename * $item->qty == 250 ) ? 'selected' : '' }} {{ ( $item->options->sizename > 250 ) ? 'weightHide' : '' }}>250gm</option>
                        <option value="2" {{ ( $item->options->sizename * $item->qty == 500 ) ? 'selected' : '' }}>500gm</option>
                        <option value="3" {{ ( $item->options->sizename * $item->qty == 1000 ) ? 'selected' : '' }}>1kg</option>
                    </select>
                </div>
                <span class="ammount">{{ SM::currency_price_value($item->price) }}</span>
                <span class="pro-close removeToCart" data-product_id="{{$id}}"><i class="fa fa-times-circle"></i></span>
            </div>
        @empty
            <div class="empty_img image-emty">
                <img class="image-emty-busket" src="{{asset('/additional')}}/images/busketempty.png">
            </div>
            <div class="text-center">
                <span>Empty Cart</span>
            </div>
        @endforelse
    </div>
    <div class="add-btn-area">
        <h5><span class="cart_sub_total">{{ SM::currency_price_value(Cart::instance('cart')->subTotal()) }}</span></h5>
        <a class="btn btn-add-place" href="{{URL('cart')}}">Place Order</a>
    </div>
</div>
<section class="chat-box-area" style="display: none;">
    <div id="live-chat">
        <header class="clearfix">
            <div class="chat-message-counter">
                <i class="fa fa-comment"></i>
                <div class="desktop-chat">
                    <div class="chat-area">
                        <h5>Hello! How can i help?</h5>
                        <img alt="" src="{{asset('/frontend/')}}/img/interface/arrow.png">
                    </div>
                    <div class="chat-img">
                        <img alt="" src="{{asset('/frontend/')}}/img/interface/chat.png">
                    </div>
                </div>
            </div>
        </header>

        <div class="chat">
            <header class="clearfix">
                <h4>Vishal Shukla <i class="fa fa-times"></i></h4>
            </header>
            <div class="chat-history">
                <div class="chat-message clearfix">
                    <img src="{{asset('/frontend/')}}/img/interface/chat.png" alt="" width="32" height="32">
                    <div class="chat-message-content clearfix">
                        <span class="chat-time">13:35</span>
                        <h5>Vishal </h5>
                        <p>Hello! How can i help?</p>
                    </div>
                </div>
                <hr>
                <hr>
            </div>

            <p class="chat-feedback">Your partner is typing…</p>
            <form action="#" method="post">
                <fieldset>
                    <input type="text" placeholder="Type your message…" autofocus>
                    <input type="hidden">
                </fieldset>
            </form>
        </div>
    </div>
</section>