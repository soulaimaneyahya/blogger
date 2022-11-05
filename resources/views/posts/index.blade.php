@extends('layouts.app')
@section('title', 'Blog Posts')
@section('content')
<div class="row">
    <div class="mb-3">
        @isset($tag)
        <h3>{{ '#'.$tag->name }}</h3>
        <h6><span class="fw-bold">{{ count($blogPosts) }}</span> {{ Str::plural('post', count($blogPosts)) }}</h6>
        @else
        <h3>{{ __('Blog Posts') }}</h3>
        @endisset
    </div>
    <div class="col-md-9">
        @forelse ($blogPosts->chunk(2) as $chunk)
        <div class="row">
            @foreach ($chunk as $blogPost)
            <div class="col-md-6 mb-5">
                @include('posts.partials._post')
            </div>
            @endforeach
        </div>
        @empty
            <p>No blog posts yet!</p>
        @endforelse
        <div>
            {{ $blogPosts->links() }}
        </div>
    </div>
    <div class="col-md-3">
        @include('posts.partials._activity')
    </div>
</div>
@endsection
