<?php

require 'config/config.php';

use Devbook\utility\CommonFile;
use Devbook\dao\PostDao;
use Devbook\models\{
    Auth,
    Post
};

$postDao = new PostDao($pdo);
$user = (new Auth($pdo))->verifyToken();

$retorno = ['error' => true];

if (!empty(CommonFile::getFile('photo'))) {
    $photo = CommonFile::makeImage(CommonFile::getFile('photo'), 800, 800, 'upload');

    $newPost = new Post();
    $newPost->setBody($photo);
    $newPost->setType('photo');
    $newPost->setCreatedAt(date('Y-m-d H:i:s'));
    $newPost->setUserId($user->getId());
    $postDao->insert($newPost);

    $retorno = ['error' => false];
} else {
    $retorno['message'] = 'Nenhuma imagem foi enviada.';
}

header('Content-Type: application/json');
echo json_encode($retorno);
exit;
