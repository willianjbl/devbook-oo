<?php

use Devbook\functions\Common;
use Devbook\models\Auth;

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();

$postDao = new \Devbook\dao\PostDao($pdo);
print_r($postDao->getHomeFeed($user->getId()));
exit;


Common::renderPartial('header', [
    'title' => 'Feed',
    'user' => $user
]);
Common::renderPartial('menu', ['activeMenu' => 'home']);
Common::renderFlash();
?>

<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">
            <?php Common::renderPartial('new-post', ['user' => $user]); ?>
            <?php Common::renderPartial('feed', ['user' => $user]); ?>
        </div>
        <div class="column side pl-5">
            <?php Common::renderPartial('notifications'); ?>
        </div>
    </div>
</section>

<?php
Common::renderPartial('footer');
