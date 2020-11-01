<?php

namespace Devbook\interfaces;

use Devbook\models\User;

interface UserInterface
{
    function findUserByToken(string $token): User;
}
