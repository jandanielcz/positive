<?php

namespace Jandanielcz\Positive;

use League\Glide\Urls\UrlBuilder;
use Psr\Http\Message\UploadedFileInterface;

class Posts
{
    public function __construct(
        protected string $pathToList,
        protected string $pathToPictures,
        protected UrlBuilder $urlBuilder
    ){}

    /**
     * @return Post[]
     */
    public function loadAll(): array
    {
        $c = file($this->pathToList);
        return array_map([Post::class, 'fromJson'], $c);
    }

    public function add(\DateTimeInterface $day, string $text, UploadedFileInterface $picture): void
    {
        $year = $day->format('Y');
        if (!file_exists($this->pathToPictures . '/' . $year)) {
            mkdir($this->pathToPictures . '/' . $year);
        }
        $newPath = $year . '/' . strtolower($picture->getClientFilename());
        file_put_contents($this->pathToPictures . '/' . $newPath, $picture->getStream()->read($picture->getSize()));

        $newLine = json_encode([
            'day' => $day->format('Y-m-d'),
            'text' => $text,
            'picture' => $newPath
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ) . PHP_EOL;

        file_put_contents($this->pathToList, $newLine . file_get_contents($this->pathToList));
    }
}