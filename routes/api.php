<?php

use Illuminate\Http\Request;

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
//AuthController
Route::post('register','api\AuthController@registerPhone');
Route::post('login','api\AuthController@login');
Route::post('activcodeuser','api\AuthController@activcodeuser');
Route::get('setting','api\AuthController@setting');
Route::post('contact','api\AuthController@contact');
Route::post('reset','api\AuthController@reset');
Route::post('resetPassword','api\AuthController@resetPassword');
Route::post('profileUser','api\AuthController@profileUser');
Route::post('editUser','api\AuthController@editUser');
//
Route::get('google', 'Api\SocialAuthGoogleController@redirect');
Route::get('google/callback', 'Api\SocialAuthGoogleController@callback');
//BannerController
Route::get('getBanner','api\BannerController@getBanner');

//homeController
Route::get('getCategory','api\HomeController@getCategory');
Route::post('getBrand','api\HomeController@getBrand');
Route::post('getSubCategory','api\HomeController@getSubCategory');
Route::post('getSection','api\HomeController@getSection');
Route::get('allCountry','api\HomeController@allCountry');
Route::post('cityCountry','api\HomeController@cityCountry');
Route::post('areaCity','api\HomeController@areaCity');

//Advertising Controller
Route::get('getAdv','api\AdvertisingController@getAdv');
Route::post('getCatAdv','api\AdvertisingController@getCatAdv');
Route::post('getUserAds','api\AdvertisingController@getUserAds');
Route::post('getAdvId','api\AdvertisingController@getAdvId');
Route::post('filter','api\AdvertisingController@filter');
Route::post('sorting','api\AdvertisingController@sorting');
Route::post('searchTitleAdvs','api\AdvertisingController@searchTitleAdvs');
Route::post('searchNameCat','api\AdvertisingController@searchNameCat');
Route::post('searchNameSubCat','api\AdvertisingController@searchNameSubCat');
Route::post('searchNameBrand','api\AdvertisingController@searchNameBrand');
Route::post('searchNameClass','api\AdvertisingController@searchNameClass');
Route::post('getSimmillarAdvs','api\AdvertisingController@getSimmillarAdvs');
Route::post('destroyAdv','api\AdvertisingController@destroyAdv');
Route::get('getCategoryWithFiveAdvs','api\AdvertisingController@getCategoryWithFiveAdvs');
//User Controller
Route::post('profileUser','api\UserController@profileUser');
Route::post('reportUser','api\UserController@reportUser');
Route::post('unReportUser','api\UserController@unReportUser');
Route::post('messageReport','api\UserController@messageReport');
Route::get('getconversation','api\ChatController@getconversation');
Route::post('destroyNotfy','api\FavourtController@destroyNotfy');
Route::post('getComment','api\UserController@getComment');
Route::post('viewCount','api\UserController@viewCount');



Route::group(['middleware' => 'auth:api' , 'namespace'=>'api'],function(){
	//User Controller
	Route::get('profile','UserController@profile');
	Route::post('editProfile','UserController@editProfile');
	Route::post('postComment','UserController@postComment');
	
	
	
	//Advertising Controller
	Route::post('addAdv','AdvertisingController@addAdvertising');
	Route::post('updateAdvertising','AdvertisingController@updateAdvertising');
	Route::get('myAdvs','AdvertisingController@getMyAds');
    //	Route::post('filter','AdvertisingController@filter');
	//Favourt Controller
	Route::post('addFollow','FavourtController@addFollow');
	Route::post('addLove','FavourtController@addLove');
	Route::post('removLove','FavourtController@removLove');
	Route::get('getMyLoveAdv','FavourtController@getMyLoveAdv');
	Route::get('getMyFollowing','FavourtController@getMyFollowing');
	Route::get('getMyFollowers','FavourtController@getMyFollowers');
	Route::post('searchFollowerName','FavourtController@searchFollowerName');
	Route::get('getNotfy','FavourtController@getNotfy');
	//Chat Controller
	Route::post('addmassage','ChatController@addmassage');
    Route::get('myChats','ChatController@myChats');	
    Route::post('profileChate','ChatController@profileChate');	
    Route::post('searchChatName','ChatController@searchChatName');	
    //User Controller
    Route::post('contactUS','UserController@contactUS');
});