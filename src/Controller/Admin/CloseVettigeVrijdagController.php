<?php

namespace App\Controller\Admin;

use App\Message\Command\CloseVettigeVrijdag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class CloseVettigeVrijdagController
{
    /**
     * @Route("admin/close-vettige-vrijdag", name="close_vettige_vrijdag")
     */
    public function __invoke(
        MessageBusInterface $messageBus
    ): JsonResponse {
        try {
            $messageBus->dispatch(new CloseVettigeVrijdag());
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse('Vettige Vrijdag has been closed');
    }
}
