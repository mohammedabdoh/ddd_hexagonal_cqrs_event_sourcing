<?php declare(strict_types=1);

namespace App\Port\Adapter\Persistence\MySQL\Doctrine\Type;

use App\Domain\Model\Post\PostId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PostIdType extends Type
{
    const POST_ID_TYPE = 'post_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'POST_ID_TYPE';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new PostId($value);
    }

    public function getName()
    {
        return self::POST_ID_TYPE;
    }
}