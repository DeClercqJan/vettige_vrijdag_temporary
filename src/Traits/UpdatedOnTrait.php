<?php

namespace App\Traits;

use DateTimeImmutable;

Trait UpdatedOnTrait
{
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $updatedOn;

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedOn(): void
    {
        $this->updatedOn = new DateTimeImmutable();
    }

    public function getUpdatedOn(): ?DateTimeImmutable
    {
        return $this->updatedOn;
    }
}
