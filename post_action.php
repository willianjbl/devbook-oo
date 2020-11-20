<?php

use Devbook\dao\PostDao;
use Devbook\utility\Common;
use Devbook\models\{
    Auth,
    Post
};

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken();

$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);

if ($body) {
    $postDao = new PostDao($pdo);
    $createdAt = new DateTime();
    $createdAt = $createdAt->format('Y-m-d H:i:s');

    $newPost = new Post();
    $newPost->setUserId($user->getId());
    $newPost->setType('text');
    $newPost->setBody($body);
    $newPost->setCreatedAt($createdAt);

    if (!$postDao->insert($newPost)) {
        Common::flash(FLASH_ERROR, 'Erro ao postar no feed!');
    }
}

Common::redirect();
