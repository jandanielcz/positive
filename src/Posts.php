<?php

namespace Jandanielcz\Positive;

use League\Glide\Urls\UrlBuilder;

class Posts
{
    public function __construct(
        protected string $pathToList,
        protected UrlBuilder $urlBuilder
    ){}

    public function loadAll(): array
    {
        $c = file($this->pathToList);
        return array_map([Post::class, 'fromJson'], $c);
    }
}