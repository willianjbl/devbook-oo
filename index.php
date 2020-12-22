<?php

use Devbook\dao\PostDao;
use Devbook\utility\Common;
use Devbook\models\Auth;

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();
$postDao = new PostDao($pdo);

$page = intval(filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT));
if ($page < 1) {
    $page = 1;
}
$feed = $postDao->getHomeFeed($user->getId(), $page);
$posts = $feed['feed'];

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

                foreach ($posts as $feedItem) {
                    Common::renderPartial('feed', [
                        'user' => $user,
                        'feed' => $feedItem
                    ]);
                }
            ?>

            <?php
                Common::renderPartial('paginator', [
                    'url' => BASE . '/?',
                    'totalPages' => $feed['totalPages'],
                    'currentPage' => $feed['currentPage'],
                ]);
            ?>

        </div>
        <div class="column side pl-5">

            <?php Common::renderPartial('notifications'); ?>

        </div>
    </div>
</section>

<script src="<?= BASE . '/assets/js/toggle-like.js' ?>"></script>
<script src="<?= BASE . '/assets/js/new-comment.js' ?>"></script>
<script src="<?= BASE . '/assets/js/new-photo.js' ?>"></script>
<script src="<?= BASE . '/assets/js/feed-options.js' ?>"></script>

<?php
Common::renderPartial('footer');
