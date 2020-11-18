<?php

namespace Devbook\models;

use Devbook\dao\UserDao;
use Devbook\functions\Common;
use PDO;

class Auth
{
    private PDO $pdo;
    private UserDao $dao;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }

        $this->dao = new UserDao($this->pdo);
    }

    public function verifyToken(): User
    {
        $user = $this->dao->findUserByToken(Session::get('TOKEN'));

        if ($user->isEmpty()) {
            Common::redirect('login');
        }
        return $user;
    }

    public function verifyLogin($email, $password): bool
    {
        $user = $this->dao->checkLogin($email, $password);

        if (!$user->isEmpty()) {
            $token = md5(time() . rand(0, 99999) . $user->getEmail());
            $user->setToken($token);

            if ($this->dao->update($user)) {
                Session::set('TOKEN', $token);
            }
        }
        return !empty(Session::get('TOKEN'));
    }

    public function emailExists(string $email): bool
    {
        return $this->dao->findUserByEmail($email);
    }

    public function registerUser(string $name, string $email, string $password, string $birthdate): bool
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = md5($email . time() . rand(0, 99999));

        $newUser = new User();
        $newUser->setName($name);
        $newUser->setEmail($email);
        $newUser->setPassword($password);
        $newUser->setBirthdate($birthdate);
        $newUser->setToken($token);

        if ($this->dao->insert($newUser)) {
            Session::set('TOKEN', $token);
            return true;
        }
        return false;
    }
}
