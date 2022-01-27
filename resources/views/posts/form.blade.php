<div class="form-group">
    <label for="title">Your title :</label>
    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? null)}}" class="form-control">
    </inupt>
</div>
<div class="form-group">
    <label for="content">Content :</label>
    <input type="text" name="content" id="content" value="{{ old('content', $post->content ?? null )}}"
        class="form-control"></inupt>
</div>
<div class="form-group">
    <label for="picture">Picture</label>
    <input type="file" name="picture" id="picture" class="form-control-file">
</div>
<x-errors></x-errors>