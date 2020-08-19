<?php

namespace App\MessageHandler\Command;

use App\Message\Command\RemoveProduct;
use App\Message\Event\ProductRemovedEvent;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class RemoveProductHandler implements MessageHandlerInterface
{
    private ProductRepository $productRepository;
    private MessageBusInterface $eventBus;

    public function __construct(ProductRepository $productRepository, MessageBusInterface $eventBus)
    {
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RemoveProduct $message): void
    {
        $product = $message->getProduct();

        $product->archive();
        $this->productRepository->update($product);

        $this->eventBus->dispatch(new ProductRemovedEvent());
    }
}
