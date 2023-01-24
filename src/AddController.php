<?php

namespace Jandanielcz\Positive;

use Couchbase\ReplaceOptions;
use Laminas\Diactoros\Response;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class AddController
{
    public function __construct(
        protected Engine $engine,
        protected Configuration $configuration,
        protected Identity $identity,
        protected Posts $posts
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
                'identity' => $this->identity
            ])
        );
        return $response;
    }

    public function handleAdd(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->identity->isLoggedIn()) {
            $response = new Response();
            return $response->withStatus(302)->withAddedHeader('Location', '/login');
        }
        if ($request->getParsedBody()['csrfToken'] !== $this->identity->csrfToken) {
            return (new Response)->withStatus(302)->withAddedHeader('Location', '/add?msg=csrfIssue');
        }

        $text = $request->getParsedBody()['text'];
        $day = \DateTimeImmutable::createFromFormat('Y-m-d', $request->getParsedBody()['day']);
        /** @var UploadedFileInterface $picture */
        $picture = $request->getUploadedFiles()['picture'];


        $this->posts->add($day, $text, $picture);

        return (new Response)->withStatus(302)->withAddedHeader('Location', '/');
    }
}