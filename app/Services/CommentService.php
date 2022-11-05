<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\BlogPost;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Model;

class CommentService
{

    /**
     * instantiate Comment
     * @param Comment $comment
     */
    public function __construct
    (
        private CommentRepository $commentRepository,
        private Comment $comment,
    )
    {
        //  
    }

    public function find(Model $model, string $class)
    {
        return $this->commentRepository->find($model->id, $class);
    }

    /**
     * store comment
     *
     * @param array $data
     * @return void
     */
    public function store(array $data)
    {
        return $this->comment->create($data);
    }
}
