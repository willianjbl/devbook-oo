<?php

require 'config/config.php';

use Devbook\dao\{
    UserRelationDao,
    UserDao
};
use Devbook\models\Auth;

$userRelationDao = new UserRelationDao($pdo);
$userId = (new Auth($pdo))->verifyToken()->getId();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    if (!(new UserDao($pdo))->findUserById($id)->isEmpty()) {
        if ($userRelationDao->isFollowing($userId, $id)) {
            $userRelationDao->delete($userId, $id);
        } else {
            $userRelationDao->insert($userId, $id);
        }
    }
}

header('Location: ' . BASE . "/profile.php?id=$id");
exit;
