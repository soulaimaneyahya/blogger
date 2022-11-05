@extends('layouts.app')
@section('title', $user->name)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-start">
            <img src="{{ $user->profile->image ? $user->profile->image->url() : asset('storage/laravolt/avatar-'. $user->id.'.png') }}" class="img-thumbnail avatar" />
            <div class="mx-4 w-full w-100">
                @can('update', $user)
                <a href="{{ route('users.edit', $user) }}">edit profile</a>
                @endcan
                
                <div class="d-flex align-items-center">
                    <h3 title="{{ $user->name }}">
                        {{ $user->name }}
                    </h3>
                    {{-- <button type="submit" class="btn btn-dark btn-sm mx-3">Follow</button> --}}
                    @auth
                    @if ($user->id != auth()->id())
                    <form action="{{ route('users.follow', $user) }}" method="POST" class="mx-2">
                        @csrf
                        @method('PUT')
                        @if ($user->profile->followers->contains(auth()->user()))
                        <button type="submit" class="btn btn-secondary btn-sm">Unfollow</button>
                        @else
                        <button type="submit" class="btn btn-dark btn-sm">Follow</button>
                        @endif
                    </form>
                    @endif
                    @endauth
                </div>

                <h5>{{ '@'.$user->username }}</h5>

                <div class="d-flex align-items-center">
                    <p>
                        <span class="fw-bold">
                            {{ $profile->followers_count > 1000 ? round($profile->followers_count/1000, 1) . 'k' : $profile->followers_count }}
                        </span> {{ Str::plural('follower', $profile->followers_count) }}
                    </p>
                    <p class="mx-3">
                        <span class="fw-bold">
                            {{ $user->following_count > 1000 ? round($user->following_count/1000, 1) . 'k' : $user->following_count}}
                        </span> {{ Str::plural('following', $user->following_count) }}
                    </p>
                    <p>
                        <span class="fw-bold">
                            {{ $user->join_count > 1000 ? round($user->join_count/1000, 1) . 'k' : $user->join_count }}
                        </span> {{ Str::plural('group', $user->join_count) }}
                    </p>
                </div>

                <div class="mb-3">
                    <p class="p-0 m-0">{{ $profile->description }}</p>
                    <a class="p-0 m-0" href="http://{{ $profile->url }}" target="_blank">{{ $profile->url }}</a>
                </div>

                @auth
                    @commentForm(['route' => route('users.comments.store', $user), 'placeholder' => "Write something to @{$user->username}"])
                    @endcommentForm
                    <hr>
                @else
                    <a href="{{ route('login') }}">Sign-in to leave a comment!</a>
                @endauth

                @if ($user->comments_on_count)
                <ul class="list-group">
                    <p class="fw-bold p-0 mx-0 mb-2">Total {{ Str::plural('comment', $user->comments_on_count) }}: {{ $user->comments_on_count }}</p>
                    @commentList(['commentList' => $comments])
                    @endcommentList
                </ul>                  
                @else
                <p>No comments yet!</p> 
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
