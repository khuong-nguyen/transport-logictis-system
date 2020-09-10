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
    Route::delete('/registration/{id}', 'BookingRegistrationController@delete');

    Route::get('/inquiry', 'BookingInquiryController@index');

    Route::group(['prefix' => 'transport'],function (){
        Route::get('/registration', 'BookingContainerRegistrationController@create');
        Route::post('/registration', 'BookingContainerRegistrationController@store');
        Route::get('/registration/{id}', 'BookingContainerRegistrationController@edit');
        Route::put('/registration/{id}', 'BookingContainerRegistrationController@update');
        Route::delete('/registration/{id}', 'BookingContainerRegistrationController@destroy');
        
        Route::group(['prefix' => 'schedule'],function (){
            Route::get('/registration', 'TransportScheduleRegistrationController@create');
            Route::post('/registration', 'TransportScheduleRegistrationController@store');
            Route::get('/registration/{id}', 'TransportScheduleRegistrationController@edit');
            Route::put('/registration', 'TransportScheduleRegistrationController@update');
            Route::delete('/registration/{id}', 'TransportScheduleRegistrationController@destroy');
            Route::post('/useds', 'TransportScheduleRegistrationController@validateUseds');
            Route::get('/inquiry', 'TransportScheduleInquiryController@index');
        });
    });
});

Route::group(['prefix' => 'customer','namespace' => 'Customer'],function (){
    Route::get('/registration', 'CustomerController@create');
    Route::post('/registration', 'CustomerController@store');
    Route::get('/registration/{id}', 'CustomerController@edit');
    Route::put('/registration/{id}', 'CustomerController@update');
    Route::delete('/registration/{id}', 'CustomerController@destroy');
    Route::get('/inquiry', 'CustomerInquiryController@index');
});

    Route::group(['prefix' => 'employee','namespace' => 'Employee'],function (){
        Route::get('/registration', 'EmployeeController@create');
        Route::post('/registration', 'EmployeeController@store');
        Route::get('/registration/{id}', 'EmployeeController@edit');
        Route::put('/registration/{id}', 'EmployeeController@update');
        Route::get('/search', 'EmployeeController@search');
        Route::get('/inquiry', 'EmployeeInquiryController@index');
    });

    Route::group(['prefix' => 'fixed_asset','namespace' => 'FixedAsset'],function (){
        Route::get('/registration', 'FixedAssetController@create');
        Route::post('/registration', 'FixedAssetController@store');
        Route::get('/registration/{id}', 'FixedAssetController@edit');
        Route::put('/registration/{id}', 'FixedAssetController@update');
        Route::get('/search', 'FixedAssetController@search');
        Route::get('/inquiry', 'FixedAssetInquiryController@index');
    });

    Route::group(['prefix' => 'advance_money','namespace' => 'AdvanceMoney'],function (){
        Route::get('/registration', 'AdvanceMoneyController@create');
        Route::post('/registration', 'AdvanceMoneyController@store');
        Route::get('/registration/{id}', 'AdvanceMoneyController@edit');
        Route::put('/registration/{id}', 'AdvanceMoneyController@update');
        Route::get('/inquiry', 'AdvanceMoneyInquiryController@index');
    });

    Route::group(['prefix' => 'location_code','namespace' => 'LocationCode'],function (){
        Route::get('/registration', 'LocationCodeController@create');
        Route::post('/registration', 'LocationCodeController@store');
        Route::get('/registration/{id}', 'LocationCodeController@edit');
        Route::put('/registration/{id}', 'LocationCodeController@update');
        Route::get('/search', 'LocationCodeController@search');
        Route::get('/inquiry', 'LocationCodeInquiryController@index');
    });
    
    Route::group(['prefix' => 'print_document','namespace' => 'PrintDocument'],function (){
        Route::get('/booking/{booking_id}', 'PrintDocumentController@printBooking');
    });