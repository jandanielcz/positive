<?php
    $this->layout('layout', ['configuration' => $configuration, 'showLogout' => true])
?>

<form action="" method="post" enctype="multipart/form-data">
    <?php //TODO: CSRF ?>
    <label for="day">Day</label>
    <input type="date" name="day" id="day" value="<?= date('Y-m-d') ?>">
    <label for="text">Text</label>
    <input type="text" name="text" id="text">
    <label for="picture">Picture</label>
    <input type="file" name="picture" id="picture" accept="image/*">
    <input type="submit" value="Upload">
</form>
