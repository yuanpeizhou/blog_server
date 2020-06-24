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
// ->middleware('api_auth')
Route::namespace('Api')->group(function(){
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
    Route::get('/article/list','articleController@articleList');
    Route::get('/article/info','articleController@articleInfo');
    Route::post('/article/insert','articleController@articleInsert');
    Route::post('/article/update','articleController@articleUpdate');
    Route::post('/article/delete','articleController@articleDelete');

    /**
     * 文章
     */
    Route::get('/article/list','ArticleController@articleList');
    Route::get('/article/info','ArticleController@articleInfo');
    Route::post('/article/insert','ArticleController@articleInsert');
    Route::post('/article/update','ArticleController@articleUpdate');
    Route::post('/article/delete','ArticleController@articleDelete');

});





