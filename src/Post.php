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

    /**
     * @param string[] $jsonStrings
     * @return Post[]
     */
    public static function fromJsonLines(array $jsonStrings): array
    {
        $out = [];
        foreach ($jsonStrings as $json) {
            $obj = json_decode($json);
            if (!$obj) {
                 continue;
            }
            if (!isset($obj->day) || !isset($obj->text) || !isset($obj->picture)) {
                continue;
            }
            $out[] = new Post(
                \DateTimeImmutable::createFromFormat('Y-m-d', $obj->day),
                $obj->text,
                $obj->picture
            );
        }

        return $out;
    }

    public function id():string
    {
        return sprintf('picture-%s', str_replace('/', '-', $this->picture));
    }
}