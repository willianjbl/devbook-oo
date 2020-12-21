<?php

require 'config/config.php';
use Devbook\dao\PostLikeDao;
use Devbook\models\Auth;

$postLikeDao = new PostLikeDao($pdo);
$userId = (new Auth($pdo))->verifyToken()->getId();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    $postLikeDao->likeToggle($id, $userId);
}
