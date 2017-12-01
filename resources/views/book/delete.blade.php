@extends('layouts.master')

@section('title')
    Delete book {{ $book->title }}
@endsection

@section('content')

    <h1>Delete book</h1>

    <p>Do you wish to delete "{{ $book->title }}"?</p>

    <form method='POST' action='/book/{{ $book->id }}'>

        {{ method_field('delete') }}

        {{ csrf_field() }}

        <input type='submit' value='Yes, Delete this book' class='btn btn-primary btn-small'>
    </form>

    <p class='cancel'>
        <a href='{{ $previousUrl }}'>No, I changed my mind.</a>
    </p>

@endsection
