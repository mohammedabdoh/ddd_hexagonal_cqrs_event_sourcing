<?php declare(strict_types=1);

namespace App\Application\Representation;

use App\Domain\Model\Post\Post as PostModel;

class AllPosts
{
    private array $posts;

    /*** @param PostModel[] $posts */
    public function __construct(array $posts)
    {
        $this->posts = array_map(function (PostModel $post) {
            return new Post(
                $post->getPostId()->id(),
                $post->getTitle(),
                $post->getContent()
            );
        }, $posts);
    }

    public function getPosts(): array
    {
        return $this->posts;
    }
}