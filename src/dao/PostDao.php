<?php

namespace Devbook\dao;

use PDO;
use Devbook\models\Post;
use Devbook\interfaces\PostInterface;
use Devbook\utility\CommonValidation;

class PostDao implements PostInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }
    
    public function getProfileFeed(int $userId): array
    {
        $feed = [];
        $userRelationDao = new UserRelationDao($this->pdo);
        $userDao = new UserDao($this->pdo);
        $userList = $userRelationDao->listRelationsFrom($userId);

        $query = $this->pdo->prepare('
            SELECT * FROM posts
            WHERE user_id = :ID
            ORDER BY created_at DESC
        ');
        $query->bindParam(':ID', $userId, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll() as $row) {
                $post = $this->generatePost($row);
                $post->setAuthor($userDao->findUserById($post->getUserId()));
                $post->likeCount = 0;
                $post->comments = [];

                if ($post->getUserId() === $userId) {
                    $post->isAuthor = true;
                }
                $feed[] = $post;
            }
        }
        return $feed;
    }

    public function getHomeFeed(int $loggedUserId): array
    {
        $feed = [];
        $userRelationDao = new UserRelationDao($this->pdo);
        $userDao = new UserDao($this->pdo);
        $userList = $userRelationDao->listRelationsFrom($loggedUserId);

        $query = $this->pdo->query('
            SELECT * FROM posts
            WHERE user_id IN (' . implode(',', $userList) . ')
            ORDER BY created_at DESC
        ');

        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll() as $row) {
                $post = $this->generatePost($row);
                $post->setAuthor($userDao->findUserById($post->getUserId()));
                $post->likeCount = 0;
                $post->comments = [];

                if ($post->getUserId() === $loggedUserId) {
                    $post->isAuthor = true;
                }
                $feed[] = $post;
            }
        }
        return $feed;
    }

    private function generatePost(\StdClass $post): Post
    {
        $newPost = new Post();
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

    public function getPhotosFrom(int $id): array
    {
        $photos = [];

        $query = $this->pdo->prepare("SELECT * FROM posts WHERE type = 'photo' AND user_id = :ID");
        $query->bindParam(':ID', $id, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            $photos = $query->fetchAll();
        }
        return $photos;
    }
}
