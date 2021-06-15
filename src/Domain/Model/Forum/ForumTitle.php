<?php declare(strict_types=1);

namespace App\Domain\Model\Forum;

class ForumTitle
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public static function create(string $title): self
    {
        self::validateForumTitle($title);
        return new self($title);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    private static function validateForumTitle(string $title): void
    {
        if(!preg_match('/[a-z0-9\s,]+/i', $title)) {
            throw new TitleIsInvalid($title);
        }
    }
}
