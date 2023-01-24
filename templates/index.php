<?php
    $this->layout('layout', ['configuration' => $configuration])
?>

<?php foreach ($posts as $post): ?>
    <?= $this->insert('post', ['post' => $post, 'configuration' => $configuration, 'lazy' => true, 'urlBuilder' => $urlBuilder]) ?>
<?php endforeach; ?>
