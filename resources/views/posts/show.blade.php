@extends('layout')

@section('content')
    <h1>Просмотр поста</h1>

    <div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
    </div>

    <a href="/">Все посты</a> 
@endsection