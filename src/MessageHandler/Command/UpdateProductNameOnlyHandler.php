<?php

namespace App\MessageHandler\Command;

use App\Entity\Product;
use App\Message\Command\UpdateProductNameOnly;
use App\Message\Event\ProductUpdatedEvent;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateProductNameOnlyHandler implements MessageHandlerInterface
{
    private ProductRepository $productRepository;
    private  MessageBusInterface $eventBus;

    public function __construct(
        ProductRepository $productRepository,
        MessageBusInterface $eventBus
    ) {
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(UpdateProductNameOnly $message): Product
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
            $oldProduct->getCategory()
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

        $oldProduct->archive();
        $this->productRepository->update($oldProduct);

        $this->eventBus->dispatch(new ProductUpdatedEvent());

        return $newProduct;
    }
}
