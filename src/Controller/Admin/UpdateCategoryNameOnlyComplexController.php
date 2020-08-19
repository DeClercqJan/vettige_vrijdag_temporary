<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Message\Command\ProcessOrder;
use App\Message\Command\UpdateCategoryNameOnly;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class UpdateCategoryNameOnlyComplexController
{
    /**
     * @Route("admin/category/{id}/update-name-only-complex", name="category_update_name_only_complex", methods={"POST"})
     */
    public function __invoke(
        Category $category,
        Request $request,
        MessageBusInterface $commandbus,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $content = json_decode($request->getContent(), true);
        $updateCategoryNameOnly = new UpdateCategoryNameOnly($category);
        // rest of data transfer object remains empty
        $updateCategoryNameOnly->name = $content['name'];

        try {
            $entityManager->beginTransaction();
            $envelope = $commandbus->dispatch($updateCategoryNameOnly);
            $entityManager->commit();
        } catch (Exception $exception) {
            $entityManager->rollback();
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        if ($envelope->last(HandledStamp::class)->getResult() instanceof Category) {
            $newId = $envelope->last(HandledStamp::class)->getResult()->getId();
            $response = new JsonResponse();
            $dataToReturn = array('newId' => $newId);
            $response->setData($dataToReturn);

            return $response;
        }

        // fallback
        return new JsonResponse('The category has not been updated', Response::HTTP_BAD_REQUEST, [], false);
    }
}
