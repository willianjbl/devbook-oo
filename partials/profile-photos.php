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

            <?php for ($i = 0; $i < 6; $i++): ?>
                <?php if (!empty($profileUser->photos[$i]->getBody())): ?>
                    <div class="user-photo-item">
                        <a href="#modal-<?= $i ?>" rel="modal:open">
                            <img src="<?= BASE ?>/media/uploads/<?= $profileUser->photos[$i]->getBody() ?>"  alt="<?= $profileUser->photos[$i]->getBody() ?>"/>
                        </a>
                        <div id="modal-<?= $i ?>" style="display:none">
                            <img src="<?= BASE ?>/media/uploads/<?= $profileUser->photos[$i]->getBody() ?>>"  alt="<?= $profileUser->photos[$i]->getBody() ?>"/>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>

        </div>
    </div>
<?php endif; ?>
