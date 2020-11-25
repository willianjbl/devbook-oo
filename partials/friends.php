<div class="row">
    <div class="column">
        <div class="box">
            <div class="box-body">
                <div class="tabs">
                    <div class="tab-item" data-for="followers">
                        Seguidores
                    </div>
                    <div class="tab-item active" data-for="following">
                        Seguindo
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-body" data-item="followers">

                        <?= empty($profileUser->followers) ? '<p style="text-align: center;">Este perfil não possui nenhum seguidor.</p>' : '' ?>

                        <div class="full-friend-list">

                            <?php foreach($profileUser->followers as $follower): ?>
                                <div class="friend-icon">
                                    <a href="<?= BASE ?>/profile.php?id=<?= $follower->user->getId() ?>">
                                        <div class="friend-icon-avatar">
                                            <img src="<?= BASE ?>/media/avatars/<?= $follower->user->getAvatar() ?>"  alt=""/>
                                        </div>
                                        <div class="friend-icon-name">
                                            <?= $follower->user->getName() ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                    <div class="tab-body" data-item="following">

                        <?= empty($profileUser->followings) ? '<p style="text-align: center;">Este perfil não está seguindo ninguém.</p>' : '' ?>

                        <div class="full-friend-list">

                            <?php foreach($profileUser->followings as $following): ?>
                                <div class="friend-icon">
                                    <a href="<?= BASE ?>/profile.php?id=<?= $following->user->getId() ?>">
                                        <div class="friend-icon-avatar">
                                            <img src="<?= BASE ?>/media/avatars/<?= $following->user->getAvatar() ?>" alt="" />
                                        </div>
                                        <div class="friend-icon-name">
                                            <?= $following->user->getName() ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
