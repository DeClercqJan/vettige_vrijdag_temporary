<?php

namespace App\MessageHandler\Command;

use App\Entity\Product;
use App\Message\Command\CreateProduct;
use App\Message\Event\ProductCreatedEvent;
use App\Repository\ProductRepository;
use RuntimeException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateProductHandler implements MessageHandlerInterface
{
    private ProductRepository $productRepository;
    private MessageBusInterface $eventBus;

    public function __construct(ProductRepository $productRepository, MessageBusInterface $eventBus)
    {
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateProduct $message): Product
    {
        if ($this->productRepository->existsByName($message->name)) {
            throw new RuntimeException('A product with that name already exists', 500);
        }

        $product = new Product(
            $message->name,
            $message->category
        );
        $this->productRepository->create($product);

        $this->eventBus->dispatch(new ProductCreatedEvent());

        return $product;
    }
}
