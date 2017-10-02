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

Route::middleware(['auth', 'role:administrator,user'])->group(function () {
    Route::get('/', 'VkController@index');

    // Ищу.Киев
    Route::prefix('fk')->group(function () {
        Route::get('lfy', 'FindKievController@lookingForYou'); // Ищу тебя
    });
});


Route::get('/auth', 'VkController@auth');






Route::get('campus', 'CampusController@index');
Route::post('campus/update/all', 'CampusController@updateAll');
Route::get('campus/update/{id}', 'CampusController@update');
Route::get('campus/my/{id}', 'CampusController@my');
Route::get('campus/credit/{id}', 'CampusController@credit');
Route::post('campus/add', 'CampusController@add');
Route::post('campus/find', 'CampusController@find');