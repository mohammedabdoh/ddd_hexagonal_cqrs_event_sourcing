<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

interface EventSourcedForumRepository
{
    /**
     * Fetches a Forum aggregate by its ID.
     * @param ForumId $forumId
     * @return Forum|null
     */
    public function byId(ForumId $forumId): ?Forum;

    /**
     * Saves a Forum aggregate to a EventStream persistence.
     * @param Forum $forum
     */
    public function save(Forum $forum): void;
}
