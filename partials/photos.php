<?php if (count($profileUser->photos) > 0): ?>
    <div class="row">
        <div class="column">
            <div class="box">
                <div class="box-body">
                    <div class="full-user-photos">

                        <?php foreach ($profileUser->photos as $key => $photo): ?>
                            <div class="user-photo-item">
                                <a href="<?= BASE ?>/media/uploads/<?= $photo->body ?>" class="glightbox" data-gallery="Minha Galeria">
                                    <img src="<?= BASE ?>/media/uploads/<?= $photo->body ?>"  alt="photo"/>
                                </a>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>