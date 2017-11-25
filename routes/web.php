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
Route::get('/practice/6', 'PracticeController@practice6');
Route::any('/practice/{n?}', 'PracticeController@index');



/**
* Book
*/
# Create a book
Route::get('/book/create', 'BookController@create');
Route::post('/book', 'BookController@store');

# Edit a book
Route::get('/book/{id}/edit', 'BookController@edit');
Route::put('/book/{id}', 'BookController@update');


# View all books
Route::get('/book', 'BookController@index');

# View a book
Route::get('/book/{id}', 'BookController@show');

# Search all books
Route::get('/search', 'BookController@search');

# Delete a book
Route::get('/book/{id}/delete', 'BookController@delete');
Route::delete('/book/{id}', 'BookController@deleteBook');

/**
* Example portion of Foobooks that mirrors what you'll do for P3
*/
Route::get('/trivia/', 'TriviaController@index');
Route::get('/trivia/check-answer', 'TriviaController@checkAnswer');


/**
* Homepage
*/
Route::get('/', 'WelcomeController');
