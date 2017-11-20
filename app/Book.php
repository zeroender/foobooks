<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /*
    * Dump the essential details of books to the page
    * Used when practicing queries and you want to quickly see the books in the database
    * Can accept a Collection of books, or if none is provided, will default to all books
    */
    public static function dump($books = null)
    {
        $data = [];
        if (is_null($books)) {
            $books = self::all();
        }
        foreach ($books as $book) {
            $data[] = $book->title.' by '.$book->author;
        }
        dump($data);
    }
}
