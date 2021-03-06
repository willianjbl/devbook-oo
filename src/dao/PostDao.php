<?php

namespace Devbook\dao;

use Devbook\interfaces\PostInterface;
use Devbook\utility\{
    CommonValidation,
    Common,
};
use Devbook\models\{
    Session,
    Post,
};
use PDOStatement;
use StdClass;
use PDO;

class PostDao implements PostInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $this->pdo ?? $pdo;
    }

    private function fetchFeed(PDOStatement $stmt, int $userId, int $totalPages, int $currentPage): array
    {
        $feed = [];
        $userDao = new UserDao($this->pdo);
        $loggedUser = $userDao->findUserByToken(Session::get('TOKEN'));

        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $postLikeDao = (new PostLikeDao($this->pdo));

                $post = $this->generatePost($row);
                $post->setAuthor($userDao->findUserById($post->getUserId()));
                $post->likeCount = $postLikeDao->getLikeCount($post->getId());
                $post->liked = $postLikeDao->isLiked($post->getId(), $loggedUser->getId());
                $post->comments = (new PostCommentDao($this->pdo))->getComments($post->getId());
                $post->isAuthor = false;

                if ($post->getUserId() === $userId) {
                    $post->isAuthor = true;
                }
                $feed['feed'][] = $post;
            }
            $feed['totalPages'] = $totalPages;
            $feed['currentPage'] = $currentPage;
        }
        return $feed;
    }
    
    public function getProfileFeed(int $userId, int $page = 1): array
    {
        $perPage = 5;

        $pageOffset = ($page - 1) * $perPage;

        $feed = $this->pdo->prepare("
            SELECT *
              FROM posts
             WHERE user_id = :ID
          ORDER BY created_at DESC
             LIMIT {$pageOffset},{$perPage} 
        ");
        $feed->bindParam(':ID', $userId, PDO::PARAM_INT);
        $feed->execute();

        $totalPages = $this->pdo->prepare('
            SELECT COUNT(*) as count
              FROM posts
             WHERE user_id = :ID
        ');
        $totalPages->bindParam(':ID', $userId, PDO::PARAM_INT);
        $totalPages->execute();
        $totalPages = ceil($totalPages->fetch(PDO::FETCH_OBJ)->count / $perPage);

        return $this->fetchFeed($feed, $userId, $totalPages, $page);
    }

    public function getHomeFeed(int $loggedUserId, int $page = 1): array
    {
        $userList = (new UserRelationDao($this->pdo))->listRelationsFrom($loggedUserId);
        $perPage = 5;

        $pageOffset = ($page - 1) * $perPage;

        $feed = $this->pdo->query("
            SELECT *
              FROM posts
             WHERE user_id IN (" . implode(',', $userList) . ")
          ORDER BY created_at DESC
             LIMIT {$pageOffset},{$perPage} 
        ");
        $totalPages = $this->pdo->query("
            SELECT COUNT(*) AS count
              FROM posts
             WHERE user_id IN (" . implode(',', $userList) . ")
        ");
        $totalPages = ceil($totalPages->fetch(PDO::FETCH_OBJ)->count / $perPage);

        return $this->fetchFeed($feed, $loggedUserId, $totalPages, $page);
    }

    private function generatePost(StdClass $post): Post
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

    public function delete(int $id, int $userID): bool
    {
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = :ID AND user_id = :USER_ID');
        $query->bindParam('ID', $id, PDO::PARAM_INT);
        $query->bindParam('USER_ID', $userID, PDO::PARAM_INT);
        $query->execute();
        $post = $query->fetch(PDO::FETCH_OBJ);

        if ($post->type === 'photo') {
            if (file_exists("./media/uploads/{$post->body}")) {
                if (!unlink("./media/uploads/{$post->body}")) {
                    Common::flash(FLASH_ERROR, 'Erro ao apagar o arquivo!');
                    Common::redirect('index');
                    exit;
                }
            }
        }
        $query = $this->pdo->prepare('DELETE FROM post_comments WHERE post_id = :POST_ID');
        $query->bindValue('POST_ID', $post->id, PDO::PARAM_INT);

        if ($query->execute()) {
            $query = $this->pdo->prepare('DELETE FROM post_likes WHERE post_id = :POST_ID');
            $query->bindValue('POST_ID', $post->id, PDO::PARAM_INT);

            if ($query->execute()) {
                $query = $this->pdo->prepare('DELETE FROM posts WHERE id = :ID AND user_id = :USER_ID');
                $query->bindParam('ID', $id, PDO::PARAM_INT);
                $query->bindParam('USER_ID', $userID, PDO::PARAM_INT);

                return $query->execute();
            }
            Common::flash(FLASH_ERROR, 'Erro ao excluir likes');
            Common::redirect('index');
            exit;
        }
        Common::flash(FLASH_ERROR, 'Erro ao excluir comentários');
        Common::redirect('index');
        exit;
    }

    public function getPhotosFrom(int $id): array
    {
        $photos = [];

        $query = $this->pdo->prepare("
            SELECT *
              FROM posts
             WHERE type = 'photo'
               AND user_id = :ID
          ORDER BY id DESC
        ");
        $query->bindParam('ID', $id, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            $photos = $query->fetchAll();
        }
        return $photos;
    }

    public function searchPosts($searchTerm, int $loggedUserId): array
    {
        $result = [];
        $query = $this->pdo->prepare("
                SELECT U.id, U.name, U.avatar,
                       P.id, P.body, P.created_at
                  FROM posts AS P
            INNER JOIN users AS U
                    ON P.user_id = U.id
            INNER JOIN user_relations AS UR
                    ON U.id = UR.user_to
                 WHERE P.body LIKE :BODY
                   AND P.type = 'text'
                   AND UR.user_from = :ID
        ");
        $query->bindValue('BODY', "%$searchTerm%", PDO::PARAM_STR);
        $query->bindParam('ID', $loggedUserId, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            $result = $query->fetchAll();
        }
        return $result;
    }

    public function findById(int $id): bool
    {
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = :ID');
        $query->bindParam('ID', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->rowCount() > 0;
    }
}
