<?php

namespace App\Traits;

use DateTimeImmutable;

Trait CreatedOnTrait
{
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdOn;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedOn(): void
    {
        $this->createdOn = $this->updatedOn = new DateTimeImmutable();
    }

    public function getCreatedOn(): string
    {
        return $this->createdOn->format('d/m/Y');
    }
}
