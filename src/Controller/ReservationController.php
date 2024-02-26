<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/showBE.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/show', name: 'app_reservation_showres', methods: ['GET'])]
    public function showres(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }
    #[Route('/export-to-excel', name: 'app_reservation_export_excel', methods: ['GET'])]
    public function exportToExcel(ReservationRepository $reservationRepository): Response
    {
        // Get reservations from the database
        $reservations = $reservationRepository->findAll();
    
        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
    
        // Set the column headers
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Number of Tickets')
            ->setCellValue('C1', 'User ID')
            ->setCellValue('D1', 'Payment')
            ->setCellValue('E1', 'Voyage ID');
    
        // Populate data from reservations
        $row = 2;
        foreach ($reservations as $reservation) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $row, $reservation->getId())
                ->setCellValue('B' . $row, $reservation->getNbrtickets())
                ->setCellValue('C' . $row, $reservation->getIduser())
                ->setCellValue('D' . $row, $reservation->getPaiement())
                ->setCellValue('E' . $row, $reservation->getVoyage()->getTitle()); // Assuming Voyage has getId method
    
            $row++;
        }
    
        // Create a response with a callback to generate the Excel file
        $response = new StreamedResponse(function () use ($spreadsheet) {
            // Set headers for streaming
            $writer = new WriterXlsx($spreadsheet);
            $writer->save('php://output');
        });
    
        // Set headers for the response
        $fileName = 'reservations_export_' . date('YmdHis') . '.xlsx';
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
    
        return $response;
    }
    
    

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $reservation = new Reservation();
    $form = $this->createForm(ReservationType::class, $reservation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Get the associated Voyage
        $voyage = $reservation->getVoyage();

        // Get the number of tickets reserved in the current reservation
        $nbrTicketsReserved = $reservation->getNbrtickets();

        // Update the number of places available in the Voyage
        $voyage->setNbrplaces($voyage->getNbrplaces() - $nbrTicketsReserved);

        // Persist changes to the database
        $entityManager->persist($reservation);
        $entityManager->persist($voyage);
        $entityManager->flush();

        return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('reservation/new.html.twig', [
        'reservation' => $reservation,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_reservation_deleteFe', methods: ['POST'])]
    public function deleteFe(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_reservation_showres', [], Response::HTTP_SEE_OTHER);
    }

}
