<?php

namespace App\MessageHandler\Command;

use App\Entity\Category;
use App\Entity\Product;
use App\Message\Command\UpdateCategory;
use App\Message\Command\UpdateProduct;
use App\Message\Event\CategoryUpdatedEvent;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\FileUploadsHelper;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use RuntimeException;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class UpdateCategoryHandler implements MessageHandlerInterface
{
    private CategoryRepository $categoryRepository;
    private string $iconDirectory;
    private string $imageDirectory;
    private FileUploadsHelper $fileUploadsHelper;
    private MessageBusInterface $eventBus;
    private MessageBusInterface $messageBus;
    private ProductRepository $productRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        string $iconDirectory,
        string $imageDirectory,
        FileUploadsHelper $fileUploadsHelper,
        MessageBusInterface $eventBus,
        MessageBusInterface $messageBus,
        ProductRepository $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->iconDirectory = $iconDirectory;
        $this->imageDirectory = $imageDirectory;
        $this->fileUploadsHelper = $fileUploadsHelper;
        $this->eventBus = $eventBus;
        $this->messageBus = $messageBus;
        $this->productRepository = $productRepository;
    }

    public function __invoke(UpdateCategory $message): Category
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

        $newIconFile = $message->icon;
        $newImageFile = $message->image;
        $oldIconFileName = $oldCategory->getIcon();
        $oldImageFileName = $oldCategory->getImage();

        $newIconFileName = $this->fileUploadsHelper->saveFileToDirectoryAndReturnNewFileName($newIconFile, $this->iconDirectory);
        $newImageFileName = $this->fileUploadsHelper->saveFileToDirectoryAndReturnNewFileName($newImageFile, $this->imageDirectory);

        $newCategory = new Category(
            $message->name,
            $newIconFileName,
            $newImageFileName,
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

        $this->fileUploadsHelper->removeFileFromDirectory($oldIconFileName, $this->iconDirectory);
        $this->fileUploadsHelper->removeFileFromDirectory($oldImageFileName, $this->imageDirectory);

        $this->eventBus->dispatch(new CategoryUpdatedEvent());

        return $newCategory;
    }
}
