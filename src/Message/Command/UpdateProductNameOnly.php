<?php

namespace App\Message\Command;

use App\DataTransferObject\ProductDataTransferObject;
use App\Entity\Product;

class UpdateProductNameOnly extends ProductDataTransferObject
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
