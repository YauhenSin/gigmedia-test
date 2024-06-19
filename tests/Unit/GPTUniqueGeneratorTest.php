<?php

namespace Tests\Unit;

use App\Faker\GPTUniqueGenerator;
use PHPUnit\Framework\TestCase;

class GPTUniqueGeneratorTest extends TestCase
{
    /**
     * @dataProvider wordsProvider
     */
    public function test_count_of_combinations(array $words): void
    {
        $generator = new GPTUniqueGenerator();
        $this->assertCount($this->calculateCombinationsCount(count($words)), $generator->run($words));
    }

    private function calculateCombinationsCount($wordsCount): int
    {
        return (2 ** $wordsCount) - 1;
    }

    /**
     * @dataProvider wordsProvider
     */
    public function test_if_combinations_are_unique($words): void
    {
        $generator = new GPTUniqueGenerator();
        $combinations = $generator->run($words);
        $this->assertCount(count(array_unique($combinations)), $combinations);
    }

    public function wordsProvider(): array
    {
        return [
            [[]],
            [['Cool']],
            [['Cool', 'Strange', 'Funny', 'Laughing', 'Nice', 'Awesome']],
            [['Cool', 'Strange', 'Funny', 'Laughing', 'Nice', 'Awesome', 'Great', 'Horrible', 'Beautiful', 'PHP', 'Vegeta', 'Italy', 'Joost']],

        ];
    }
}
