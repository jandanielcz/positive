<?php
declare(strict_types=1);

use Jandanielcz\Positive\ContainerBuilder;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

require '../vendor/autoload.php';

$container = ContainerBuilder::build();

$request = $container->get(\Laminas\Diactoros\ServerRequest::class);

/** @var Router $router */
$router = $container->get(Router::class);

$router->map('GET', '/image/{year}/{path}',
    function (ServerRequestInterface $request, array $args) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\ImageController::class);
        return $controller->get($request, $args['year'], $args['path']);
    });
$router->map('GET', '/rss2',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\FeedController::class);
        return $controller->rss2($request);
    });
$router->map('GET', '/atom',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\FeedController::class);
        return $controller->atom($request);
    });
$router->map('GET', '/add',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\AddController::class);
        return $controller->add($request);
    });
$router->map('POST', '/add',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\AddController::class);
        return $controller->handleAdd($request);
    });
$router->map('GET', '/login',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\LoginController::class);
        return $controller->login($request);
    });
$router->map('POST', '/login',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\LoginController::class);
        return $controller->handleLogin($request);
    });
$router->map('GET', '/logout',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\LoginController::class);
        return $controller->handleLogout($request);
    });
$router->map('GET', '/',
    function (ServerRequestInterface $request) use ($container): ResponseInterface  {
        $controller = $container->get(\Jandanielcz\Positive\IndexController::class);
        return $controller->index($request);
    });

$response = $router->dispatch($request);

/** @var \Laminas\HttpHandlerRunner\Emitter\SapiEmitter $emitter */
$emitter = $container->get(\Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter::class);
$emitter->emit($response);