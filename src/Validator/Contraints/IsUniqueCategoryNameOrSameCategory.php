<?php

namespace App\Validator\Contraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsUniqueCategoryNameOrSameCategory extends Constraint
{
    public $message = 'This Category name already exists for another Category';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
