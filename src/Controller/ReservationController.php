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
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Voyage;
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

    #[Route('/import', name: 'app_reservation_import_excel', methods: ['GET','POST'])]
    public function importExcel(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Check if a file is uploaded
        $file = $request->files->get('file');
    
        if ($file) {
            // Create a new ReaderXlsx object
            $reader = new ReaderXlsx();
            $spreadsheet = new Spreadsheet();
            $spreadsheet = $reader->load($file->getPathname());
           /* try {
                // Load the Excel file
                
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                // Handle exception (e.g., log, show an error message)
                return new Response('Error loading the Excel file: ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
            }*/
    
            // Get the active sheet
            $sheet = $spreadsheet->getActiveSheet();
    
            // Get the entity manager (Note: This line is not needed as you already injected $entityManager)
    
            foreach ($sheet->getRowIterator(2) as $row) {
                $rowData = $row->getWorksheet()->rangeToArray('A' . $row->getRowIndex() . ':' . 'E' . $row->getRowIndex(), null, true, false);
    
                // Assuming the columns in the Excel file are in the same order as in the export function
                list($id, $nbrTickets, $userId, $payment, $voyageId) = $rowData[0];
    
                // Create a new Reservation entity
                $reservation = new Reservation();
                $reservation->setId($id);

                $reservation->setNbrtickets($nbrTickets);
                $reservation->setIduser($userId);
                $reservation->setPaiement($payment);
    
                // Retrieve the associated Voyage from the database based on the Voyage ID
                $voyage = $entityManager->getRepository(Voyage::class)->find($voyageId);
    
                if ($voyage) {
                    $reservation->setVoyage($voyage);
    
                    // Persist the Reservation entity
                    $entityManager->persist($reservation);
                }
            }
    
            // Flush changes to the database
            $entityManager->flush();
    
            // Redirect or do anything else you need after a successful import
            return $this->redirectToRoute('app_reservation_showres');
        }
    
        // Render an error response or do anything else when no file is uploaded
        return new Response('No file uploaded', Response::HTTP_BAD_REQUEST);
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
    #[Route('/{id}', name: 'app_reservation_deleteFe', methods: ['POST'])]
    public function deleteFe(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
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

    

}
