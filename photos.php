<?php

use Devbook\utility\Common;
use Devbook\models\Auth;
use Devbook\dao\{
    UserDao,
    UserRelationDao,
};

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();
$userDao = new UserDao($pdo);
$profileId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? $user->getId();
$isFollowing = (new UserRelationDao($pdo))->isFollowing($user->getId(), $profileId);

$profileUser = $profileId !== $user->getId()
    ? $userDao->findUserById($profileId, true)
    : $userDao->findUserById($user->getId(), true);

Common::renderPartial('header', [
    'title' => 'Photos',
    'user' => $user
]);

if (empty($profileId)) {
    Common::redirect('photos');
}

Common::renderPartial('menu', ['activeMenu' => 'photos']);
Common::renderFlash();
?>

    <section class="feed mt-10">
        <section class="feed">

            <?php
                Common::renderPartial('profile-header', [
                    'profileUser' => $profileUser,
                    'user' => $user,
                    'isFollowing' => $isFollowing
                ]);
                Common::renderPartial('photos', ['profileUser' => $profileUser]);
            ?>

        </section>
    </section>

<?php
Common::renderPartial('footer');
