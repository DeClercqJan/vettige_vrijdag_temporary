<?php

namespace App\Message\Command;

use App\Entity\Order;
use App\Entity\Product;

class CreateOrderLine
{
    private Order $order;
    private Product $product;
    private int $amount;

    public function __construct(
        Order $order,
        Product $product,
        int $amount
    ) {

        $this->order = $order;
        $this->product = $product;
        $this->amount = $amount;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}

