<?php
    $this->layout('layout', ['configuration' => $configuration])
?>

<?php foreach ($posts as $post): ?>
    <?= $this->insert('post', ['post' => $post]) ?>
<?php endforeach; ?>
