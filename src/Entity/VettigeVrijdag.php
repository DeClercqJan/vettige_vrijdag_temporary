<?php

namespace App\Entity;

use App\Traits\CreatedOnTrait;
use App\Traits\IdTrait;
use App\ValueObject\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class VettigeVrijdag
{
    use IdTrait;
    use CreatedOnTrait;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="vettigeVrijdag", orphanRemoval=true)
     */
    private Collection $orders;

    /**
     * @ORM\Column(type="status")
     */
    private Status $status;

    /**
     * @ORM\Column(type="string")
     */
    private string $slug;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $closedOn;

    public function __construct()
    {
        $this->status = new Status(Status::OPEN);
        $this->orders = new ArrayCollection();
        $this->slug = substr(hash('sha256', random_bytes(10)), 0, 5);
    }

    /**
     * @ORM\PreUpdate
     */
    public function setClosedOn(): void
    {
        $this->closedOn = new DateTimeImmutable();
    }

    public function close(): void
    {
        $this->status = new Status(Status::CLOSED);
    }

    public function getClosedOn(): ?string
    {
        if ($this->closedOn === null) {
            return null;
        }

        return $this->closedOn->format('d/m/Y');
    }

    public function isClosed(): bool
    {
        if ($this->getClosedOn() === null) {
            return false;
        }

        return true;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
