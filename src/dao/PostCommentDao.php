<?php

namespace Devbook\dao;

use PDO;
use Devbook\models\PostComment;
use Devbook\interfaces\PostCommentInterface;

class PostCommentDao implements PostCommentInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        if (empty($this->pdo)) {
            $this->pdo = $pdo;
        }
    }

    public function getComments(int $postId): array
    {
        $comments = [];

        $query = $this->pdo->prepare('SELECT * FROM post_comments WHERE post_id = :POST_ID');
        $query->bindParam('POST_ID', $postId, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll(PDO::FETCH_OBJ) as $comment) {
                $newComment = new PostComment();
                $newComment->setId($comment->id);
                $newComment->setPostId($comment->post_id);
                $newComment->setUserId($comment->user_id);
                $newComment->setBody($comment->body);
                $newComment->setCreatedAt($comment->created_at);
                $newComment->user = (new UserDao($this->pdo))->findUserById($comment->user_id);

                $comments[] = $newComment;
            }
        }

        return $comments;
    }

    public function addComment(PostComment $post): bool
    {
        $query = $this->pdo->prepare('
            INSERT INTO post_comments (
               post_id, user_id, body, created_at
            ) VALUES (
                :POST_ID, :USER_ID, :BODY, :CREATED_AT
            ) 
        ');
        $query->bindValue('POST_ID', $post->getPostId());
        $query->bindValue('USER_ID', $post->getUserId());
        $query->bindValue('BODY', $post->getBody());
        $query->bindValue('CREATED_AT', $post->getCreatedAt());
        return $query->execute();
    }
}
