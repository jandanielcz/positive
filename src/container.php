<?php
declare(strict_types=1);

use League\Container\Container;
use League\Container\ReflectionContainer;

$c = new Container();

$c->delegate(
    new ReflectionContainer()
);

const BASEDIR = __DIR__ . '/../';

$c->add(\League\Route\Router::class);
$c->add(\League\Plates\Engine::class)->addArgument('../templates');
$c->add(\Jandanielcz\Positive\Configuration::class)
    ->addArgument([BASEDIR .'conf/site.defaults.json5', BASEDIR .'conf/site.json5']);
$c->add(\Jandanielcz\Positive\Posts::class)->addArgument(BASEDIR . 'content/posts.listofjsons');
$c->add(\League\Glide\Server::class, function() {
    $server = \League\Glide\ServerFactory::create([
        'source' =>  BASEDIR . 'content/images',
        'cache' =>  BASEDIR . 'content/cache',
    ]);

    $server->setResponseFactory(new League\Glide\Responses\PsrResponseFactory(new \Laminas\Diactoros\Response(), function ($stream) {
        return new \Laminas\Diactoros\Stream($stream);
    }));

    return $server;
});

return $c;