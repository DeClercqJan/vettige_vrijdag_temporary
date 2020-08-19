<?php

namespace App\Message\Command;

use App\Entity\VettigeVrijdag;

class CreateOrder
{
    private string $customerName;
    private VettigeVrijdag $vettigeVrijdag;

    public function __construct(string $customerName, VettigeVrijdag $vettigeVrijdag)
    {
        $this->customerName = $customerName;
        $this->vettigeVrijdag = $vettigeVrijdag;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function getOpenVettigeVrijdag(): VettigeVrijdag
    {
        return $this->vettigeVrijdag;
    }
}
