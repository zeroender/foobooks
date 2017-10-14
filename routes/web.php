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


/**
* Practice
*/
Route::any('/practice/{n?}', 'PracticeController@index');

/**
* Homepage
*/
Route::get('/', 'WelcomeController');

/**
* Book
*/
Route::get('/book', 'BookController@index');
Route::get('/book/{title}', 'BookController@show');

/**
* Example portion of Foobooks that mirrors what you'll do for P3
*/
Route::get('/trivia/', 'TriviaController@index');
Route::get('/trivia/check-answer', 'TriviaController@checkAnswer');
