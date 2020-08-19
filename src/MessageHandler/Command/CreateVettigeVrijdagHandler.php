<?php

namespace App\MessageHandler\Command;

use App\Entity\VettigeVrijdag;
use App\Message\Command\CreateVettigeVrijdag;
use App\Repository\VettigeVrijdagRepository;
use App\ValueObject\Status;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use RuntimeException;

class CreateVettigeVrijdagHandler implements MessageHandlerInterface
{
    private VettigeVrijdagRepository $vettigeVrijdagRepository;

    public function __construct(VettigeVrijdagRepository $vettigeVrijdagRepository)
    {
        $this->vettigeVrijdagRepository = $vettigeVrijdagRepository;
    }

    public function __invoke(CreateVettigeVrijdag $message): VettigeVrijdag
    {
        if ($this->vettigeVrijdagRepository->getCurrentVettigeVrijdag() instanceof VettigeVrijdag) {
            throw new RuntimeException('There is already a VettigeVrijdag object with the status \' open \'');
        }

        $openVettigeVettigeVrijdag = new VettigeVrijdag();

        $this->vettigeVrijdagRepository->create($openVettigeVettigeVrijdag);

        return $openVettigeVettigeVrijdag;
    }
}
