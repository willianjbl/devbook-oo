<?php

require 'config/config.php';

use Devbook\utility\Common;
use Devbook\dao\PostDao;
use Devbook\models\Auth;

$postDao = new PostDao($pdo);
$user = (new Auth($pdo))->verifyToken();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    if ($postDao->findById($id)) {
        if ($postDao->delete($id, $user->getId())) {
            Common::flash(FLASH_SUCCESS, 'O post foi excluído');
            Common::redirect('index');
            exit;
        }
        Common::flash(FLASH_WARNING, 'Falha ao excluir o post.');
        Common::redirect('index');
        exit;
    }
    Common::flash(FLASH_WARNING, 'O post não foi encontrado.');
    Common::redirect('index');
    exit;
}
Common::flash(FLASH_ERROR, 'ID inválido.');
Common::redirect('index');
exit;
