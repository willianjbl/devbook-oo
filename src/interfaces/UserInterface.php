<?php

namespace Devbook\interfaces;

use Devbook\models\User;

interface UserInterface
{
    public function checkLogin($email, $password): User;
    public function findUserByToken(string $token): User;
    public function findUserByEmail(string $email): bool;
    public function update(User $user): bool;
    public function insert(User $user): bool;
}
