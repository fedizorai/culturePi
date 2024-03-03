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
use App\Entity\Voyage;
use Dompdf\Dompdf;
//QR CODE
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
//



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


    #[Route('/{id}/pdf', name: 'reservation_pdf')]
    public function generatePdf(Reservation $reservation): Response
    {
        // Get reservation data
        $reservationData = [
            'id' => $reservation->getId(),
            'nbrtickets' => $reservation->getNbrtickets(),
            'iduser' => $reservation->getIduser(),
            'paiement' => $reservation->getPaiement(),
            'voyage' => [
                'id' => $reservation->getVoyage()->getId(),
                'title' => $reservation->getVoyage()->getTitle(),
                'location' => $reservation->getVoyage()->getLocation(),
                'duration' => $reservation->getVoyage()->getDuration(),
                'voyageimage' => $reservation->getVoyage()->getVoyageimage(),
                // Add more reservation details if needed
            ],
        ];

        // Render PDF content
        $pdfContent = $this->renderView('reservation/pdf.html.twig', [
            'reservation' => $reservationData,
        ]);

        // Create PDF
        $pdf = new Dompdf();
        $pdf->loadHtml($pdfContent);
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Return PDF response
        return new Response(
            $pdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="reservation_' . $reservation->getId() . '.pdf"',
            ]
        );
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
                ->setCellValue('E' . $row, $reservation->getVoyage()->getId()); // Assuming Voyage has getId method
    
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

    #[Route('/qrcode/{id}', name: 'qrcodegenerate', methods: ['GET','POST'])]
    public function generateQRCode(Reservation $reservation)
    {
        // 1. Get reservation data
        //$reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);

        if (!$reservation) {
            throw $this->createNotFoundException('Reservation not found');
        }

        // 2. Generate data to encode
        $qrCodeData = "Reservation ID: {$reservation->getId()}\n" .
                      "Number of Tickets: {$reservation->getNbrtickets()}\n" .
                      "Payment Method: {$reservation->getPaiement()}\n" .
                      "Voyage Details:\n" .
                      "  - Title: {$reservation->getVoyage()->getTitle()}\n" .  // Assuming Voyage has a `getTitle` method
                      "  - Location: {$reservation->getVoyage()->getLocation()}\n" . // Assuming Voyage has a `getLocation` method
                      "  - Date: {$reservation->getVoyage()->getDuration()}\n";  // Assuming Voyage has a `getDate` method (format as needed)
                      // ...Add more reservation details as needed

        // 3. Create the QR Code object
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $writer->writeFile($qrCodeData, 'qrcode.png');

        // 5. Return the image as a response
        

        return $writer;
    }

}