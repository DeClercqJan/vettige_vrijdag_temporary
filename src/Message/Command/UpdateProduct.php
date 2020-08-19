<?php

namespace App\Message\Command;

use App\DataTransferObject\ProductDataTransferObject;
use App\Entity\Product;

class UpdateProduct extends ProductDataTransferObject
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->name = $product->getName();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
