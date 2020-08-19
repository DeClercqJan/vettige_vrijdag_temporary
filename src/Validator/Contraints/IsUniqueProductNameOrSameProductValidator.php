<?php

namespace App\Validator\Contraints;

use App\Message\Command\UpdateProduct;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsUniqueProductNameOrSameProductValidator extends ConstraintValidator
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof UpdateProduct && $value->name === $value->getProduct()->getName()) {
            return;
        }

        if (!$this->productRepository->existsByName($value->name)) {
            return;
        }

        foreach ($value->getProduct()->getHistoricalVersions()->getValues() as $historicalVersion) {
            if ($historicalVersion->getName() === $value->name) {
                return;
            }
        }

        $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
    }
}
