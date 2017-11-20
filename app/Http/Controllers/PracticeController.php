<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Debugbar;
use cebe\markdown\MarkdownExtra;
use App\Rules\AlphaAndSpaces;
use App\Book;
use App\Utilities\Practice;

class PracticeController extends Controller
{

    /**
    *
    */
    public function practice21()
    {
        $books = Book::all();

        foreach ($books as $book) {
            dump($book->title);
        }
    }



    /**
    * [1 of 6] Solution to query practice from Week 11 progress log
    * Remove all books authored by “J.K. Rowling”
    */
    public function practice20()
    {
        Book::dump();

        Book::where('author', 'LIKE', 'J.K. Rowling')->delete();

        dump('Deleted all books where author like J.K. Rowling');

        Book::dump();

        Practice::resetDatabase();

        # Underlying SQL: delete from `books` where `author` LIKE 'J.K. Rowling'
    }


    /**
    * [2 of 6] Solution to query practice from Week 11 progress log
    * Retrieve the last 2 books that were added to the books table.
    */
    public function practice19()
    {

        $books = Book::orderBy('id', 'desc')->limit(2)->get();

        Book::dump($books);

        # Underlying SQL: select * from `books` order by `id` desc limit 2
    }


    /**
    * [3 of 6] Solution to query practice from Week 11 progress log
    * Retrieve all the books published after 1950.
    */
    public function practice18()
    {
        $books = Book::where('published', '>', 1950)->get();

        Book::dump($books);

        # Underlying SQL: select * from `books` where `published` > '1950'
    }


    /**
    * [4 of 6] Solution to query practice from Week 11 progress log
    * Retrieve all the books in alphabetical order by title
    */
    public function practice17()
    {
        $books = Book::orderBy('title', 'asc')->get();

        Book::dump($books);

        # Underlying SQL: select * from `books` order by `title` asc
    }


    /**
    * [5 of 6] Solution to query practice from Week 11 progress log
    * Retrieve all the books in descending order according to published date
    */
    public function practice16()
    {
        $books = Book::orderByDesc('published')->get();

        Book::dump($books);

        # Underlying SQL: select * from `books` order by `published` desc
    }


    /**
    * [6 of 6] Solution to query practice from Week 11 progress log
    * Find any books by the author Bell Hooks and update the author name to be bell hooks (lowercase).
    */
    public function practice15()
    {

        Book::dump();

        # Approach # 1
        # Get all the books that match the criteria
        $books = Book::where('author', '=', 'Bell Hooks')->get();

        $matches = $books->count();

        dump('Found '.$matches.' '.str_plural('book', $matches).' that match this search criteria');

        if ($matches > 0) {
            # Loop through each book and update them
            foreach ($books as $book) {
                $book->author = 'bell hooks';
                $book->save();
                # Underlying SQL: update `books` set `updated_at` = '2017-11-15 14:19:17', `author` = 'bell hooks' where `id` = '4'
            }
        }

        Book::dump();

        #Practice::resetDatabase($books);

        # Approach #2
        Book::where('author', '=', 'Bell Hooks')->update(['author' => 'bell hooks']);
    }


    /**
    * Example 1 of 2 for dynamically creating a query via a loop
    * Search across a single field (title)
    * https://github.com/susanBuck/dwa15-fall2017/issues/143
    */
    public function practice14()
    {
        # Example keywords to mock what you might get from the Request
        $keywords = ['harry', 'gatsby'];

        # Initiate a query using the `select` method with no params
        # This will will get all the fields from the rows that match our query
        $query = Book::select();

        # Build on the query
        foreach ($keywords as $keyword) {
            $query->orWhere('title', 'LIKE', '%'.$keyword.'%');
        }

        # Execute the query
        $results = $query->get();

        # Show the title of each book found
        foreach ($results as $result) {
            dump($result->title);
        }

        # Notes:
        # select * from `books` where `title` LIKE '%harry%' or `title` LIKE '%gatsby%'
        # "The Great Gatsby"
        # "Harry Potter and the Sorcerer's Stone"
        # "Harry Potter and the Chamber of Secrets"
        # "Harry Potter and the The Prisoner of Azkaban"
    }


    /**
    * Example 2 of 2 for dynamically creating a query via a loop
    * Search across multiple fields
    * https://github.com/susanBuck/dwa15-fall2017/issues/143
    */
    public function practice13()
    {
        # Example keywords to mock what you might get from the Request
        $keywords = ['harry', 'gatsby', 1963];

        # Fields you want to search
        $fieldsToSearch = ['title', 'published'];

        # Initiate a query using the `select` method with no params
        # This will will get all the fields from the rows that match our query
        $query = Book::select();

        # Build on the query
        foreach ($keywords as $keyword) {
            foreach ($fieldsToSearch as $field) {
                $query->orWhere($field, 'LIKE', '%'.$keyword.'%');
            }
        }

        # Execute the query
        $results = $query->get();

        # Show the title of each book found
        foreach ($results as $result) {
            dump($result->title);
        }

        # Notes:
        # select * from `books` where `title` LIKE '%harry%'
        #    or `published` LIKE '%harry%'
        #    or `title` LIKE '%gatsby%'
        #    or `published` LIKE '%gatsby%'
        #    or `title` LIKE '%1963%'
        #    or `published` LIKE '%1963%'
        # "The Great Gatsby"
        # "The Bell Jar"
        # "Harry Potter and the Sorcerer's Stone"
        # "Harry Potter and the Chamber of Secrets"
        # "Harry Potter and the The Prisoner of Azkaban"
    }


    /**
    *
    */
    public function practice12()
    {
        $results = Book::where('author', '=', 'J.K. Rowling')->get();
        dump($results);
    }


    /**
    * Example deletion
    */
    public function practice11()
    {
        $book = Book::find(11);

        if ($book) {
            dump('Did not delete book 11, did not find it.');
        } else {
            $books->delete();
            dump('Deleted book #11');
        }
    }


    /**
    * Example update
    */
    public function practice10()
    {
        # First get a book to update
        $book = Book::where('author', 'LIKE', '%Scott%')->first();

        if (!$book) {
            dump("Book not found, can't update.");
        } else {
            # Change some properties
            $book->title = 'The Really Great Gatsby';
            $book->published = '2025';

            # Save the changes
            $book->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }


    /**
    * Example of querying for books with constraints using an Eloquent model
    */
    public function practice8()
    {
        #$book = new Book();
        $books = Book::where('title', 'LIKE', '%Harry Potter%')
        ->orWhere('published', '>=', 1880)
        ->orderBy('created_at', 'desc')
        ->get();

        dump($books->toArray());
    }


    /**
    * Example of querying for books using an Eloquent model
    */
    public function practice7()
    {
        $book = new Book();
        $books = $book->all();
        dump($books->toArray());
    }


    /**
    * Example of adding a new book using an Eloquent model
    */
    public function practice6()
    {
        # Instantiate a new Book Model object
        $book = new Book();

        # Set the parameters
        # Note how each parameter corresponds to a field in the table
        $book->title = 'Harry Potter and the Sorcerer\'s Stone';
        $book->author = 'J.K. Rowling';
        $book->published = 1997;
        $book->cover = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_link = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $book->save();

        dump($book->toArray());
    }


    /**
    * Demonstration of a custom validation rule
    */
    public function practice5(Request $request)
    {

        $name = $request->input('name', null);

        $this->validate($request, [
            'name' => [new AlphaAndSpaces]
            #'name' => 'regex:/^[\pL\s\-]+$/u'
        ]);

        return view('practice.6')->with([
            'name' => $name,
        ]);
    }


    /**
    * Example using an external package
    */
    public function practice4()
    {
        $parser = new MarkdownExtra();
        echo $parser->parse('# Hello World');
    }


    /**
    * Examples writing to the Debugbar
    */
    public function practice3()
    {
        Debugbar::info($_GET);
        Debugbar::info(['a' => 1, 'b' => 2, 'c' => 3]);
        Debugbar::error('Error!');
        Debugbar::warning('Watch out…');
        Debugbar::addMessage('Another message', 'mylabel');
        return 'Practice 4';
    }


    /**
    * Purposefully create an error to view it in the error logs
    */
    public function practice2()
    {
        return view('abc');
    }


    /**
    * Viewing config info
    */
    public function practice1()
    {
        $email = config('mail');
        dump($email);
    }


    /**
    * ANY (GET/POST/PUT/DELETE)
    * /practice/{n?}
    *
    * This method accepts all requests to /practice/ and
    * invokes the appropriate method.
    *
    * http://foobooks.loc/practice/1 => Invokes practice1
    * http://foobooks.loc/practice/5 => Invokes practice5
    * http://foobooks.loc/practice/999 => Practice route [practice999] not defined
    */
    public function index($n = null)
    {
        # If no specific practice is specified, show index of all available methods
        if (is_null($n)) {
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    # Echo'ing display code from a controller is typically bad; making an
                    # exception here because:
                    # 1. This controller is for debugging/demonstration purposes only
                    # 2. This controller is introduced before we cover views
                    echo "<a href='".str_replace('practice', '/practice/', $method)."'>" . $method . "</a><br>";
                }
            }
            # Otherwise, load the requested method
        } else {
            $method = 'practice'.$n;

            if (method_exists($this, $method)) {
                return $this->$method();
            } else {
                dd("Practice route [{$n}] not defined");
            }
        }
    }
}
