<?php

namespace App\MessageHandler\Command;

use App\Entity\Category;
use App\Entity\Product;
use App\Message\Command\UpdateCategoryNameOnly;
use App\Message\Command\UpdateProduct;
use App\Message\Event\CategoryUpdatedEvent;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class UpdateCategoryNameOnlyHandler implements MessageHandlerInterface
{
    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;
    private MessageBusInterface $eventBus;
    private MessageBusInterface $messageBus;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        MessageBusInterface $eventBus,
        MessageBusInterface $messageBus
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
        $this->messageBus = $messageBus;
    }

    public function __invoke(UpdateCategoryNameOnly $message): Category
    {
        $oldCategory = $message->getCategory();

        $isHistoricalName = false;
        foreach ($message->getCategory()->getHistoricalVersions()->getValues() as $historicalVersion) {
            if ($historicalVersion->getName() === $message->name) {
                $isHistoricalName = true;
            }
        }

        if (($message->name !== $message->getCategory()->getName() && !$isHistoricalName)
            && $this->categoryRepository->existsByName($message->name)
        ) {
            throw new RuntimeException('A category with that name already exists', 500);
        }

        $oldHistoricalVersions = $oldCategory->getHistoricalVersions();
        // adding old version of itself to new 'copy'
        $oldHistoricalVersions->add($oldCategory);

        $newCategory = new Category(
            $message->name,
            $oldCategory->getIcon(),
            $oldCategory->getImage()
        );
        foreach ($oldHistoricalVersions->getValues() as $olderCategory) {
            // note that the inverse side is handled in the entity itself
            $newCategory->addToHistoricalVersion($olderCategory);
        }
        $this->categoryRepository->create($newCategory);

        foreach ($oldCategory->getProducts() as $oldProduct) {
            // part 1. save flag as updating product will always return not historical
            $isHistorical = $oldProduct->getIsHistorical();

            // chosen to dispatch instead of doing the work here. This way, you also get notified of updated products
            $updateProduct = new UpdateProduct($oldProduct);
            $updateProduct->category = $newCategory;
            $envelope = $this->messageBus->dispatch($updateProduct);

            $newProduct = $envelope->last(HandledStamp::class)->getResult();

            // part 2. use flag to flag newly created product as historical
            if ($newProduct instanceof Product && $isHistorical) {
                $newProduct->archive();
            }
        }

        $oldCategory->archive();
        $this->categoryRepository->update($oldCategory);

        $this->eventBus->dispatch(new CategoryUpdatedEvent());

        return $newCategory;
    }
}
