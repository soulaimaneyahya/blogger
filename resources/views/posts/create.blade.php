@extends('layouts.app')
@section('title', 'Create BlogPost')
@section('content')
<h3 class="mb-3">Create BlogPost</h3>
<form action="{{ route('blog_posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('posts.partials._form')
    <button type="submit" class="btn btn-dark">
        {{ __('Save') }}
    </button>
</form>
@endsection
