<div class="row">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $title}}</h4>
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($items as $item)
            <li class="list-group-item">
                {{ $item }}
            </li>
            @endforeach
        </ul>
    </div>
</div><br>