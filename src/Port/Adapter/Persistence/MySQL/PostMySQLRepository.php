<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\MySQL;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostRepository;

class PostMySQLRepository implements PostRepository
{
    public function byId(int $postId): Post
    {
        
    }

    public function save(): Post
    {
    }
}
