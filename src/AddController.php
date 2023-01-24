<?php

namespace Jandanielcz\Positive;

use Couchbase\ReplaceOptions;
use Laminas\Diactoros\Response;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AddController
{
    public function __construct(
        protected Engine $engine,
        protected Configuration $configuration,
        protected Identity $identity
    ){}

    public function add(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->identity->isLoggedIn()) {
            $response = new Response();
            return $response->withStatus(302)->withAddedHeader('Location', '/login');
        }
        $response = new Response();
        $response->getBody()->write(
            $this->engine->render('add', [
                'configuration' => $this->configuration,
            ])
        );
        return $response;
    }
}