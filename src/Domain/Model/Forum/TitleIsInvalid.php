<?php

declare(strict_types=1);

namespace App\Domain\Model\Forum;

class TitleIsInvalid extends \LogicException
{
    public function __construct(string $forumTitle)
    {
        parent::__construct(
            \sprintf('Title "%s" is an invalid forum title.', $forumTitle)
        );
    }
}