<?php

use Devbook\utility\Common;
use Devbook\models\Auth;
use Devbook\dao\{
    PostDao,
    UserDao,
    UserRelationDao
};

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();
$userDao = new UserDao($pdo);
$postDao = new PostDao($pdo);
$profileId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? $user->getId();

$profileUser = $profileId !== $user->getId()
    ? $userDao->findUserById($profileId, true)
    : $userDao->findUserById($user->getId(), true);

$isFollowing = (new UserRelationDao($pdo))->isFollowing($user->getId(), $profileId);

$page = intval(filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT));
if ($page < 1) {
    $page = 1;
}

$feed = $postDao->getProfileFeed($profileId, $page);
$posts = $feed['feed'];

if (empty($feed) && $profileId !== $user->getId()) {
    Common::redirect('profile');
}

Common::renderPartial('header', [
    'title' => 'Feed',
    'user' => $user
]);
Common::renderPartial('menu', ['activeMenu' => 'profile']);
Common::renderFlash();
?>

<section class="feed mt-10">
    <section class="feed">

        <?php Common::renderPartial('profile-header', [
            'profileUser' => $profileUser,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]) ?>

        <div class="row">
            <div class="column side pr-5">

                <?php Common::renderPartial('profile-details', ['profileUser' => $profileUser]) ?>

            </div>
            <div class="column pl-5">

                <?php
                    Common::renderPartial('profile-photos', ['profileUser' => $profileUser]);

                    if ($profileId === $user->getId()) {
                        Common::renderPartial('new-post', ['user' => $user]);
                    }

                    foreach ($posts as $feedItem) {
                        Common::renderPartial('feed', [
                            'user' => $user,
                            'feed' => $feedItem
                        ]);
                    }

                    Common::renderPartial('paginator', [
                        'url' => $profileId ? BASE . "/profile.php?id=$profileId&" : BASE . '/profile.php?',
                        'totalPages' => $feed['totalPages'],
                        'currentPage' => $feed['currentPage'],
                    ]);
                ?>

            </div>
        </div>
    </section>
</section>

<script src="<?= BASE . '/assets/js/toggle-like.js' ?>"></script>
<script src="<?= BASE . '/assets/js/new-comment.js' ?>"></script>
<script src="<?= BASE . '/assets/js/new-photo.js' ?>"></script>
<script src="<?= BASE . '/assets/js/feed-options.js' ?>"></script>

<?php
Common::renderPartial('footer');
