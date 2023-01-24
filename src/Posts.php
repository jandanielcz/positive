<?php

namespace Jandanielcz\Positive;

use League\Glide\Urls\UrlBuilder;
use Psr\Http\Message\UploadedFileInterface;

class Posts
{
    public function __construct(
        protected string $pathToList,
        protected string $pathToPictures,
        protected UrlBuilder $urlBuilder,
        protected Configuration $configuration
    ){
        if (!file_exists($this->pathToList)) {
            touch($this->pathToList);
        }
        if (!file_exists($this->pathToPictures)) {
            mkdir($this->pathToPictures);
        }
    }

    /**
     * @return Post[]
     */
    public function loadAll(?int $page = null): array
    {
        $c = file($this->pathToList);
        if ($page === null) {
            return array_map([Post::class, 'fromJson'], $c);
        }
        $pageSize = (int)$this->configuration->get('site::pageSize');
        $c = array_slice($c, ($page - 1) * $pageSize, $pageSize);
        return array_map([Post::class, 'fromJson'], $c);
    }

    public function loadByPicture(string $picturePath): ?Post
    {
        $c = file($this->pathToList);
        array_filter($c, function($line) use ($picturePath) {
            return str_contains($line, $picturePath);
        });
        if (count($c) < 1) {
            return null;
        }
        return array_map([Post::class, 'fromJson'], $c)[0];
    }

    public function add(\DateTimeInterface $day, string $text, UploadedFileInterface $picture): string
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

        file_put_contents($this->pathToList, file_get_contents($this->pathToList) . $newLine);
        return $newPath;
    }

    public function buildPagination(?int $currentPage = null): array
    {
        $c = file($this->pathToList);
        $count = count($c);
        $pageSize = (int)$this->configuration->get('site::pageSize');
        $pages = (int)ceil($count / $pageSize);

        return [
            'max' => $pages,
            'current' => ($currentPage == null) ? $pages : $currentPage
        ];
    }

    public function findUrlFor(Post $post): string
    {
        $lines = file($this->pathToList);
        $pos = -1;
        foreach ($lines as $idx => $line) {
            if (str_contains($line, $post->picture)) {
                $pos = $idx;
                break;
            }
        }
        $page = floor($idx / $this->configuration->get('site::pageSize')) + 1;

        return sprintf('%s?page=%s#%s', $this->configuration->get('site::URL'), $page, $post->id());
    }
}