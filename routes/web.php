<?php

/**
* Code from Week 7 progress log
*/
Route::get('/env', function () {
    dump(config('app.name'));
    dump(config('app.env'));
    dump(config('app.debug'));
    dump(config('app.url'));
});


/**
* Practice
*/
Route::any('/practice/{n?}', 'PracticeController@index');


/**
* Book
*/
Route::get('/book/create', 'BookController@create');
Route::post('/book', 'BookController@store');

Route::get('/book', 'BookController@index');
Route::get('/book/{title}', 'BookController@show');

Route::get('/search', 'BookController@search');


/**
* Example portion of Foobooks that mirrors what you'll do for P3
*/
Route::get('/trivia/', 'TriviaController@index');
Route::get('/trivia/check-answer', 'TriviaController@checkAnswer');


/**
* Homepage
*/
Route::get('/', 'WelcomeController');
