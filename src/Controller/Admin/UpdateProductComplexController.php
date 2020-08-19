<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Message\Command\UpdateProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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

class UpdateProductComplexController
{
    /**
     * @Route("admin/product/{id}/update-complex", name="product_update_complex")
     */
    public function __invoke(
        Product $product,
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
        $updateProduct = new UpdateProduct($product);

        $form = $formFactory->create(
            ProductType::class,
            $updateProduct,
            ['action' => $router->generate(
                'product_update_complex',
                ['id' => $product->getId()],
            )]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted()
            && $form->isValid()
        ) {
            try {
                $entityManager->beginTransaction();
                $commandbus->dispatch($updateProduct);
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
                'fragments/_update_product_complex.html.twig',
                [
                    'form' => $form->createView(),
                ],
            )
        );
    }
}
