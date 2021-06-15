<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

class ForumAlreadyOpened extends \LogicException
{
    public function __construct(ForumId $forumId)
    {
        parent::__construct(
            \sprintf('Forum %s is already opened', $forumId->getId())
        );
    }
}