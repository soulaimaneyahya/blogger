@auth
@if ($group->trashed())
<del>
@endif
@endauth
<div class="d-flex align-items-start">
<h4>
    <a class="fw-bold {{ $group->trashed() ? 'text-muted' : '' }}" href="{{ route('groups.show', $group) }}">
        {{ $group->name }}
    </a>
</h4>

@badge(['show' => $group->members->contains(auth()->user()), 'type' => 'dark'])
Joined
@endbadge  

@badge(['type' => 'danger', 'show' => now()->diffInMinutes($group->created_at) < 5])
new !
@endbadge
</div>
@auth
@if ($group->trashed())
</del>
@endif
@endauth

<p class="p-0 m-0">{{ \Illuminate\Support\Str::limit($group->description, 100, $end='...') }}</p>
@updated(['date'=> $group->created_at])@endupdated

<div class="mb-2">
<span class="fw-bold">{{ $group->members_count }}</span> {{ Str::plural('member', $group->members_count) }}
</div>
