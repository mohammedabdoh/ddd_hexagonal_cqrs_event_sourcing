<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\Redis;

class RedisForumEvent
{
    private string $className;
    private string $createdAt;
    private string $dataRepresentation;

    /**
     * RedisForumEvent constructor.
     * @param string $className
     * @param string $createdAt
     * @param string $dataRepresentation
     */
    public function __construct(string $className, string $createdAt, string $dataRepresentation)
    {
        $this->className = $className;
        $this->createdAt = $createdAt;
        $this->dataRepresentation = $dataRepresentation;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getDataRepresentation(): string
    {
        return $this->dataRepresentation;
    }
}
