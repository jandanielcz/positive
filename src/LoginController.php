<?php

namespace Jandanielcz\Positive;

use Couchbase\ReplaceOptions;
use Laminas\Diactoros\Response;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController
{
    public function __construct(
        protected Engine $engine,
        protected Configuration $configuration,
        protected Identity $identity,
        protected IdentityBuilder $identityBuilder
    ){}

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->identity->isLoggedIn()) {
            $response = new Response();
            return $response->withStatus(302)->withAddedHeader('Location', '/add');
        }
        $response = new Response();
        $response->getBody()->write(
            $this->engine->render('login', [
                'configuration' => $this->configuration,
            ])
        );
        return $response;
    }

    public function handleLogin(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->configuration->get('site::user::password') === null) {
            return (new Response())->withStatus(302)->withAddedHeader('Location', '/login?msg=notConfigured');
        }
        if (
            password_verify($request->getParsedBody()['password'], $this->configuration->get('site::user::password'))
            &&
            $this->configuration->get('site::user::login') === $request->getParsedBody()['login']
        ) {
            $identity = new Identity($request->getParsedBody()['login'], uniqid('csrf', true));
            $this->identityBuilder->store($identity);
            return (new Response())->withStatus(302)->withAddedHeader('Location', '/add');
        }
        return (new Response())->withStatus(302)->withAddedHeader('Location', '/login?msg=wrongPassword');
    }

    public function handleLogout(ServerRequestInterface $request): ResponseInterface
    {
        $this->identityBuilder->destroy();
        return (new Response())->withStatus(302)->withAddedHeader('Location', '/');
    }
}