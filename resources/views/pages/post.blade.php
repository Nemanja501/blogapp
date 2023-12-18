@extends('layout.default')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <h1>{{ $post->title }}</h1>
    <h2>by: {{ $post->user->name }}</h2>
    <p>{{ $post->body }}</p>

    @foreach ($post->tags as $tag)
        <a href="/tags/{{ $tag->name }}"><span class="badge rounded-pill text-bg-secondary">{{ $tag->name }}</span></a>
    @endforeach
    @include('components.createcomment')
    @include('components.errors')
    @include('components.status')
    <br>
    <ul class="list-group">
        @foreach ($post->comments as $comment)
            <li class="list-group-item">{{ $comment->content }}<br>by: {{ $comment->user->name }}</li>
        @endforeach
    </ul>
@endsection
