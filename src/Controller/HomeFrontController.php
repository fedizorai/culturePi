<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PdfGeneratorService;
use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;

class HomeFrontController extends AbstractController
{
    #[Route('/', name: 'app_home_front')]
    public function index(): Response
    {
        return $this->render('base1.html.twig', [
            'controller_name' => 'HomeFrontController',
        ]);
    }

    #[Route('/pdf', name: 'generator_service')]
    public function pdfService(EntityManagerInterface $entityManager): Response
    { 
        $evenements = $entityManager
        ->getRepository(Evenement::class)
        ->findAll();

        $html = $this->renderView('evenement/PdfEvenement.html.twig', ['evenements' => $evenements]);
        $pdfGeneratorService = new PdfGeneratorService();
        $pdf = $pdfGeneratorService->generatePdf($html);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }

}
