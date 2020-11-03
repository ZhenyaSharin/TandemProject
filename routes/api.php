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


Route::post('/persons', [
    'uses' => 'PersonController@index'
]);

Route::post('/personbyid/{id}', [
    'uses' => 'api\PersonController@personById'
]);

// Route::get('/personage', [
//     'uses' => 'api\PersonController@age'
// ]);

Route::get('/personsbygroupid', [
    'uses' => 'api\AcadGroupController@getPersonsByGroupId'
]);

Route::post('/groupslist', [
    'uses' => 'api\AcadGroupController@groupsList'
]);

Route::post('/getPersonsRange', [
    'uses' => 'api\PersonController@getRange'
]);

Route::get('/getAgeById', [
    'uses' => 'api\PersonController@getAge'
]);