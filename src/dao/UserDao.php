<?php

namespace Devbook\dao;

use PDO;
use Devbook\models\User;
use Devbook\interfaces\UserInterface;
use Devbook\utility\CommonValidation;

class UserDao implements UserInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    private function generateUser(
        User $newUser,
        \StdClass $user,
        bool $returnPass = false,
        bool $returnRelated = false
    ): User {
        if ($returnPass) {
            $newUser->setPassword($user->password ?? null);
        }
        $newUser->setId($user->id ?? null);
        $newUser->setName($user->name ?? null);
        $newUser->setEmail($user->email ?? null);
        $newUser->setBirthdate($user->birthdate ?? null);
        $newUser->setCity($user->city ?? null);
        $newUser->setWork($user->work ?? null);
        $newUser->setAvatar($user->avatar ?? null);
        $newUser->setCover($user->cover ?? null);
        $newUser->setToken($user->token ?? null);

        if ($returnRelated) {
            $userRelationDao = new UserRelationDao($this->pdo);
            $postDao = new PostDao($this->pdo);
            $newUser->followings = $userRelationDao->getFollowings($newUser->getId());
            $newUser->followers = $userRelationDao->getFollowers($newUser->getId());
            $newUser->photos = $postDao->getPhotosFrom($newUser->getId());
        }
        return $newUser;
    }

    public function findUserByToken(string $token, bool $returnPass = false): User
    {
        $user = $this->pdo->prepare('SELECT * FROM users WHERE token = :TOKEN');
        $user->bindParam(':TOKEN', $token, PDO::PARAM_STR);
        $user->execute();
        $newUser = new User();

        if ($user->rowCount() > 0) {
            $user = $user->fetch();
            $newUser = $this->generateUser($newUser, $user, $returnPass);
        }
        return $newUser;
    }

    public function findUserByEmail(string $email): bool
    {
        $emailbd = $this->pdo->prepare('SELECT email FROM users WHERE email = :EMAIL');
        $emailbd->bindParam(':EMAIL', $email, PDO::PARAM_STR);
        $emailbd->execute();

        return $emailbd->rowCount() > 0;
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
                $newUser = $this->generateUser($newUser, $user, true);
            }
        }
        return $newUser;
    }

    public function update(User $user): bool
    {
        $query = $this->pdo->prepare('
            UPDATE  users
            SET     email       = :EMAIL,
                    password    = :PASSWORD,
                    name        = :NAME,
                    city        = :CITY,
                    birthdate   = :BIRTHDATE,
                    work        = :WORK,
                    avatar      = :AVATAR,
                    cover       = :COVER,
                    token       = :TOKEN
            WHERE   id          = :ID
        ');

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

        return CommonValidation::validateQuery($query);
    }

    public function insert(User $user): bool
    {
        $query = $this->pdo->prepare('
            INSERT INTO users (
                name, email, password, birthdate, token
            )
            VALUES (
                :NAME, :EMAIL, :PASSWORD, :BIRTHDATE, :TOKEN
            )
        ');

        $query->bindValue(':NAME', $user->getName(), PDO::PARAM_STR);
        $query->bindValue(':EMAIL', $user->getEmail(), PDO::PARAM_STR);
        $query->bindValue(':PASSWORD', $user->getPassword(), PDO::PARAM_STR);
        $query->bindValue(':BIRTHDATE', $user->getBirthdate(), PDO::PARAM_STR);
        $query->bindValue(':TOKEN', $user->getToken(), PDO::PARAM_STR);

        return CommonValidation::validateQuery($query);
    }

    public function findUserById(int $id, bool $returnRelation = false): User
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE id = :ID');
        $query->bindParam(':ID', $id, PDO::PARAM_INT);
        $query->execute();
        $newUser = new User();

        if ($query->rowCount() > 0) {
            $newUser = $this->generateUser($newUser, $query->fetch(), false, $returnRelation);
        }
        return $newUser;
    }

    public function searchUsers($searchTerm, int $loggedUserId): array
    {
        $result = [];
        $query = $this->pdo->prepare('
            SELECT DISTINCT id, name, avatar
            FROM users
            WHERE name LIKE :NAME AND
                  id     != :ID
        ');
        $query->bindValue(':NAME', "%$searchTerm%", PDO::PARAM_STR);
        $query->bindParam(':ID', $loggedUserId, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll() as $user) {
                $newUser = new User();
                $result[] = $this->generateUser($newUser, $user);
            }
        }
        return $result;
    }
}
