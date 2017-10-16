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

Route::middleware(['auth', 'role:administrator,moderator,premium,user'])->group(function () {
    Route::get('/', 'VkController@index');

    // Ищу.Киев
    Route::prefix('fk')->group(function () {
        Route::get('posts', 'FindKievController@posts'); // Посты со стены
        Route::post('posts', 'FindKievController@showPosts'); // Посты со стены
        Route::post('posts/add', 'FindKievController@addPost'); // Добавление нового поста в базу
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