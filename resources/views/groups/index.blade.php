@extends('layouts.app')
@section('title', 'Groups')
@section('content')
<div class="row">
    <h3 class="mb-3">Groups</h3>
    <div class="col-md-9">
        @forelse ($groups->chunk(2) as $chunk)
        <div class="row">
            @foreach ($chunk as $group)
            <div class="col-md-6 mb-5">
                @include('groups.partials._group')
            </div>
            @endforeach
        </div>
        @empty
            <p>No blog groups yet!</p>
        @endforelse
        <div>
            {{ $groups->links() }}
        </div>
    </div>
    <div class="col-md-3">
        @include('groups.partials._activity')
    </div>
</div>
@endsection
