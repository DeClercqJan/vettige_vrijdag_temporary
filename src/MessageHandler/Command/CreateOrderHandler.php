<?php

namespace App\MessageHandler\Command;

use App\Entity\Order;
use App\Message\Command\CreateOrder;
use App\Repository\OrderRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOrderHandler implements MessageHandlerInterface
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(CreateOrder $message): Order
    {
        $order = new Order(
            $message->getCustomerName(),
            $message->getOpenVettigeVrijdag()
        );

        $this->orderRepository->create($order);

        return $order;
    }
}
