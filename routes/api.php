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
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
    //    Route::resource('task', 'TasksController');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_api_routes
});

/*
API pencarian kota
 */
Route::get('cari-organisasi','ApiController@cariOrg');
Route::get('cari-kota-public','ApiController@cariKotaPublic');

/*
API Kategori Campaign
 */
Route::get('categories','ApiController@getCategories');

/*
API login
 */
Route::post('login', 'Auth\LoginController@apiPublicLogin')->name('api.public.login');

/*
Midtrans Callback
 */
Route::post('mtCallback', 'PublicDonationController@midtransCallback');

Route::group(['prefix' => 'v1/'], function() {
    Route::post('altopay', 'v1\ApiController@InquiryAlto');
    //Route::get('zains_sign/{id}', 'v1\ApiController@Zains')->name('api.zains');
});
