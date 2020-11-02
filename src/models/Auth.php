<?php

namespace Devbook\models;

use Devbook\dao\UserDao;
use Devbook\functions\Common;
use PDO;

class Auth
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    public function verifyToken(): User
    {
        $userDao = new UserDao($this->pdo);
        $user = $userDao->findUserByToken(Session::get('TOKEN'));

        if ($user->isEmpty()) {
            Common::redirect('login');
        }
        return $user;
    }

    public function verifyLogin($email, $password): bool
    {
        $userDao = new UserDao($this->pdo);
        $user = $userDao->checkLogin($email, $password);

        if (!$user->isEmpty()) {
            $token = md5(time() . rand(0, 99999) . $user->getEmail());
            $user->setToken($token);

            if ($userDao->update($user)) {
                Session::set('TOKEN', $token);
            }
        }
        return !empty(Session::get('TOKEN'));
    }
}
