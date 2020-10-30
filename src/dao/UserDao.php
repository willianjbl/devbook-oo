<?php

namespace Devbook\dao;

use Devbook\interfaces\UserInterface;
use Devbook\models\User;

class UserDao implements UserInterface
{
    public function findUserByToken(string $token): User
    {
        // TODO: Implement findUserByToken() method.
    }
}
