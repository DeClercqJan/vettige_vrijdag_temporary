<?php

namespace App\Controller\Everyone;

use App\DataTransferObject\OrderLineDataTransferObject;
use App\Entity\VettigeVrijdag;
use App\EventSubscriber\ApiRoute;
use App\Message\Command\CreateOrder;
use App\Message\Command\ProcessOrder;
use App\Repository\ProductRepository;
use App\Repository\VettigeVrijdagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Twig\Environment;
use Exception;

class SubmitOrderController
{
    /**
     * @ApiRoute("submit-order/{slug}", name="submit_order", methods={"POST"})
     */
    public function __invoke(
        VettigeVrijdag $vettigeVrijdag,
        Request $request,
        MessageBusInterface $commandbus,
        Environment $twig,
        VettigeVrijdagRepository $vettigeVrijdagRepository,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        if ($vettigeVrijdag->isClosed()) {
            return new JsonResponse('The vettigeVrijdag has already been closed', Response::HTTP_BAD_REQUEST);
        }

        $submittedOrderArray = json_decode($request->getContent(), true);

        $createOrder = new CreateOrder(
            $submittedOrderArray['name'],
            $vettigeVrijdag,
        );

        $orderLineDataTransferObjects = [];

        foreach ($submittedOrderArray['orderLines'] as $submittedOrderLine) {
            $product = $productRepository->findOneBy(['id' => $submittedOrderLine['productId']]);
            $amount = $submittedOrderLine["amount"];

            if ($amount <= 0) {
                return new JsonResponse('You must provide an amount greater than 0', Response::HTTP_BAD_REQUEST);
            }

            $orderLineDataTransferObject = new OrderLineDataTransferObject(
                $product,
                $amount
            );

            $orderLineDataTransferObjects[] = $orderLineDataTransferObject;
        }

        try {
            $entityManager->beginTransaction();
            $commandbus->dispatch(new ProcessOrder($createOrder, $orderLineDataTransferObjects));
            $entityManager->commit();
        } catch (Exception $exception) {
            $entityManager->rollback();

            return new JsonResponse($exception->getMessage(), Response::HTTP_NOT_MODIFIED);
        }

        // to do: return name of ordering person to confirm page + change twig
        return new JsonResponse('The order has been processed', Response::HTTP_CREATED);
    }
}
