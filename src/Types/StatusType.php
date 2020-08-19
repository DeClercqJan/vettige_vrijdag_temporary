<?php

namespace App\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\ValueObject\Status;

class StatusType extends StringType
{
    private const STATUS = 'status';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Status
    {
        if (null === $value) {
            return null;
        }

        return new Status($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null || !$value instanceof Status) {
            return null;
        }

        return (string) $value;
    }
}
