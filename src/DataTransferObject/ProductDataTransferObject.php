<?php

namespace App\DataTransferObject;

use App\Entity\Category;
use App\Validator\Contraints\IsUniqueProductNameOrSameProduct;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @IsUniqueProductNameOrSameProduct (message="Deze productnaam bestaat al voor een andere categorie. Kies een andere")
 */
class ProductDataTransferObject
{
    /**
     * @Assert\NotBlank(message="Je moet een naam kiezen")
     */
    public ?string $name = null;

    /**
     * @Assert\NotBlank(message="Je moet een categorie kiezen")
     */
    public ?Category $category = null;
}
