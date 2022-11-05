@extends('layouts.app')
@section('title', 'Edit BlogPost')
@section('content')
<h3>Edit BlogPost</h3>
<a href="{{ route('blog_posts.show', $blogPost) }}">View Post</a>
<form action="{{ route('blog_posts.update', $blogPost) }}" method="POST" enctype="multipart/form-data" class="my-3">
    @csrf
    @method('PUT')
    @include('posts.partials._form')
    <button type="submit" class="btn btn-dark">
        {{ __('Update') }}
    </button>
</form>
@endsection
