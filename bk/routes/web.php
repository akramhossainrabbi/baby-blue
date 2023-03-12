<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include_once('install_r.php');

/*eCOMMERCE vsL*/
Route::get('/clear', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'DONE';
});
        /**
         * Media
         */
        Route::get('media', 'MediaController@index');
        Route::post('media/upload', 'MediaController@upload');
        Route::post('media/delete', 'MediaController@delete');
        Route::post('media/update', 'MediaController@update');
        Route::get('media/download/{id}', 'MediaController@download');
        Route::get('media/{offset}', 'MediaController@getMedias');
        Route::get('deleteMultipleMedia', 'MediaController@deleteMultipleMedia')->name('deleteMultipleMedia');

        Route::get('media_search', 'MediaController@media_search')->name('media_search');
        /**
             * orders
             */
            
            


            


            
          

Route::get("is-customer-logged-in", "Front\HomeController@isCustomerLoggedIn");

Route::group(["namespace" => "Front\Auth"], function () {
    Route::post("guest-login", "LoginController@guestLogin");
    Route::get('login/{social}', 'LoginController@socialLogin');
    Route::get('login/{social}/callback', 'LoginController@handleSocialLoginCallback');

    Route::get("login", "LoginController@index");
    Route::get("signin", "LoginController@index")->name('ayon_signin');
    Route::get("logout", "LoginController@logout")->name('ayon_logout');
    Route::post("login", "LoginController@login")->name("login");
    Route::get("register", "RegisterController@index");
    Route::get("signup", "RegisterController@index");
    Route::post("register", "RegisterController@register");
    Route::get('password/reset', 'ForgotPassword@index');
    Route::post('password/reset', 'ForgotPassword@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'ResetPassword@showResetForm')->name('password.reset');
    Route::post('password/update', 'ResetPassword@reset');


    
         

    /**
     * social login and registration
     */
    //login and register with fb
    Route::get('login/facebook/{auth?}', 'LoginController@loginWithFB');
    Route::get('register/facebook', 'RegisterController@registerWithFB');
//login and register with gp
    Route::get('login/google', 'LoginController@loginWithGP');
    Route::get('register/google', 'RegisterController@registerWithGP');
//login and register with twitter
    Route::get('login/twitter', 'LoginController@loginWithTT');
    Route::get('register/twitter', 'RegisterController@registerWithTT');
//login and register with linkedin
    Route::get('login/linkedin', 'LoginController@loginWithLI');
    Route::get('register/linkedin', 'RegisterController@registerWithLI');


});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function (){
        echo "hi";
    });
});
Route::get('/category_list/{slug}/', 'ProductController@category_list')->name('category_list');
Route::get('/product_detail/{slug}/', 'ProductController@productDetail')->name('product_detail');


Route::group(['namespace' => 'Front', 'prefix' => 'dashboard'], function () {
    Route::get("/", "Dashboard@index");
    Route::get("/edit-profile", "Dashboard@editProfile");
    Route::get("/wallet", "Dashboard@Wallet");
    Route::post("/save-profile", "Dashboard@saveProfile");
    Route::post("/user-profile-pic-change", "Dashboard@saveProfilePicture");
    Route::post("/update-password", "Dashboard@updatePassword");
    Route::get("/downloads", "Dashboard@downloads");
    Route::get("/cancel_order/{id}", "Dashboard@cancel_order");
    Route::get("/media/download/{id}", "Dashboard@mediaDownload");
    /**
     * Customer Order Management
     */
    Route::group(['prefix' => 'orders'], function () {
        Route::get("/", "Dashboard@orders");
        Route::get("/status/{status}", "Dashboard@orders");
        Route::get("/detail/{id}", "Dashboard@detailOrders");
//        Route::get("/reorder/{id}", "Checkout@reorder");
        Route::get("/edit/{id}", "Dashboard@editOrders");
        Route::get("/download/{id}", "Dashboard@downloadOrders");
        Route::get("/pay/{id}", "Checkout@pay");
        Route::post('/pay-due', 'Checkout@payDue');
    });
    /**
     * Customer wishlist Management
     */
    Route::group(['prefix' => 'wishlist'], function () {
        Route::get("/", "Dashboard@wishlist");
    });
    Route::group(['prefix' => 'review'], function () {
        Route::get("/", "Dashboard@review");
    });
    Route::group(['prefix' => 'wallet'], function () {
        Route::get("/", "Dashboard@wallet");
    });
    /**
     * Customer support system
     */
    Route::group(['prefix' => 'tickets'], function () {
        Route::get("/", "Dashboard@tickets");
        Route::get("/add", "Dashboard@addTicket");
        Route::post("/add", "Dashboard@saveTicket");
        Route::get("/detail/{id}", "Dashboard@detailTicket");
        Route::post("/reply", "Dashboard@saveReplyTicket");
        Route::get("/older-support-detail/{id}", "Dashboard@olderSupportDetail");
        Route::get("/new-support-detail/{id}/{lastId?}", "Dashboard@newSupportDetail");
    });
});


Route::group(["namespace" => "Front"], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', "HomeController@index");
    Route::get('page/{url?}', 'HomeController@page');
    Route::post('/currency_change', "HomeController@currency_change")->name('currency_change');

    Route::get('/blog', "HomeController@blog");
    Route::get('/blog/{slug}', "HomeController@blogDetail");

    Route::get('/blog/category/{slug}', "HomeController@categoryByBlog");
    Route::get('/blog/tag/{slug}', "HomeController@tagByBlog");
    Route::get('/comments/{blogId}/{type}/{parentId}/{parentLastCommentId}', "HomeController@getAjaxComments");
    Route::post('/save_comment', "HomeController@saveComment");

    Route::post('search', 'HomeController@search');
    Route::get('search', 'HomeController@search');
    Route::post('likes', 'HomeController@likes');
    Route::post('is-already-liked', 'HomeController@isAlreadyLiked');

    //    catalogue
    Route::get('/catalogue', 'HomeController@catalogue');

    //    wholesale
    Route::get('/wholesale', 'HomeController@wholesale');
    Route::post('/storeWholesale', 'HomeController@storeWholesale');
    Route::get('/wholesale-thanks', 'HomeController@wholesaleThanks');
    Route::get('/about', 'HomeController@about');
    Route::get('/contact', 'HomeController@contact');
    Route::post('/send_mail', "HomeController@send_mail");
    Route::get('/seoScore', "HomeController@seoScore");
    Route::post('/subscribe', "HomeController@subscribe");

    //    categoryType_filter_by_product
    Route::post('main_search', 'ProductController@main_search');
    Route::get('categoryType_filter_by_product', 'ProductController@categoryType_filter_by_product')
        ->name('categoryType_filter_by_product');

    //shop
    Route::get('/shop/', 'ProductController@shop')->name('shop');
    Route::get('/offerProduct/', 'ProductController@offerProduct')->name('offerProduct');
    Route::get('/products/', 'ProductController@shop')->name('product');
    Route::get('/products/category/', 'ProductController@shop')->name('category');
    

    Route::get('/test-test/{slug}/', 'ProductController@testtest');

    Route::get('product_search_data', 'ProductController@product_search_data')
        ->name('product_search_data');
    
    Route::get('/products/category/{slug}/', 'ProductController@categorylist');
    Route::get('/tag/{slug}', "ProductController@tagByProduct");
    Route::get('/brand/{slug}', "ProductController@brandByProduct");
    Route::get('product_color_by_size', 'ProductController@product_color_by_size')
        ->name('product_color_by_size');
    Route::get('product_size_by_color', 'ProductController@product_size_by_color')
        ->name('product_size_by_color');

    Route::get('att_size_by_product_price', 'ProductController@att_size_by_product_price')
        ->name('att_size_by_product_price');

    //    review
    Route::get('add_to_review', 'CartController@add_to_review')->name('add_to_review');
    Route::get('remove_to_review', 'CartController@remove_to_review')->name('remove_to_review');

    //Wishlist--------------
    Route::get('add_to_wishlist', 'CartController@add_to_wishlist')->name('add_to_wishlist');
    Route::get('remove_to_wishlist', 'CartController@remove_to_wishlist')->name('remove_to_wishlist');

    //    add-to-cart
    Route::get('add-to-cart', 'CartController@add_to_cart')->name('add_to_cart');
    Route::get('cart', 'CartController@cart')->name('ayon_cart');
    Route::post('otp', 'Dashboard@otp');
    Route::post('otplogin', 'Dashboard@otplogin');
    Route::get('remove_to_cart', 'CartController@remove_to_cart')->name('remove_to_cart');
    Route::get('destroy_to_cart', 'CartController@destroy_to_cart')->name('destroy_to_cart');
    Route::get('update_to_cart', 'CartController@update_to_cart')->name('update_to_cart');

    /**
     * Customer Compare Management
     */
    Route::get("/compare", "CartController@compare");
    Route::get('add_to_compare', 'CartController@add_to_compare')->name('add_to_compare');
    Route::get('remove_to_compare', 'CartController@remove_to_compare')->name('remove_to_compare');

    /**
     * subscribe Management
     */
    Route::post('/subscribe', "HomeController@subscribe");
    Route::get('/unsubscribe/{email}', "HomeController@unsubscribe");
    Route::get('/subscribe-confirmation/{email}', "HomeController@subscribeConfirmation");
    Route::get('/subscription-close-for-a-day', "HomeController@subscriptionClosedForADay");
    Route::get('/offer-close-for-a-day', "HomeController@offerClosedForADay");
    //    ---------------------------
    Route::get('viewcart', 'CheckoutController@viewcart');

    //    Route::group(['middleware' => 'CheckoutAccess'], function () {
    Route::get('checkout', 'CheckoutController@checkout');
    Route::post('checkout_shipping_address', 'CheckoutController@checkout_shipping_address');
    Route::post('checkout_billing_address', 'CheckoutController@checkout_billing_address');
    Route::post('checkout_shipping_method', 'CheckoutController@checkout_shipping_method');
    Route::get('coupon-check', 'CheckoutController@couponCheck')->name('coupon_check');
    Route::post('place_order', 'CheckoutController@placeOrder')->name('place_order');
    Route::get('order-success', 'CheckoutController@orderSuccess')->name('order-success');
    Route::get('order-fail', 'CheckoutController@orderFail')->name('order-fail');


    
    Route::post('place_order_new', 'CheckoutController@placeOrderNew');


   



    Route::get('confirm-order', 'CheckoutController@onfirmOrder');
    Route::post('confirm-order-post', 'CheckoutController@onfirmOrderPost');
    Route::post('sslcommercesuccess', 'CheckoutController@sslcommerceSuccess');

    Route::get('order-success', 'CheckoutController@orderSuccess');
    Route::post('order-fail', 'CheckoutController@orderFail');
});
/*eCOMMERCE vsL*/


Route::middleware(['setData'])->group(function () {
//    Route::get('/', function () {
//        return view('welcome');
//    });

    Auth::routes();

    Route::get('/business/register', 'BusinessController@getRegister')->name('business.getRegister');
    Route::post('/business/register', 'BusinessController@postRegister')->name('business.postRegister');
    Route::post('/business/register/check-username', 'BusinessController@postCheckUsername')->name('business.postCheckUsername');
    Route::post('/business/register/check-email', 'BusinessController@postCheckEmail')->name('business.postCheckEmail');

    Route::get('/invoice/{token}', 'SellPosController@showInvoice')
        ->name('show_invoice');
});

//Routes for authenticated users only
Route::middleware(['setData', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu', 'CheckUserLogin'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/get-totals', 'HomeController@getTotals');
    Route::get('/home/product-stock-alert', 'HomeController@getProductStockAlert');
    Route::get('/home/product-stock-alert-purchase', 'HomeController@getProductStockAlertPurchase');
    Route::get('/home/purchase-payment-dues', 'HomeController@getPurchasePaymentDues');
    Route::get('/home/sales-payment-dues', 'HomeController@getSalesPaymentDues');
    
    Route::post('/test-email', 'BusinessController@testEmailConfiguration');
    Route::post('/test-sms', 'BusinessController@testSmsConfiguration');
    Route::get('/business/settings', 'BusinessController@getBusinessSettings')->name('business.getBusinessSettings');
    Route::post('/business/update', 'BusinessController@postBusinessSettings')->name('business.postBusinessSettings');
    Route::get('/user/profile', 'UserController@getProfile')->name('user.getProfile');
    Route::post('/user/update', 'UserController@updateProfile')->name('user.updateProfile');
    Route::post('/user/update-password', 'UserController@updatePassword')->name('user.updatePassword');

    Route::resource('brands', 'BrandController');
    Route::resource('sliders', 'Front\Admin\Common\Sliders');

    Route::get('taxonomies-ajax-index-page', 'TaxonomyController@getTaxonomyIndexPage');
    Route::resource('taxonomies', 'TaxonomyController');
    
    Route::resource('payment-account', 'PaymentAccountController');

    Route::resource('tax-rates', 'TaxRateController');

    Route::resource('units', 'UnitController');

    Route::get('/contacts/map', 'ContactController@contactMap');
    Route::get('/contacts/update-status/{id}', 'ContactController@updateStatus');
    Route::get('/contacts/stock-report/{supplier_id}', 'ContactController@getSupplierStockReport');
    Route::get('/contacts/ledger', 'ContactController@getLedger');
    Route::post('/contacts/send-ledger', 'ContactController@sendLedger');
    Route::get('/contacts/import', 'ContactController@getImportContacts')->name('contacts.import');
    Route::post('/contacts/import', 'ContactController@postImportContacts');
    Route::post('/contacts/check-contact-id', 'ContactController@checkContactId');
    Route::get('/contacts/customers', 'ContactController@getCustomers');
    Route::resource('contacts', 'ContactController');

    

    Route::resource('variation-templates', 'VariationTemplateController');

    Route::get('/delete-media/{media_id}', 'ProductController@deleteMedia');
    Route::post('/products/mass-deactivate', 'ProductController@massDeactivate');
    Route::get('/products/activate/{id}', 'ProductController@activate');
    Route::get('/products/view-product-group-price/{id}', 'ProductController@viewGroupPrice');
    Route::get('/products/add-selling-prices/{id}', 'ProductController@addSellingPrices');
    Route::post('/products/save-selling-prices', 'ProductController@saveSellingPrices');
    Route::post('/products/mass-delete', 'ProductController@massDestroy');
    Route::get('/products/view/{id}', 'ProductController@view');
    Route::get('/products/list', 'ProductController@getProducts');
    Route::get('/products/list-no-variation', 'ProductController@getProductsWithoutVariations');
    Route::post('/products/bulk-edit', 'ProductController@bulkEdit');
    Route::post('/products/bulk-update', 'ProductController@bulkUpdate');
    Route::post('/products/bulk-update-location', 'ProductController@updateProductLocation');
    Route::get('/products/get-product-to-edit/{product_id}', 'ProductController@getProductToEdit');
    
    Route::post('/products/get_sub_categories', 'ProductController@getSubCategories');
    Route::get('/products/get_sub_units', 'ProductController@getSubUnits');
    Route::post('/products/product_form_part', 'ProductController@getProductVariationFormPart');
    Route::post('/products/get_product_variation_row', 'ProductController@getProductVariationRow');
    Route::post('/products/get_variation_template', 'ProductController@getVariationTemplate');
    Route::get('/products/get_variation_value_row', 'ProductController@getVariationValueRow');
    Route::post('/products/check_product_sku', 'ProductController@checkProductSku');
    Route::get('/products/quick_add', 'ProductController@quickAdd');
    Route::post('/products/save_quick_product', 'ProductController@saveQuickProduct');
    Route::get('/products/get-combo-product-entry-row', 'ProductController@getComboProductEntryRow');
    
    Route::resource('products', 'ProductController');

    Route::post('/purchases/update-status', 'PurchaseController@updateStatus');
    Route::get('/purchases/get_products', 'PurchaseController@getProducts');
    Route::get('/purchases/get_suppliers', 'PurchaseController@getSuppliers');
    Route::post('/purchases/get_purchase_entry_row', 'PurchaseController@getPurchaseEntryRow');
    Route::post('/purchases/check_ref_number', 'PurchaseController@checkRefNumber');
    Route::resource('purchases', 'PurchaseController')->except(['show']);

    Route::get('/toggle-subscription/{id}', 'SellPosController@toggleRecurringInvoices');
    Route::post('/sells/pos/get-types-of-service-details', 'SellPosController@getTypesOfServiceDetails');
    Route::get('/sells/subscriptions', 'SellPosController@listSubscriptions');
    Route::get('/sells/duplicate/{id}', 'SellController@duplicateSell');
    Route::get('/sells/drafts', 'SellController@getDrafts');
    Route::get('/sells/report-purchase-sells', 'SellController@getSellWithPurchase'); 
    
    Route::get('/sells/quotations', 'SellController@getQuotations');
    Route::get('/sells/draft-dt', 'SellController@getDraftDatables');
    Route::get('/convert_pos/{id}', 'SellPosController@convert_pos')->name('convert_pos');
    Route::get('/create_ecommerce/{data}', 'SellController@create_ecommerce')->name('create_ecommerce');

    Route::resource('sells', 'SellController')->except(['show']);

    Route::get('/import-sales', 'ImportSalesController@index');
    Route::post('/import-sales/preview', 'ImportSalesController@preview');
    Route::post('/import-sales', 'ImportSalesController@import');
    Route::get('/revert-sale-import/{batch}', 'ImportSalesController@revertSaleImport');

    Route::get('/sells/pos/get_product_row/{variation_id}/{location_id}', 'SellPosController@getProductRow');
    Route::post('/sells/pos/get_payment_row', 'SellPosController@getPaymentRow');
    Route::post('/sells/pos/get-reward-details', 'SellPosController@getRewardDetails');
    Route::get('/sells/pos/get-recent-transactions', 'SellPosController@getRecentTransactions');
    Route::get('/sells/pos/get-product-suggestion', 'SellPosController@getProductSuggestion');
    Route::resource('pos', 'SellPosController');

    Route::resource('roles', 'RoleController');

    Route::get('deleteMultipleMedia', 'Media@deleteMultipleMedia')->name('deleteMultipleMedia');
    Route::get('media_search', 'Media@media_search')->name('media_search');

    Route::resource('users', 'ManageUserController');
    Route::resource('media', 'MediaController');

    Route::resource('group-taxes', 'GroupTaxController');

    Route::get('/barcodes/set_default/{id}', 'BarcodeController@setDefault');
    Route::resource('barcodes', 'BarcodeController');

    //Invoice schemes..
    Route::get('/invoice-schemes/set_default/{id}', 'InvoiceSchemeController@setDefault');
    Route::resource('invoice-schemes', 'InvoiceSchemeController');

    //Print Labels
    Route::get('/labels/show', 'LabelsController@show');
    Route::get('/labels/add-product-row', 'LabelsController@addProductRow');
    Route::get('/labels/preview', 'LabelsController@preview');

    //Reports...
    Route::get('/reports/purchase-report', 'ReportController@purchaseReport');
    Route::get('/reports/sale-report', 'ReportController@saleReport');
    Route::get('/reports/service-staff-report', 'ReportController@getServiceStaffReport');
    Route::get('/reports/service-staff-line-orders', 'ReportController@serviceStaffLineOrders');
    Route::get('/reports/table-report', 'ReportController@getTableReport');
    Route::get('/reports/profit-loss', 'ReportController@getProfitLoss');
    Route::get('/reports/get-opening-stock', 'ReportController@getOpeningStock');
    Route::get('/reports/purchase-sell', 'ReportController@getPurchaseSell');
    Route::get('/reports/customer-supplier', 'ReportController@getCustomerSuppliers');
    Route::get('/reports/stock-report', 'ReportController@getStockReport');
    Route::get('/reports/stock-details', 'ReportController@getStockDetails');
    Route::get('/reports/tax-report', 'ReportController@getTaxReport');
    Route::get('/reports/tax-details', 'ReportController@getTaxDetails');
    Route::get('/reports/trending-products', 'ReportController@getTrendingProducts');
    Route::get('/reports/expense-report', 'ReportController@getExpenseReport');
    Route::get('/reports/stock-adjustment-report', 'ReportController@getStockAdjustmentReport');
    Route::get('/reports/register-report', 'ReportController@getRegisterReport');
    Route::get('/reports/sales-representative-report', 'ReportController@getSalesRepresentativeReport');
    Route::get('/reports/sales-representative-total-expense', 'ReportController@getSalesRepresentativeTotalExpense');
    Route::get('/reports/sales-representative-total-sell', 'ReportController@getSalesRepresentativeTotalSell');
    Route::get('/reports/sales-representative-total-commission', 'ReportController@getSalesRepresentativeTotalCommission');
    Route::get('/reports/stock-expiry', 'ReportController@getStockExpiryReport');
    Route::get('/reports/stock-expiry-edit-modal/{purchase_line_id}', 'ReportController@getStockExpiryReportEditModal');
    Route::post('/reports/stock-expiry-update', 'ReportController@updateStockExpiryReport')->name('updateStockExpiryReport');
    Route::get('/reports/customer-group', 'ReportController@getCustomerGroup');
    Route::get('/reports/product-purchase-report', 'ReportController@getproductPurchaseReport');
    Route::get('/reports/product-sell-report', 'ReportController@getproductSellReport');
    Route::get('/reports/product-sell-report-with-purchase', 'ReportController@getproductSellReportWithPurchase');
    Route::get('/reports/product-sell-grouped-report', 'ReportController@getproductSellGroupedReport');
    Route::get('/reports/lot-report', 'ReportController@getLotReport');
    Route::get('/reports/purchase-payment-report', 'ReportController@purchasePaymentReport');
    Route::get('/reports/sell-payment-report', 'ReportController@sellPaymentReport');
    Route::get('/reports/product-stock-details', 'ReportController@productStockDetails');
    Route::get('/reports/adjust-product-stock', 'ReportController@adjustProductStock');
    Route::get('/reports/get-profit/{by?}', 'ReportController@getProfit');
    Route::get('/reports/items-report', 'ReportController@itemsReport');
    Route::get('/reports/report-product-ledger', 'ReportController@getProductLedger'); 
    
    Route::get('/reports/ecommerce-product-sell-report', 'ReportController@getEcommerceProductWiseSellReport');
    Route::get('/reports/get-stock-value', 'ReportController@getStockValue');
    
    Route::get('business-location/activate-deactivate/{location_id}', 'BusinessLocationController@activateDeactivateLocation');

    //Business Location Settings...
    Route::prefix('business-location/{location_id}')->name('location.')->group(function () {
        Route::get('settings', 'LocationSettingsController@index')->name('settings');
        Route::post('settings', 'LocationSettingsController@updateSettings')->name('settings_update');
    });

    //Business Locations...
    Route::post('business-location/check-location-id', 'BusinessLocationController@checkLocationId');
    Route::resource('business-location', 'BusinessLocationController');

    //Invoice layouts..
    Route::resource('invoice-layouts', 'InvoiceLayoutController');

    //Expense Categories...
    Route::resource('expense-categories', 'ExpenseCategoryController');

    /**
             * Appearance
             */
            
                Route::get("smthemeoptions", "AppearanceController@smthemeoptions")->name('smthemeoptions');
                Route::post("save-sm-theme-options", "AppearanceController@saveSmThemeOptions")
                    ->name("saveThemeOption");
                Route::get('menus', 'AppearanceController@menus')->name('menus');
                Route::post('save_menus', 'AppearanceController@save_menus')->name('save_menus');
                Route::any("editor", "AppearanceController@editor")->name('editor');
                /**
                 * editor
                 */
                // Route::group(['prefix' => 'editor'], function () {
                //     Route::any("/", "Appearance@editor");
                //     Route::post("update-file", "Appearance@updateFile");
                // });

    /**
     * Tags
     */
    Route::get('tags/list','TagController@index')->name('list');
    Route::get('tags/create','TagController@create')->name('create');
    Route::get('slug_generate', 'TagController@slugGenerate')->name('slug_generate');
    Route::post('tags/store','TagController@store')->name('tags.store');
    Route::get('tags/edit/{id}','TagController@edit')->name('edit');
    Route::post('tags/update/{id}','TagController@update')->name('tags.update');
    Route::get('tags/delete/{id}','TagController@delete')->name('delete');

//    Route::resource("tags", "Tags");
    Route::get("tags/destroy/{id}", "Tags@destroy");
    Route::post("tag_status_update", "Tags@tag_status_update");
    Route::get("dataProcessingTag", "Tags@dataProcessing")->name('dataProcessingTag');




            Route::resource("orders", "OrdersController");
            Route::get("/order", "OrdersController@index")->name('order_list');
            Route::get("orders/destroy/{id}", "OrdersController@destroy");
            Route::get("orders/download/{id}", "OrdersController@download");
            Route::get("orders/download_product_request/{id}", "OrdersController@download_product_request");
            Route::post("orders/order_status_update", "OrdersController@order_status_update");
            Route::post("orders/delivery_status_update", "OrdersController@delivery_status_update")->name('delivery_status_update');
            Route::post("orders/order_info_update", "OrdersController@order_info_update")
                ->name('order_info_update');
                
            Route::post("orders/delivery_info_update", "OrdersController@delivery_info_update")
                ->name('delivery_info_update');
                
                
            Route::post("orders/order_mail", "OrdersController@order_mail")
                ->name('order_mail');
            Route::post("orders/payment_status_update", "OrdersController@payment_status_update");
            Route::post("orders/payment_info_update", "OrdersController@payment_info_update")
                ->name('payment_info_update');
            Route::get("dataProcessingOrder", "OrdersController@dataProcessing")->name('dataProcessingOrder');
            Route::get("adminApplyCoupon", "OrdersController@adminApplyCoupon")->name('adminApplyCoupon');
            Route::get("/findProductBySize", "OrdersController@findProductBySize")->name('findProductBySize');
            Route::get("/findProductSizeByColorPrice", "OrdersController@findProductSizeByColorPrice")->name('findProductSizeByColorPrice');
            Route::get("find_product_by_details", "OrdersController@find_product_by_details")->name('find_product_by_details');
            Route::get("admin_remove_to_cart", "OrdersController@remove_to_cart")->name('admin_remove_to_cart');

    /**
     * Blog
     */
    Route::get('bloglist','BlogController@index')->name('bloglist');
    Route::get('blogcreate','BlogController@create')->name('create');
    Route::get('slug_generate', 'BlogController@slugGenerate')->name('slug_generate');
    Route::post('blogstore','BlogController@store')->name('blog.store');
    Route::get('blogedit/{id}','BlogController@edit')->name('edit');
    Route::post('blogupdate/{id}','BlogController@update')->name('blog.update');
    Route::get('blogdelete/{id}','BlogController@delete')->name('delete');

    /**
     * Slider
     */
    Route::get('sliderslist','SlidersController@index')->name('sliderslist');
    Route::get('create','SlidersController@create')->name('create');
    Route::post('store','SlidersController@store')->name('store');
    Route::get('edit/{id}','SlidersController@edit')->name('edit');
    Route::post('update/{id}','SlidersController@update')->name('update');
    Route::get('delete/{id}','SlidersController@delete')->name('delete');

    /**
     * Page
     */
    Route::get('pageslist','PagesController@index')->name('pageslist');
    Route::get('pagescreate','PagesController@create')->name('pagescreate');
    Route::get('slug_generate', 'PagesController@slugGenerate')->name('slug_generate');
    Route::post('pagesstore','PagesController@store')->name('pagesstore');
    Route::get('pagesedit/{id}','PagesController@edit')->name('pagesedit');
    Route::post('pagesupdate/{id}','PagesController@update')->name('pagesupdate');
    Route::get('pagesdelete/{id}','PagesController@delete')->name('pagesdelete');

    //Expenses...
    Route::resource('expenses', 'ExpenseController');

    //Transaction payments...
    // Route::get('/payments/opening-balance/{contact_id}', 'TransactionPaymentController@getOpeningBalancePayments');
    Route::get('/payments/show-child-payments/{payment_id}', 'TransactionPaymentController@showChildPayments');
    Route::get('/payments/view-payment/{payment_id}', 'TransactionPaymentController@viewPayment');
    Route::get('/payments/add_payment/{transaction_id}', 'TransactionPaymentController@addPayment');
    Route::get('/payments/pay-contact-due/{contact_id}', 'TransactionPaymentController@getPayContactDue');
    Route::post('/payments/pay-contact-due', 'TransactionPaymentController@postPayContactDue');
    Route::resource('payments', 'TransactionPaymentController');

    //Printers...
    Route::resource('printers', 'PrinterController');

    Route::get('/stock-adjustments/remove-expired-stock/{purchase_line_id}', 'StockAdjustmentController@removeExpiredStock');
    Route::post('/stock-adjustments/get_product_row', 'StockAdjustmentController@getProductRow');
    Route::resource('stock-adjustments', 'StockAdjustmentController');

    Route::get('/cash-register/register-details', 'CashRegisterController@getRegisterDetails');
    Route::get('/cash-register/close-register', 'CashRegisterController@getCloseRegister');
    Route::post('/cash-register/close-register', 'CashRegisterController@postCloseRegister');
    Route::resource('cash-register', 'CashRegisterController');

    //Import products
    Route::get('/import-products', 'ImportProductsController@index');
    Route::post('/import-products/store', 'ImportProductsController@store');

    //Sales Commission Agent
    Route::resource('sales-commission-agents', 'SalesCommissionAgentController');

    //Stock Transfer
    Route::get('stock-transfers/print/{id}', 'StockTransferController@printInvoice');
    Route::resource('stock-transfers', 'StockTransferController');
    
    Route::get('/opening-stock/add/{product_id}', 'OpeningStockController@add');
    Route::post('/opening-stock/save', 'OpeningStockController@save');

    //Customer Groups
    Route::resource('customer-group', 'CustomerGroupController');

    //Import opening stock
    Route::get('/import-opening-stock', 'ImportOpeningStockController@index');
    Route::post('/import-opening-stock/store', 'ImportOpeningStockController@store');

    //Sell return
    Route::resource('sell-return', 'SellReturnController');
    Route::get('sell-return/get-product-row', 'SellReturnController@getProductRow');
    Route::get('/sell-return/print/{id}', 'SellReturnController@printInvoice');
    Route::get('/sell-return/add/{id}', 'SellReturnController@add');
    
    //Backup
    Route::get('backup/download/{file_name}', 'BackUpController@download');
    Route::get('backup/delete/{file_name}', 'BackUpController@delete');
    Route::resource('backup', 'BackUpController', ['only' => [
        'index', 'create', 'store'
    ]]);

    Route::get('selling-price-group/activate-deactivate/{id}', 'SellingPriceGroupController@activateDeactivate');
    Route::get('export-selling-price-group', 'SellingPriceGroupController@export');
    Route::post('import-selling-price-group', 'SellingPriceGroupController@import');

    Route::resource('selling-price-group', 'SellingPriceGroupController');

    Route::resource('notification-templates', 'NotificationTemplateController')->only(['index', 'store']);
    Route::get('notification/get-template/{transaction_id}/{template_for}', 'NotificationController@getTemplate');
    Route::post('notification/send', 'NotificationController@send');

    Route::post('/purchase-return/update', 'CombinedPurchaseReturnController@update');
    Route::get('/purchase-return/edit/{id}', 'CombinedPurchaseReturnController@edit');
    Route::post('/purchase-return/save', 'CombinedPurchaseReturnController@save');
    Route::post('/purchase-return/get_product_row', 'CombinedPurchaseReturnController@getProductRow');
    Route::get('/purchase-return/create', 'CombinedPurchaseReturnController@create');
    Route::get('/purchase-return/add/{id}', 'PurchaseReturnController@add');
    Route::resource('/purchase-return', 'PurchaseReturnController', ['except' => ['create']]);

    Route::get('/discount/activate/{id}', 'DiscountController@activate');
    Route::post('/discount/mass-deactivate', 'DiscountController@massDeactivate');
    Route::resource('discount', 'DiscountController');

    Route::group(['prefix' => 'account'], function () {
        Route::resource('/account', 'AccountController');
        Route::get('/fund-transfer/{id}', 'AccountController@getFundTransfer');
        Route::post('/fund-transfer', 'AccountController@postFundTransfer');
        Route::get('/deposit/{id}', 'AccountController@getDeposit');
        Route::post('/deposit', 'AccountController@postDeposit');
        Route::get('/close/{id}', 'AccountController@close');
        Route::get('/activate/{id}', 'AccountController@activate');
        Route::get('/delete-account-transaction/{id}', 'AccountController@destroyAccountTransaction');
        Route::get('/get-account-balance/{id}', 'AccountController@getAccountBalance');
        Route::get('/balance-sheet', 'AccountReportsController@balanceSheet');
        Route::get('/trial-balance', 'AccountReportsController@trialBalance');
        Route::get('/payment-account-report', 'AccountReportsController@paymentAccountReport');
        Route::get('/link-account/{id}', 'AccountReportsController@getLinkAccount');
        Route::post('/link-account', 'AccountReportsController@postLinkAccount');
        Route::get('/cash-flow', 'AccountController@cashFlow');
    });
    
    Route::resource('account-types', 'AccountTypeController');

    //Restaurant module
    Route::group(['prefix' => 'modules'], function () {
        Route::resource('tables', 'Restaurant\TableController');
        Route::resource('modifiers', 'Restaurant\ModifierSetsController');

        //Map modifier to products
        Route::get('/product-modifiers/{id}/edit', 'Restaurant\ProductModifierSetController@edit');
        Route::post('/product-modifiers/{id}/update', 'Restaurant\ProductModifierSetController@update');
        Route::get('/product-modifiers/product-row/{product_id}', 'Restaurant\ProductModifierSetController@product_row');

        Route::get('/add-selected-modifiers', 'Restaurant\ProductModifierSetController@add_selected_modifiers');

        Route::get('/kitchen', 'Restaurant\KitchenController@index');
        Route::get('/kitchen/mark-as-cooked/{id}', 'Restaurant\KitchenController@markAsCooked');
        Route::post('/refresh-orders-list', 'Restaurant\KitchenController@refreshOrdersList');
        Route::post('/refresh-line-orders-list', 'Restaurant\KitchenController@refreshLineOrdersList');

        Route::get('/orders', 'Restaurant\OrderController@index');
        Route::get('/orders/mark-as-served/{id}', 'Restaurant\OrderController@markAsServed');
        Route::get('/data/get-pos-details', 'Restaurant\DataController@getPosDetails');
        Route::get('/orders/mark-line-order-as-served/{id}', 'Restaurant\OrderController@markLineOrderAsServed');
    });

    Route::get('bookings/get-todays-bookings', 'Restaurant\BookingController@getTodaysBookings');
    Route::resource('bookings', 'Restaurant\BookingController');

    Route::resource('types-of-service', 'TypesOfServiceController');
    Route::get('sells/edit-shipping/{id}', 'SellController@editShipping');
    Route::put('sells/update-shipping/{id}', 'SellController@updateShipping');
    Route::get('shipments', 'SellController@shipments');

    Route::post('upload-module', 'Install\ModulesController@uploadModule');
    Route::resource('manage-modules', 'Install\ModulesController')
        ->only(['index', 'destroy', 'update']);
    Route::resource('warranties', 'WarrantyController');

    Route::resource('dashboard-configurator', 'DashboardConfiguratorController')
    ->only(['edit', 'update']);

    

    Route::post('get_image_src', 'DashboardConfiguratorController@get_image_src')->name('get_image_src');

    //common controller for document & note
    Route::get('get-document-note-page', 'DocumentAndNoteController@getDocAndNoteIndexPage');
    Route::post('post-document-upload', 'DocumentAndNoteController@postMedia');
    Route::resource('note-documents', 'DocumentAndNoteController');
});


Route::middleware(['EcomApi'])->prefix('api/ecom')->group(function () {
    Route::get('products/{id?}', 'ProductController@getProductsApi');
    Route::get('categories', 'CategoryController@getCategoriesApi');
    Route::get('brands', 'BrandController@getBrandsApi');
    Route::post('customers', 'ContactController@postCustomersApi');
    Route::get('settings', 'BusinessController@getEcomSettings');
    Route::get('variations', 'ProductController@getVariationsApi');
    Route::post('orders', 'SellPosController@placeOrdersApi');
});

//common route
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::middleware(['setData', 'auth', 'SetSessionData', 'language', 'timezone'])->group(function () {
    Route::get('/load-more-notifications', 'HomeController@loadMoreNotifications');
    Route::get('/get-total-unread', 'HomeController@getTotalUnreadNotifications');
    Route::get('/purchases/print/{id}', 'PurchaseController@printInvoice');
    Route::get('/purchases/{id}', 'PurchaseController@show');
    Route::get('/sells/{id}', 'SellController@show');
    Route::get('/sells/{transaction_id}/print', 'SellPosController@printInvoice')->name('sell.printInvoice');
    Route::get('/sells/invoice-url/{id}', 'SellPosController@showInvoiceUrl');
});
