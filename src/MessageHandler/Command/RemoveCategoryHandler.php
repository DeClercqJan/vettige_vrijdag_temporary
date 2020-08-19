<?php

namespace App\MessageHandler\Command;

use App\Message\Command\RemoveCategory;
use App\Message\Command\RemoveProduct;
use App\Message\Event\CategoryRemovedEvent;
use App\Repository\CategoryRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class RemoveCategoryHandler implements MessageHandlerInterface
{
    private CategoryRepository $categoryRepository;
    private MessageBusInterface $eventBus;
    private MessageBusInterface $messageBus;

    public function __construct(
        CategoryRepository $categoryRepository,
        MessageBusInterface $eventBus,
        MessageBusInterface $messageBus
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->eventBus = $eventBus;
        $this->messageBus = $messageBus;
    }

    public function __invoke(RemoveCategory $message): void
    {
        $category = $message->getCategory();

        foreach ($category->getProducts()->getValues() as $product) {
            // or should I do this here directly?
            $removeProduct = new RemoveProduct($product);
            $envelope = $this->messageBus->dispatch($removeProduct);
        }

        $category->archive();
        $this->categoryRepository->update($category);

        $this->eventBus->dispatch(new CategoryRemovedEvent());
    }
}
