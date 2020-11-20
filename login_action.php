<?php

use Devbook\utility\Common;
use Devbook\models\Auth;

require 'config/config.php';

$auth = new Auth($pdo);

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if ($email && $password) {
    if ($auth->verifyLogin($email, $password)) {
        $user = $auth->verifyToken();
        Common::flash(FLASH_SUCCESS, "Bem-vindo(a) {$user->getName()}!");
        Common::redirect();
    }
    Common::flash(FLASH_ERROR, 'Login ou senha inválidos!');
}

Common::redirect('login');
