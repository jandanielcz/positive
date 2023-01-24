<?php

namespace Jandanielcz\Positive;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;
use League\Container\ReflectionContainer;

class ContainerBuilder
{
    const BASEDIR = __DIR__ . '/../';

    public static function build(): Container
    {
        $c = new Container();

        $c->delegate(
            new ReflectionContainer()
        );



        $c->add(\League\Route\Router::class);
        $c->add(\League\Plates\Engine::class)->addArgument('../templates');
        $c->add(Configuration::class)
            ->addArgument([self::BASEDIR .'conf/site.defaults.json5', self::BASEDIR .'conf/site.json5']);
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
            ->addArgument(self::BASEDIR . 'content/posts.listofjsons')
            ->addArgument($c->get(\League\Glide\Urls\UrlBuilder::class));
        $c->add(\League\Glide\Server::class, function() {
            $server = \League\Glide\ServerFactory::create([
                'source' =>  self::BASEDIR . 'content/images',
                'cache' =>  self::BASEDIR . 'content/cache',
            ]);

            $server->setResponseFactory(
                new League\Glide\Responses\PsrResponseFactory(
                    new \Laminas\Diactoros\Response(), function ($stream) {
                        return new \Laminas\Diactoros\Stream($stream);
                    }
                )
            );

            return $server;
        });

        $c->add(ServerRequest::class, function() {
            return ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_FILES);
        });

        $c->add(Identity::class, function() {
            return IdentityBuilder::build();
        });

        return $c;
    }
}