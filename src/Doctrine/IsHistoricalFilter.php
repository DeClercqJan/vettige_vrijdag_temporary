<?php

namespace App\Doctrine;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class IsHistoricalFilter extends SQLFilter
{
    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->getReflectionClass()->name != 'App\Entity\Product'
            && $targetEntity->getReflectionClass()->name != 'App\Entity\Category') {
            // It's gotta be an empty string. That tells Doctrine: hey, I don't want to add any WHERE clauses here - so just leave it alone. If you return null, it adds the WHERE but doesn't put anything in it.
            return '';
        }

        return $targetTableAlias . '.is_historical = 0';
    }
}
