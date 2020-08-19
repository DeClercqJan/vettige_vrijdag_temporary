<?php

namespace App\MessageHandler\Command;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Message\Command\CreateOrderLine;
use App\Message\Command\ProcessOrder;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use RuntimeException;

class ProcessOrderHandler implements MessageHandlerInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(ProcessOrder $message): void
    {
        $envelope = $this->messageBus->dispatch($message->getCreateOrder());
        $order = $envelope->last(HandledStamp::class)->getResult();

        if (!$order instanceof Order) {
            throw new RuntimeException('The stamp returned unexpected results in the creation of the Order object');
        }

        foreach ($message->getOrderLineData() as $orderLineDatum) {
            $envelope = $this->messageBus->dispatch(
                new CreateOrderLine(
                    $order,
                    $orderLineDatum['product'],
                    $orderLineDatum['amount'],
                )
            );

            $orderLine = $envelope->last(HandledStamp::class)->getResult();

            if (!$orderLine instanceof OrderLine) {
                throw new RuntimeException('The stamp returned unexpected results in the creation of an OrderLine object');
            }
        }
    }
}
