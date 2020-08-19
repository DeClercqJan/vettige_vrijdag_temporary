<?php

namespace App\Controller\Everyone;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ConfirmOrderController
{
    /**
     * @Route("/confirm-order", name="confirm_order")
     */
    public function __invoke(
        Request $request,
        Environment $twig
    ): Response {
        return new Response(
            $twig->render(
                'confirmed.html.twig',
                ['customerName' => $request->query->get('customerName')]
            )
        );
    }
}
