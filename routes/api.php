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

Route::group(['namespace' => 'Api'], function($lang=null) {
    Route::get('/container/code', 'ContainerApiController@search');
    Route::get('/customer/code', 'CustomerApiController@search');
    Route::get('/booking/code', 'BookingApiController@search');
    Route::get('/booking/{id}', 'BookingApiController@getBooking');
    Route::get('/employee/employee-code', 'EmployeeApiController@employeeByEmployeeCode');
    Route::get('autocompleteBookingNo', ['as'=>'autocompleteBookingNo', 'uses'=>'BookingApiController@autoCompleteBookingNo']);
    Route::get('autocompleteTruckNo', ['as'=>'autocompleteTruckNo', 'uses'=>'FixedAssetApiController@autoCompleteTruckNo']);
    Route::get('autocompleteDriverNo', ['as'=>'autocompleteDriverNo', 'uses'=>'EmployeeApiController@autoCompleteDriverNo']);
    Route::get('autocompleteNodeCode', ['as'=>'autocompleteNodeCode', 'uses'=>'LocationCodeApiController@autocompleteNodeCode']);
    Route::get('autocompleteCustomerNo', ['as'=>'autocompleteCustomerNo', 'uses'=>'CustomerApiController@autocompleteCustomerNo']);
    Route::get('loadTruckSchedule', ['as'=>'loadTruckSchedule', 'uses'=>'TransportScheduleApiController@getContainerTrucksForSchedule']);
    Route::post('createSchedule', ['as'=>'createSchedule', 'uses'=>'TransportScheduleApiController@createSchedule']);
    Route::put('updateSchedule', ['as'=>'updateSchedule', 'uses'=>'TransportScheduleApiController@updateSchedule']);
    Route::post('updateSchedule', ['as'=>'updateSchedule', 'uses'=>'TransportScheduleApiController@updateSchedule']);
    Route::get('getLocationCode', ['as'=>'getLocationCode', 'uses'=>'LocationCodeApiController@getLocationCode']);
});
