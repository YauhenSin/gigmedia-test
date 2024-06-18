<?php

namespace App\Http\Filters;

class PostFilter extends BaseFilter
{
    protected array $sortable = [
        'id',
        'topic',
        'created_at',
        'updated_at',
    ];

    protected array $relations = [
        'comments',
    ];

    public function id(string $value): void
    {
        $this->query->where('id', $value);
    }

    public function topic(string $value): void
    {
        $this->query->where('topic', 'like', '%' . $value . '%');
    }

    public function comment(string $value): void
    {
        $this->query->whereRelation('comments', 'content', 'like', '%' . $value . '%');
    }

    public function created_at(string $value): void
    {
        $this->query->whereDate('created_at', $value);
    }

    public function updated_at(string $value): void
    {
        $this->query->whereDate('updated_at', $value);
    }
}
