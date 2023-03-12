<?php

namespace App\Http\Controllers\Front;

use App\Model\Common\Product;
use App\Model\Common\Review;
use App\Model\Common\Wishlist;
use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Controllers\Front\Session;
use App\Model\Common\AttributeProduct;

class CartController extends Controller
{

    public function cart()
    {
        $user_id = Auth::id();

        $data["cart"] = Cart::instance('cart')->content();
        if (!empty($user_id)) {
            if (count($data["cart"]) > 0) {
                return view('frontend.checkout.cart', $data); //
            } else {
                return redirect('/shop')->with('w_message', "Please Order First...!");
            }
        } else {

            return view('frontend.common.otpRegister', $data);
        }
    }

    public function add_to_cart(Request $request)
    {

        if ($request->ajax()) {
            $output = array();
            $id = $request->product_id;
            $qty = $request->qty;
            $product_info = Product::find($id);
            $product_info = DB::table('products')
                ->leftjoin('variations', 'products.id', 'variations.product_id')
                ->groupBy('products.id')
                ->select('*')
                ->select(DB::raw('products.*,variations.sell_price_inc_tax as sell_price_inc_tax'))
                ->where("products.id", $id)
                ->first();

            if (empty($product_info)) {
                $product_attribute_size = $request->product_attribute_size;

                if (!empty($product_attribute_size)) {
                    $attribute_product = AttributeProduct::find($product_attribute_size);
                    Cart::instance('cart')->add(array(
                        array(
                            'id' => $id,
                            'name' => $product_info->title,
                            'price' => $attribute_product->attribute_price,
                            'qty' => $qty,
                            'options' => array(
                                'image' => $product_info->image,
                                'slug' => $product_info->slug,
                                'sku' => $product_info->sku,
                                'size' => $product_attribute_size,
                                'sizename' => $attribute_product->attribute->title,
                                'color' => $product_info->unit_id,
                                'colorname' => $product_info->unit->title,
                            )
                        ),
                    ));

                    $output['cart_count'] = Cart::instance('cart')->count();
                    $output['cart_sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
                    $output['header_cart_html'] = $this->header_cart_html();
                    $output['title'] = 'Product is added';
                    $output['message'] = 'thank you for your order';
                } else {
                    $output['exists_cart'] = 1;
                    $output['title'] = 'Please Select any option';
                    $output['message'] = 'Select any product weight size';
                }
            } else {
                if ($product_info->regular_price > 0) {
                    // if($product_info->weighted == 1)
                    // {
                    //      $product_price = $product_info->sale_price * $product_info->product_weight;
                    // }
                    // else
                    // {
                    $product_price = $product_info->regular_price;
                    // }

                } else {
                    // if($product_info->weighted == 1)
                    // {
                    //     $product_price = $product_info->regular_price * $product_info->product_weight;
                    // }
                    // else
                    // {
                    $product_price = $product_info->sell_price_inc_tax;
                    // }

                }


                Cart::instance('cart')->add(array(
                    array(
                        'id' => $id,
                        'name' => $product_info->name,
                        'price' => $product_price,
                        'qty' => $qty,
                        'options' => array(
                            'image' => $product_info->image,
                            'slug' => $product_info->slug,
                            'sku' => $product_info->sku,
                            'size' => $product_info->weight,
                            'sizename' => $product_info->weight,
                            'weight' => $product_info->weight,
                            'color' => $product_info->unit_id,

                        )
                    ),
                ));

                $item = Cart::instance('cart')->content()->where('id', $id)->first();
                $output['row_id'] = $item->rowId;
                $total = $item->qty * $item->price;
                $output['price'] = $item->price;
                $output['sub_total_new'] = $total;
                $output['p_id'] = $item->id;

                $output['qty_new'] = $qty;
                $output['cart_count'] = Cart::instance('cart')->count();
                $output['cart_sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());

                $output['cart_shipping_new'] = SM::all_cart_shiping_cost();
                $output['cart_toal_new_all'] = SM::all_cart_total_new_toal();

                $output['header_cart_html'] = $this->header_cart_html();
                $output['title'] = 'Product is added';
                $output['message'] = 'thank you for your order';
            }
            echo json_encode($output);
        }
    }

    public
    function update_to_cart(Request $request)
    {

        if ($request->ajax()) {
            $rowId = $request->row_id;
            $qty = $request->qty;
           
            $stock = SM::getProdcutStock($request->product_id);
            if ($stock > $qty) {
                Cart::instance('cart')->update($rowId, $qty);
                $output['title'] = 'Product is Update';
                $output['message'] = 'thank you';
            } else {
                $output['title'] = 'Product is Out of stock';
                $output['message'] = 'thank you';
                $qty = $qty - 1;
            }


            $sub_total = Cart::instance('cart')->content()->where('rowId', $rowId)->first();

            $total = $sub_total->qty * $sub_total->price;

            $output['sub_total_new'] = $total;
            $output['p_id'] = $sub_total->id;
            $output['price'] = $sub_total->price;

            $output['qty_new'] = $qty;
            $output['cart_count'] = Cart::instance('cart')->count();
            $output['cart_sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
            $output['cart_shipping_new'] = SM::all_cart_shiping_cost();
            $output['cart_toal_new_all'] = SM::all_cart_total_new_toal();
            $output['header_cart_html'] = $this->header_cart_html();
            $output['cart_table'] = $this->cart_table();

            echo json_encode($output);
        }
    }

    public
    function remove_to_cart(Request $request)
    {
        if ($request->ajax()) {
            $output = array();
            $id = $request->product_id;
            $cat = Cart::instance('cart')->content()->where('rowId', $id)->first();
            if (!empty($cat)) {
                $lastProdid = $cat->id;
                $lastProdrowId = $cat->rowId;
                Cart::instance('cart')->remove($id);
                $output['cart_count'] = Cart::instance('cart')->count();
                $output['cart_sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
                $output['header_cart_html'] = $this->header_cart_html();
                $output['cart_table'] = $this->cart_table();
                $output['title'] = 'This Product removed';
                $output['message'] = 'thank you';
                $output['lastProdid'] = $lastProdid;
                $output['lastProdrowId'] = $lastProdrowId;
                echo json_encode($output);
            }
        }
    }

    public
    function header_cart_html()
    {
       
        $html = '';
        $items = Cart::instance('cart')->content();

        if (count($items) > 0) {
            foreach ($items as $id => $item) {
                $product_info = Product::find($item->id);

                $html .= '   <div class="add-pro-liner">
                                <div class="counting">
                                    <a class="inc" data-product_id ="' . $item->id . '" data-row_id="' . $item->rowId . '" href="JavaScript:Void(0)"><i
                                                class="fa fa-plus-circle"></i></a>
                                     <input type="hidden" data-product_id ="' . $item->id . '" name="qty" class="qty-inc-dc" id="' . $item->rowId . '"
                                            value="' . $item->qty . '">
                                    <h3>' . $item->qty . '</h3>';
                if ($item->qty > 1) {
                    $html .= ' <a class="dec" data-product_id ="' . $item->id . '" data-row_id="' . $item->rowId . '" href="JavaScript:Void(0)"><i
                                                class="fa fa-minus-circle"></i></a>';
                }
                $html .= ' </div> 
                                <img alt="" src="' . SM::sm_get_the_src($product_info->image) . '"> 
                                <div class="pro-head">
                                    <h3>' . $item->name . '</h3>';
                if ($item->options->sizename != '') {

                    $html .= '<p>N.W: ' . $item->options->sizename . ' ' . $item->options->colorname . '</p>
                      <p>T.W: ' . SM::productWeightCal1($item->options->sizename * $item->qty, $item->options->colorname) . '</p>
                ';
                }
                $pr_new = $item->price * $item->qty;
                $html .= '</div>
                        <span class="ammount">' . SM::currency_price_value($pr_new) . '</span>
                         <span class="pro-close removeToCart" data-product_id="' . $id . '"><i class="fa fa-times-circle"></i></span>
                    </div>';
            }
        } else {
            $html .= '<div class="empty_img image-emty">
                <img class="image-emty-busket" src="' . asset('/additional') . '/images/busketempty.png">
            </div>
            <div class="text-center">
                <span>Empty Cart</span>
            </div>';
        }
        
        return $html;
    }

    public
    function cart_table()
    {
        $html = '';
        $html .= '
                    <thead>
                        <tr>
                            <th class="cart_product">Product</th>
                            <th>Description</th>
                            <th>Unit price</th>
                          
                            <th>Qty</th>
                            <th>Total</th>
                            <th class="action"><i class="fa fa-trash-o"></i></th>
                        </tr>
                    </thead>
                    <tbody>';
        $cart = Cart::instance('cart')->content();
        foreach ($cart as $id => $item) {
            $html .= '<tr id="tr_' . $item->rowId . '" class="removeCartTrLi">
                            <td class="cart_product">
                                <a href="' . url('product/' . $item->options->slug) . '">
                                    <img src="' . SM::sm_get_the_src($item->options->image, 112, 112) . '"
                                         alt="' . $item->name . '">
                                 </a>
                            </td>
                            <td class="cart_description">
                                <p class="product-name">
                                    <a href="' . url('product/' . $item->options->slug) . '"><strong>' . $item->name . '</strong> </a></p> 
                                <br>
                                <small>N.W : ' . $item->options->sizename . ' ' . $item->options->colorname . '</small> <br>

                                 <small>T.W : ' . SM::productWeightCal1($item->options->sizename * $item->qty, $item->options->colorname) . '</small>
                            </td>
                            
                             <td class="price"><span>' . SM::currency_price_value($item->price) . '</span></td>
                            <td class="qty">
                                <div class="input-group custom-heart-extra" align="center" style="margin:0 auto;">

                                      <input type="button" data-row_id="' . $item->rowId . '" value="-" data-product_id ="' . $item->id . '" class="button-minus dec">

                                      <input type="text" id="pro_' . $item->rowId . '" data-product_id ="' . $item->id . '" value="' . $item->qty . '" name="qty" class=" quantity-field qty-inc-dc " readonly>

                                      <input type="button" data-product_id ="' . $item->id . '" data-row_id="' . $item->rowId . '" value="+" class="button-plus inc">

                                    </div>
                            </td>
                            <td class="price">
                                <span>' . SM::currency_price_value($item->price * $item->qty) . '</span>
                            </td>
                            <td class="action">
                                <a data-product_id="' . $item->rowId . '" class="btn btn-danger remove_link removeToCart" title="Delete item"
                                   href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>
                             
                            </td>
                        </tr>';
        }

        $total_weight = 0;
        $cart1 = Cart::instance('cart')->content();
        foreach ($cart1 as $id => $item) {
            if ($item->options->colorname == 'gm') {
                $weight = $item->options->sizename;
                $qty = $item->qty;
                $total_weight += $weight * $qty;
            }
        }
        if ($total_weight > 9999) {
            $shipping_cost = 120;
        } elseif ($total_weight < 1) {
            $shipping_cost = 0;
        } else {
            $shipping_cost = 100;
        }
        $sub_total = Cart::instance('cart')->subTotal();
        $sub_total = intval(preg_replace('/[^\d.]/', '', $sub_total));
        $grand_total = $sub_total + $shipping_cost;
        $html .= '</tbody>
                      <tfoot>
                        <tr>
                            <td colspan="2" rowspan="3"></td>
                            <td colspan="3">Sub Total</td>
                            <td colspan="2">' . SM::currency_price_value(Cart::instance('cart')->subTotal()) . '</td>
                        </tr>';
        if ($shipping_cost > 1) {
            $html .= '<tr> 
                                <td colspan="3"><strong>DELIVERY COST / ডাক মাশুল</strong></td> 
                                <td colspan="2"><strong>' . SM::currency_price_value($shipping_cost) . '</strong> 
                                 </td> 
                             </tr>';
        }
        $html .= ' <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td colspan="2">
                                <strong>' . SM::currency_price_value($grand_total) . '</strong></td>
                        </tr> 
                        </tfoot> 
               ';
        return $html;
    }

    //    ----------Compare------------
    public
    function compare()
    {
        $data['activeMenu'] = 'compare';

        $data["compares"] = Cart::instance('compare')->content();
        if (count($data["compares"]) > 0) {
            return view("frontend.products.compare", $data);
        } else {
            return redirect('/shop')->with('w_message', "Please Product compare First...!");
        }
    }

    public function add_to_compare(Request $request)
    {
        if ($request->ajax()) {
            $output = array();
            $id = $request->product_id;
            $exists_compare = Cart::instance('compare')->content()->where('id', $id)->first();
            if (!empty($exists_compare)) {
                $output['exists_compare'] = 1;
                $output['error_title'] = 'This Product Already compare';
                $output['error_message'] = 'This Product Already compare';
                echo json_encode($output);
            } else {
                $product_info = Product::find($id);
                $brand_name = $product_info->brand->title;
                Cart::instance('compare')->add(array(
                    array(
                        'id' => $id,
                        'name' => $product_info->title,
                        'price' => $product_info->regular_price,
                        'qty' => 1
                    ),
                ));
                $output['compare_count'] = Cart::instance('compare')->count();
                $output['title'] = 'Product added to compare';
                $output['message'] = 'thank you for compare';
                echo json_encode($output);
                //        }
            }
        }
    }

    public function remove_to_compare(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->product_id;
            $cat = Cart::instance('compare')->content()->where('rowId', $id)->first();
            if (!empty($cat)) {
                Cart::instance('compare')->remove($id);
                $output['compare_count'] = Cart::instance('compare')->count();
                $output['title'] = 'Compare remove';
                $output['message'] = 'thank you';
                echo json_encode($output);
            }
        }
        //        Cart::instance('compare')->remove($rowId);
        //        return redirect()->back()->with('s_message', 'Product removed Compare!');
    }

    //-----------wishlist---------

    public
    function add_to_wishlist(Request $request)
    {
        if ($request->ajax()) {
            $check_wishlist = Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if (!empty($check_wishlist)) {
                $output['check_wishlist'] = 1;
                $output['error_title'] = 'This Product Already wishlist';
                $output['error_message'] = 'This Product Already wishlist';
                echo json_encode($output);
            } else {
                $wishlistModel = new Wishlist;
                $wishlistModel->product_id = $request->product_id;
                $wishlistModel->user_id = Auth::id();
                $wishlistModel->save();
                //            $output['compare_count'] = Auth::user()->wishlists->count();
                $output['title'] = 'Product added to wishlist';
                $output['message'] = 'thank you for wishlists';
                $output['wishlist_count'] = count(Auth::user()->wishlists);
                echo json_encode($output);
            }
        }
    }

    public
    function remove_to_wishlist(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->wshlist_id;
            $wishlist = Wishlist::find($id);
            if (!empty($wishlist)) {
                Wishlist::destroy($id);
                $output['title'] = 'Wishlist remove';
                $output['message'] = 'thank you';
                $output['wishlist_count'] = Auth::user()->wishlists()->count();

                echo json_encode($output);
            }
        }
    }

    //-----------review-------------------------

    public function add_to_review(Request $request)
    {
        
        if (Auth::check()) {
            $this->validate($request, [
                'description' => 'required',
                'rating' => 'required'
            ]);

            if ($request->ajax()) {

                $output = array();
                auth()->user()->reviews()->create($request->all());
                //                $review = new Review;
                //                $review->product_id = $request->product_id;
                //                $review->rating = $request->rating;
                //                $review->description = $request->description;
                //                $review->user_id = Auth::id();
                //                $review->save();
                $output['title'] = 'You review submitted admin approved then show!';
                $output['message'] = 'Description';
                $output['check_reviewAuth'] = 0;
                echo json_encode($output);
            }
        } else {
            $output['error_title'] = 'Please Login First...!';
            $output['error_message'] = '';
            $output['check_reviewAuth'] = 1;
            echo json_encode($output);
        }
    }

    function remove_to_review(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->review_id;
            $wishlist = Review::find($id);
            if (!empty($wishlist)) {
                Review::destroy($id);
                $output['title'] = 'Product Review remove';
                $output['message'] = 'thank you';
                echo json_encode($output);
            }
        }
        return back()->with('s_message', "Wishlist Remove Successfully!");
    }
}