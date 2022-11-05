@card(['title' => 'Most Commented Posts'])
@slot('subtitle')
What people are currently talking about
@endslot
@slot('items')
    @foreach ($mostCommented as $post)
    <li class="list-group-item">
        <a href="{{ route('blog_posts.show', $post) }}">
            <p class="m-0 p-0">{{ $post->title }} <b>({{ $post->comments_count }})</b></p>
        </a>
    </li>    
    @endforeach
@endslot
@endcard

@card(['title' => 'Most Active Users'])
@slot('subtitle')
Users with most posts written
@endslot
@slot('items', $mostActiveUsers) {{-- ->pluck('name') --}}
@endcard

@card(['title' => 'Most Active Users Last month', 'subtitle' => 'Users with most posts written last month'])
@slot('items', $mostActiveLastMonth)
@endcard
