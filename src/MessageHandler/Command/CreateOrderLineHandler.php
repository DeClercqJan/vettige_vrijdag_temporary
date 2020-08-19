<?php

namespace App\MessageHandler\Command;

use App\Entity\OrderLine;
use App\Message\Command\CreateOrderLine;
use App\Repository\OrderLineRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOrderLineHandler implements MessageHandlerInterface
{
    private OrderLineRepository $orderLineRepository;

    public function __construct(OrderLineRepository $orderLineRepository)
    {
        $this->orderLineRepository = $orderLineRepository;
    }

    public function __invoke(CreateOrderLine $message): OrderLine
    {
        $orderline = new OrderLine(
            $message->getOrder(),
            $message->getProduct(),
            $message->getAmount(),
        );

        $this->orderLineRepository->create($orderline);

        return $orderline;
    }
}
