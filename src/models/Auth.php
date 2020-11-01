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

        if (empty(Session::get('TOKEN'))) {
            Common::redirect('login');
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
}
