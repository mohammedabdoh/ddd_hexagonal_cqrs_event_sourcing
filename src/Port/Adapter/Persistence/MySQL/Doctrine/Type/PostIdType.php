<?php

declare(strict_types=1);

namespace App\Port\Adapter\Persistence\MySQL\Doctrine\Type;

use App\Domain\Model\Post\PostId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class PostIdType extends GuidType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new PostId($value);
    }

    public function getName()
    {
        return 'PostId';
    }
}
