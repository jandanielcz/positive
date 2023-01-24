<?php

namespace Jandanielcz\Positive;

use Laminas\Diactoros\Response;
use League\Glide\Urls\UrlBuilder;
use League\Plates\Engine;
use PicoFeed\Syndication\AtomFeedBuilder;
use PicoFeed\Syndication\AtomItemBuilder;
use PicoFeed\Syndication\Rss20FeedBuilder;
use PicoFeed\Syndication\Rss20ItemBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FeedController
{
    public function __construct(
        protected Configuration $configuration,
        protected Posts $posts,
    ){}

    public function rss2(ServerRequestInterface $request): ResponseInterface
    {
        $feedBuilder = Rss20FeedBuilder::create()
            ->withTitle($this->configuration->get('site::title'))
            ->withAuthor($this->configuration->get('site::author'), $this->configuration->get('site::authorEmail'))
            ->withFeedUrl($this->configuration->get('site::URL'). 'rss2')
            ->withSiteUrl($this->configuration->get('site::URL'))
            ->withDate(new \DateTime());

        $posts = $this->posts->loadAll();

        foreach ($posts as $post) {
            $feedBuilder
                ->withItem(Rss20ItemBuilder::create($feedBuilder)
                    ->withTitle($post->text)
                    ->withUrl($this->posts->findUrlFor($post))
                    ->withAuthor($this->configuration->get('site::author'), $this->configuration->get('site::authorEmail'))
                    ->withPublishedDate(\DateTime::createFromImmutable($post->day))
                    ->withSummary($post->text)
                    ->withContent($post->text)
                );
        }

        $response = new Response();
        $response->getBody()->write(
            $feedBuilder->build()
        );
        return $response;
    }

    public function atom(ServerRequestInterface $request): ResponseInterface
    {
        $feedBuilder = AtomFeedBuilder::create()
            ->withTitle($this->configuration->get('site::title'))
            ->withAuthor($this->configuration->get('site::author'), $this->configuration->get('site::authorEmail'))
            ->withFeedUrl($this->configuration->get('site::URL'). 'atom')
            ->withSiteUrl($this->configuration->get('site::URL'))
            ->withDate(new \DateTime());

        $posts = $this->posts->loadAll();

        foreach ($posts as $post) {
            $feedBuilder
                ->withItem(AtomItemBuilder::create($feedBuilder)
                    ->withTitle($post->text)
                    ->withUrl($this->posts->findUrlFor($post))
                    ->withAuthor($this->configuration->get('site::author'), $this->configuration->get('site::authorEmail'))
                    ->withPublishedDate(\DateTime::createFromImmutable($post->day))
                    ->withUpdatedDate(\DateTime::createFromImmutable($post->day))
                    ->withSummary($post->text)
                    ->withContent($post->text)
                );
        }

        $response = new Response();
        $response->getBody()->write(
            $feedBuilder->build()
        );
        return $response;
    }
}