<?php

namespace App\Controller\Everyone;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\VettigeVrijdag;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class OrderHomeController
{
    /**
     * @Route("/order/{slug}", name="order_home")
     */
    public function invoke(
        VettigeVrijdag $vettigeVrijdag,
        CategoryRepository $categoryRepository,
        Environment $twig
    ): Response {
        $categories = $categoryRepository->findAll();

        return new Response(
            $twig->render(
                '3_columns/order-empty.html.twig',
                [
                'categories' => $categories,
                'vettigeVrijdag' => $vettigeVrijdag,
                ]
            )
        );
    }
}
