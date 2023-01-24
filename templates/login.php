<?php
    $this->layout('layout', ['configuration' => $configuration])
?>

<?php if (isset($_GET['msg'])): ?>
<?php
    $content = [
            'notConfigured' => 'You need to first setup password. See README.',
            'wrongPassword' => 'Wrong username or password.',
    ]
?>
<p class="message">
    <?= $content[$_GET['msg']] ?>
</p>
<?php endif ?>

<form action="/login" method="post">
    <label for="login">Login</label>
    <input type="text" name="login" id="login">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <input type="submit" value="Login">
</form>
