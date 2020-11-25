<?php

use Devbook\utility\Common;
use Devbook\models\Auth;
use Devbook\dao\{
    PostDao,
    UserDao
};

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();
$userDao = new UserDao($pdo);
$postDao = new PostDao($pdo);

$searchTerm = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);

if (empty($searchTerm)) {
    Common::redirect();
}

$searchUsers = $userDao->searchUsers($searchTerm, $user->getId());
$searchPosts = $postDao->searchPosts($searchTerm, $user->getId());

Common::renderPartial('header', [
    'title' => 'Search',
    'user' => $user
]);
Common::renderPartial('menu', ['activeMenu' => 'home']);
Common::renderFlash();
?>

    <section class="feed mt-10">
        <div class="row">
            <div class="column pr-5">
                <div class="box feed-item" style="padding: 15px">
                    <h3>Pesquisar por: <?= $searchTerm ?></h3>
                    <hr>
                    <h3 class="mt-20">Usuários</h3>
                    <div class="full-friend-list">

                        <?php foreach ($searchUsers as $searchUser): ?>
                            <div class="friend-icon">
                                <a href="">
                                    <div class="friend-icon-avatar">
                                        <img src="<?= BASE ?>/media/avatars/<?= $searchUser->getAvatar() ?>"  alt=""/>
                                    </div>
                                    <div class="friend-icon-name">
                                        <?= $searchUser->getName() ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <h3 class="mt-20">Posts</h3>

                    <?php foreach ($searchPosts as $searchPost): ?>
                        <div class="feed-item-head row mt-20 m-width-20">
                            <div class="feed-item-head-photo">
                                <a href="<?= BASE ?>/profile.php?id=<?= $searchPost->id ?>">
                                    <img src="<?= BASE ?>/media/avatars/<?= $searchPost->avatar ?>"  alt="avatar do usuário"/>
                                </a>
                            </div>
                            <div class="feed-item-head-info">
                                <a href="<?= BASE ?>/profile.php?id=<?= $searchPost->id ?>"><span class="fidi-name"><?= $searchPost->name ?></span></a>
                                <span class="fidi-action">Publicou um post</span>
                                <br/>
                                <span class="fidi-date">
                                     <?= \Devbook\utility\CommonDate::brazilianDateTimeConvert($searchPost->created_at) ?>
                                </span>
                            </div>
                        </div>
                        <div class="feed-item-body mt-10 m-width-20">
                            <?= nl2br($searchPost->body) ?>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <div class="column side pl-5">

                <?php Common::renderPartial('notifications'); ?>

            </div>
        </div>
    </section>

<?php
Common::renderPartial('footer');
