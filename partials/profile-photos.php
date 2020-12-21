<?php if (count($profileUser->photos) > 0): ?>
    <div class="box">
        <div class="box-header m-10">
            <div class="box-header-text">
                Fotos
                <span>(<?= count($profileUser->photos) ?>)</span>
            </div>
            <div class="box-header-buttons">
                <a href="<?= BASE ?>/photos.php?id=<?= $profileUser->getId() ?>">ver todos</a>
            </div>
        </div>
        <div class="box-body row m-20">

            <?php for ($i = 0; $i < 4; $i++): ?>
                <?php if (!empty($profileUser->photos[$i]->body)): ?>
                    <div class="user-photo-item">
                        <a href="<?= BASE ?>/media/uploads/<?= $profileUser->photos[$i]->body ?>" class="glightbox" data-gallery="Minha Galeria">
                            <img src="<?= BASE ?>/media/uploads/<?= $profileUser->photos[$i]->body ?>"  alt="photo"/>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>

        </div>
    </div>
<?php endif; ?>
