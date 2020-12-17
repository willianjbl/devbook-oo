<?php

namespace Devbook\interfaces;

interface PostLikeInterface
{
    public function getLikeCount(int $postId): int;
    public function isLiked(int $postId, int $userId): bool;
    public function likeToggle(int $postId, int $userId): bool;
}
