<?php

use UniSharp\LaravelFilemanager\Lfm;
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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

Route::get('/', 'HomeController@redirect')->name('index');

Route::middleware('web')->prefix('auth')->group(function () {
    Route::get('login', 'AuthController@login_form')->name('auth.login_form');
    Route::get('register', 'AuthController@register_form')->name('auth.register_form');
    Route::post('login', 'AuthController@do_login')->name('auth.do_login');
    Route::post('register', 'AuthController@do_register')->name('auth.do_register');
    Route::post('logout', 'AuthController@do_logout')->name('auth.do_logout');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', 'HomeController@index')->name('home.index');
    Route::prefix('quizzes')->group(function(){
        Route::get('do/{quiz}', 'QuizController@do')->name('quizzes.do');
        Route::get('summary/{quiz}', 'QuizController@summary')->name('quizzes.summary');
        Route::post('do_ajax', 'QuizController@do_ajax')->name('quizzes.do_ajax');
        Route::post('finish/{quiz}', 'QuizController@finish')->name('quizzes.finish');
    });
    Route::middleware('is_admin')->group(function(){
        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index')->name('users.index');
            Route::get('/create', 'UserController@create')->name('users.create');
            Route::get('/edit/{user}', 'UserController@edit')->name('users.edit');
            Route::put('/update/{user}', 'UserController@update')->name('users.update');
            Route::post('/store', 'UserController@store')->name('users.store');
            Route::delete('/delete/{user}', 'UserController@delete')->name('users.delete');
        });
        Route::prefix('questions')->group(function(){
            Route::get('import', 'QuestionController@import')->name('questions.import');
            Route::post('import', 'QuestionController@import_do')->name('questions.import');
        });
        Route::resource('questions', 'QuestionController');
        Route::prefix('quizzes')->group(function(){
            Route::get('view_questions/{quiz}', 'QuizController@view_questions')->name('quizzes.view_questions');
        });
        Route::resource('quizzes', 'QuizController');
        Route::prefix('reports')->group(function(){
            Route::get('/', 'ReportController@index')->name('reports.index');
            Route::get('/export-excel', 'ReportController@export')->name('reports.export.excel');
        });
    });

});