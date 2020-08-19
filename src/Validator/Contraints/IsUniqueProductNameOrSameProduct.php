<?php

namespace App\Validator\Contraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsUniqueProductNameOrSameProduct extends Constraint
{
    public $message = 'This Product name already exists for another Product';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
