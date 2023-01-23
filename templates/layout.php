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

        const removeListeners = () => {
            document.getElementById('M').removeEventListener('click', hideModal)
            document.querySelector('body').removeEventListener('keydown', hideModalEsc)
        }

        const hideModal = (event) => {
            document.getElementById('M').classList.add('hidden')
            removeListeners()
        }
        const hideModalEsc = (event) => {
            if (event.keyCode === 27) {
                document.getElementById('M').classList.add('hidden')
                removeListeners()
            }
        }

        const fillModal = (modal, img) => {
            modal.querySelector('source[type="image/avif"]').setAttribute('srcset', img.getAttribute('data-avif'))
            modal.querySelector('source[type="image/webp"]').setAttribute('srcset', img.getAttribute('data-webp'))
            modal.querySelector('img').setAttribute('src', img.getAttribute('data-jpg'))
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('body').addEventListener('click', (event) => {
                if (event.target.matches('img')) {
                    const modal = document.getElementById('M')
                    fillModal(modal, event.target)
                    modal.classList.remove('hidden')
                    modal.addEventListener('click', hideModal)
                    document.querySelector('body').addEventListener('keydown', hideModalEsc)
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
            <span><a href="/add">add content</a></span>
            <span><a href="/atom">atom</a>/<a href="/rss2">rss2</a></span>
            <span><a href="https://github.com/jandanielcz/positive">opensourced</a></span>
        </nav>
        <section>
            <?=$this->section('content')?>
        </section>
    </div>
    <div id="M" class="hidden">
        <div class="frame">
            <picture>
                <source type="image/avif" srcset="" />
                <source type="image/webp" srcset="" />
                <img src="" alt="Photo">
            </picture>
        </div>
    </div>
</body>
</html>