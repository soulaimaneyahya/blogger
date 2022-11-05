<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/blog_posts');
        $response->assertSeeText('No blog posts yet!');
    }

    public function testSee1BlogPostWhenThereIs1WithNoComments() 
    {
        // Arrange
        $post = $this->actingAs($this->user())->createDummyBlogPost($this->user()->id);
        // Act
        $response = $this->get('/blog_posts');
        // Assert
        $response->assertSeeText('lorem ipsum dolor sit ament');
        $response->assertSeeText('No comments yet!');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'lorem ipsum dolor sit ament',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.',
        ]);
    }

    public function testSee1BlogPostWithComments()
    {
        // Arrange
        $post = $this->actingAs($this->user())->createDummyBlogPost($this->user()->id);
        Comment::factory(4)->create([
            'user_id' => auth()->id(),
            'commentable_id' => $post->id,
            'commentable_type' => BlogPost::class,
        ]);
        $response = $this->get('/blog_posts');
        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '
        ];

        $this->actingAs($this->user())->post('/blog_posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-success');

        $this->assertEquals(session('alert-success'), 'Post Created !');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())->post('/blog_posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'lorem ipsum dolor sit ament',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.',
        ]);

        $params = [
            'user_id' => $user->id,
            'title' => 'Lorem ipsum dolor sit amet - new',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. - new'
        ];

        $this->actingAs($user)->put("/blog_posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-success');

        $this->assertEquals(session('alert-success'), 'Post Updated !');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'lorem ipsum dolor sit ament',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.',
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Lorem ipsum dolor sit amet - new',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. - new'
        ]);
    }

    public function testDelete() 
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'lorem ipsum dolor sit ament',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.',
        ]);

        $this->actingAs($user)->delete("/blog_posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('alert-info');

        $this->assertEquals(session('alert-info'), 'Post Deleted !');
        // $this->assertDatabaseMissing('blog_posts', $post);
        $this->assertSoftDeleted('blog_posts', [
            'title' => 'lorem ipsum dolor sit ament',
            'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.',
        ]);
    }
}
