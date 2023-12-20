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
    <br><br>
    @include('components.createcomment')
    @include('components.errors')
    @include('components.status')
    <br>
    <ul class="list-group">
        @foreach ($post->comments as $comment)
            <li class="list-group-item">{{ $comment->content }}<br>by: {{ $comment->user->name }}
            @if (auth()->check() && auth()->user()->id == $comment->user->id)
                <a href="/deletecomment/{{ $comment->id }}"><button type="button" class="btn btn-secondary">Delete</button></a>
                <a href="/updatecomment/{{ $comment->id }}"><button type="button" class="btn btn-secondary">Update</button></a>
            @endif
            </li>
        @endforeach
    </ul>
@endsection
