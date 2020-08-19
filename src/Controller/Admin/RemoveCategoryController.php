<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\RemoveCategoryType;
use App\Message\Command\RemoveCategory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class RemoveCategoryController
{
    /**
     * @Route("admin/category/{id}/remove", name="category_remove")
     */
    public function __invoke(
        Category $category,
        MessageBusInterface $messageBus,
        FormFactoryInterface $formFactory,
        Environment $twig,
        Request $request,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $removeCategory = new RemoveCategory($category);

        $form = $formFactory->create(RemoveCategoryType::class, $removeCategory);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $messageBus->dispatch($removeCategory);

             return new RedirectResponse($urlGenerator->generate('change_menu_complex'));
        }

        return new Response(
            $twig->render(
                '/fragments/_remove_form.html.twig',
                ['form' => $form->createView(),
                    'path' => 'category_remove',
                ]
            )
        );
    }
}
