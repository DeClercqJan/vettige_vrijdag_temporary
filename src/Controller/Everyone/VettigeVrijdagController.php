<?php

namespace App\Controller\Everyone;

use App\Repository\VettigeVrijdagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class VettigeVrijdagController
{
    /**
     * @Route("/", name="vettige_vrijdag")
     */
    public function __invoke(
        VettigeVrijdagRepository $vettigeVrijdagRepository,
        Environment $twig
    ): Response {
        return new Response(
            $twig->render(
                'index.html.twig',
                [
                    'vettige_vrijdag' => $vettigeVrijdagRepository->getCurrentVettigeVrijdag(),
                ]
            )
        );
    }
}
