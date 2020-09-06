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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'dashboard' , 'namespace'=>'dash'],function (){
    
     Route::middleware('auth:admin')->group(function(){

    Route::get('dashboard','DashboardController@index')->name('adminPanal');   
  	Route::post('dynamic_dependent/fetch', 'DashboardController@fetch')->name('dynamicdependent.fetch');

  	   //users
       Route::resource('users','UserController');

       //categories
       Route::resource('categories','CategoryController');
       //subCategories
       Route::resource('subCategories','SubCategoryController');
       //Brand SubCategory
       Route::resource('detailsSubCategories','BrandController');
      Route::get('getSubcategories/{id}','BrandController@getSubCategories')->name('getSubCat');
        //class SubCategory
       Route::resource('classes','ClassController');
      Route::get('getSubcategories/{id}','ClassController@getSubCategories')->name('getSubCat');
      Route::get('getBrands/{id}','ClassController@getBrands')->name('getBrand');
        //Advertising
       Route::resource('advertising','AdvertisingController');
       Route::put('available/update/{id}','AdvertisingController@acceptance')->name('available.update');


       //banner
       Route::resource('banners','BannerController');
       //CountryController
       Route::resource('country','CountryController');
       //CityController
       Route::resource('city','CityController');
       //AreaController
       Route::resource('area','AreaController');
       Route::get('getCities/{id}','AreaController@getCities')->name('getCities');
        //contact
       Route::resource('contact','ContactController');
       //Settings
        Route::get('settings','SettingController@index')->name('settings');
        Route::get('settings/create','SettingController@create')->name('settings.create');
        Route::post('settings','SettingController@store')->name('settings.store');
});
     Route::get('login','UserController@showLogin')->name('admin.showLogin');
     Route::post('login','UserController@login')->name('login');
     Route::post('logout','UserController@logout')->name('admin.logout');
  
 });
/*============================== Test Area ============================= */
    Route::get('test', function() {})->name('test');

    Route::get('get-clear-cache', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    });

    Route::get('get-link-storage', function() {
$exitCode = Artisan::call('storage:link', [] ); echo $exitCode;   
    });
