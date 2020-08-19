<?php

namespace App\Controller\Admin;

use App\Form\ProductType;
use App\Message\Command\CreateProduct;
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

class CreateProductComplexController
{
    /**
     * @Route("admin/product/new-complex", name="product_new_complex")
     */
    public function __invoke(
        Request $request,
        FormFactoryInterface $formFactory,
        MessageBusInterface $commandbus,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        Environment $twig,
        ValidatorInterface $validator,
        HttpKernelInterface $httpKernel,
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->getFilters()->enable('is_historical');

        $createProduct = new CreateProduct();

        $form = $formFactory->create(
            ProductType::class,
            $createProduct,
            [
                'action' => $router->generate('product_new_complex')
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted()
            && $form->isValid()
        ) {
            $commandbus->dispatch($createProduct);

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
                'fragments/_create_product_complex.html.twig',
                [
                    'form' => $form->createView(),
                ],
            )
        );
    }
}
