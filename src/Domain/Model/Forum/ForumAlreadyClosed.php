<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

class ForumAlreadyClosed extends \LogicException
{
    public function __construct(ForumId $forumId)
    {
        parent::__construct(
            \sprintf('Forum %s is already closed, no further changes can be made.', $forumId->getId())
        );
    }
}