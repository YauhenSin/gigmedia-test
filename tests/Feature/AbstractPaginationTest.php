<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class AbstractPaginationTest extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint;
    protected int $count = 15;
    protected int $defaultLimit = 10;

    public function test_default_pagination_limit(): void
    {
        $this
            ->getJson($this->endpoint)
            ->assertJsonCount($this->defaultLimit, 'result')
            ->assertJsonPath('count', $this->count);
    }

    /**
     * @dataProvider customLimitProvider
     */
    public function test_custom_pagination_limit(int $customLimit, int $result): void
    {
        $this
            ->getJson($this->endpoint . '?limit=' . $customLimit)
            ->assertJsonCount($result, 'result')
            ->assertJsonPath('count', $this->count);
    }

    public function customLimitProvider(): array
    {
        return [
            [0, $this->defaultLimit],
            [1, 1],
            [11, 11],
        ];
    }

    /**
     * @dataProvider pageProvider
     */
    public function test_pagination_page_n(int $page, int $count): void
    {
        $this
            ->getJson($this->endpoint . '?page=' . $page)
            ->assertJsonCount($count, 'result')
            ->assertJsonPath('count', $this->count);
    }

    public function pageProvider(): array
    {
        return [
            [1, 10],
            [2, 5],
            [3, 0],
        ];
    }

    /**
     * @dataProvider limitPageProvider
     */
    public function test_pagination_limit_page(int $customLimit, int $page, int $result): void
    {
        $this
            ->getJson($this->endpoint . '?limit=' . $customLimit . '&page=' . $page)
            ->assertJsonCount($result, 'result')
            ->assertJsonPath('count', $this->count);
    }

    public function limitPageProvider(): array
    {
        return [
            [8, 1, 8],
            [8, 2, 7],
            [8, 3, 0],
            [15, 1, 15],
            [15, 2, 0],
        ];
    }
}
