<?php

use Devbook\models\Auth;
use Devbook\functions\{
    Common,
    CommonDate
};

require 'config/config.php';

$auth = new Auth($pdo);

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);

if ($name && $email && $password && $birthdate) {
    $birthdate = CommonDate::americanDateConvert($birthdate);

    if (!empty($birthdate)) {
        if (!$auth->emailExists($email)) {
            if ($auth->registerUser($name, $email, $password, $birthdate)) {
                Common::flash(FLASH_SUCCESS, "Bem vindo(a) $name!");
                Common::redirect();
            } else {
                Common::flash(FLASH_ERROR, 'Falha ao realizar cadastro!');
                Common::redirect('signup');
            }
        } else {
            Common::flash(FLASH_ERROR, 'Este e-mail já está cadastrado');
            Common::redirect('signup');
        }
    } else {
        Common::flash(FLASH_ERROR, 'Data inválida!');
        Common::redirect('signup');
    }
}

Common::flash(FLASH_ERROR, 'Os campos não foram preenchidos corretamente');
Common::redirect('signup');
