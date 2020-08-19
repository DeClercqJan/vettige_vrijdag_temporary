<?php

namespace App\Controller\Everyone;

use App\EventSubscriber\ApiRoute;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetCategoriesController
{
    /**
     * @ApiRoute("api/categories", name="get_categories")
     */
    public function invoke(
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $entityManager->getFilters()->enable('is_historical');
        $categories = $categoryRepository->getAlphabetical();

        $categoriesJson =  json_encode($categories, JSON_PRETTY_PRINT);

        return new JsonResponse($categoriesJson, Response::HTTP_OK, [], true);
    }
}
