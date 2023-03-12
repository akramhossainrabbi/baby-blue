<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Admin\Common\ShippingMethods;
use App\Mail\InvoiceMail;
use App\Mail\NormalMail;
use App\Model\Common\Category;
use App\Model\Common\Coupon;
use App\Model\Common\Order;
use App\Model\Common\Order_detail;
use App\Model\Common\Shipping;
use App\Model\Common\Payment_method;
use App\Model\Common\Product;

use App\Model\Common\AttributeProduct;
use App\Model\Common\ShippingMethod;
use App\Model\Common\Orderaddress;
use App\Model\Common\Slider;
use App\Model\Common\Page as Page_model;
use App\Model\Common\Tax;
use App\SM\SM;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Model\Common\Payment;
use App\Model\Common\Product_request as Product_request;
use Barryvdh\DomPDF\Facade as PDF;

class CheckoutController extends Controller
{

    public function viewcart()
    {
        $result['activeMenu'] = 'dashboard';
        $result['cart'] = Cart::instance('cart')->content();

        return view('frontend.checkout.viewcart', $result);
    }

    public function checkout()
    {
        $data["sub_total"] = Cart::instance('cart')->subTotal();

        $noraml_discount = Coupon::Published()->where('discount_type', 1)->where('validity', '>=', Carbon::now()->toDateString())->first();
        if (!empty($noraml_discount)) {
            if ($noraml_discount->type == 1) {
                $data["noraml_discount_amount"] = $noraml_discount->coupon_amount;
                $data["discount_amount"] = 0;
            } elseif ($noraml_discount->type == 2) {
                $data["noraml_discount_amount"] = $data["sub_total"] * $noraml_discount->coupon_amount / 100;
                $data["discount_amount"] = $noraml_discount->coupon_amount;
            } else {
                $data["noraml_discount_amount"] = 0;
            }
        } else {
            $data["noraml_discount_amount"] = 0;
        }

        $data["cart"] = Cart::instance('cart')->content();
        if (count($data["cart"]) > 0) {
            if (empty(session('step'))) {
                session(['step' => '0']);
            }
            $data['shipping_methods'] = ShippingMethod::Published()->get();
            $data['payment_methods'] = Payment_method::Published()->get();
            $data["sub_total"] = Cart::instance('cart')->subTotal();
//        -----------tax-------------
            $data['is_tax_enable'] = SM::get_setting_value("is_tax_enable", 1);
            $data['default_tax'] = SM::get_setting_value("default_tax", 1);
            $data['default_tax_type'] = SM::get_setting_value("default_tax_type", 1);

            if ($data['is_tax_enable'] == 1 && Auth::check() && Session::get('shipping.country') != '') {
                $taxInfo = Tax::where("country", Session::get('shipping.country'))->first();

                if (!empty($taxInfo)) {
//                if (count($taxInfo) > 0) {
                    if ($taxInfo->type == 1) {
                        $tax = $taxInfo->tax;
                    } else {
                        $tax = $data["sub_total"] * $taxInfo->tax / 100;
                    }
                } else {
                    if ($data['default_tax_type'] == 1) {
                        $tax = (float)$data['default_tax'];
                    } else {
                        $tax = (float)$data['default_tax'] * $taxInfo->tax / 100;
                    }
                }
                $data['tax'] = $tax;
            } else {
                $data['tax'] = 0;
            }
            return view('frontend.checkout.checkout', $data);
        } else {
            return redirect('/shop')->with('s_message', "Please Order First...!");
        }
    }

    public function shippingMethod()
    {
        $data["userInfo"] = Auth::user();
        $data["shippingInfo"] = Auth::user()->shipping;
        $data['shipping_methods'] = ShippingMethod::Published()->get();
    }

    public function checkout_shipping_address(Request $request)
    {
        if (session('step') == '0') {
            session(['step' => '1']);
        }

        $shipping["firstname"] = $request->firstname;
        $shipping["lastname"] = $request->lastname;
        $shipping["mobile"] = $request->mobile;
        $shipping["company"] = $request->company;
        $shipping["address"] = $request->address;
        $shipping["country"] = $request->country;
        $shipping["state"] = $request->state;
        $shipping["city"] = $request->city;
        $shipping["zip"] = $request->zip;
        Session::put("shipping", $shipping);
        
        
        $shipping_data = ShippingMethod::find($request->shipping_method);
        $shipping_method["method_name"] = $shipping_data->title;
        $shipping_method["method_charge"] = $shipping_data->charge;
        Session::put("shipping_method", $shipping_method);
        
        return redirect()->back();
    }

    //checkout_billing_address
    public function checkout_billing_address(Request $request)
    {
        if (session('step') == '1') {
            session(['step' => '2']);
        }

        $billing["billing_firstname"] = $request->billing_firstname;
        $billing["billing_lastname"] = $request->billing_lastname;
        $billing["billing_mobile"] = $request->billing_mobile;
        $billing["billing_company"] = $request->billing_company;
        $billing["billing_address"] = $request->billing_address;
        $billing["billing_country"] = $request->billing_country;
        $billing["billing_state"] = $request->billing_state;
        $billing["billing_city"] = $request->billing_city;
        $billing["billing_zip"] = $request->billing_zip;
        $billing["billing_same_address"] = $request->billing_same_address;
        Session::put("billing", $billing);
        return redirect()->back();
    }

    public function saveShippingMethod(Request $request)
    {
        $this->validate($request, [
            'shipping_method' => 'required',
        ]);
    }

    //checkout_shipping_method
    public function checkout_shipping_method(Request $request)
    {
        if (session('step') == '2') {
            session(['step' => '3']);
        }
        $shipping_data = ShippingMethod::find($request->shipping_method);
        $shipping_method["method_name"] = $shipping_data->title;
        $shipping_method["method_charge"] = $shipping_data->charge;
        Session::put("shipping_method", $shipping_method);
        return redirect()->back();
    }

    public function couponCheck(Request $request)
    {
        $this->validate($request, ['coupon_code' => 'required']);
        $sub_total_price = $request->sub_total_price;

        $coupon = Coupon::where("coupon_code", $request->coupon_code)->first();

        if (!empty($coupon)) {
            if (!empty(Session::get('coupon.coupon_code'))) {
                $response['check_coupon'] = 0;
                $response['title'] = 'Coupon Already exits!';
                $response['message'] = 'Description';
                return response()->json($response);
            } else {
                $validity = $coupon->validity;
                $balance_qty = $coupon->balance_qty;
                $response["couponCode"] = $request->couponCode;
                if ($balance_qty > 0) {
                    if ($validity >= Carbon::now()->toDateString()) {
                        if ($coupon->type == 1) {
                            $response["id"] = $coupon->id;
                            $response["coupon_code"] = $coupon->coupon_code;
                            $response["coupon_amount"] = $coupon->coupon_amount;
                            $response["type"] = $coupon->type;
                            Session::put("coupon", $response);
                            Session::save();
                            unset($response["id"]);
                            $update_qty = $balance_qty - 1;

                            Coupon::where("coupon_code", $request->coupon_code)
                                ->update(['balance_qty' => $update_qty]);

                        } else {
                            $response["id"] = $coupon->id;
                            $response["coupon_code"] = $coupon->coupon_code;
                            $response["coupon_amount"] = $sub_total_price * $coupon->coupon_amount / 100;
                            $response["type"] = $coupon->type;
                            Session::put("coupon", $response);
                            Session::save();
                            unset($response["id"]);
                            $update_qty = $balance_qty - 1;
                            Coupon::where("coupon_code", $request->coupon_code)
                                ->update(['balance_qty' => $update_qty]);
                        }

                    } else {
                        $response['check_coupon'] = 0;
                        $response['title'] = 'Coupon Validity Expired!';
                        $response['message'] = 'Description';
                        return response()->json($response);
                    }
                } else {
                    $response['check_coupon'] = 0;
                    $response['title'] = 'Coupon Qty limit over';
                    $response['message'] = 'Description';
                    return response()->json($response);
                }

                $response['check_coupon'] = 1;
                $response['title'] = 'Coupon Successfully Applied!';
                $response['message'] = 'Description';
                $response['coupon_amount'] = Session::get('coupon.coupon_amount');
                $response['grand_total'] = $sub_total_price - Session::get('coupon.coupon_amount');

                return response()->json($response);
            }
        } else {
            $response['check_coupon'] = 0;
            $response['title'] = 'Coupon Not Found!';
            $response['message'] = 'Description';
            return response()->json($response);
        }
    }

    public function orderDetail()
    {
        $data["sub_total"] = Cart::instance('cart')->subTotal();

        $data['is_tax_enable'] = SM::get_setting_value("is_tax_enable", 1);
        $data['default_tax'] = SM::get_setting_value("default_tax", 1);
        $data['default_tax_type'] = SM::get_setting_value("default_tax_type", 1);


        if ($data['is_tax_enable'] == 1 && Auth::check() && Auth::user()->country != '') {
            $taxInfo = Tax::where("country", Auth::user()->country)->first();

            if (!empty($taxInfo)) {

                if ($taxInfo->type == 1) {
                    $tax = $taxInfo->tax;
                } else {
                    $tax = $data["sub_total"] * $taxInfo->tax / 100;
                }
            } else {
                if ($data['default_tax_type'] == 1) {
                    $tax = (float)$data['default_tax'];
                } else {
                    $tax = (float)$data['default_tax'] * $taxInfo->tax / 100;
                }
            }
            $data['tax'] = $tax;
        } else {
            $data['tax'] = 0;
        }

        $data['activeMenu'] = 'dashboard';
        $data['payment_methods'] = Payment_method::Published()->get();
        $data["cart"] = Cart::instance('cart')->content();

        return view('frontend.checkout.order_detail', $data);
    }

    public function placeOrder(Request $request)
    {
    
      
       $slot = $request->delivery_slot;
       if(!empty($slot))
       {
           $am_pm = explode(" ",$slot);
            $am_pm = substr($am_pm[1], 0, -3);
           
            if($am_pm > 8 && $am_pm < 11)
            {
                $am_pm = " AM";
            }
            else
            {
                $am_pm = " PM";
            }
       }
       else
       {
         
           $slot = date('Y-m-d h:i',strtotime('+2 hours') );
            $am_pm = explode(" ",$slot);
            $am_pm = substr($am_pm[1], 0, -3);
           
            if($am_pm > 8 && $am_pm < 11)
            {
                $am_pm = " AM";
            }
            else
            {
                $am_pm = " PM";
            }
       }
        
        
        
        $shipping = Session::get("shipping");
        $billing = Session::get("billing");
        $userInfo = \Auth::user();
        if ($request->isMethod('post')) {
            if (!empty($request->coupon_amount)) {
                $coupon_amount = $request->coupon_amount;
            } else {
                $coupon_amount = 0;
            }
            
            
            
            
            $user_id = Auth::id();
            $user_email = Auth::user()->email;
            
            $name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $user_address = Auth::user()->address;
            $user_phone = Auth::user()->mobile;
            $state = Auth::user()->state;
            $city = Auth::user()->city;
            $zip = Auth::user()->zip;
            
            $phone_number = $request->mobile ;
            DB::table('users')->where('id', $userInfo->id)->update(['first_name' => $request->firstname, 'mobile' => $request->mobile, 'address' => $request->address, 'email' => $request->email]);
            if ($userInfo) 
            {
                $cartProducts = Cart::instance('cart')->content();
                $user_id = $userInfo->id;
                
                $cookie_name = 'countryCurrency';
                if (isset($_COOKIE[$cookie_name])) {
                    $cooki_val = $_COOKIE[$cookie_name];
                    $get_currency = DB::table('countries')
                        ->where('id', $cooki_val)
                        ->first();
                    if (SM::get_setting_value('currency') != $cooki_val) {
                        $orderCurrency = $cooki_val;
                        $currencyRate = $get_currency->currency_rate;
                        $currency_symbol = $get_currency->currency_symbol;
                    } else {
                        $currencyRate = 0;
                        $orderCurrency = SM::get_setting_value('currency');
                        $currency_symbol = $get_currency->currency_symbol;
                    }
                } else {
                    $get_currency = DB::table('countries')
                        ->where('id', SM::get_setting_value('currency'))
                        ->first();
                    $currency_symbol = $get_currency->currency_symbol;
                    $currencyRate = 0;
                    $orderCurrency = SM::get_setting_value('currency');
                }
                
                
                $last_order_id = Order::select('id')->latest('id')->limit(1)->first();
                if (!empty($last_order_id)) {
                    $invoice_no = sprintf("%04d", $last_order_id->id + 1);
                } else {
                    $invoice_no = sprintf("%04d", 1);
                }
                $order = new Order;
                
                
                if ($request->payment_method_id == 6) { 
                
                    $user_email = Session::get('email');
                    $name = Session::get('name');
                    $user_address = Session::get('address');
                    $user_phone = Session::get('phone');
                    $state = Session::get('state');
                    $city = Session::get('city');
                    $zip = Session::get('zip');
                    $delivery_slot = Session::get('delivery_slot');
                
                    Session::put('invoice_no', $invoice_no);
                    Session::put('user_id', $user_id);
                    Session::put('name', $name);
                    Session::put('phone', $user_phone);
                    Session::put('email', $user_email);
                    Session::put('address', $user_address);
                    Session::put('city', $city);
                    Session::put('state', $state);
                    Session::put('zip', $zip);
                    Session::put('grand_total', $request->grand_total);
                    Session::put('tax_amount', $request->tax);
                    Session::put('coupon_code', $request->coupon_code);
                    Session::put('coupon_amount', $coupon_amount);
                    Session::put('payment_method_id', $request->payment_method_id);
                    Session::put('order_note', $request->order_note);
                    $tran_id = "VSL" . uniqid();
                    Session::put('tran_id', $tran_id);
                    Session::put('shipping_method_charge', $request->shipping_method_charge);
                    Session::put('shipping_method_name', $request->shipping_method_name);  
                    Session::put('sub_total', $request->sub_total);
                    $slot = date('Y-m-d h:i', strtotime($slot)) . $am_pm ;
                    Session::put('delivery_slot', $slot);
                
                DB::beginTransaction();
                try{
                    $order->user_id = Auth::id();
                    $order->customer_name = $name;
                    $order->contact_email = $user_phone;
                    $order->cart_json = json_encode($cartProducts);
                    $order->coupon_code = $request->coupon_code;
                    $order->sub_total = $request->sub_total;
                    $order->discount = $request->discount;
                    $order->tax = $request->tax;
                    $order->delivery_slot = $slot;
                    $order->delivery_address = $request->delivery_address ;
          
                    
                    $order->currency = $orderCurrency;
                    $order->currencyRate = $currencyRate;
                    $order->currency_symbol = $currency_symbol;
                    $order->baseCurrency = SM::get_setting_value('currency');
                    $order->coupon_amount = $coupon_amount;
                    
                    
                    if($request->grand_grand_total_js){
                        $order->grand_total = $request->grand_grand_total_js;
                    } else {
                        $order->grand_total = $request->grand_total;
                    }
                    $order->payment_method_id = $request->payment_method_id;
                    if($request->shipping_js){
                        $order->shipping_method_charge = $request->shipping_js;
                    } else {
                        $order->shipping_method_charge = $request->shipping_method_charge;
                    }
                    
                    $order->order_note = $request->order_note;
                    $order->order_status = 3;
                    $order->publish = 0;
                    // dd($order);
                    // dd($order->save());
                    
                    
                    if ($order->save()) {
                        
                    $order_id = $order->id;
                    Session::put('order_id', $order_id);
                    $order_address = new Orderaddress();
                    $order_address->order_id = $order_id;
                    $order_address->firstname = $shipping["firstname"];
                    $order_address->lastname = $shipping["lastname"];
                    $order_address->mobile = $shipping["mobile"];
                    $order_address->company = $shipping["company"];
                    $order_address->address = $shipping["address"];
                    $order_address->country = $shipping["country"];
                    $order_address->state = $shipping["state"];
                    $order_address->city = $shipping["city"];
                    $order_address->zip = $shipping["zip"];
                    $order_address->billing_firstname = $billing["billing_firstname"];
                    $order_address->billing_lastname = $billing["billing_lastname"];
                    $order_address->billing_mobile = $billing["billing_mobile"];
                    $order_address->billing_company = $billing["billing_company"];
                    $order_address->billing_address = $billing["billing_address"];
                    $order_address->billing_country = $billing["billing_country"];
                    $order_address->billing_state = $billing["billing_state"];
                    $order_address->billing_city = $billing["billing_city"];
                    $order_address->billing_zip = $billing["billing_zip"];
                    $order_address->save();
                        $order_id = $order->id;
                        foreach ($cartProducts as $pro) {
                            $cartPro = new Order_detail;
                            $cartPro->order_id = $order_id;
                            $cartPro->product_id = $pro->id;
                            $cartPro->product_color = $pro->options->colorname;
                            $cartPro->product_size = $pro->options->sizename;
                            $cartPro->product_image = $pro->options->image;
                            $cartPro->product_price = $pro->price;
                            $cartPro->product_qty = $pro->qty;
                            $cartPro->sub_total = $pro->price * $pro->qty;
                            $cartPro->save();
                        }
                    }
                    DB::commit();
                }
                catch (\Exception $e) {
                            DB::rollback(); ///RollBack
                            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                            return response()->json([
                                'msg' => 'Oops, Something went wrong !'
                            ], 402);
                        } 

                 return redirect('/confirm-order');
                }
                
                $order->user_id = $user_id;
                $order->customer_name = $name;
                $order->contact_email = $user_phone;
                $order->cart_json = json_encode($cartProducts);
                $order->coupon_code = $request->coupon_code;
                $order->sub_total = $request->sub_total;
                $order->discount = $request->discount;
                $order->tax = $request->tax;
                $order->delivery_slot = date('Y-m-d h:i', strtotime($slot)) . $am_pm ;
                $order->delivery_address = $request->delivery_address ;
                $order->publish = 1;
                
                $order->currency = $orderCurrency;
                $order->currencyRate = $currencyRate;
                $order->currency_symbol = $currency_symbol;
                $order->baseCurrency = SM::get_setting_value('currency');
                $order->coupon_amount = $coupon_amount;
                if($request->grand_grand_total_js){
                    $order->grand_total = $request->grand_grand_total_js;
                } else {
                    $order->grand_total = $request->grand_total;
                }
                $order->payment_method_id = $request->payment_method_id;
                if($request->shipping_js){
                    $order->shipping_method_charge = $request->shipping_js;
                } else {
                    $order->shipping_method_charge = $request->shipping_method_charge;
                }
                
                $order->order_note = $request->order_note;
                $order->order_status = 3;
                if ($order->save()) {
                
                $order_id = $order->id;
                $order_address = new Orderaddress();
                $order_address->order_id = $order_id;
                $order_address->firstname = $shipping["firstname"];
                $order_address->lastname = $shipping["lastname"];
                $order_address->mobile = $shipping["mobile"];
                $order_address->company = $shipping["company"];
                $order_address->address = $shipping["address"];
                $order_address->country = $shipping["country"];
                $order_address->state = $shipping["state"];
                $order_address->city = $shipping["city"];
                $order_address->zip = $shipping["zip"];
                $order_address->billing_firstname = $billing["billing_firstname"];
                $order_address->billing_lastname = $billing["billing_lastname"];
                $order_address->billing_mobile = $billing["billing_mobile"];
                $order_address->billing_company = $billing["billing_company"];
                $order_address->billing_address = $billing["billing_address"];
                $order_address->billing_country = $billing["billing_country"];
                $order_address->billing_state = $billing["billing_state"];
                $order_address->billing_city = $billing["billing_city"];
                $order_address->billing_zip = $billing["billing_zip"];
                $order_address->save();
                    $order_id = $order->id;
                    foreach ($cartProducts as $pro) {
                        $cartPro = new Order_detail;
                        $cartPro->order_id = $order_id;
                        $cartPro->product_id = $pro->id;
                        $cartPro->product_color = $pro->options->colorname;
                        $cartPro->product_size = $pro->options->sizename;
                        $cartPro->product_image = $pro->options->image;
                        $cartPro->product_price = $pro->price;
                        $cartPro->product_qty = $pro->qty;
                        $cartPro->sub_total = $pro->price * $pro->qty;
                        $cartPro->save();
                    }
                    Session::forget('step');
                    Session::forget('shipping');
                    Session::forget('billing');
                    Session::forget('shipping_method');
                    Session::forget('coupon');
                    Cart::instance('cart')->destroy();
                    Session::put('order_id', $order_id);
                    Session::put('grand_total', $request->grand_total);
                    
                    

                    // mail
                    $extra = new \stdClass();
                    $contact_email = SM::get_setting_value('email');
                     
                    // if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                    //     $extra->subject = "Order Invoice id # " . SM::orderNumberFormat($order) . " Mail";
                    //     $extra->message = $request->message;
                    //     \Mail::to($contact_email)->queue(new InvoiceMail($order_id));
                    //     $info['message'] = 'Mail Successfully Send';
                    // }
                    // dd($contact_email);
                    if(!empty($phone_number))
                    {
                        $o_id = 1000 + $order_id;
                        $message = "Your Virtual Shoppers BD order has been placed. Order No - $order_id Helpline - 01841152080";
                      
                        $url = "http://66.45.237.70/api.php";
                        $data_msg = array(
                            'username' => "nextpagetl",
                            'password' => "NextPage@2020",
                            'number' => "$phone_number",
                            'message' => "$message"
                        );
                        $ch = curl_init(); // Initialize cURL
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_msg));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $smsresult = curl_exec($ch);
                        $p = explode("|", $smsresult);
                        $sendstatus = $p[0];
                        
                        
                        // $url = "http://66.45.237.70/api.php";
                        // $data_msg = array(
                        //     'username' => "nextpagetl",
                        //     'password' => "NextPage@2020",
                        //     'number' => "01841152080  ",
                        //     'message' => "A order has been place from $phone_number. Order no - $order_id."
                        // );
                        // $ch = curl_init(); // Initialize cURL
                        // curl_setopt($ch, CURLOPT_URL, $url);
                        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_msg));
                        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // $smsresult = curl_exec($ch);
                        
                        
                        
                    }
                    
                    $data["order"] = Order::with('payment', 'user', 'detail')->find($order_id);

                     // dd($data);
                    if (!empty($data["order"])) {
                        $data["payment"] = Payment::find($data["order"]->payment_id);
                        return view("customer/order_detail", $data)->with('s_message', "Ordered Successfully!");
                    } else {
                        return abort(404);
                    }
                    

                    
                }
            }
        }
        return redirect('/order-success')->with('w_message', "Order Successfully!");
    }
     public function onfirmOrder(){
         return view('frontend.checkout.confirm-order');
     }
    public function onfirmOrderPost(Request $reques){
         
 
     
            $cartProducts = Cart::instance('cart')->content();
            $user_id = Session::get('user_id');
            $user_email = Session::get('email');
            $name = Session::get('name');
            $user_address = Session::get('address');
            $user_phone = Session::get('phone');
            $state = Session::get('state');
            $city = Session::get('city');
            $zip = Session::get('zip');
            $delivery_slot = Session::get('delivery_slot');
            $order_id = Session::get('order_id');
            
            
            
            
            /* PHP */
                $post_data = array();
                
                
                //live
                $post_data['store_id'] = "virtualshoppersbdlive";
                $post_data['store_passwd'] = "5FC70BED362F166645";
                
                
                //sandbox
                // $post_data['store_id'] = "virtu5fcc7964bbe02";
                // $post_data['store_passwd'] = "virtu5fcc7964bbe02@ssl";
                
                
                $post_data['total_amount'] = Session::get("grand_total");
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = "VSL" . uniqid();
                $post_data['success_url'] = url('/sslcommercesuccess/');
                $post_data['fail_url'] = url('/sslcommercesuccess');
                $post_data['cancel_url'] = url('/sslcommercesuccess');




# CUSTOMER INFORMATION
                $post_data['cus_name'] = $name;
                $post_data['cus_email'] = $user_email;
                $post_data['cus_add1'] = $user_address;
                $post_data['cus_add2'] = $user_address;
                $post_data['cus_city'] = $city;
                $post_data['cus_state'] = $state;
                $post_data['cus_postcode'] = $zip;
                $post_data['cus_country'] = 'Bangladesh';
                $post_data['cus_phone'] = $user_phone;
                $post_data['cus_fax'] = $user_phone;

# SHIPMENT INFORMATION
                $post_data['ship_name'] = $name;
                $post_data['ship_add1 '] = $user_email;
                $post_data['ship_add2'] = $user_address;
                $post_data['ship_city'] = $city;
                $post_data['ship_state'] = $state;
                $post_data['ship_postcode'] = $zip;
                $post_data['ship_country'] = "Bangladesh";
                $post_data['shipping_method'] = "no";


# OPTIONAL PARAMETERS
                $post_data['value_a'] = $order_id;
                $post_data['value_b '] = $user_id;
                $post_data['value_c'] = $user_phone;
                $post_data['value_d'] = $user_email;

# CART PARAMETERS

                $product_name = 'a';
                $product_arr = array();
                foreach ($cartProducts as $pro) {
                    $product_arr[] = array('product' => $pro->name, 'amount' => $pro->price);
                    $product_name .= $pro->name . ', ';

                }
                $post_data['cart'] = json_encode($product_arr);

                $post_data['product_name'] = $product_name;
                $post_data['product_category'] = "Grocery";
                $post_data['product_profile'] = "general";

                $post_data['product_amount'] = Session::get("grand_total");
                $post_data['vat'] = Session::get("tax_amount");
                $post_data['discount_amount'] = Session::get("coupon_amount");
                $post_data['convenience_fee'] = 0;

                # REQUEST SEND TO SSLCOMMERZ
                // $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
                
                $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
                

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $direct_api_url);
                curl_setopt($handle, CURLOPT_TIMEOUT, 30);
                curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


                $content = curl_exec($handle);
                
         

                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                if ($code == 200 && !(curl_errno($handle))) {
                    curl_close($handle);
                    $sslcommerzResponse = $content;
                } else {
                    curl_close($handle);
                    echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
                    exit;
                }

# PARSE THE JSON RESPONSE
                $sslcz = json_decode($sslcommerzResponse, true);
            
                if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
               
                    header("Location: " . $sslcz['GatewayPageURL']);
                    exit;
                } else {
                    echo "JSON Data parsing error!";
                }
    }
    
    public function sslcommerceSuccess(Request $request)
    {
        $order_id = $request->value_a;
        $user_id = $request->value_b;
        $user_phone = $request->value_c;
        $user_email = $request->value_d;
    
        if(empty($_POST['val_id']))
        {
            
            return redirect('/checkout')->with('w_message', "Order Payment Failed!");
        }
        else
        {
            $val_id = urlencode($_POST['val_id']);
        
        }
        
        //live
        $store_id = "virtualshoppersbdlive";
        $store_passwd = "5FC70BED362F166645";
        //sandbox
            // $store_id = "virtu5fcc7964bbe02";
            // $store_passwd = "virtu5fcc7964bbe02@ssl";
        // $requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");
        $requested_url = ("https://securepay.sslcommerz.com/validator/api/validationserverAPI.php?val_id=" . $val_id . "&store_id=" . $store_id . "&store_passwd=" . $store_passwd . "&v=1&format=json");

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $requested_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

        $result = curl_exec($handle);
        
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    

        if ($code == 200 && !(curl_errno($handle))) {

            # TO CONVERT AS OBJECT
            $result = json_decode($result);
            $method_charge = Session::get('shipping_method_charge');
            
             
            # TRANSACTION INFO
            $status = $result->status;
            $tran_date = $result->tran_date;
            $tran_id = $result->tran_id;
            $val_id = $result->val_id;
            $amount = $result->amount;
            $store_amount = $result->store_amount;
            $bank_tran_id = $result->bank_tran_id;
            $card_type = $result->card_type;

            # EMI INFO


            # ISSUER INFO
            $card_no = $result->card_no;
            $card_issuer = $result->card_issuer;
            $card_brand = $result->card_brand;
            $card_issuer_country = $result->card_issuer_country;
            $card_issuer_country_code = $result->card_issuer_country_code;

            # API AUTHENTICATION
            $APIConnect = $result->APIConnect;
            $validated_on = $result->validated_on;
            $gw_version = $result->gw_version;
            
            
            
            $data['publish'] = 1;
            $data['payment_status'] = 1;
            $data['payment_details'] = json_encode($request->all());
            $data['paid'] =  $amount;
            
            $flag = DB::table('orders')->where('id', $order_id)->update($data);
 
            Cart::instance('cart')->destroy();
            
            if ($flag) {
             
                //mail
                $extra = new \stdClass();
                $contact_email = $user_email;
                $contact_email2 = SM::get_setting_value('email');
                if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                    $extra->subject = "Order Invoice id # " . $order_id . " Mail";
                    $extra->message = $request->message;
                    \Mail::to($contact_email)->queue(new InvoiceMail($order_id));
                    \Mail::to($contact_email2)->queue(new InvoiceMail($order_id));
                    $info['message'] = 'Mail Successfully Send';
                }
                
                if(!empty($user_phone))
                    {
                     
                        $message = "Your Virtual Shoppers BD order has been placed. Order No - $order_id Helpline - 01841152080";
                      
                        $url = "http://66.45.237.70/api.php";
                        $data_msg = array(
                            'username' => "nextpagetl",
                            'password' => "NextPage@2020",
                            'number' => "$user_phone",
                            'message' => "$message"
                        );
                        $ch = curl_init(); // Initialize cURL
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_msg));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $smsresult = curl_exec($ch);
                        $p = explode("|", $smsresult);
                        $sendstatus = $p[0];
                        
                        
                    }
            }

            //mail
            $extra = new \stdClass();
            $contact_email = $user_email;
            $contact_email2 = SM::get_setting_value('email');

            if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                $extra->subject = "Order Invoice id # " . $order_id. " Mail";
                $extra->message = $request->message;
                \Mail::to($contact_email)->queue(new InvoiceMail($order_id));
                \Mail::to($contact_email2)->queue(new InvoiceMail($order_id));
                $info['message'] = 'Mail Successfully Send';
            }


            Cart::instance('cart')->destroy();
            
            
            
            
            return redirect('/order-success')->with('s_message', "Order Successfully!");
        } else {
            return redirect('/order-fail')->with('w_message', "Order Payment Failed!");
        }

    }     
    public function sslcommercesuccessget(){
        return 'Success Redirect';
    }
    public function placeOrderNew(Request $request)
    {

        $req_name = json_encode($request->req_name);
        $qty = json_encode($request->req_qty);
        $firstname = $request->firstname;
        $mobile = $request->mobile;
        $address = $request->address;
        $created_at = date('Y-m-d H:i:s', time());
        
        
        $flag = DB::insert('insert into product_requests (product_name, product_qty,name,mobile,address, created_at
        ) values (?, ?,?,?,?,?)', [$req_name, $qty,$firstname,$mobile,$address,$created_at]);

        
        
		if($flag == true)
		{
		   
		    $last2 = DB::table('product_requests')->orderBy('id', 'DESC')->first();
		    $last = $last2->id;
		    $url = "http://66.45.237.70/api.php";
                        $data_msg = array(
                            'username' => "nextpagetl",
                            'password' => "NextPage@2020",
                            'number' => "01841152080  ",
                            'message' => "A Special product request order has been place from $mobile. Special Product Order no - $last."
                        );
                        $ch = curl_init(); // Initialize cURL
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_msg));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $smsresult = curl_exec($ch);
           
            $data["order"] = Product_request::where('id', $last)->first();
                if (!empty($data["order"])) 
                {
                             
                    
                }
                else 
                {
                    return abort(404);
                } 
                                    
		    return redirect('/home')->with('s_message', "Your product request has been submitted successfully!");
		}
		else
		{
		    return redirect('/home')->with('s_message', "Your request has not been submitted successfully!");
		}
				
        
    }
   
    public
    function orderSuccess()
    {
        return view('frontend.checkout.order_success');
    }

    public
    function orderFail()
    {

        return view('frontend.checkout.order_fail');
    }

}
