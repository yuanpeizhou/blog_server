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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api')->group(function(){
    Route::post('/user/login','UserController@userLogin');
});

Route::namespace('Api')->middleware('api_auth')->group(function(){
    Route::post('/menu/insert', 'MenuController@menuInsert');
    Route::post('/menu/delete', 'MenuController@menuDelete');

    /*人员*/
    Route::get('/user/list','UserController@userList');
    Route::get('/user/info','UserController@userInfo');
    Route::post('/user/insert','UserController@userInsert');
    Route::post('/user/update','UserController@userUpdate');
    Route::post('/user/delete','UserController@userDelete');

    /*权限*/
    Route::get('/permission/list','PermissionController@permissionList');
    Route::get('/permission/info','PermissionController@permissionInfo');
    Route::post('/permission/insert','PermissionController@permissionInsert');
    Route::post('/permission/update','PermissionController@permissionUpdate');
    Route::post('/permission/delete','PermissionController@permissionDelete');

    /*角色*/
    Route::get('/role/list','RoleController@roleList');
    Route::get('/role/info','RoleController@roleInfo');
    Route::post('/role/insert','RoleController@roleInsert');
    Route::post('/role/update','RoleController@roleUpdate');
    Route::post('/role/delete','RoleController@roleDelete');

});



