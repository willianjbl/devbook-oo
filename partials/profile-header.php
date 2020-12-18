<div class="row">
    <div class="box flex-1 border-top-flat">
        <div class="box-body">
            <div class="profile-cover" style="background-image: url('<?= BASE ?>/media/covers/<?= $profileUser->getCover() ?>');"></div>
            <div class="profile-info m-20 row">
                <div class="profile-info-avatar">
                    <img src="<?= BASE ?>/media/avatars/<?= $profileUser->getAvatar() ?>" alt=""/>
                </div>
                <div class="profile-info-name">
                    <div class="profile-info-name-text"><?= $profileUser->getName() ?></div>
                    <div class="profile-info-location"><?= $profileUser->getCity() ?? '' ?></div>
                </div>
                <div class="profile-info-data row">
                    <div class="profile-info-item m-width-20">

                        <?php if ($profileUser->getId() !== $user->getId()): ?>
                            <a href="<?= BASE ?>/follow_action.php?id=<?= $profileUser->getId() ?>" class="button"><?= $isFollowing ? 'Deixar de Seguir' : 'Seguir' ?></a>
                        <?php endif; ?>

                    </div>
                    <a href="<?= BASE?>/friends.php?id=<?= $profileUser->getId() ?>">
                        <div class="profile-info-item m-width-20">
                            <div class="profile-info-item-n"><?= count($profileUser->followers) ?></div>
                            <div class="profile-info-item-s">Seguidores</div>
                        </div>
                    </a>
                    <a href="<?= BASE?>/friends.php?id=<?= $profileUser->getId() ?>">
                        <div class="profile-info-item m-width-20">
                            <div class="profile-info-item-n"><?= count($profileUser->followings) ?></div>
                            <div class="profile-info-item-s">Seguindo</div>
                        </div>
                    </a>
                    <a href="<?= BASE?>/photos.php?id=<?= $profileUser->getId() ?>">
                        <div class="profile-info-item m-width-20">
                            <div class="profile-info-item-n"><?= count($profileUser->photos) ?></div>
                            <div class="profile-info-item-s">Fotos</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
