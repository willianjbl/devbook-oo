<?php if ($totalPages > 1): ?>
    <div class="paginator">
        <?php for ($i = 1; $i < $totalPages + 1; $i++): ?>
            <?php if ($currentPage === $i): ?>
                <a class="active" href="<?= $url . "p=$i" ?>"><?= $i ?></a>
            <?php else: ?>
                <a href="<?= $url . "p=$i" ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
<?php endif; ?>