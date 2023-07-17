<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $configuration->get('site::title') ?></title>
    <link rel="stylesheet" href="/style.css">
    <link rel="alternate" type="application/rss+xml" href="/rss2">
    <link rel="alternate" type="application/atom+xml" href="/atom">
    <script>

        const removeListeners = () => {
            document.getElementById('M').removeEventListener('click', hideModal)
            document.querySelector('body').removeEventListener('keydown', hideModalEsc)
        }

        const unFillModal = (modal) => {
            modal.querySelector('source[type="image/avif"]').setAttribute('srcset', '')
            modal.querySelector('source[type="image/webp"]').setAttribute('srcset', '')
            modal.querySelector('img').setAttribute('src', '')
        }

        const hideModal = (event) => {
            const modal = document.getElementById('M')
            modal.classList.add('hidden')
            unFillModal(modal)
            removeListeners()
        }
        const hideModalEsc = (event) => {
            if (event.keyCode === 27) {
                const modal = document.getElementById('M')
                modal.classList.add('hidden')
                unFillModal(modal)
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
                if (event.target.matches('img') && !event.target.classList.contains('inModal')) {
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
            <nav>
                <span><a href="/add">add</a></span>
                <span><a href="/atom">atom</a>/<a href="/rss2">rss2</a></span>
                <span><a href="https://github.com/jandanielcz/positive">source</a></span>
                <?php if(isset($showLogout) && $showLogout): ?>
                    <span><a href="/logout">logout</a></span>
                <?php endif; ?>
            </nav>
        </header>


        <section>
            <?=$this->section('content')?>
        </section>

        <?= $this->insert('pagination', ['pagination' => $pagination ?? null]) ?>
    </div>
    <div id="M" class="hidden">
        <div class="frame">
            <picture>
                <source type="image/avif" srcset="" />
                <source type="image/webp" srcset="" />
                <img class="inModal" src="" alt="Photo">
            </picture>
        </div>
    </div>
</body>
</html>