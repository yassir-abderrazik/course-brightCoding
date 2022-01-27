@extends('layouts.app')
@section('content')

<form  method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf
    @include('posts.form')
    <button type="submit" class="btn btn-block btn-primary" >Add Post</button>
</form>
@endsection
