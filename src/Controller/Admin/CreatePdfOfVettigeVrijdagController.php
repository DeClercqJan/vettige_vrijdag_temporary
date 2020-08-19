<?php

namespace App\Controller\Admin;

use App\Entity\VettigeVrijdag;
use App\Repository\CategoryRepository;
use App\Repository\VettigeVrijdagRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CreatePdfOfVettigeVrijdagController
{
    /**
     * @Route("admin/vettige-vrijdag/{id}/pdf", name="vettige_vrijdag_create_pdf")
     */
    public function __invoke(
        VettigeVrijdag $vettigeVrijdag,
        CategoryRepository $categoryRepository,
        VettigeVrijdagRepository $vettigeVrijdagRepository,
        Environment $twig,
        ContainerInterface $container
    ): PdfResponse {
        $categories = $categoryRepository->findAll();

        $html = $twig->render(
            '/pdf/vettige_vrijdag_pdf.html.twig',
            [
                'vettige_vrijdag' => $vettigeVrijdag,
                'categories' => $categories,
            ],
        );

        return new PdfResponse(
            $container->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf',
        );
    }
}
