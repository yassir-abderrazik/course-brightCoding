@foreach ($tags as $tag)
    <span class="badge badge-success"><a class="text-white" href="{{ route('poststag.index', $tag->id ) }}">{{ $tag->name}}</a></span>
@endforeach