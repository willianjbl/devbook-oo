<?php

namespace Devbook\dao;

use PDO;
use Devbook\models\UserRelation;
use Devbook\interfaces\UserRelationInterface;

class UserRelationDao implements UserRelationInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    public function listRelationsFrom(int $id): array
    {
        $users = [$id];

        $query = $this->pdo->prepare('SELECT user_to FROM user_relations WHERE user_to = :ID');
        $query->bindParam(':ID',$id, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll() as $value) {
                $users[] = $value->user_to;
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
