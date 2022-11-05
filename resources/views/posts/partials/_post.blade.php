@auth
@if ($blogPost->trashed())
<del>
@endif
@endauth
<div class="d-flex align-items-start">
<h4>
    <a class="fw-bold {{ $blogPost->trashed() ? 'text-muted' : '' }}" href="{{ route('blog_posts.show', $blogPost) }}">{{ $blogPost->title }}</a>
</h4>
@badge(['type' => 'danger', 'show' => now()->diffInMinutes($blogPost->created_at) < 5])
new !
@endbadge
</div>
@auth
@if ($blogPost->trashed())
</del>
@endif
@endauth

<p class="p-0 m-0">{{ \Illuminate\Support\Str::limit($blogPost->content, 100, $end='...') }}</p>

@updated(['date'=> $blogPost->created_at, 'name'=> $blogPost->user->name, 'user' => $blogPost->user])@endupdated
@if($blogPost->comments_count)
<p class="p-0 m-0">{{ $blogPost->comments_count }} {{ Str::plural('comment', $blogPost->comments_count) }}</p>
@else
<p class="p-0 m-0">No comments yet!</p>
@endif

<div class="mb-2">
@tags(['tags' => collect($blogPost->tags)->pluck('name')])@endtags
</div>

@auth
<div>
    @can('update', $blogPost)
    <a href="{{ route('blog_posts.edit', $blogPost) }}" class="btn btn-sm btn-dark">Edit</a>
    @endcan
    @if (!$blogPost->trashed())
    @can('delete', $blogPost)
    <form action="{{ route('blog_posts.destroy', $blogPost) }}" onsubmit="return confirm('Are You Sure ?')" method="post" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
    @endcan
    @endif
</div>
@endauth
