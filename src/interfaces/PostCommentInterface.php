<?php

namespace Devbook\interfaces;

use Devbook\models\PostComment;

interface PostCommentInterface
{
    public function getComments(int $postId): array;
    public function addComment(PostComment $post): bool;
}
