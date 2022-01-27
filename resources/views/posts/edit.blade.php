@extends('layouts.app')
@section('content')

<form  method="POST" action="{{ route('posts.update', [ 'post' => $post->id ]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('posts.form')
    <button type="submit" class="btn btn-block btn-primary">Update Post</button>
</form>
@endsection 