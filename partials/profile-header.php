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
                        <div class="profile-info-item-n"><?= count($profileUser->followers) ?></div>
                        <div class="profile-info-item-s">Seguidores</div>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <div class="profile-info-item-n"><?= count($profileUser->followings) ?></div>
                        <div class="profile-info-item-s">Seguindo</div>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <div class="profile-info-item-n"><?= count($profileUser->photos) ?></div>
                        <div class="profile-info-item-s">Fotos</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
