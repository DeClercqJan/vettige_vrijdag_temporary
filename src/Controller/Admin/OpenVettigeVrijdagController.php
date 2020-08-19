<?php

namespace App\Controller\Admin;

use App\Entity\VettigeVrijdag;
use App\Message\Command\CreateVettigeVrijdag;
use App\Repository\VettigeVrijdagRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Exception;

class OpenVettigeVrijdagController
{
    /**
     * @Route("admin/open-vettige-vrijdag", name="open_vettige_vrijdag")
     */
    public function __invoke(
        VettigeVrijdagRepository $vettigeVrijdagRepository,
        MessageBusInterface $messageBus,
        FlashBagInterface $flashBag,
        Environment $twig
    ): JsonResponse {
        try {
            $envelope = $messageBus->dispatch(new CreateVettigeVrijdag());

            $newOpenVettigeVrijdag = $envelope->last(HandledStamp::class)->getResult();

            if (!$newOpenVettigeVrijdag instanceof VettigeVrijdag) {
                throw new RuntimeException('The VettigeVrijdag object was not opened The stamp returned unexpected results');
            }
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage());
        }

        return new JsonResponse($newOpenVettigeVrijdag, Response::HTTP_CREATED);
    }
}
