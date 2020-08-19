<?php

namespace App\Traits;

trait NameTrait
{
//    /**
//     * @ORM\Column(type="string", unique=true)
//     */
    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }
}
