@extends('layout.default')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->body }}</p>

    @foreach ($post->tags as $tag)
        <a href="/tags/{{ $tag->name }}"><span class="badge rounded-pill text-bg-secondary">{{ $tag->name }}</span></a>
    @endforeach
@endsection
