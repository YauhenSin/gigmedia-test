<?php

namespace Tests\Unit;

use App\Entities\Comment;
use PHPUnit\Framework\TestCase;

class CommentEntityTest extends TestCase
{
    /**
     * @dataProvider abbreviationsProvider
     */
    public function test_abbreviations(string $content, string $abbreviation): void
    {
        $comment = new Comment($content);
        $this->assertEquals($content, $comment->getContent());
        $this->assertEquals($abbreviation, $comment->getAbbreviation());
    }

    public function abbreviationsProvider(): array
    {
        return [
            ['alfa', 'a'],
            ['bravo', 'b'],
            ['bravo alfa', 'ba'],
            ['charlie', 'c'],
            ['alfa charlie', 'ac'],
            ['bravo charlie', 'bc'],
            ['alfa bravo charlie', 'abc'],
        ];
    }
}
