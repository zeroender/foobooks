@extends('layouts.master')

@push('head')
    <link href='/css/book/show.css' rel='stylesheet'>
@endpush

@section('title')
    {{ $book->title }}
@endsection

@section('content')

    <h2>{{ $book['title'] }}</h2>
    <img src='{{ $book['cover'] }}' class='cover' alt='Cover image for {{ $book['title'] }}'>

    <p>By {{ $book['author']['first_name'] }} {{ $book['author']['last_name'] }} </p>
    <p>Published in {{ $book['published'] }}</p>

    <p><a href='{{ $book['purchase_url'] }}'>Purchase this book...</a></p>
    <p><a href='/book/{{ $book['id'] }}/edit'>Edit</a></p>
    <p><a href='/book/{{ $book['id'] }}/delete'>Delete</a></p>

@endsection
