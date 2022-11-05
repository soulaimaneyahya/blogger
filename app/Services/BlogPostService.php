<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Image;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Storage;
use App\Repositories\BlogPostRepository;

class BlogPostService
{
    public function __construct
    (
        private Image $image,
        private BlogPost $blogPost,
        private BlogPostRepository $blogPostRepository,
    )
    {
    }

    public function all()
    {
        return $this->blogPostRepository->all();
    }

    public function findByTag(Tag $tag)
    {
        return $this->blogPostRepository->findByTag($tag);
    }

    public function find(BlogPost $blogPost)
    {
        return $this->blogPostRepository->find($blogPost);
    }

    public function store(array $data)
    {
        $blogPost = $this->blogPost->create($data);
        if(isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('thumbnails');
            $blogPost->image()->save(
                $this->image->make(['path' => $path])
            );
        }
        return $blogPost;
    }

    public function update(array $data, BlogPost $blogPost)
    {
        $blogPost->update($data);
        if(isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('thumbnails');
            if ($blogPost->image) {
                Storage::delete($blogPost->image->path);
                $blogPost->image->path = $path;
                $blogPost->image->save();
            } else {
                $blogPost->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }
        return $blogPost;
    }

    public function delete(BlogPost $blogPost)
    {
        return $blogPost->delete();
    }
}
