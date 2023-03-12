@extends('frontend.master')
@section("title", "Wishlist")
@section("content")
    <section class="all-body-area">
        <div id="main">
            <section class="about-page-area">
                <div class="text-page-blog">
                    <div class="row">
                        <div class="col-sm-3">
                            @include("customer.left-sidebar")
                        </div>
                        <div class="col-sm-9">
                            <div class="account-panel">
                                <h2>My wishlist </h2>
                                @if(count($wishlists)>0)
                                    <ul class="row list-wishlist">
                                        @forelse($wishlists as $wishlist)
                                            <li class="col-sm-3 wishlistRow">
                                                <div class="product-img">
                                                    <a href="{{ url('product/'.$wishlist->product->slug) }}">
                                                        <img src="{{ SM::sm_get_the_src($wishlist->product->image, 165, 165) }}"
                                                             alt="{{ $wishlist->product->title }}"
                                                             class="image-style">
                                                    </a>
                                                </div>
                                                <h5 class="product-name">
                                                    <a href="{{ url('product/'.$wishlist->product->slug) }}">{{ $wishlist->product->title }}</a>
                                                    <a data-wshlist_id="{{ $wishlist->id }}"
                                                       class="removeToWishlist pull-right"
                                                       title="Remove item"
                                                       href="javascript:void(0)"><i class="fa fa-close"></i></a>
                                                </h5>
                                            </li>
                                        @empty
                                            <div class="alert alert-warning">
                                                <i class="fa fa-warning"></i> No Wishlist Found!
                                            </div>
                                        @endforelse
                                    </ul>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fa fa-warning"></i> No data found
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    @include('frontend.inc.footer')
@endsection
