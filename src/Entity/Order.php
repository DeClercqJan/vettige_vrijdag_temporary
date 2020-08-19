<?php

namespace App\Entity;

use App\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="`order`")
 */
class Order
{
    use IdTrait;

    /**
     * @ORM\Column(type="string")
     */
    private string $customerName;

    /**
     * @ORM\OneToMany(targetEntity="OrderLine", mappedBy="order", orphanRemoval=true)
     */
    private Collection $orderLines;

    /**
     * @ORM\ManyToOne(targetEntity="VettigeVrijdag", inversedBy="orders", cascade={"persist"})
     */
    private VettigeVrijdag $vettigeVrijdag;

    public function __construct(string $customerName, VettigeVrijdag $vettigeVrijdag)
    {
        $this->customerName = $customerName;
        $this->vettigeVrijdag = $vettigeVrijdag;
        $this->orderLines = new ArrayCollection();
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function getVettigeVrijdag(): VettigeVrijdag
    {
        return $this->vettigeVrijdag;
    }

    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }
}
