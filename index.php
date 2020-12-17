<?php

use Devbook\dao\PostDao;
use Devbook\utility\Common;
use Devbook\models\Auth;

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();

$postDao = new PostDao($pdo);
$feed = $postDao->getHomeFeed($user->getId());

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

            <?php
                Common::renderPartial('new-post', ['user' => $user]);

                foreach ($feed as $feedItem) {
                    Common::renderPartial('feed', [
                        'user' => $user,
                        'feed' => $feedItem
                    ]);
                }
            ?>

        </div>
        <div class="column side pl-5">

            <?php Common::renderPartial('notifications'); ?>

        </div>
    </div>
</section>

<script src="<?= BASE . '/assets/js/feed.js' ?>"></script>

<?php
Common::renderPartial('footer');
