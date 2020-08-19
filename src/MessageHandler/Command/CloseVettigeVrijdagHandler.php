<?php

namespace App\MessageHandler\Command;

use App\Entity\VettigeVrijdag;
use App\Message\Command\CloseVettigeVrijdag;
use App\Repository\VettigeVrijdagRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use RuntimeException;

class CloseVettigeVrijdagHandler implements MessageHandlerInterface
{
    private VettigeVrijdagRepository $vettigeVrijdagRepository;

    public function __construct(VettigeVrijdagRepository $vettigeVrijdagRepository)
    {
        $this->vettigeVrijdagRepository = $vettigeVrijdagRepository;
    }

    public function __invoke(CloseVettigeVrijdag $message): void
    {
        $vettigeVrijdag = $this->vettigeVrijdagRepository->getCurrentVettigeVrijdag();

        if (!$vettigeVrijdag instanceof VettigeVrijdag) {
            throw new RuntimeException('The VettigeVrijdag object was not open and therefore cannot been closed');
        }

        $vettigeVrijdag->close();

        $this->vettigeVrijdagRepository->update($vettigeVrijdag);
    }
}
