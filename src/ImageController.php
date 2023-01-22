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
        $imagePath = str_replace('/image/', '', $path);
        return $this->glide->getImageResponse($imagePath, $_GET);
    }
}