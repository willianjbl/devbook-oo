<?php

namespace Devbook\dao;

use Devbook\interfaces\UserInterface;
use Devbook\models\User;
use PDO;
use stdClass;

class UserDao implements UserInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (!empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    private function generateUser(User $newUser, StdClass $user): User
    {
        $newUser->setId($user->id ?? null);
        $newUser->setName($user->name ?? null);
        $newUser->setEmail($user->email ?? null);
        $newUser->setBirthdate($user->birthdate ?? null);
        $newUser->setCity($user->city ?? null);
        $newUser->setWork($user->work ?? null);
        $newUser->setAvatar($user->avatar ?? null);
        $newUser->setCover($user->cover ?? null);

        return $newUser;
    }

    public function findUserByToken(string $token): User
    {
        $user = $this->pdo->prepare('SELECT * FROM users WHERE token = :TOKEN');
        $user->bindParam(':TOKEN', $token);
        $user->execute();
        $newUser = new User();

        if ($user->rowCount() > 0) {
            $user = $user->fetch();
            $newUser = $this->generateUser($newUser, $user);
        }
        return $newUser;
    }
}
