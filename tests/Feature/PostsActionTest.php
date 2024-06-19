<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostsActionTest extends TestCase
{
    use RefreshDatabase;

    public string $endpoint = '/api/posts';


    public function test_destroy_post(): void
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $this->assertDatabaseHas('posts', ['id' => $post->id]);

        $this
            ->delete($this->endpoint . '/' . $post->id, [], $this->getHeaders())
            ->assertOk()
            ->assertSeeText('true');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_destroy_non_existent_post(): void
    {
        $postId = 1000;

        $this->assertDatabaseMissing('posts', ['id' => $postId]);

        $this
            ->delete($this->endpoint . '/' . $postId, [], $this->getHeaders())
            ->assertNotFound()
            ->assertJsonCount(1, 'errors')
            ->assertJsonStructure([
                'errors' => [
                    '*' => [
                        'status',
                        'title',
                    ],
                ],
            ]);
    }

    private function getHeaders(): array
    {
        return ['Accept' => 'application/json'];
    }
}
