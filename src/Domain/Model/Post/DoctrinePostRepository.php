<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

interface DoctrinePostRepository
{
    public function byId(int $postId): Post;
    public function save(Post $post): void;
}
