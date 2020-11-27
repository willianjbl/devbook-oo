<?php

use Devbook\utility\{
    Common,
    CommonDate
};
use Devbook\models\Auth;
use Devbook\dao\UserDao;

require 'config/config.php';

$auth = new Auth($pdo);
$user = $auth->verifyToken(true);

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$rePassword = filter_input(INPUT_POST, 'repassword', FILTER_SANITIZE_STRING);
$birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
$work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_STRING);

if ($name && $email && $birthdate) {
    $userDao = new UserDao($pdo);
    $birthdate = CommonDate::americanDateConvert($birthdate);
    $user->setName($name);
    $user->setCity($city);
    $user->setWork($work);

    if (!empty($birthdate)) {
        if ($birthdate !== $user->getBirthdate()) {
            $user->setBirthDate($birthdate);
        }
    } else {
        Common::flash(FLASH_ERROR, 'Data inválida!');
    }
    if (!empty($password)) {
        if ($password === $repassword) {
            if (!password_verify($password, $user->getPassword())) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $user->setPassword($password);
            }
        } else {
            Common::flash(FLASH_ERROR, 'As senhas não coincidem!');
        }
    }
    if ($email !== $user->getEmail()) {
        if (!$userDao->findUserByEmail($email)) {
            $user->setEmail($email);
        } else {
            Common::flash(FLASH_ERROR, 'Este e-mail já está cadastrado!');
        }
    }
    if ($userDao->update($user)) {
        Common::flash(FLASH_SUCCESS, 'Dados alterados com sucesso!');
        Common::redirect('settings');
    } else {
        Common::flash(FLASH_ERROR, 'Houve um erro interno!');
    }
    Common::redirect('settings');
}
