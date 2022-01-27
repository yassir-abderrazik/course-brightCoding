@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-8">
        {{-- <nav class="nav nav-tabs nav-stacked">
            <a class="nav-link @if($tab == 'list') active @endif" href="{{ route('posts.index') }}">List</a>
        <a class="nav-link @if($tab == 'archive') active @endif" href="{{ route('archive') }}">Archive</a>
        <a class="nav-link @if($tab == 'all') active @endif" href="{{ route('all') }}">All</a>
        </nav> --}}

        <div class="my-3">
            <h4>{{ $posts->count() }} Post(s)</h4>
        </div>
        @foreach ($posts as $post)
        <div class="jumbotron">
            <div class="container">
                <h1 class="text-center"><a href="{{ route('posts.show', [ 'post' => $post->id ])}}">
                        @if($post->trashed())
                        <del>{{ $post->title }}</del>
                        @else
                        {{ $post->title }}
                        @if($post->created_at->diffInHours() < 1) <x-badge>New</x-badge>
                            @endif
                            @endif
                    </a>
                </h1>
                @if($post->image)
                <img src="{{ $post->image->url() }}" alt="img" class="img-fluid">
                @endif

                <x-tags :tags="$post->tags"></x-tags>
                <p>{{ $post->content }}</p>
                <em>{{ $post->created_at }}</em>
                @if($post->comments_count)
                <div>
                    <x-badge type="danger">
                        comment : {{ $post->comments_count }}
                    </x-badge>
                </div>
                @else
                <div>
                    <x-badge type="light">
                        no comment</span>
                    </x-badge>
                </div>
                @endif
                <x-updated :date="$post->updated_at" :name="$post->user->name">

                </x-updated>


                @auth


                @if(!$post->deleted_at)
                @can('update', $post)
                <a href="{{ route('posts.edit', [ 'post' => $post->id ])}}" class="btn btn-warning">EDIT</a>
                @endcan
                @can('delete', $post)
                <form style="display: inline" method="POST"
                    action="{{ route('posts.update', [ 'post' => $post->id ]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                @endcan
                @else
                @can('restore', $post)
                <form method="POST" action="{{ route('restore', $post->id)}}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Restore</button>
                </form>
                @endcan
                @can('forceDelete', $post)
                <form method="POST" action="{{ route('forceDelete', $post->id)}}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">force delete</button>
                </form>
                @endcan
                @endif
                @endauth
            </div>
        </div>
        @endforeach
        <br>
        <div class="text-center">
            {{ $posts->onEachSide(5)->links() }}
        </div>
    </div>
    <div class="col-4">
        @include('posts.sidebar')
    </div>
</div>

@endsection
