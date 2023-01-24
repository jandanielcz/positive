<?php
    $pagination = (isset($pagination)) ? $pagination : null;
    $this->layout('layout', ['configuration' => $configuration, 'pagination' => $pagination])
?>

<?php foreach ($posts as $post): ?>
    <?= $this->insert('post', ['post' => $post, 'configuration' => $configuration, 'lazy' => true, 'urlBuilder' => $urlBuilder]) ?>
<?php endforeach; ?>
