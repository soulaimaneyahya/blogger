@extends('layouts.app')
@section('title', $blogPost->title)
@section('content')
<div class="row">
    <div class="d-flex align-items-start">
        <h3 class="mb-3">{{ $blogPost->title }}</h3>
        @badge(['type' => 'danger', 'show' => now()->diffInMinutes($blogPost->created_at) < 5])
         new !
        @endbadge
    </div>
    <div class="col-md-9">
        @tags(['tags' => collect($blogPost->tags)->pluck('name')])@endtags
        <img src="{{ $blogPost->image ? $blogPost->image->url() : 'https://dummyimage.com/900x400/ced4da/6c757d.jpg' }}" width="900" class="p-0 m-0 my-3" alt="no-image">
        
        <div class="p-0">
            <h5>{{ $blogPost->content }}</h5>
        </div>
        <div class="mb-2 mt-3">
            <p class="p-0 m-0 text-muted fw-bold">{{ $view }} {{ Str::plural('view', $view) }}</p>
            @updated(['date' => $blogPost->updated_at, 'name'=> $blogPost->user->name, 'user' => $blogPost->user]) Updated @endupdated
        </div>
        
        <div class="my-3">
            @auth
            @commentForm(['route' => route('blog_posts.comments.store', $blogPost)])
            @endcommentForm
            @else
            <li class="list-group-item">
                <h5 class="fw-bold py-3 m-0"><a href="{{ route('login') }}">Sign-in to leave a comment!</a></h5>
            </li>
            @endauth

            @if ($blogPost->comments_count)
            <ul class="list-group">
                <p class="fw-bold p-0 mx-0 mb-2">Total {{ Str::plural('comment', $blogPost->comments_count) }}: {{ $blogPost->comments_count }}</p>
                @commentList(['commentList' => $comments])
                @endcommentList
            </ul>                  
            @else
            <p>No comments yet!</p> 
            @endif
        </div>
    </div>
    <div class="col-md-3">
        @include('posts.partials._activity')
    </div>
</div>
@endsection
