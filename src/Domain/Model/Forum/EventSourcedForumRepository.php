<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

interface EventSourcedForumRepository
{
    /**
     * Check if item exists or not
     *
     * @param string $forumId
     * @return bool
     */
    public function exists(string $forumId): bool;

    /**
     * Fetches a Forum aggregate by its ID.
     *
     * @param string $forumId
     * @return Forum|null
     */
    public function byId(string $forumId): ?Forum;

    /**
     * Saves a Forum aggregate to a EventStream persistence.
     *
     * @param Forum $forum
     */
    public function save(Forum $forum): void;
}
