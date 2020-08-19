<?php

namespace App\Controller\Everyone;

use App\Repository\VettigeVrijdagRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CustomErrorController
{
    public function __invoke(
        VettigeVrijdagRepository $vettigeVrijdagRepository,
        Environment $twig
    ): Response {
        $vettige_vrijdag = $vettigeVrijdagRepository->getCurrentVettigeVrijdag();

        return new Response($twig->render('404.html.twig', ['vettige_vrijdag' => $vettige_vrijdag]));
    }
}
