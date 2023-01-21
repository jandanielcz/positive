<?php

namespace Jandanielcz\Positive;

use Laminas\Diactoros\Response;
use League\Glide\Server;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImageController
{
    public function __construct(
        protected Server $glide,
        protected Configuration $configuration
    ){}

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        var_dump($path);
        return $this->glide->getImageResponse('2023/sampleA.jpg', $_GET);
    }
}