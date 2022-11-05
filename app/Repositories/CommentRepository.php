<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function find(int $id, string $model)
    {
        $per_page = request('per_page') ?? 5;
        return Comment::where('commentable_id', $id)
            ->where('commentable_type', $model)
            ->with(['user.profile.image', 'user'])
            ->latest()
            ->paginate($per_page) // page = 1
            ->appends([
                'per_page' => $per_page // &per_page=10
            ]);
    }
}
