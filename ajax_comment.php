<?php

require 'config/config.php';

use Devbook\dao\PostCommentDao;
use Devbook\models\{
    Auth,
    PostComment
};

$postCommentDao = new postCommentDao($pdo);
$user = (new Auth($pdo))->verifyToken();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$txt = filter_input(INPUT_POST, 'txt', FILTER_SANITIZE_STRING);

$retorno = [
    'error' => true
];

if ($id && $txt) {
    $newComment = new PostComment();
    $newComment->setPostId($id);
    $newComment->setBody($txt);
    $newComment->setUserId($user->getId());
    $newComment->setCreatedAt(date('Y-m-d H:i:s'));

    if ($postCommentDao->addComment($newComment)) {
        $retorno = [
            'error' => false,
            'link' => BASE . "/profile?id={$user->getId()}",
            'avatar' => BASE . "/media/avatars/{$user->getAvatar()}",
            'name' => $user->getName(),
            'body' => $txt,
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($retorno);
exit;
