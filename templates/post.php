<article>
    <aside>
        <p class="day"><?= $this->e($post->day) ?></p>
    </aside>
    <p>
        <?= $this->e($post->text) ?>
    </p>
    <figure>

        <picture>
            <source media="(max-width: 480px)" type="image/avif" srcset="/image/<?= $post->picture ?>?w=480&q=90&fm=avif" />
            <source media="(max-width: 480px)" type="image/webp" srcset="/image/<?= $post->picture ?>?w=480&q=90&fm=webp" />
            <source media="(max-width: 480px)" srcset="/image/<?= $post->picture ?>?w=480&q=90" />
            <source type="image/avif" srcset="/image/<?= $post->picture ?>?w=640&q=90&fm=avif" />
            <source type="image/webp" srcset="/image/<?= $post->picture ?>?w=640&q=90&fm=webp" />
            <img src="/image/<?= $post->picture ?>?w=640&q=90" alt="Photo" <?= ($lazy) ? 'loading="lazy"' : '' ?>>
        </picture>

    </figure>
</article>