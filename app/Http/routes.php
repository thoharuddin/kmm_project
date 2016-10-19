<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'GuestController@index');
    Route::auth();
    Route::get('auth/verify/{token}', 'Auth\AuthController@verify');
    Route::get('auth/send-verification', 'Auth\AuthController@sendVerification');
    Route::get('/home', 'HomeController@index');
    Route::get('settings/profile', 'SettingsController@profile');
    Route::get('settings/profile/edit', 'SettingsController@editProfile');
    Route::post('settings/profile', 'SettingsController@updateProfile');
    Route::get('settings/password', 'SettingsController@editPassword');
    Route::post('settings/password', 'SettingsController@updatePassword');

    Route::get('books/{book}/borrow', [
        'middleware'=>['auth', 'role:member'],
        'as'=>'books.borrow',
        'uses'=>'BooksController@borrow']);
    Route::put('books/{book}/return', [
        'middleware'=>['auth', 'role:member'],
        'as'=>'books.return',
        'uses'=>'BooksController@returnBack']);

    Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'role:admin']], function () {
        Route::resource('authors', 'AuthorsController');
        Route::resource('books', 'BooksController');
        Route::resource('members', 'MembersController', [
            'only'=>['index', 'show', 'destroy']
        ]);
        Route::get('statistics', [
            'as'=>'admin.statistics.index',
            'uses'=>'StatisticsController@index']);
        Route::get('export/books', [
            'as'=>'admin.export.books',
            'uses'=>'BooksController@export']);
        Route::post('export/books', [
            'as'=>'admin.export.books.post',
            'uses'=>'BooksController@exportPost']);
        Route::get('template/books', [
            'as'=>'admin.template.books',
            'uses'=>'BooksController@generateExcelTemplate']);
        Route::post('import/books', [
            'as'=>'admin.import.books',
            'uses'=>'BooksController@importExcel']);
    });
});
