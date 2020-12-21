<?php

namespace Devbook\dao;

use Devbook\interfaces\PostLikeInterface;
use PDO;

class PostLikeDao implements PostLikeInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    public function getLikeCount(int $postId): int
    {
        $query = $this->pdo->prepare('SELECT COUNT(*) AS count FROM post_likes WHERE post_id = :ID');
        $query->bindParam('ID', $postId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch()->count;
    }

    public function isLiked(int $postId, int $userId): bool
    {
        $query = $this->pdo->prepare('SELECT * FROM post_likes WHERE post_id = :POST_ID AND user_id = :ID');
        $query->bindParam('POST_ID', $postId, PDO::PARAM_INT);
        $query->bindParam('ID', $userId, PDO::PARAM_INT);
        $query->execute();

        return !empty($query->fetch());
    }

    public function likeToggle(int $postId, int $userId): bool
    {
        if ($this->isLiked($postId, $userId)) {
            $query = $this->pdo->prepare('
                DELETE FROM post_likes
                WHERE post_id = :POST_ID
                  AND user_id = :USER_ID
            ');
        } else {
            $query = $this->pdo->prepare('
                INSERT INTO post_likes (
                    post_id, user_id, created_at
                ) VALUES (
                    :POST_ID, :USER_ID, NOW()
                )
            ');
        }
        $query->bindParam('POST_ID', $postId, PDO::PARAM_INT);
        $query->bindParam('USER_ID', $userId, PDO::PARAM_INT);
        return $query->execute();
    }
}
