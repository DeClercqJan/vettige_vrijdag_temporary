<?php

namespace App\Controller\Everyone;

use Symfony\Component\Routing\Annotation\Route;

class LogoutController
{
    /**
     * @Route("/logout", name="logout")
     */
    public function __invoke()
    {
        // automatically redirects to login controller
    }
}
