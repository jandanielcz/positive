<?php

namespace Jandanielcz\Positive;

class Post
{

    public ?string $id = null;
    public array $picturePaths = [];

    public function __construct(
        public \DateTimeImmutable $day,
        public string $text,
        public string $picture
    ){}

    public static function fromJson(string $jsonString): Post
    {
        $obj = json_decode($jsonString);
        return new Post(
            \DateTimeImmutable::createFromFormat('Y-m-d', $obj->day),
            $obj->text,
            $obj->picture
        );
    }

    public function id():string
    {
        return sprintf('picture-%s', str_replace('/', '-', $this->picture));
    }
}