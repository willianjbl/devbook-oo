<?php

namespace Devbook\interfaces;

use Devbook\models\Post;

interface PostInterface
{
    public function insert(Post $post): bool;
    public function update(Post $post): bool;
    public function delete(Post $post): bool;
}
