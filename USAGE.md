# Deleted Queries

- $posts = BlogPost::all()->pluck('id');
- $all = BlogPost::withTrashed()->get();
- $post = $all->find(3);

- $post = BlogPost::has('comments')->get()->first();
- $post->delete(); // True
- $post->trashed(); // True
- $post->restore(); // True
- $post->forceDelete();

## Gates & Permissions

- $post = BlogPost::find(1)
- $user = User::find(4)
- Gate::forUser($user)->denies('update-post', $post);
- Gate::forUser($user)->allows('update-post', $post);

## Query Scopes

### Latest

- $latest = BlogPost::orderBy('created_at', 'desc')->get()

### Most Commented

- $mostCommented = BlogPost::withCount('comments')->orderBy('comments_count', 'desc')->get()->take(5);

### Most Active Users

- $mostCommented = BlogPost::withCount('blogPosts')->orderBy('blog_posts_count', 'desc')->get()->take(5);

### Most Active Users Last Month

- $mostCommented = BlogPost::withCount(['blogPosts' => function($query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])
        ->having('blog_posts_count', '>=', 2)
        ->orderBy('blog_posts_count', 'desc');

## Cache Facade

- cache::put('username', 'soulaimane.yh', 60);
- cache::has('username'); // T/F
- cache::get('username');
- cache::get('username2') // null/Data
- cache::get('username3', 'omniael'); // default value if null
- cache::increment('i');
- cache::decrement('i');
- cache::put(); //without expiration time <=> cache::forever();

## Cache Tags

>>> Cache::tags(['people', 'artists'])->put('John', 'Hello World', 100);
=> true
>>> Cache::tags(['people', 'artists'])->get('John')
=> "Hello World"

- Empty tags cache:
- Cache::tags(['people', 'authors'])->flush();

- Remove only this cache:
- Cache::tags('authors')->flush();

## BlogPostTag

### testing delete record and correspondent pivot table

- $post = BlogPost::withTrashed()->find(1)
- $post->restore();

- $tag = Tag::find(1);
- $tag->delete();
- $tag->restore();

## Laravel Telescope

### Data Pruning

Without pruning, the telescope_entries table can accumulate records very quickly. To mitigate this, you should schedule the telescope:prune Artisan command to run daily:

$schedule->command('telescope:prune')->daily();

By default, all entries older than 24 hours will be pruned. You may use the hours option when calling the command to determine how long to retain Telescope data. For example, the following command will delete all records created over 48 hours ago:

$schedule->command('telescope:prune --hours=48')->daily();
