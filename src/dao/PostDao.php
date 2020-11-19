<?php

namespace Devbook\dao;

use PDO;
use Devbook\models\Post;
use Devbook\interfaces\PostInterface;
use Devbook\functions\CommonValidation;

class PostDao implements PostInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    private function generatePost(Post $newPost, \StdClass $post): Post
    {
        $newPost->setId($post->id ?? null);
        $newPost->setUserId($post->user_id ?? null);
        $newPost->setType($post->type ?? null);
        $newPost->setBody($post->body ?? null);
        $newPost->setCreatedAt($post->created_at ?? null);

        return $newPost;
    }

    public function insert(Post $post): bool
    {
        $query = $this->pdo->prepare('
            INSERT INTO posts (
                user_id, type, body, created_at
            )
            VALUES (
                :USER_ID, :TYPE, :BODY, :CREATED_AT
            ) 
        ');

        $query->bindValue('USER_ID', $post->getUserId(), PDO::PARAM_INT);
        $query->bindValue('TYPE', $post->getType(), PDO::PARAM_STR);
        $query->bindValue('BODY', $post->getBody(), PDO::PARAM_STR);
        $query->bindValue('CREATED_AT', $post->getCreatedAt(), PDO::PARAM_STR);
        return CommonValidation::validateQuery($query);
    }

    public function update(Post $post): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(Post $post): bool
    {
        // TODO: Implement delete() method.
    }
}
