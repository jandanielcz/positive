<?php
$pagination = (isset($pagination)) ? $pagination : null;
    $this->layout('layout', ['configuration' => $configuration, 'pagination' => $pagination])
?>

<?php
    $c = 0;
    foreach ($posts as $post):
?>
    <?= $this->insert('post', ['post' => $post, 'configuration' => $configuration, 'lazy' => !(($c < 10)), 'urlBuilder' => $urlBuilder]) ?>
<?php
    $c++;
    endforeach;
?>
