<?php

namespace Jandanielcz\Positive;

use Laminas\Diactoros\Response;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    public function __construct(
        protected Engine $engine,
        protected Configuration $configuration,
        protected Posts $posts,
        protected UrlBuilder $urlBuilder
    ){}

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write(
            $this->engine->render('index', [
                'configuration' => $this->configuration,
                'posts' => $this->posts->loadAll(),
                'urlBuilder' => $this->urlBuilder
            ])
        );
        return $response;
    }

    public function single(ServerRequestInterface $request): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $imagePath = str_replace('/image/', '', $path);
        $response = new Response();
        $post = $this->posts->loadByPicture($imagePath);
        $response->getBody()->write(
            $this->engine->render('single', [
                'configuration' => $this->configuration,
                'post' => $post,
                'urlBuilder' => $this->urlBuilder
            ])
        );
        return $response;
    }
}