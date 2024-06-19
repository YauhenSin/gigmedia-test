<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsPaginationTest extends AbstractPaginationTest
{
    use RefreshDatabase;

    public string $endpoint = '/api/posts';

    public function setUp(): void
    {
        parent::setUp();

        Post::factory()->count($this->count)->create();
    }

    public function test_get_posts_response_structure(): void
    {
        $this->get($this->endpoint)
            ->assertOk()
            ->assertJsonStructure([
                'result' => [
                    '*' => [
                        'id',
                        'topic',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'count',
            ]);
    }
}
