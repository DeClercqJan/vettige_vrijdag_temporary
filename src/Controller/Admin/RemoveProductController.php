<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\RemoveProductType;
use App\Message\Command\RemoveProduct;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class RemoveProductController
{
    /**
     * @Route("admin/product/{id}/remove", name="product_remove")
     */
    public function __invoke(
        Product $product,
        MessageBusInterface $messageBus,
        FormFactoryInterface $formFactory,
        Environment $twig,
        Request $request,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $removeProduct = new RemoveProduct($product);

        $form = $formFactory->create(RemoveProductType::class, $removeProduct);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $messageBus->dispatch($removeProduct);

            return new RedirectResponse($urlGenerator->generate('change_menu_complex'));
        }

        return new Response(
            $twig->render(
                '/fragments/_remove_form.html.twig',
                ['form' => $form->createView(),
                    'path' => 'product_remove',
                ]
            )
        );
    }
}
