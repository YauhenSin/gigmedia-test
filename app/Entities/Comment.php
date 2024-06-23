<?php

namespace App\Entities;

class Comment
{
    public function __construct(
        private string $content,
    ){}

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAbbreviation(): string
    {
        return array_reduce(
            explode(' ', $this->content),
            fn (string $result, string $word) => $result .= substr($word, 0, 1),
            ''
        );
    }
}
