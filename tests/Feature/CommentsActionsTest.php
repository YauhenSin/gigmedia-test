<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentsActionsTest extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint = '/api/comments';

    public function test_destroy_comment(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()->for($this->createPost())->create();

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);

        $this
            ->delete($this->endpoint . '/' . $comment->id, [], $this->getHeaders())
            ->assertOk()
            ->assertSeeText('true');

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_destroy_non_existent_comment(): void
    {
        $commentId = 1000;

        $this->assertDatabaseMissing('comments', ['id' => $commentId]);

        $this
            ->delete($this->endpoint . '/' . $commentId, [], $this->getHeaders())
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

    public function test_store_comment(): void
    {
        $post = $this->createPost();

        $data = [
            'post_id' => $post->id,
            'content' => 'strange cool funny',
            'abbreviation' => 'scf',
        ];

        $this->assertDatabaseMissing('comments', ['abbreviation' => $data['abbreviation']]);

        $this
            ->post($this->endpoint, $data, $this->getHeaders())
            ->assertCreated()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('post_id', $post->id)
                    ->where('content', $data['content'])
                    ->where('abbreviation', $data['abbreviation'])
                    ->hasAll('id', 'created_at', 'updated_at')
            );

        $this->assertDatabaseHas('comments', ['abbreviation' => $data['abbreviation']]);
    }

    public function test_store_duplicated_comment(): void
    {
        $post = $this->createPost();

        $data = [
            'post_id' => $post->id,
            'content' => 'strange cool funny',
            'abbreviation' => 'scf',
        ];

        Comment::query()->create($data);

        $this->assertDatabaseHas('comments', ['abbreviation' => $data['abbreviation']]);

        $this
            ->post($this->endpoint, $data, $this->getHeaders())
            ->assertUnprocessable();
    }

    private function createPost(): Post
    {
        return Post::factory()->create();
    }

    private function getHeaders(): array
    {
        return ['Accept' => 'application/json'];
    }
}
