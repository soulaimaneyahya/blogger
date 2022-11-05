<p class="m-0 p-0">
    @foreach ($tags as $name)
        <span class="badge bg-secondary">
            <a href="{{ route('blog_posts.tags.index', $name) }}" class="text-white text-decoration-none">{{ $name }}</a>
        </span>
    @endforeach
</p>
