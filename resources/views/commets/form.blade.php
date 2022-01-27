
@auth
<h5>Add Comment</h5>
<form method="POST" action="{{ route('post.comments.store', ['post' => $post->id]) }}">
    @csrf
    <textarea class="form-control" name="content" id="content" rows="3"></textarea>
    <button type="submit" class="btn btn-block btn-primary">Add Post</button>
    <x-errors></x-errors>
</form>
@endauth
