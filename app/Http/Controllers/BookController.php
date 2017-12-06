<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Book;
use App\Author;
use App\Tag;

class BookController extends Controller
{
    /**
    * GET /
    */
    public function index()
    {
        $books = Book::orderBy('title')->get();

        # Get from DB
        # $newBooks = Book::orderByDesc('created_at')->limit(3)->get();

        # Get from collection
        $newBooks = $books->sortByDesc('created_at')->take(3);

        return view('book.index')->with([
            'books' => $books,
            'newBooks' => $newBooks,
        ]);
    }


    /**
    * GET /book/{$id}
    */
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect('/book')->with('alert', 'Book not found');
        }

        return view('book.show')->with([
            'book' => $book
        ]);
    }


    /**
    * GET /book/create
    */
    public function create()
    {
        $authorsForDropdown = Author::getForDropdown();

        # Get all the possible tags so we can include them with checkboxes in the view
        $tagsForCheckboxes = Tag::getForCheckboxes();

        return view('book.create') -> with([
            'authorsForDropdown' => $authorsForDropdown,
            'tagsForCheckboxes' => $tagsForCheckboxes
        ]);
    }


    /**
    * POST /book
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'author' => 'notIn:0',
            'published' => 'required|min:4|numeric',
            'purchase_link' => 'required|url',
            'cover' => 'required|url',
        ]);

        # Add new book to the database
        $book = new Book();

        $book->title = $request->input('title');
        $book->author_id = $request->input('author');
        $book->published = $request->input('published');
        $book->cover = $request->input('cover');
        $book->purchase_link = $request->input('purchase_link');
        $book->save();

        $book->tags()->sync($request->input('tags'));


        return redirect('/book')->with('alert', 'The book '.$request->input('title').' was added.');
    }


    /*
    * GET /book/{id}/edit
    */
    public function edit($id = null)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect('/book')->with('alert', 'Book not found');
        }

        # Get authors
        $authorsForDropdown = Author::getForDropdown();

        # Get all the possible tags so we can include them with checkboxes in the view
        $tagsForCheckboxes = Tag::getForCheckboxes();

        # Create a simple array of just the tag names for tags associated with this book;
        # will be used in the view to decide which tags should be checked off
        $tagsForThisBook = [];
        foreach ($book->tags as $tag) {
            $tagsForThisBook[] = $tag->name;
        }

        return view('book.edit')->with([
            'book' => $book,
            'authorsForDropdown' => $authorsForDropdown,
            'tagsForCheckboxes' => $tagsForCheckboxes,
            'tagsForThisBook' => $tagsForThisBook
        ]);
    }

    /*
    * PUT /book/{id}
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'author' => 'notIn:0',
            'published' => 'required|min:4|numeric',
            'cover' => 'required|url',
            'purchase_link' => 'required|url',
        ]);

        $book = Book::find($id);

        $book->tags()->sync($request->input('tags'));

        $book->title = $request->input('title');
        $book->author_id = $request->input('author');
        $book->published = $request->input('published');
        $book->cover = $request->input('cover');
        $book->purchase_link = $request->input('purchase_link');
        $book->save();

        return redirect('/book/'.$id.'/edit')->with('alert', 'Your changes were saved.');
    }


    /**
    * GET /search
    * TODO: Update this so it searches the database, not books.json
    */
    public function search(Request $request)
    {
        # Start with an empty array of search results; books that
        # match our search query will get added to this array
        $searchResults = [];

        # Store the searchTerm in a variable for easy access
        # The second parameter (null) is what the variable
        # will be set to *if* searchTerm is not in the request.
        $searchTerm = $request->input('searchTerm', null);

        # Only try and search *if* there's a searchTerm
        if ($searchTerm) {
            # Open the books.json data file
            # database_path() is a Laravel helper to get the path to the database folder
            # See https://laravel.com/docs/helpers for other path related helpers
            $booksRawData = file_get_contents(database_path('/books.json'));

            # Decode the book JSON data into an array
            # Nothing fancy here; just a built in PHP method
            $books = json_decode($booksRawData, true);

            # Loop through all the book data, looking for matches
            # This code was taken from v0 of foobooks we built earlier in the semester
            foreach ($books as $title => $book) {
                # Case sensitive boolean check for a match
                if ($request->has('caseSensitive')) {
                    $match = $title == $searchTerm;
                    # Case insensitive boolean check for a match
                } else {
                    $match = strtolower($title) == strtolower($searchTerm);
                }

                # If it was a match, add it to our results
                if ($match) {
                    $searchResults[$title] = $book;
                }
            }
        }

        # Return the view, with the searchTerm *and* searchResults (if any)
        return view('book.search')->with([
            'searchTerm' => $searchTerm,
            'caseSensitive' => $request->has('caseSensitive'),
            'searchResults' => $searchResults
        ]);
    }

    /*
    * GET /book/{id}/delete
    */
    public function delete($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect('/book')->with('alert', 'Book not found');
        }


        return view('book.delete')->with([
          'book' => $book,
          'previousUrl' => url()->previous() == url()->current() ? '/book' : url()->previous()
        ]);
    }

    /*
    * DELETE /book/{id}
    */
    public function deleteBook($id)
    {

        $book = Book::find($id);

        $book->tags()->detach();

        $book->delete();

        return redirect('/book')->with('alert', $book->title.' has been deleted');
    }
}
