<?php
declare(strict_types=1);

use Jandanielcz\Positive\Configuration;
use League\Container\Container;
use League\Container\ReflectionContainer;

$c = new Container();

$c->delegate(
    new ReflectionContainer()
);

const BASEDIR = __DIR__ . '/../';

$c->add(\League\Route\Router::class);
$c->add(\League\Plates\Engine::class)->addArgument('../templates');
$c->add(Configuration::class)
    ->addArgument([BASEDIR .'conf/site.defaults.json5', BASEDIR .'conf/site.json5']);
$c->add(\League\Glide\Urls\UrlBuilder::class, function() use ($c) {
    /** @var Configuration $configuration */
    $configuration = $c->get(Configuration::class);
    $key = $configuration->get('site::glidekey');
    $urlBuilder = \League\Glide\Urls\UrlBuilderFactory::create('/image/', $key);
    return $urlBuilder;
});
$c->add(\League\Glide\Signatures\Signature::class, function() use ($c) {
    /** @var Configuration $configuration */
    $configuration = $c->get(Configuration::class);
    $key = $configuration->get('site::glidekey');
    $signature = \League\Glide\Signatures\SignatureFactory::create($key);
    return $signature;
});
$c->add(\Jandanielcz\Positive\Posts::class)
    ->addArgument(BASEDIR . 'content/posts.listofjsons')
    ->addArgument($c->get(\League\Glide\Urls\UrlBuilder::class));
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