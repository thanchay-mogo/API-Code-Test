<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'API\RegisterController@register');
Route::post('login', [ 'as' => 'login', 'uses' => 'API\RegisterController@login']);
   
Route::middleware('auth:api')->group( function () {
    Route::resource('products', 'API\ProductController');
    Route::resource('shops', 'API\ShopController');
    Route::resource('coupons', 'API\CouponController');
    Route::resource('couponshop', 'API\CouponShopController');
    Route::get('coupons/{couponid}/shops/{shopid}', 'API\CouponController@getCouponByShop');
    Route::delete('coupon/{couponId}','API\CouponController@destroy');
    Route::get('coupons/{couponId}/shops','API\CouponController@getCouponByID');
    Route::delete('coupons/{couponId}/shops/{shopId}','API\CouponController@deleteCouponShop');
});