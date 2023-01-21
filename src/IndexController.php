<?php

namespace Jandanielcz\Positive;

use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    public function __construct(
        protected Engine $engine,
        protected Configuration $configuration,
        protected Posts $posts
    ){}

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write(
            $this->engine->render('index', [
                'configuration' => $this->configuration,
                'posts' => $this->posts->loadAll()
            ])
        );
        return $response;
    }
}