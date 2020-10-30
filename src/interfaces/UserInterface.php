<?php

namespace Devbook\interfaces;

use Devbook\models\User;

interface UserInterface
{
    public function findUserByToken(string $token): User;
}
