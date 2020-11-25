<?php

use Devbook\utility\Common;
use Devbook\models\Auth;
use Devbook\dao\UserDao;

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();
$userDao = new UserDao($pdo);
$profileId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? $user->getId();

$profileUser = $profileId !== $user->getId()
    ? $userDao->findUserById($profileId, true)
    : $userDao->findUserById($user->getId(), true);

if (empty($profileId)) {
    Common::redirect('friends');
}

Common::renderPartial('header', [
    'title' => 'Friends',
    'user' => $user
]);
Common::renderPartial('menu', ['activeMenu' => 'friends']);
Common::renderFlash();
?>

    <section class="feed mt-10">
        <section class="feed">

            <?php Common::renderPartial('profile-header', [
                'profileUser' => $profileUser
            ]) ?>

            <?php Common::renderPartial('friends', ['profileUser' => $profileUser]) ?>
        </section>
    </section>

<?php
Common::renderPartial('footer');
