<?php if (count($profileUser->photos) > 0): ?>
    <div class="row">
        <div class="column">
            <div class="box">
                <div class="box-body">
                    <div class="full-user-photos">

                        <?php foreach ($profileUser->photos as $photo): ?>
                            <div class="user-photo-item">
                                <a href="#modal-1" rel="modal:open">
                                    <img src="<?= BASE ?>/media/uploads/<?= $photo->getBody() ?>"  alt="<?= $photo->getBody() ?>"/>
                                </a>
                                <div id="modal-1" style="display:none">
                                    <img src="<?= BASE ?>/media/uploads/<?= $photo->getBody() ?>>"  alt="<?= $photo->getBody() ?>"/>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>