<?php

namespace App\Controller;

use App\Entity\Reservhebergement;
use App\Form\ReservhebergementType;
use App\Repository\ReservhebergementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;




#[Route('/reservhebergement')]
class ReservhebergementController extends AbstractController
{
    #[Route('/testtt', name: 'app_reservhebergement_index', methods: ['GET'])]
    public function index(ReservhebergementRepository $reservhebergementRepository): Response
    {
        return $this->render('reservhebergement/index.html.twig', [
            'reservhebergements' => $reservhebergementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservhebergement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservhebergement = new Reservhebergement();
        $form = $this->createForm(ReservhebergementType::class, $reservhebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservhebergement);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservhebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservhebergement/new.html.twig', [
            'reservhebergement' => $reservhebergement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservhebergement_show', methods: ['GET'])]
    public function show(Reservhebergement $reservhebergement): Response
    {
        return $this->render('reservhebergement/show.html.twig', [
            'reservhebergement' => $reservhebergement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservhebergement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservhebergement $reservhebergement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservhebergementType::class, $reservhebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservhebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservhebergement/edit.html.twig', [
            'reservhebergement' => $reservhebergement,
            'form' => $form,
        ]);
    }
    #[Route('/ExportPdf/{id}', name: 'app_pdf', methods: ['GET', 'POST'])]
    public function ExportPdf(Reservhebergement $reservhebergement) :Response
    {
          
          $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $html = $this->renderView('reservhebergement/pdf.html.twig', [
            // Pass any necessary data to your Twig template
            'reserv' => $reservhebergement,
        ]);

        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to browser (inline view)
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    #[Route('/{id}', name: 'app_reservhebergement_delete', methods: ['POST'])]
    public function delete(Request $request, Reservhebergement $reservhebergement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservhebergement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservhebergement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservhebergement_index', [], Response::HTTP_SEE_OTHER);
    }
}
