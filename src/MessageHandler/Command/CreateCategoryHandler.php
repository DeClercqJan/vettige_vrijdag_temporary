<?php

namespace App\MessageHandler\Command;

use App\Entity\Category;
use App\Message\Command\CreateCategory;
use App\Message\Event\CategoryCreatedEvent;
use App\Repository\CategoryRepository;
use App\Service\FileUploadsHelper;
use RuntimeException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateCategoryHandler implements MessageHandlerInterface
{
    private CategoryRepository $categoryRepository;
    private string $iconDirectory;
    private string $imageDirectory;
    private FileUploadsHelper $fileUploadsHelper;
    private MessageBusInterface $eventBus;

    public function __construct(
        CategoryRepository $categoryRepository,
        string $iconDirectory,
        string $imageDirectory,
        FileUploadsHelper $fileUploadsHelper,
        MessageBusInterface $eventBus
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->iconDirectory = $iconDirectory;
        $this->imageDirectory = $imageDirectory;
        $this->fileUploadsHelper = $fileUploadsHelper;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateCategory $message): Category
    {
        if ($this->categoryRepository->existsByName($message->name)) {
            throw new RuntimeException('A category with that name already exists', 500);
        }

        $iconFile = $message->icon;
        $imageFile = $message->image;

        if ($iconFile->guessExtension() !== 'svg') {
            throw new RuntimeException('You must provide a .svg file as icon', 500);
        }
        if ($imageFile->guessExtension() !== 'svg') {
            throw new RuntimeException('You must provide a .svg file as image', 500);
        }

        $imageFileName = $this->fileUploadsHelper->saveFileToDirectoryAndReturnNewFileName($imageFile, $this->imageDirectory);
        $iconFileName = $this->fileUploadsHelper->saveFileToDirectoryAndReturnNewFileName($iconFile, $this->iconDirectory);

        $category = new Category(
            $message->name,
            $iconFileName,
            $imageFileName,
        );
        $this->categoryRepository->create($category);

        $this->eventBus->dispatch(new CategoryCreatedEvent());

        return $category;
    }
}
