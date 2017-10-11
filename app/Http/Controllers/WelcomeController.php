<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
    * Public GET for /
    */
    public function __invoke() {
        return view('welcome');
    }
}
