<?php

namespace App\ValueObject;

use InvalidArgumentException;

class Status
{
    const OPEN = 'open';
    const CLOSED = 'closed';

    private string $status;

    private array $acceptedStatusValues = [self::OPEN, self::CLOSED];

    public function __construct(string $value)
    {
        if (!in_array($value, $this->acceptedStatusValues)) {
            throw new InvalidArgumentException('You must select one of the accepted status values');
        }

        $this->status = $value;
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
