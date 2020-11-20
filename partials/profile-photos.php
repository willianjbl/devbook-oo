<?php if (count($profileUser->photos) > 0): ?>
    <div class="box">
        <div class="box-header m-10">
            <div class="box-header-text">
                Fotos
                <span>(<?= count($profileUser->photos) ?>)</span>
            </div>
            <div class="box-header-buttons">
                <a href="">ver todos</a>
            </div>
        </div>
        <div class="box-body row m-20">

            <?php foreach ($profileUser->photos as $photo): ?>
                <div class="user-photo-item">
                    <a href="#modal-1" rel="modal:open">
                        <img src="<?= BASE ?>/media/uploads/<?= $photo->getBody() ?>>"  alt="<?= $photo->getBody() ?>"/>
                    </a>
                    <div id="modal-1" style="display:none">
                        <img src="<?= BASE ?>/media/uploads/<?= $photo->getBody() ?>>"  alt="<?= $photo->getBody() ?>"/>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
<?php endif; ?>
