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
$profileId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? $user->getId();

$profileUser = $profileId !== $user->getId()
    ? $userDao->findUserById($profileId, true)
    : $userDao->findUserById($user->getId(), true);

$feed = $postDao->getProfileFeed($profileId);

if (empty($feed)) {
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
                'profileUser' => $profileUser
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

                        foreach ($feed as $feedItem) {
                            Common::renderPartial('feed', [
                                'user' => $user,
                                'feed' => $feedItem
                            ]);
                        }
                    ?>

                </div>
            </div>
        </section>
    </section>

<?php
Common::renderPartial('footer');
