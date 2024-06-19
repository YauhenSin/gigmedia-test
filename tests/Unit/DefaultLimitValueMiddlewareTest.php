<?php

namespace Tests\Unit;

use App\Http\Middleware\DefaultLimitValue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class DefaultLimitValueMiddlewareTest extends TestCase
{
    /**
     * @dataProvider limitProvider
     */
    public function test_limit_parameter(int $input, int $expected): void
    {
        $request = Request::create('test', parameters: ['limit' => $input]);

        $middleware = new DefaultLimitValue();
        $middleware->handle($request, fn () => new Response());

        $this->assertEquals($expected, $request->get('limit'));
    }

    public function limitProvider(): array
    {
        return [
            [-1, 10],
            [0, 10],
            [1, 1],
            [10, 10],
            [15, 15],
        ];
    }

    public function test_default_per_page_limit_is_10(): void
    {
        $this->assertEquals(10, Config::get('gigmedia.api.default_per_page_limit'));
    }
}
