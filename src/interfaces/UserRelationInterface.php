<?php

namespace Devbook\interfaces;

use Devbook\models\UserRelation;

interface UserRelationInterface
{
    public function listRelationsFrom(int $id): array;
    public function insert(int $userFrom, int $userTo): bool;
    public function delete(int $userFrom, int $userTo): bool;
}
