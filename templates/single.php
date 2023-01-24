<?php
    $this->layout('layout', ['configuration' => $configuration]);

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
    <figure>
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'avif', 'q' => 90, 'w' => $small]) ?>">
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'webp', 'q' => 90, 'w' => $small]) ?>">
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'jpg', 'q' => 90, 'w' => $small]) ?>">
        <hr>
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'avif', 'q' => 90, 'w' => $list]) ?>">
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'webp', 'q' => 90, 'w' => $list]) ?>">
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'jpg', 'q' => 90, 'w' => $list]) ?>">
        <hr>
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'avif', 'q' => 90, 'w' => $full]) ?>">
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'webp', 'q' => 90, 'w' => $full]) ?>">
        <img src="<?= $urlBuilder->getUrl($post->picture, ['fit'=> 'max', 'fm' => 'jpg', 'q' => 90, 'w' => $full]) ?>">

    </figure>
</article>
