<?php

namespace App\DataTransferObject;

use App\Entity\Product;

class OrderLineDataTransferObject
{
    private int $amount;
    private Product $product;

    public function __construct(Product $product, int $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
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
