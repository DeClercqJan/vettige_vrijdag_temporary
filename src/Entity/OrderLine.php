<?php

namespace App\Entity;

use App\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class OrderLine
{
    use IdTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderLines")
     */
    private Order $order;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="orderLines")
     */
    private Product $product;

    public function __construct(Order $order, Product $product, int $amount)
    {
        $this->order = $order;
        $this->product = $product;
        $this->amount = $amount;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}
