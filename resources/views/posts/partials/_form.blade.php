<div class="mb-3">
    <label for="title">{{ __('Title') }}</label>
    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $blogPost->title ?? '') }}" placeholder="title .." required autocomplete="title" autofocus>
    @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="mb-3">
    <label for="content">{{ __('Content') }}</label>
    <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" placeholder="Content .." required autocomplete="content" autofocus>{{ old('content', $blogPost->content ?? '') }}</textarea>
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