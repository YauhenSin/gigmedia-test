<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BaseFilter
{
    public Builder $query;
    protected array $sortable = [];
    protected array $relations = [];

    public function __construct(
        public Request $request,
    ){}

    public function apply(Builder $query): Builder
    {
        $this->query = $query;

        foreach ($this->request->all() as $key => $value) {
            if (! is_null($value) && method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->query;
    }

    public function sort(string $value): void
    {
        if (! in_array($value, $this->sortable)) {
            return;
        }

        $direction = 'asc';
        if ($this->request->get('direction') === 'desc') {
            $direction = $this->request->get('direction');
        }

        $this->query->orderBy($value, $direction);
    }

    public function with(string $value): void
    {
        if (in_array($value, $this->relations)) {
            $this->query->with($value);
        }
    }
}
