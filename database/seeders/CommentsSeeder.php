<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        $postIds = Post::query()->pluck('id');
        $totalCount = app(Generator::class)->commentsCount();
        $batchSize = 1000;

        while ($totalCount > 0) {
            $batchSize = min($batchSize, $totalCount);

            Comment::query()->insert(
                Comment::factory()
                    ->count($batchSize)
                    ->make(new Sequence(
                        fn ($sequence) => ['post_id' => $postIds->random()]
                    ))
                    ->toArray()
            );

            $totalCount -= $batchSize;
        }
    }
}
