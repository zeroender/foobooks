<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
    * GET /books
    */
    public function index()
    {
        return 'Here are all the books...';
    }

    public function show($title)
    {
        return 'Results for the book: '.$title;
    }
}
