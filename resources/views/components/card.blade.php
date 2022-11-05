<div class="card mb-4">
    <div class="card-header p-3">
        <h5 class="card-title fw-bold">{{ $title }}</h5>
        <h6 class="card-subtitle text-muted fw-bold">{{ $subtitle }}</h6>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            @if (is_a($items, 'Illuminate\Support\Collection'))
                @foreach ($items as $user)
                    <li class="list-group-item">
                        <a href="{{ route('users.show', $user) }}">{{ '@'.$user->username }} <b>({{ $user->blog_posts_count }})</b></a>
                    </li>
                @endforeach
            @else
            {{ $items }}
            @endif
        </ul>
    </div>
</div>
