<?php

namespace App\Controller\Admin;

use App\Form\CategoryType;
use App\Message\Command\CreateCategory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class CreateCategoryComplexController
{
    /**
     * @Route("admin/category/new-complex", name="category_new_complex")
     */
    public function __invoke(
        Request $request,
        FormFactoryInterface $formFactory,
        MessageBusInterface $commandbus,
        RouterInterface $router,
        Environment $twig,
        ValidatorInterface $validator,
        HttpKernelInterface $httpKernel
    ): Response {
        $createCategory = new CreateCategory();

        $form = $formFactory->create(
            CategoryType::class,
            $createCategory,
            [
                'action' => $router->generate('category_new_complex')
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted()
            && $form->isValid()
        ) {
            $commandbus->dispatch($createCategory);
            return new RedirectResponse($router->generate('change_menu_complex'));
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
                'fragments/_create_category_complex.html.twig',
                [
                    'form' => $form->createView(),
                ],
            )
        );
    }
}
