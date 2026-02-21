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

// Route::get('/', function () {
//     return view('frontend.welcome');
// });

Route::prefix('api/v1')->group(function () {
	Route::post('login', 'Api\HomeController@login');
	Route::post('auth', 'Api\HomeController@auth');
	Route::get('authy', 'Api\HomeController@authy');
	Route::post('logout', 'Api\HomeController@getLogout');
	Route::post('register', 'Api\HomeController@register');
	
	Route::get('address', 'Api\VegetableController@address');
    /*Route::get('token', function () {
    	return  csrf_token();
        // Matches The "/admin/users" URL
    });*/
    Route::get('testable', 'Api\VegetableController@test');

});
Route::group(["prefix" => "api/v1" , "middleware" => 'user'], function(){
	Route::resource('vegetable', 'Api\VegetableController', ['only' => [
		'index'
	]]);
	
	Route::get('init', 'Api\VegetableController@initialize');
	Route::get('orders', 'Api\VegetableController@orders');
	Route::post('checkout', 'Api\VegetableController@checkout');
});

Auth::routes();

Route::group(['middleware'=>['admin']],function(){
	Route::get('/home', 'Backend\HomeController@index')->name('admin-manager');
	Route::get('/home/change-password', 'Backend\HomeController@changePassword')->name('admin-change-password');
	Route::post('/home/change-password/store', 'Backend\HomeController@changePasswordStore')->name('admin-change-password-store');
	// branch
	Route::get('/home/branch', 'Backend\BranchController@index')->name('admin-create-branch');
	Route::post('/home/branch/store', 'Backend\BranchController@store')->name('admin-create-branch-store');
	// manager
	Route::get('/home/manager', 'Backend\ManagerController@index')->name('admin-create-manager');
	Route::post('/home/manager/store', 'Backend\ManagerController@store')->name('admin-create-manager-store');

	// to get branch detail
	Route::get('/home/manager/{id}', 'Backend\Manager\HomeController@index')->name('manager-index');
	
	Route::get('/home/manager/{id}/purchase', 'Backend\Manager\HomeController@purchase')->name('manager-purchase');
	Route::post('/home/manager/{id}/purchase/search', 'Backend\Manager\HomeController@purchase_search')->name('manager-purchase-search');
	Route::get('/home/manager/{id}/sales', 'Backend\Manager\HomeController@sales')->name('manager-sales');
	Route::post('/home/manager/{id}/sales/search', 'Backend\Manager\HomeController@sales_search')->name('manager-sales-search');
	Route::get('/home/manager/{id}/stock', 'Backend\Manager\HomeController@stock')->name('manager-stock');
	Route::post('/home/manager/{id}/stock/search', 'Backend\Manager\HomeController@stock_search')->name('manager-stock-search');

	// creditor customer
	Route::get('/home/customer-creditor', 'Backend\CustomerCreditController@index')->name('admin-customer-creditor');
	Route::get('/home/customer-creditor/{id}', 'Backend\CustomerCreditController@customer_creditor_detail')->name('admin-customer-creditor-detail');
	Route::post('/home/customer-creditor/getAllCreditor', 'Backend\CustomerCreditController@getAllCreditor')->name('admin-getAllCreditor');
	Route::post('/home/customer-creditor/creditor-store', 'Backend\CustomerCreditController@creditor_store')->name('admin-customer-creditor-store');

	// debitor customer
	Route::get('/home/customer-debitor', 'Backend\CustomerDebitController@index')->name('admin-customer-debitor');
	Route::get('/home/customer-debitor/{id}', 'Backend\CustomerDebitController@customer_debitor_detail')->name('admin-customer-debitor-detail');
	Route::post('/home/customer-debitor/getAllDebitor', 'Backend\CustomerDebitController@getAllDebitor')->name('admin-getAllDebitor');
	Route::post('/home/customer-debitor/debitor-store', 'Backend\CustomerDebitController@debitor_store')->name('admin-customer-debitor-store');

	// unit
	Route::get('/home/unit', 'Backend\UnitController@index')->name('admin-unit');
	Route::post('/home/unit/store', 'Backend\UnitController@store')->name('admin-unit-store');

	// category
	Route::get('/home/category', 'Backend\CategoryController@index')->name('admin-category');

	// vegetable
	Route::get('/home/vegetable', 'Backend\VegetableController@index')->name('admin-vegetable');
	Route::post('/home/vegetable/getAllVegetable', 'Backend\VegetableController@getAllVegetable')->name('admin-getAllVegetable');
	Route::post('/home/vegetable/store', 'Backend\VegetableController@store')->name('admin-vegetable-store');
	Route::post('/home/order/getItemUnit', 'Backend\OrderController@getItemUnit')->name('admin-getItemUnit');

	// category list
	Route::get('/home/category/{slug}', 'Backend\CategoryController@detail')->name('admin-category-detail');
	Route::post('/home/category/getAllCategoryDetail', 'Backend\CategoryController@getAllCategoryDetail')->name('admin-getAllCategoryDetail');
	
	Route::post('/home/category/getAllCategory', 'Backend\CategoryController@getAllCategory')->name('admin-getAllCategory');
	Route::post('/home/category/store', 'Backend\CategoryController@store')->name('admin-category-store');

	// purchase entry
	Route::get('/home/purchase/entry', 'Backend\PurchaseController@show')->name('admin-purchase-entry');
	Route::post('/home/purchase/entry/getCatVeg', 'Backend\PurchaseController@getCatVeg')->name('admin-getCatVeg');
	Route::post('/home/purchase/entry/store', 'Backend\PurchaseController@store')->name('admin-purchase-store');
	// purchase view
	Route::get('/home/purchase/view', 'Backend\PurchaseController@index')->name('admin-purchase-view');
	Route::post('/home/purchase/search', 'Backend\PurchaseController@search')->name('admin-purchase-search');

	// manage
	Route::get('/home/purchase/view/manage/{id}', 'Backend\ManageController@index')->name('admin-purchase-manage');
	Route::post('/home/purchase/view/manage/{id}/store', 'Backend\ManageController@store')->name('admin-purchase-manage-store');

	// order
	Route::get('/home/order', 'Backend\OrderController@index')->name('admin-order-view');
	Route::post('/home/order/getItemList', 'Backend\OrderController@getItemList')->name('admin-getItemList');
	Route::post('/home/order/getItemUnit', 'Backend\OrderController@getItemUnit')->name('admin-getItemUnit');
	Route::post('/home/order/getItemCalculation', 'Backend\OrderController@getItemCalculation')->name('admin-getItemCalculation');
	Route::post('/home/order/store', 'Backend\OrderController@store')->name('admin-order-store');
	Route::get('/home/order/bill/{id}', 'Backend\OrderController@bill_print')->name('admin-print_bill');

	// report part
	Route::get('/home/report','Backend\Report\HomeController@index')->name('admin-report');

	Route::get('/home/report/customer','Backend\Report\CustomerController@index')->name('admin-customer-report');
	Route::post('/home/report/customer/search','Backend\Report\CustomerController@search')->name('admin-customer-search');
	Route::post('/home/report/customer/getCustomer','Backend\Report\CustomerController@getCustomer')->name('admin-customer-getCustomer');

	Route::get('/home/report/stock','Backend\Report\StockController@index')->name('admin-stock-report');
	Route::post('/home/report/stock/getVegetable','Backend\Report\StockController@getVegetable')->name('admin-vegetable-getVegetable');
	Route::post('/home/report/stock/search','Backend\Report\StockController@search')->name('admin-stock-search');

	Route::get('/home/report/sales','Backend\Report\SaleController@index')->name('admin-sales-report');
	Route::post('/home/report/sales/getSale','Backend\Report\SaleController@getSale')->name('admin-getSale');
	Route::post('/home/report/sales/search','Backend\Report\SaleController@search')->name('admin-sales-search');

	Route::get('/home/report/purchase','Backend\Report\PurchaseController@index')->name('admin-purchase-report');
	Route::post('/home/report/purchase/getPurchase','Backend\Report\PurchaseController@getPurchase')->name('admin-getPurchase');
	Route::post('/home/report/purchase/search','Backend\Report\PurchaseController@search')->name('admin-purchase-search');

	Route::get('/home/report/bill','Backend\Report\BillController@index')->name('admin-bill-report');
	Route::post('/home/report/bill/search','Backend\Report\BillController@search')->name('admin-bill-search');

	//slider part
	Route::get('/home/slider', 'Backend\Slider\SliderController@index')->name('slider-view');
	Route::post('/home/slider/store', 'Backend\Slider\SliderController@store')->name('slider-store');
	Route::get('/home/slider/{id}/isActive', 'Backend\Slider\SliderController@isActive')->name('slider-isActive');
	Route::get('/home/slider/{id}/inApp', 'Backend\Slider\SliderController@inApp')->name('slider-inApp');
	Route::get('/home/slider/{id}/delete', 'Backend\Slider\SliderController@destroy')->name('slider-delete');
	Route::post('/home/sort/slider', 'Backend\Slider\SliderController@isSort')->name('slider-isSort');
	Route::get('/home/slider/{id}/edit','Backend\Slider\SliderController@edit')->name('slider-edit');
	Route::post('/home/slider/{id}/update','Backend\Slider\SliderController@update')->name('slider-update');

	//Contact part
	Route::get('/home/contact','Backend\Contact\ContactController@index')->name('contact-view');
	Route::post('/home/contact/store','Backend\Contact\ContactController@store')->name('contact-store');
	Route::get('/home/contact/{id}/isActive', 'Backend\Contact\ContactController@isActive')->name('contact-isActive');
	Route::post('/home/sort/contact', 'Backend\Contact\ContactController@isSort')->name('contact-isSort');
	Route::get('/home/contact/{id}/delete', 'Backend\Contact\ContactController@destroy')->name('contact-delete');
	Route::get('/home/contact/{id}/edit', 'Backend\Contact\ContactController@edit')->name('contact-edit');
	Route::post('/home/contact/{id}/update', 'Backend\Contact\ContactController@update')->name('contact-update');

	//Blog part

	Route::get('/home/blog','Backend\Blog\BlogController@index')->name('blog-view');
	Route::post('/home/blog/store','Backend\Blog\BlogController@store')->name('blog-store');
	Route::get('/home/blog/{id}/isActive','Backend\Blog\BlogController@isActive')->name('blog-isActive');
	Route::post('/home/sort/blog', 'Backend\Blog\BlogController@isSort')->name('blog-isSort');
	Route::get('/home/blog/{id}/edit', 'Backend\Blog\BlogController@edit')->name('blog-edit');
	Route::post('/home/blog/{id}/update', 'Backend\Blog\BlogController@update')->name('blog-update');
	Route::get('/home/blog/{id}/delete', 'Backend\Blog\BlogController@destroy')->name('blog-delete');


});

Route::group(['middleware'=>['manager']],function(){
	Route::get('/manager', 'Manager\HomeController@index')->name('manager');
	Route::get('/manager/change-password', 'Manager\HomeController@changePassword')->name('change-password');
	Route::post('/manager/change-password/store', 'Manager\HomeController@changePasswordStore')->name('change-password-store');
	// to view price list
	Route::get('/manager/today-price/{date}/{lang}', 'Manager\HomeController@todayPrice')->name('today-price');

	// creditor customer
	Route::get('/manager/customer-creditor', 'Manager\CustomerCreditController@index')->name('customer-creditor');
	Route::get('/manager/customer-creditor/{id}', 'Manager\CustomerCreditController@customer_creditor_detail')->name('customer-creditor-detail');
	Route::post('/manager/customer-creditor/getAllCreditor', 'Manager\CustomerCreditController@getAllCreditor')->name('getAllCreditor');
	Route::post('/manager/customer-creditor/creditor-store', 'Manager\CustomerCreditController@creditor_store')->name('customer-creditor-store');

	// debitor customer
	Route::get('/manager/customer-debitor', 'Manager\CustomerDebitController@index')->name('customer-debitor');
	Route::get('/manager/customer-debitor/{id}', 'Manager\CustomerDebitController@customer_debitor_detail')->name('customer-debitor-detail');
	Route::post('/manager/customer-debitor/getAllDebitor', 'Manager\CustomerDebitController@getAllDebitor')->name('getAllDebitor');
	Route::post('/manager/customer-debitor/debitor-store', 'Manager\CustomerDebitController@debitor_store')->name('customer-debitor-store');

	// unit
	Route::get('/manager/unit', 'Manager\UnitController@index')->name('unit');
	Route::post('/manager/unit/store', 'Manager\UnitController@store')->name('unit-store');

	// category
	Route::get('/manager/category', 'Manager\CategoryController@index')->name('category');

	// vegetable
	Route::get('/manager/vegetable', 'Manager\VegetableController@index')->name('vegetable');
	Route::get('/manager/vegetable/{slug}', 'Manager\VegetableController@getDetail')->name('vegetable-getDetail');
	Route::post('/manager/vegetable/getAllVegetable', 'Manager\VegetableController@getAllVegetable')->name('getAllVegetable');
	Route::post('/manager/vegetable/store', 'Manager\VegetableController@store')->name('vegetable-store');
	Route::post('/manager/order/getItemUnit', 'Manager\OrderController@getItemUnit')->name('getItemUnit');

	// category list
	Route::get('/manager/category/{slug}', 'Manager\CategoryController@detail')->name('category-detail');
	Route::post('/manager/category/getAllCategoryDetail', 'Manager\CategoryController@getAllCategoryDetail')->name('getAllCategoryDetail');
	
	Route::post('/manager/category/getAllCategory', 'Manager\CategoryController@getAllCategory')->name('getAllCategory');
	Route::post('/manager/category/store', 'Manager\CategoryController@store')->name('category-store');

	// purchase entry
	Route::get('/manager/purchase/entry', 'Manager\PurchaseController@show')->name('purchase-entry');
	Route::get('/manager/purchase/entry/date', 'Manager\PurchaseController@dateentryDetail')->name('purchase-entry-date');
	Route::get('/manager/purchase/entry/manage/{id}', 'Manager\ManageController@pindex')->name('ppurchase-manage');
	Route::post('/manager/purchase/entry/manage/{id}/store', 'Manager\ManageController@store_entry')->name('purchase-manage-store-entry');

	Route::post('/manager/purchase/entry/getCatVeg', 'Manager\PurchaseController@getCatVeg')->name('getCatVeg');
	Route::post('/manager/purchase/entry/store', 'Manager\PurchaseController@store')->name('purchase-store');
	// purchase view
	Route::get('/manager/purchase/view', 'Manager\PurchaseController@index')->name('purchase-view');
	Route::post('/manager/purchase/make_out', 'Manager\PurchaseController@make_out')->name('purchase-make_out');
	Route::get('/manager/purchase/view/date', 'Manager\PurchaseController@dateDetail')->name('purchase-date');
	Route::post('/manager/purchase/view/search', 'Manager\PurchaseController@search')->name('item-purchase-search');

	// manage
	Route::get('/manager/purchase/view/manage/{id}', 'Manager\ManageController@index')->name('purchase-manage');
	Route::post('/manager/purchase/view/manage/{id}/store', 'Manager\ManageController@store')->name('purchase-manage-store');

	// order
	Route::get('/manager/order', 'Manager\OrderController@index')->name('order-view');
	Route::post('/manager/order/getItemList', 'Manager\OrderController@getItemList')->name('getItemList');
	Route::post('/manager/order/getItemUnit', 'Manager\OrderController@getItemUnit')->name('getItemUnit');
	Route::post('/manager/order/getItemCalculation', 'Manager\OrderController@getItemCalculation')->name('getItemCalculation');
	Route::post('/manager/order/store', 'Manager\OrderController@store')->name('order-store');
	Route::get('/manager/order/bill/{id}', 'Manager\OrderController@bill_print')->name('print_bill');

	// report part
	Route::get('/manager/report','Manager\Report\HomeController@index')->name('report');

	Route::get('/manager/report/customer','Manager\Report\CustomerController@index')->name('customer-report');
	Route::post('/manager/report/customer/search','Manager\Report\CustomerController@search')->name('customer-search');
	Route::post('/manager/report/customer/getCustomer','Manager\Report\CustomerController@getCustomer')->name('customer-getCustomer');

	Route::get('/manager/report/stock','Manager\Report\StockController@index')->name('stock-report');
	Route::post('/manager/report/stock/getVegetable','Manager\Report\StockController@getVegetable')->name('vegetable-getVegetable');
	Route::post('/manager/report/stock/getVegetableItem','Manager\Report\StockController@getItem')->name('vegetable-getItem');
	Route::post('/manager/report/stock/search','Manager\Report\StockController@search')->name('stock-search');

	Route::get('/manager/report/sales','Manager\Report\SaleController@index')->name('sales-report');
	Route::post('/manager/report/sales/getSale','Manager\Report\SaleController@getSale')->name('getSale');
	Route::post('/manager/report/sales/search','Manager\Report\SaleController@search')->name('sales-search');

	Route::get('/manager/report/purchase','Manager\Report\PurchaseController@index')->name('purchase-report');
	Route::post('/manager/report/purchase/getPurchase','Manager\Report\PurchaseController@getPurchase')->name('getPurchase');
	Route::post('/manager/report/purchase/search','Manager\Report\PurchaseController@search')->name('purchase-search');

	Route::get('/manager/report/bill','Manager\Report\BillController@index')->name('bill-report');
	Route::post('/manager/report/bill/search','Manager\Report\BillController@search')->name('bill-search');

	// review
	Route::get('/manager/review', 'Manager\ReviewController@index')->name('review-view');
	Route::get('/manager/review/{bill_id}', 'Manager\ReviewController@getDetail')->name('review-detail');
	Route::post('/manager/review/confirm', 'Manager\ReviewController@reviewConfirm')->name('review-confirm');
	Route::post('/manager/review/deliver', 'Manager\ReviewController@reviewDeliver')->name('review-deliver');
	Route::post('/manager/review/cancle', 'Manager\ReviewController@reviewCancle')->name('review-cancle');
	
	//slider
	


});


	//frontend
	Route::get('/','Frontend\FrontController@index');
	Route::get('/my-order','Frontend\FrontController@myOrder')->name('myOrder');
	Route::get('/my-order/{id}','Frontend\FrontController@orderShow')->name('orderShow');

	//Blog
	Route::get('/blog','Frontend\BlogController@index');	
	Route::get('/blog/show','Frontend\BlogController@create')->name('blog-show');
	
	//contact
	Route::get('/contact','Frontend\ContactController@index')->middleware('cache.response');

	Route::get('/price','Frontend\todayPriceController@todayPrice');
	Route::get('/category/{slug}','Frontend\CategoryController@index');

	//Cart
	Route::get('/cart','Frontend\CartController@index')->name('cart-show');
	Route::post('/cart/store','Frontend\CartController@store')->name('cart-store');
	Route::get('/cart/proceed','Frontend\CartController@proceed')->name('cart-proceed');
	Route::get('/cart/delete/{id}','Frontend\CartController@destroy')->name('cart-delete');
	
	// profile
	Route::get('/profile','Frontend\ProfileController@index')->name('profile');
	Route::post('/profile/{id}/update','Frontend\ProfileController@update');

	//password
	Route::get('/change-password', 'Frontend\FrontController@changePassword')->name('change-password');
	Route::post('/change-password/store', 'Frontend\FrontController@changePasswordStore')->name('change-password-store');




	


