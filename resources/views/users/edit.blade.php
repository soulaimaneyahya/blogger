@extends('layouts.app')
@section('title', $user->name)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-start">
            <img src="{{ $user->profile->image ? $user->profile->image->url() : asset('storage/laravolt/avatar-'. $user->id.'.png') }}" class="img-thumbnail avatar" />
            <div class="mx-4 w-full w-100">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('users.update', $user) }}"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <a href="{{ route('users.show', $user) }}"><- back</a>
                    <div class="form-group mb-3">
                        <label>Name:</label>
                        <input class="form-control @error('name') is-invalid @enderror" placeholder="Name .." value="{{ old('name', $user->name ?? '') }}" type="text" name="name" />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label>Description:</label>
                        <input class="form-control @error('description') is-invalid @enderror" placeholder="Description .." value="{{ old('description', $user->profile->description ?? '') }}" type="text" name="description" />
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label>Url:</label>
                        <input class="form-control @error('url') is-invalid @enderror" placeholder="url .." value="{{ old('url', $user->profile->url ?? '') }}" type="url" name="url" />
                        @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>Upload a different photo</h6>
                            <input class="form-control-file" type="file" name="avatar" />
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-sm btn-dark my-2" value="Save Changes" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
