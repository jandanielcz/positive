<?php
declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

require '../vendor/autoload.php';

/** @var Container $c */
$c = include '../src/container.php';

$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_FILES);

/** @var Router $router */
$router = $c->get(Router::class);

$router->map('GET', '/image/{year}/{path}',
    function (ServerRequestInterface $request, array $args) use ($c): ResponseInterface  {
        $controller = $c->get(\Jandanielcz\Positive\ImageController::class);
        return $controller->get($request, $args['year'], $args['name']);
    });
$router->map('GET', '/',
    function (ServerRequestInterface $request) use ($c): ResponseInterface  {
        $controller = $c->get(\Jandanielcz\Positive\IndexController::class);
        return $controller->index($request);
    });

$response = $router->dispatch($request);

/** @var \Laminas\HttpHandlerRunner\Emitter\SapiEmitter $emitter */
$emitter = $c->get(\Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter::class);
$emitter->emit($response);