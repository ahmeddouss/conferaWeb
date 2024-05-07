<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfGeneratorServiceController extends AbstractController
{
    #[Route('/pdf/generator/service', name: 'app_pdf_generator_service')]
    public function index(): Response
    {
        return $this->render('pdf_generator_service/index.html.twig', [
            'controller_name' => 'PdfGeneratorServiceController',
        ]);
    }
}
