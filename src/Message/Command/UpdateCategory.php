<?php

namespace App\Message\Command;

use App\DataTransferObject\CategoryDataTransferObject;
use App\Entity\Category;

class UpdateCategory extends CategoryDataTransferObject
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->name = $category->getName();
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}
