<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $configuration->get('site::title') ?></title>
    <link rel="stylesheet" href="/style.css">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('body').addEventListener('click', (event) => {
                if (event.target.matches('img')) {
                    console.log('open modal')
                }
            })
        })
    </script>
</head>
<body>
    <div id="W">
        <header>
            <h1>
                <a href="<?= $configuration->get('site::URL') ?>">
                    <?= $configuration->get('site::title') ?>
                </a>
            </h1>
            <h2>
                <?= $configuration->get('site::subtitle') ?>
            </h2>
        </header>
        <nav>
            <a href="/add">+</a>
            <a href="/feed">feed</a>
            <a href="https://github.com/jandanielcz/positive">opensourced</a>
        </nav>
        <section>
            <?=$this->section('content')?>
        </section>
    </div>
</body>
</html>