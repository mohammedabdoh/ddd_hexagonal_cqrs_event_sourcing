<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Domain\AggregateRoot;

class Post extends AggregateRoot
{
    private PostId $postId;
    private string $title;
    private string $content;

    public function __construct(PostId $postId)
    {
        $this->postId = $postId;
    }

    public static function createNewPost(string $title, string $content): self
    {
        $postId = PostId::create();
        $post = new static($postId);
        $post->recordApplyAndPublish(
            new PostWasCreated($postId->id(), $title, $content)
        );
        return $post;
    }

    public function applyPostWasCreated(PostWasCreated $postWasCreated): void
    {
        $this->postId = $postWasCreated->postId();
        $this->title = $postWasCreated->title();
        $this->content = $postWasCreated->content();
    }
}
