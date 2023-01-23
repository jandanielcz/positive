<?php
/**
 * @var \Jandanielcz\Positive\Post $post
 * @var \League\Glide\Urls\UrlBuilder $urlBuilder
 */

?>
<article id="<?= $post->id() ?>">
    <aside>
        <p class="day"><?= $post->day->format('Y-m-d') ?></p>
    </aside>
    <p>
        <?= $this->e($post->text) ?>
    </p>
    <figure>

        <picture>
            <source media="(max-width: 480px)" type="image/avif" srcset="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'avif', 'q' => 90, 'w' => 480]) ?>" />
            <source media="(max-width: 480px)" type="image/webp" srcset="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'webp', 'q' => 90, 'w' => 480]) ?>" />
            <source media="(max-width: 480px)" srcset="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'jpg', 'q' => 90, 'w' => 480]) ?>" />
            <source type="image/avif" srcset="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'avif', 'q' => 90, 'w' => 640]) ?>" />
            <source type="image/webp" srcset="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'webp', 'q' => 90, 'w' => 640]) ?>" />
            <img src="<?= $urlBuilder->getUrl($post->picture, ['w' => 640, 'q' => 90]) ?>" alt="Photo" loading="lazy"
                data-avif="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'avif', 'q' => 90]) ?>"
                data-webp="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'webp', 'q' => 90]) ?>"
                data-jpg="<?= $urlBuilder->getUrl($post->picture, ['fm' => 'jpg', 'q' => 90]) ?>"
            >
        </picture>

    </figure>
</article>