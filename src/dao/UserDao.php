<?php

namespace Devbook\dao;

use PDO;
use stdClass;
use Devbook\models\User;
use Devbook\interfaces\UserInterface;

class UserDao implements UserInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    private function generateUser(User $newUser, StdClass $user): User
    {
        $newUser->setId($user->id ?? null);
        $newUser->setName($user->name ?? null);
        $newUser->setEmail($user->email ?? null);
        $newUser->setPassword($user->password ?? null);
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
        $user->bindParam(':TOKEN', $token, PDO::PARAM_STR);
        $user->execute();
        $newUser = new User();

        if ($user->rowCount() > 0) {
            $user = $user->fetch();
            $newUser = $this->generateUser($newUser, $user);
        }
        return $newUser;
    }

    public function checkLogin($email, $password): User
    {
        $user = $this->pdo->prepare('SELECT * FROM users WHERE email = :EMAIL');
        $user->bindParam(':EMAIL', $email, PDO::PARAM_STR);
        $user->execute();
        $newUser = new User();

        if ($user->rowCount() > 0) {
            $user = $user->fetch();

            if (password_verify($password, $user->password)) {
                $newUser = $this->generateUser($newUser, $user);
            }
        }
        return $newUser;
    }

//    public function registerToken(string $token, int $id): void
//    {
//        $query = $this->pdo->prepare('UPDATE users SET token = :TOKEN WHERE id = :ID');
//        $query->bindParam(':TOKEN', $token, PDO::PARAM_STR);
//        $query->bindParam(':ID', $id, PDO::PARAM_INT);
//        if ($query->execute()) {
//            Session::set('TOKEN', $token);
//        }
//    }

    public function update(User $user): bool
    {
        $query = $this->pdo->prepare(
            'UPDATE users
            SET email       = :EMAIL,
                password    = :PASSWORD,
                name        = :NAME,
                city        = :CITY,
                birthdate   = :BIRTHDATE,
                work        = :WORK,
                avatar      = :AVATAR,
                cover       = :COVER,
                token       = :TOKEN
            WHERE 
                id          = :ID'
        );

        $query->bindValue(':ID', $user->getId(), PDO::PARAM_INT);
        $query->bindValue(':EMAIL', $user->getEmail(), PDO::PARAM_STR);
        $query->bindValue(':PASSWORD', $user->getPassword(), PDO::PARAM_STR);
        $query->bindValue(':NAME', $user->getName(), PDO::PARAM_STR);
        $query->bindValue(':CITY', $user->getCity(), PDO::PARAM_STR);
        $query->bindValue(':BIRTHDATE', $user->getBirthdate(), PDO::PARAM_STR);
        $query->bindValue(':WORK', $user->getWork(), PDO::PARAM_STR);
        $query->bindValue(':COVER', $user->getCover(), PDO::PARAM_STR);
        $query->bindValue(':AVATAR', $user->getAvatar(), PDO::PARAM_STR);
        $query->bindValue(':TOKEN', $user->getToken(), PDO::PARAM_STR);
        return $query->execute();
    }
}
