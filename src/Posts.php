<?php

namespace Jandanielcz\Positive;

class Posts
{
    public function __construct(
        protected string $pathToList
    ){}

    public function loadAll(): array
    {
        $c = file($this->pathToList);
        return array_map('json_decode', $c);
    }
}