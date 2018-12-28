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

/*Route::get('/', function () {
    return view('welcome');
});*/


//Basic pages
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');
Route::get('/contact', 'PagesController@contact');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('customer.dashboard');
Route::get('/membership', 'DashboardController@membership');
Route::get('/resume', 'DashboardController@resume');
Route::get('/favorites', 'DashboardController@favorites');
Route::get('/settings', 'DashboardController@settings');


Route::group(['prefix' => 'ads'], function () {

    Route::get('post-ad', 'AdsController@postAd');
    Route::get('post-ad/{ad_type}/{type}', 'AdsController@type');
    Route::get('post-ad/{ad_type}/{type}/{category_parent_id}/{category_slug}', 'AdsController@cat');
    Route::get('post-ad/{ad_type}/{type}/{category_parent_id}/{category_slug}/{location_parent_id}/{location_slug}', 'AdsController@create'); //ad create page

    //Show Ad info
    Route::get('{slug}', 'AdsController@showAdBySlug');

    //show ads by it's category
    Route::get('category/{category_slug}', 'AdsController@index');

    //show ads by it's location
    Route::get('location/{location_slug}', 'AdsController@index');

    //Ordered Ads View
    Route::get('order-by/{value}', 'AdsController@orderData');

    //category and location.
    Route::get('location/{location_slug}/category/{category_slug}','AdsController@index');
});

//route to check the phone number availabiltiy via ajax
Route::post('/check-phone-availability', 'AdsController@checkPhoneAvailabilityAjax');

//Search for ads
//Route::get('','AdsController@searchAds')->name('ad.search.get');

Route::resource('ads', 'AdsController'); //to all the crud methods in AdsController
//Route::resource('categories', 'CategoriesController'); //to all the crud methods in CategoriesController
//Auth::routes();

/**
 * Admin routes
 */
//Route::group(['prefix' => 'administrator'], function () {
Route::group(['prefix' => 'administrator', 'middleware' => []], function () {
    
    Route::get('/','Auth\AdminLoginController@showLoginForm')->name('administrator.login');
    Route::get('/',"Administrator\DashboardController@index")->name('administrator.dashboard');
    Route::post('location_slug','Administrator\DashboardController@checkLocationSlug');
    Route::post('category_slug','Administrator\DashboardController@checkCategorySlug');
    /**
     *  Admin Login, register, password reset routes;
     */
    Route::get('login','Auth\AdminLoginController@showLoginForm')->name('administrator.login');
    Route::post('login', 'Auth\AdminLoginController@login')->name('administrator.login.submit');
    Route::get('logout', 'Auth\AdminLoginController@logout')->name('administrator.logout');

    /**
     *  Locations routes
    **/
    Route::get('locations/list','Administrator\LocationsController@locationList')->name('administrator.location.list');
    Route::get('locations/list/{id}','Administrator\LocationsController@locationList')->name('administrator.location.list.id');
    Route::get('locations/add','Administrator\LocationsController@locationAdd')->name('administrator.location.add.get');
    Route::post('locations/add','Administrator\LocationsController@locationSave')->name('administrator.location.add.post');
    Route::get('locations/edit/{id}','Administrator\LocationsController@locationEdit')->name('administrator.location.edit.get');
    Route::post('locations/edit/{id}','Administrator\LocationsController@locationUpdate')->name('administrator.location.edit.post');

    Route::get('sub-locations/list','Administrator\LocationsController@subLocationList')->name('administrator.sub-location.list');
    Route::get('sub-locations/add','Administrator\LocationsController@subLocationAdd')->name('administrator.sub-location.add.get');
    Route::get('sub-locations/{id}/add','Administrator\LocationsController@subLocationAdd')->name('administrator.sub-location.add.get.id');
    Route::post('sub-locations/add','Administrator\LocationsController@subLocationSave')->name('administrator.sub-location.add.post');
    Route::get('sub-locations/edit/{id}','Administrator\LocationsController@subLocationEdit')->name('administrator.sub-location.edit.get');
    Route::post('sub-locations/edit/{id}','Administrator\LocationsController@subLocationUpdate')->name('administrator.sub-location.edit.post');


    /**
     *  Categories routes
     */
    Route::get('categories/list','Administrator\CategoriesController@categoryList')->name('administrator.category.list');
    Route::get('categories/list/{id}','Administrator\CategoriesController@categoryList')->name('administrator.category.list.id');
    Route::get('categories/add','Administrator\CategoriesController@categoryAdd')->name('administrator.category.add.get');
    Route::post('categories/add','Administrator\CategoriesController@categorySave')->name('administrator.category.add.post');
    Route::get('categories/edit/{id}','Administrator\CategoriesController@categoryEdit')->name('administrator.category.edit.get');
    Route::post('categories/edit/{id}','Administrator\CategoriesController@categoryUpdate')->name('administrator.category.edit.post');

    Route::get('sub-categories/list','Administrator\CategoriesController@subCategoryList')->name('administrator.sub-category.list');
    Route::get('sub-categories/list/{id}','Administrator\CategoriesController@subCategoryList')->name('administrator.sub-sub-category.list');
    Route::get('sub-categories/add','Administrator\CategoriesController@subCategoryAdd')->name('administrator.sub-category.add.get');
    Route::get('sub-categories/{id}/add','Administrator\CategoriesController@subCategoryAdd')->name('administrator.sub-sub-category.add.get');
    Route::post('sub-categories/add','Administrator\CategoriesController@subCategorySave')->name('administrator.sub-category.add.post');
    Route::get('sub-categories/edit/{id}','Administrator\CategoriesController@subCategoryEdit')->name('administrator.sub-category.edit.get');
    Route::post('sub-categories/edit/{id}','Administrator\CategoriesController@subCategoryUpdate')->name('administrator.sub-category.edit.post');

    /**
     *  ads routes
    **/

    Route::get('ads/new-ads/list','Administrator\AdsController@newAdsList')->name('administrator.new.ads.list');
    Route::get('ads/published-ads/list','Administrator\AdsController@publishedAdsList')->name('administrator.published.ads.list');
    Route::get('ads/view/{id}','Administrator\AdsController@adView')->name('administrator.ads.view.get');
    Route::post('ads/view/{id}','Administrator\AdsController@adApprove')->name('administrator.ads.approve.post');
    Route::get('ads/reject/{id}','Administrator\AdsController@adReject')->name('administrator.ads.reject.get');
    Route::post('ads/reject/{id}','Administrator\AdsController@adRejectUpdate')->name('administrator.ads.reject.post');

    /**
     *  brands routes
    **/

    Route::get('brands/list', 'Administrator\BrandsController@brandsList')->name('administrator.brands.list');
    Route::get('brands/list/{id}','Administrator\BrandsController@brandsList')->name('admininstrator.brands.list');
    Route::get('brands/add','Administrator\BrandsController@brandAdd')->name('administrator.brands.add.get');
    Route::post('brands/add','Administrator\BrandsController@brandSave')->name('administrator.brands.add.post');
    Route::get('brands/edit/{id}','Administrator\BrandsController@brandEdit')->name('administrator.brands.edit.get');
    Route::post('brands/edit/{id}','Administrator\BrandsController@brandUpdate')->name('administrator.brands.edit.post');
    Route::delete('brands/destroy/{id}','Administrator\BrandsController@brandDelete')->name('administrator.brands.destroy');
    
});


/**
 *  Client Login, register, password reset routes;
 */
Auth::routes();

 // Get Data for datatable in dashboard
Route::get('datatable/getdata', 'DashboardController@getAds')->name('datatable/getdata');

// Get Data for sub locations in settings page form
Route::get('sub_locations/get/{name}', 'LocationsController@getSubLocations');


Route::group(['prefix' => 'customers'], function () {
    Route::get('settings', 'DashboardController@mySettings')->name('users.settings');
});

Route::resource('customers', 'CustomersController');
Route::get('/changePassword','CustomersController@showChangePasswordForm')->name('changePassword');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');