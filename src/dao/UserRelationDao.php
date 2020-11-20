<?php

namespace Devbook\dao;

use Devbook\interfaces\UserRelationInterface;
use Devbook\models\{
    Session,
    UserRelation
};
use PDO;

class UserRelationDao implements UserRelationInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    public function getFollowers(int $id): array
    {
        $users = [];
        $userDao = new UserDao($this->pdo);

        $query = $this->pdo->prepare('SELECT user_from FROM user_relations WHERE user_to = :ID');
        $query->bindParam(':ID', $id, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            $userRelation = new \StdClass;
            foreach ($query->fetchAll() as $row) {
                $userRelation->user = $userDao->findUserById($row->user_from);
                $users[] = $userRelation;
            }
        }
        return $users;
    }

    public function getFollowings(int $id): array
    {
        $users = [];
        $userDao = new UserDao($this->pdo);
        $loggedUserId = $userDao->findUserByToken(Session::get('TOKEN'))->getId();

        $query = $this->pdo->prepare('
            SELECT user_to FROM user_relations WHERE user_from = :ID');
        $query->bindParam(':ID', $id, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            $userRelation = new \StdClass;

            foreach ($query->fetchAll() as $row) {
                $userRelation->following = false;
                $userRelation->user = $userDao->findUserById($row->user_to);

                if ((int)$row->user_to === $loggedUserId) {
                    $userRelation->following = true;
                }
                $users[] = $userRelation;
            }
        }
        return $users;
    }

    public function listRelationsFrom(int $id): array
    {
        $users = [$id];

        $query = $this->pdo->prepare('SELECT user_to FROM user_relations WHERE user_from = :ID');
        $query->bindParam(':ID',$id, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll() as $row) {
                $users[] = $row->user_to;
            }
        }
        return $users;
    }

    public function insert(UserRelation $userRelation): bool
    {
        // TODO: Implement insert() method.
    }

    public function delete(UserRelation $userRelation): bool
    {
        // TODO: Implement delete() method.
    }
}
