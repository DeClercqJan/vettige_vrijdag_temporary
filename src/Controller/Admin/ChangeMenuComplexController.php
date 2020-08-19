<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ChangeMenuComplexController
{
    /**
     * @Route("admin/change-menu-complex", name="change_menu_complex")
     */
    public function __invoke(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        Environment $twig,
        EntityManagerInterface $entityManager
    ): Response {
        $products = $productRepository->findAll();
        $entityManager->getFilters()->enable('is_historical');

        $categories = $categoryRepository->getAlphabetical();

        return new Response(
            $twig->render(
                '3_columns/change_menu_complex.html.twig',
                [
                    'categories' => $categories,
                ]
            )
        );
    }
}
