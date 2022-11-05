@extends('layouts.app')
@section('title', 'Contact us')
@section('content')
<h3 class="mb-3">Contact us</h3>
@can('contact.admin')
    <a href="{{ route('contact.admin') }}">Contact admin</a>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia atque dolores impedit voluptatum quis illo veniam doloribus deserunt similique eius, repellat corporis eaque, aliquid illum ex molestias vitae laborum saepe?</p>
@endcan
@auth
<form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="mb-3">
        <label for="subject">{{ __('Subject') }}</label>
        <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" placeholder="Subject .." required autocomplete="subject" autofocus>
        @error('subject')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="content">{{ __('Content') }}</label>
        <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" placeholder="Content .." required autocomplete="content" autofocus>{{ old('content') }}</textarea>
        @error('content')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Attache Image</label>
        <input class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" type="file" id="image">
        @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-dark">
        {{ __('Send') }}
    </button>
</form>
@else
<a href="{{ route('login') }}">Login to Contact us</a>
@endauth
@endsection
