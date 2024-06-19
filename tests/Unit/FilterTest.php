<?php

namespace Tests\Unit;

use App\Http\Filters\BaseFilter;
use App\Http\Filters\CommentFilter;
use App\Http\Filters\PostFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    /**
     * @dataProvider filterProvider
     */
    public function test_filter_method_fired_if_request_parameter_provided (
        string $filterClassName, array $requestValue, string $methodName
    ): void {
        $request = new Request();
        $request->merge($requestValue);

        /** @var BaseFilter $filter */
        $filter = $this->getMockBuilder($filterClassName)
            ->setConstructorArgs(['request' => $request])
            ->onlyMethods([$methodName])
            ->getMock();

        $filter
            ->expects($this->once())
            ->method($methodName);

        $filter->apply(
            $this->getMockBuilder(Builder::class)
                ->disableOriginalConstructor()
                ->getMock()
        );
    }

    public function filterProvider(): array
    {
        return [
            [CommentFilter::class, ['id' => 1], 'id'],
            [CommentFilter::class, ['content' => 'test'], 'content'],
            [CommentFilter::class, ['abbreviation' => 'test'], 'abbreviation'],
            [CommentFilter::class, ['post' => 'test'], 'post'],
            [CommentFilter::class, ['created_at' => 'test'], 'created_at'],
            [CommentFilter::class, ['updated_at' => 'test'], 'updated_at'],
            [CommentFilter::class, ['sort' => 'test'], 'sort'],
            [CommentFilter::class, ['with' => 'test'], 'with'],
            [PostFilter::class, ['id' => 1], 'id'],
            [PostFilter::class, ['topic' => 'test'], 'topic'],
            [PostFilter::class, ['comment' => 'test'], 'comment'],
            [PostFilter::class, ['created_at' => 'test'], 'created_at'],
            [PostFilter::class, ['updated_at' => 'test'], 'updated_at'],
            [PostFilter::class, ['sort' => 'test'], 'sort'],
            [PostFilter::class, ['with' => 'test'], 'with'],
        ];
    }
}
