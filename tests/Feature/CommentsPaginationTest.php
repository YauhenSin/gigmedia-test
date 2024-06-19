<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsPaginationTest extends AbstractPaginationTest
{
    use RefreshDatabase;

    protected string $endpoint = '/api/comments';

    public function setUp(): void
    {
        parent::setUp();

        $post = Post::factory()->create();
        Comment::factory()->for($post)->count($this->count)->create();
    }

    public function test_get_comments_response_structure(): void
    {
        $this->get($this->endpoint)
            ->assertOk()
            ->assertJsonStructure([
                'result' => [
                    '*' => [
                        'id',
                        'post_id',
                        'content',
                        'abbreviation',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'count',
            ]);
    }
}
