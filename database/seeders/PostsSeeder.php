<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        Post::query()->insert(
            Post::factory()
                ->count(config('gigmedia.db_seeder.posts_count'))
                ->make()
                ->toArray()
        );
    }
}
