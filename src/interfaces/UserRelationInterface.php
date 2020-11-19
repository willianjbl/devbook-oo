<?php

namespace Devbook\interfaces;

use Devbook\models\UserRelation;

interface UserRelationInterface
{
    public function listRelationsFrom(int $id): array;
    public function insert(UserRelation $userRelation): bool;
    public function delete(UserRelation $userRelation): bool;
}
