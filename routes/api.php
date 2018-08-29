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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->get('me', 'AuthController@me');
    $router->post('done', 'AuthController@done');

});
Route::get('todo/get_all_todo', 'TodoController@get_all_todo');
Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'AuthController@user');
    Route::post('todo/done', 'TodoController@done');
    Route::post('todo/delete_all', 'TodoController@delete_all');
    Route::get('todo/view/{id}', function ( $id){
        return view('view')->with('id',$id);
    });

    Route::resource('todo', 'TodoController')->except('edit', 'create');
});

Route::group(['middleware' => 'jwt.auth'], function($router){
    $router->get('profile','UserController@profile');
});
