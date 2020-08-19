<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Message\Command\UpdateProductNameOnly;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class UpdateProductNameOnlyComplexController
{
    /**
     * @Route("admin/product/{id}/update-name-only-complex", name="product_update_name_only_complex", methods={"POST"})
     */
    public function __invoke(
        Product $product,
        Request $request,
        MessageBusInterface $commandbus,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $content = json_decode($request->getContent(), true);
        $updateProductNameOnly = new UpdateProductNameOnly($product);
        // rest of data transfer object remains empty
        $updateProductNameOnly->name = $content['name'];

        try {
            $entityManager->beginTransaction();
            $envelope = $commandbus->dispatch($updateProductNameOnly);
            $entityManager->commit();
        } catch (Exception $exception) {
            $entityManager->rollback();
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        if ($envelope->last(HandledStamp::class)->getResult() instanceof Product) {
            $newId = $envelope->last(HandledStamp::class)->getResult()->getId();
            $response = new JsonResponse();
            $dataToReturn = array('newId' => $newId);
            $response->setData($dataToReturn);

            return $response;
        }

        // fallback
        return new JsonResponse('The product has not been updated', Response::HTTP_BAD_REQUEST, [], false);
    }
}
