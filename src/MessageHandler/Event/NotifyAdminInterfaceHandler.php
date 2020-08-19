<?php

namespace App\MessageHandler\Event;

use App\Message\Event\NotifyAdminInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NotifyAdminInterfaceHandler implements MessageHandlerInterface
{
    private FlashBagInterface $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function __invoke(NotifyAdminInterface $event): void
    {
        $this->flashBag->add($event->getType(), $event->getMessage());
    }
}
