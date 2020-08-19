<?php

namespace App\Validator\Contraints;

use App\Message\Command\UpdateCategory;
use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsUniqueCategoryNameOrSameCategoryValidator extends ConstraintValidator
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof UpdateCategory && $value->name === $value->getCategory()->getName()) {
            return;
        }

        if (!$this->categoryRepository->existsByName($value->name)) {
            return;
        }

        if (method_exists($value, 'getCategory')) {
            foreach ($value->getCategory()->getHistoricalVersions()->getValues() as $historicalVersion) {
                if ($historicalVersion->getName() === $value->name) {
                    return;
                }
            }
        }

        $this->context
            ->buildViolation($constraint->message)
            ->addViolation();
    }
}
