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


Route::get('/sapcc', function () {

    return view('sapcc');
});


Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

Auth::routes();

Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_HRD]], function () {
    Route::get('zoocard','ZooCardController@index');
    Route::get('zoocard/{zoocard}/edit','ZooCardController@edit');
    Route::post('zoocard','ZooCardController@store');
});

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'DashboardController@index');
