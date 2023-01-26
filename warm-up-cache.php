<?php

require 'vendor/autoload.php';

$c = \Jandanielcz\Positive\ContainerBuilder::build();

/** @var \League\Glide\Server $glideServer */
$glideServer = $c->get(\League\Glide\Server::class);
/** @var \Jandanielcz\Positive\Posts $posts */
$posts = $c->get(\Jandanielcz\Positive\Posts::class);

$allPosts = $posts->loadAll();

printf('Found %s posts.'.PHP_EOL, count($allPosts));

/** @var \Jandanielcz\Positive\Configuration $config */
$configuration = $c->get(\Jandanielcz\Positive\Configuration::class);
$params = [];

foreach (['jpg', 'webp', 'avif'] as $format) {
    foreach (
        [
            $configuration->get('site::picture::sizes::small'),
            $configuration->get('site::picture::sizes::list'),
            $configuration->get('site::picture::sizes::full'),
        ] as $size) {
        $params[] = ['fit'=> 'max', 'fm' => $format, 'q' => 90, 'w' => $size];
    }
}

foreach ($allPosts as $post) {
    foreach ($params as $param) {
        $glideServer->makeImage($post->picture, $param);
        printf('.');
    }
    printf(PHP_EOL);
}