<?php

use Devbook\functions\Common;
use Devbook\models\Auth;

require 'config/config.php';

$auth = new Auth($pdo);

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

if ($email && $password) {
    if ($auth->verifyLogin($email, $password)) {
        Common::redirect();
    }
    Common::flash(FLASH_ERROR, 'Login ou senha inválidos!');
}

Common::redirect('login');
