<?php

namespace App\MessageHandler\Command;

use App\Entity\Product;
use App\Message\Command\UpdateProduct;
use App\Message\Event\ProductUpdatedEvent;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateProductHandler implements MessageHandlerInterface
{
    private ProductRepository $productRepository;
    private MessageBusInterface $messageBus;
    private MessageBusInterface $eventBus;

    public function __construct(
        ProductRepository $productRepository,
        MessageBusInterface $messageBus,
        MessageBusInterface $eventBus
    ) {
        $this->productRepository = $productRepository;
        $this->messageBus = $messageBus;
        $this->eventBus = $eventBus;
    }

    public function __invoke(UpdateProduct $message): Product
    {
        $oldProduct = $message->getProduct();

        $isHistoricalName = false;
        foreach ($message->getProduct()->getHistoricalVersions()->getValues() as $historicalVersion) {
            if ($historicalVersion->getName() === $message->name) {
                $isHistoricalName = true;
            }
        }

        if (($message->name !== $message->getProduct()->getName() && !$isHistoricalName)
            && $this->productRepository->existsByName($message->name)
        ) {
            throw new RuntimeException('A product with that name already exists', 500);
        }

        $newProduct = new Product(
            $message->name,
            // $oldProduct->getCategory()
            $message->category
        );

        $oldHistoricalVersions = $oldProduct->getHistoricalVersions();
        // adding old version of itself to new 'copy' if not in it
        // necessary check, otherwise duplicate entry exception
        if (!$oldHistoricalVersions->contains($oldProduct)) {
            $oldHistoricalVersions->add($oldProduct);
        }
        foreach ($oldHistoricalVersions as $olderProduct) {
            // note that the inverse side is handled in the entity itself
            $newProduct->addToHistoricalVersion($olderProduct);
        }
        // no create necesssary?

        $oldProduct->archive();
        $this->productRepository->update($oldProduct);

        $this->eventBus->dispatch(new ProductUpdatedEvent());

        return $newProduct;
    }
}
