<?php

namespace Database\Factories;

use App\Entities\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $comment = new Comment($this->faker->comment());

        return [
            'content' => $comment->getContent(),
            'abbreviation' => $comment->getAbbreviation(),
        ];
    }
}
