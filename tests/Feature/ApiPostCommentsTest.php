<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiPostCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function testNewBlogPostDoesNotHaveComments()
    {
        $post = $this->actingAs($this->user())->createDummyBlogPost($this->user()->id);

        $response = $this->json('GET', "api/v1/blog_posts/{$post->id}/comments");

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    public function testBlogPostHas10Comments()
    {
        $blog_post = $this->actingAs($this->user())->createDummyBlogPost($this->user()->id);
        $blog_post->each(function(BlogPost $post) {
            $post->comments()->saveMany(
                Comment::factory(10)->make([
                    'user_id' => $this->user()->id
                ])
            );
        });
        $response = $this->json('GET', "api/v1/blog_posts/{$blog_post->id}/comments");
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'content',
                            'created_at',
                            'updated_at',
                            'user' => [
                                'id',
                                'name',
                                'username',
                                'email',
                            ]
                        ]
                    ],
                    'links',
                    'meta'
                ]
            )
            ->assertJsonCount(10, 'data');
    }

    public function testBlogPostStoreNoAuth()
    {
        $blog_post = $this->actingAs($this->user())->createDummyBlogPost($this->user()->id);
        $response = $this->json('POST', "api/v1/blog_posts/{$blog_post->id}/comments", [
            'content' => 'lorem ipsum dolor sit ament'
        ]);
        $response->assertStatus(401);
    }


    public function testAddingCommentWithInvalidData()
    {
        $blog_post = $this->actingAs($this->user())->createDummyBlogPost($this->user()->id);
        $response = $this->actingAs($this->user(), 'api')->json('POST', "api/v1/blog_posts/{$blog_post->id}/comments", []);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The content field is required.",
                "errors" => [
                    "content" => [
                        "The content field is required."
                    ]
                ]
            ]);
    }


    public function testAddingCommentWithValidData()
    {
        $blog_post = $this->actingAs($this->user())->createDummyBlogPost($this->user()->id);
        $response = $this->actingAs($this->user(), 'api')->json('POST', "api/v1/blog_posts/{$blog_post->id}/comments", [
            'content' => 'lorem ipsum dolor sit ament'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'content',
                        'created_at',
                        'updated_at',
                    ],
                    'version',
                    'developer'
                ]
            );
    }
}
