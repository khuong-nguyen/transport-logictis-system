<?php

use Illuminate\Support\Facades\Route;

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

//Route::group([
//    'prefix' => '{locale?}',
//    'where' => ['locale' => '[a-zA-Z]{2}'],
//    'middleware' => 'language'], function($lang=null) {
//});

Route::get('/', 'DashboardController@home');
Route::group(['prefix' => 'booking','namespace' => 'Booking'],function (){
    Route::get('/registration', 'BookingRegistrationController@create');
    Route::post('/registration', 'BookingRegistrationController@store');
    Route::get('/registration/{id}', 'BookingRegistrationController@edit');
    Route::put('/registration/{id}', 'BookingRegistrationController@update');
//    Route::delete('/registration/{id}', 'BookingRegistrationController@update');

    Route::get('/inquiry', 'BookingInquiryController@index');

});

Route::group(['prefix' => 'customer','namespace' => 'Customer'],function (){
    Route::get('/registration', 'CustomerController@create');
    Route::post('/registration', 'CustomerController@store');
    Route::get('/registration/{id}', 'CustomerController@edit');
    Route::put('/registration/{id}', 'CustomerController@update');
});
