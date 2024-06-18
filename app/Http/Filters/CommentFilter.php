<?php

namespace App\Http\Filters;

class CommentFilter extends BaseFilter
{
    protected array $sortable = [
        'id',
        'post_id',
        'content',
        'abbreviation',
        'created_at',
        'updated_at',
    ];

    protected array $relations = [
        'post',
    ];

    public function id(string $value): void
    {
        $this->query->where('id', $value);
    }

    public function content(string $value): void
    {
        $this->query->where('content', 'like', '%' . $value . '%');
    }

    public function abbreviation(string $value): void
    {
        $this->query->where('abbreviation', 'like', '%' . $value . '%');
    }

    public function post(string $value): void
    {
        $this->query->whereRelation('post', 'topic', 'like', '%' . $value . '%');
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
