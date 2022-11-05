# Resource APIs

```
return $blogPost->comments()->with('user')->get();
```

```
return collect($blogPost->comments()->with('user')->get())->map(function($comment){
    return [
        'user' => $comment->user->name,
        'content' => $comment->content,
        'created_at' => $comment->created_at->diffForHumans(),
    ];
});
```
### first comment
```
return new BlogPostCommentResource($blogPost->comments->first());
```

### collection of data
```
return BlogPostCommentResource::collection($blogPost->comments);
```
