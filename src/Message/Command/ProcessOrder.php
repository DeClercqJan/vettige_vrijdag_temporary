<?php

namespace App\Message\Command;

class ProcessOrder
{
    private CreateOrder $createOrder;
    private array $orderLineDataTransferObjects;
    private array $orderLineData;

    public function __construct(CreateOrder $createOrder, array $orderLineDataTransferObjects)
    {
        $this->createOrder = $createOrder;
        $this->orderLineDataTransferObjects = $orderLineDataTransferObjects;
        foreach ($orderLineDataTransferObjects as $orderLineDataTransferObject) {
            $this->orderLineData[] = [
                'product' => $orderLineDataTransferObject->getProduct(),
                'amount' => $orderLineDataTransferObject->getAmount(),
            ];
        }
    }

    public function getCreateOrder(): CreateOrder
    {
        return $this->createOrder;
    }

    public function getOrderLineData(): array
    {
        return $this->orderLineData;
    }
}
