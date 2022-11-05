<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BlogPostCommentUserResource;

class BlogPostCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'user' => new BlogPostCommentUserResource($this->whenLoaded('user')),
        ];
    }

    public function with($request){
        return [
            'version' => 'v1.0.0',
            'developer' => 'https://github.com/soulaimaneyahya'
        ];
    }
}
