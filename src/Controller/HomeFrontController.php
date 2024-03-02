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

    
    #[Route('/export/excel', name: 'app_event_export_excel', methods: ['GET'])]
    public function exportExcel(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données des pays depuis la base de données
        $evenements = $entityManager
        ->getRepository(Evenement::class)
        ->findAll();
    
         // Créer un nouveau fichier Excel
         $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
         $sheet = $spreadsheet->getActiveSheet();
         
        // Ajouter les en-têtes
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nom Événement');
        $sheet->setCellValue('C1', 'Date Événement');
        $sheet->setCellValue('D1', 'Max Places');
        $sheet->setCellValue('E1', 'Nom Catégorie');
    
        // Remplir les données
        $row = 2;
        foreach ($evenements as $evenementsItem) {
            $sheet->setCellValue('A' . $row, $evenementsItem->getId());
            $sheet->setCellValue('B' . $row, $evenementsItem->getnomEvent());
            // Ajouter le lien vers l'image
            $sheet->setCellValue('D' . $row, $evenementsItem->getmaxPlacesEvent());
            $sheet->setCellValue('E' . $row, $evenementsItem->getdateEvent());
            $sheet->setCellValue('F' . $row, $evenementsItem->getlieuEvent());
            $sheet->setCellValue('G' . $row, $evenementsItem->getcategorie());

            $row++;
        }
        // Créer le writer pour Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        // Enregistrer le fichier Excel
        $writer->save('event_export.xlsx');
        // Retourner une réponse avec le fichier Excel
        return $this->file('event_export.xlsx');
    }


    

}
