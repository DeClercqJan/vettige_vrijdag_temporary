<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Message\Command\UpdateCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;
use Exception;

class UpdateCategoryComplexController
{
    /**
     * @Route("admin/category/{id}/update-complex", name="category_update_complex")
     */
    public function __invoke(
        Category $category,
        Request $request,
        FormFactoryInterface $formFactory,
        MessageBusInterface $commandbus,
        FlashBagInterface $flashBag,
        Environment $twig,
        RouterInterface $router,
        ValidatorInterface $validator,
        HttpKernelInterface $httpKernel,
        EntityManagerInterface $entityManager
    ): Response {
        $updateCategory = new UpdateCategory($category);

        $form = $formFactory->create(
            CategoryType::class,
            $updateCategory,
            ['action' => $router->generate(
                'category_update_complex',
                ['id' => $category->getId()]
            )
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted()
            && $form->isValid()
        ) {
            try {
                $entityManager->beginTransaction();
                $commandbus->dispatch($updateCategory);
                $entityManager->commit();
                return new RedirectResponse($router->generate('change_menu_complex'));
            } catch (Exception $exception) {
                $entityManager->rollback();
                // to do: return error
            }
        }

        if ($form->isSubmitted()
            && !$form->isValid()
        ) {
            $errors = $validator->getCollectedData();

            $subRequest = $request->duplicate(
                null,
                null,
                [
                    '_controller' => ChangeMenuComplexController::class,
                    'errors' => $errors,
                ]
            );

            return $httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        }

        return new Response(
            $twig->render(
                'fragments/_update_category_complex.html.twig',
                [
                    'form' => $form->createView(),
                    'category' => $category,
                ],
            )
        );
    }
}
