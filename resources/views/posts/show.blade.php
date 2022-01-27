@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-8">
        <h1 class="text-center text-justify text-primary font-weight-bold">{{ $post->title }}</h1><br>
        @if($post->image)
        <img src="{{ $post->image->url() }}" alt="img" class="img-fluid">
        @endif
        <br><p class="h4">{{ $post->content }}</p><br>
        <x-tags :tags="$post->tags"></x-tags>
        <br>
        <small class="font-weight-light">{{ $post->created_at->diffForHumans() }}</small>
        <p>Status : @if($post->active)
            Enabled
            @else
            Disabled
            @endif
        </p>
        <h3 class=" text-justify text-primary font-weight-bold">Comments :</h3>
        @include('commets.form')
        <hr>
        @foreach($post->comments as $comment)
        <div class="container">
            <div class="jumbotron">
                <x-updated class="bold"  :date="$comment->created_at" :name="$comment->user->name"></x-updated><br>
                <p>{{ $comment->content}}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-4">
        @include('posts.sidebar')
    </div>

</div>


@endsection