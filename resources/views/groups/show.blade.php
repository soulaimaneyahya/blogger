@extends('layouts.app')
@section('title', $group->name)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <h3>
                {{ $group->name }}
            </h3>
            @badge(['type' => 'danger', 'show' => now()->diffInMinutes($group->created_at) < 5])
            new !
            @endbadge
            <div class="mb-2">
                <span class="fw-bold">{{ $group->members_count }}</span> {{ Str::plural('member', $group->members_count) }}
            </div>
            <form action="{{ route('groups.join', $group) }}" method="POST">
                @csrf
                @method('PUT')
                @if ($group->members->contains(auth()->user()))
                <button type="submit" class="btn btn-secondary btn-sm">Leave</button>
                @else
                <button type="submit" class="btn btn-dark btn-sm">Join</button>
                @endif
            </form>
        </div>
        <p>{{ $group->description }}</p>
        @updated(['date'=> $group->created_at])@endupdated
    </div>
</div>
@endsection
