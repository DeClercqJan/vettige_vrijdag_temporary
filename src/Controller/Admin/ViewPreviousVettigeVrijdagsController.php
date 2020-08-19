<?php

namespace App\Controller\Admin;

use App\Repository\VettigeVrijdagRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class ViewPreviousVettigeVrijdagsController
{
    /**
     * @Route("/admin/vettige-vrijdag/previous", name="vettige_vrijdag_previous")
     */
    public function __invoke(
        VettigeVrijdagRepository $vettigeVrijdagRepository,
        Environment $twig
    ): Response {
        $previousVettigeVrijdags = $vettigeVrijdagRepository->getPreviousVettigeVrijdags();

        return new Response(
            $twig->render(
                '2_columns/previous.html.twig',
                [
                    'previousVettigeVrijdags' => $previousVettigeVrijdags,
                ],
            ),
        );
    }
}
