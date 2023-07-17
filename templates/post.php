<?php
/**
 * @var \Jandanielcz\Positive\Post $post
 * @var \League\Glide\Urls\UrlBuilder $urlBuilder
 */

$small = $configuration->get('site::picture::sizes::small');
$list = $configuration->get('site::picture::sizes::list');
$full = $configuration->get('site::picture::sizes::full');

?>
<article id="<?= $post->id() ?>">
    <aside>
        <p class="day"><?= $post->day->format('Y-m-d') ?></p>
    </aside>
    <p>
        <?= $this->e($post->text) ?>
    </p>

    <picture>
        <source media="(max-width: 480px)" type="image/avif" srcset="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'avif', 'q' => 90, 'w' => $small]) ?>" />
        <source media="(max-width: 480px)" type="image/webp" srcset="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'webp', 'q' => 90, 'w' => $small]) ?>" />
        <source media="(max-width: 480px)" srcset="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'jpg', 'q' => 90, 'w' => $small]) ?>" />
        <source type="image/avif" srcset="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'avif', 'q' => 90, 'w' => $list]) ?>" />
        <source type="image/webp" srcset="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'webp', 'q' => 90, 'w' => $list]) ?>" />
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'w' => $list, 'q' => 90]) ?>" alt="Photo" loading="lazy"
            data-avif="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'avif', 'q' => 90, 'w' => $full]) ?>"
            data-webp="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'webp', 'q' => 90, 'w' => $full]) ?>"
            data-jpg="<?= $urlBuilder->getUrl($post->picture, ['fit' => 'max', 'fm' => 'jpg', 'q' => 90, 'w' => $full]) ?>"
        >
    </picture>

</article>