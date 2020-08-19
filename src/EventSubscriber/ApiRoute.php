<?php

namespace App\EventSubscriber;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Annotation
 */
class ApiRoute extends Route
{
    public function getDefaults()
    {
        return array_merge(
            ['_is_api' => true],
            parent::getDefaults()
        );
    }
}
