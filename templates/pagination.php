<?php if($pagination): ?>
    <div class="pagination">
        <?php for($i = 1; $i <= $pagination['max']; $i++): ?>
            <a href="/?page=<?= $i ?>" <?php if($pagination['current'] === $i): ?>class="current"<?php endif; ?>><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>