<?php

namespace App\Controller;

use App\Entity\CategorieEvent;
use App\Form\CategorieEventType;
use App\Repository\CategorieEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;



#[Route('/categorie/event')]
class CategorieEventController extends AbstractController
{
    #[Route('/', name: 'app_categorie_event_index', methods: ['GET'])]
    public function index(CategorieEventRepository $categorieEventRepository, EvenementRepository $evenementRepository): Response
    {
        $categorieEvents = $categorieEventRepository->findAll();
        $events = $evenementRepository->findAll(); // Fetch events here

        return $this->render('categorie_event/index.html.twig', [
            'categorie_events' => $categorieEvents,
            'events' => $events, // Pass events to the template
        ]);
    }

    #[Route('/new', name: 'app_categorie_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieEvent = new CategorieEvent();
        $form = $this->createForm(CategorieEventType::class, $categorieEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieEvent);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_event/new.html.twig', [
            'categorie_event' => $categorieEvent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_event_show', methods: ['GET'])]
    public function show(CategorieEvent $categorieEvent): Response
    {
        return $this->render('categorie_event/show.html.twig', [
            'categorie_event' => $categorieEvent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieEvent $categorieEvent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieEventType::class, $categorieEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_event/edit.html.twig', [
            'categorie_event' => $categorieEvent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_event_delete', methods: ['POST'])]
    
    public function delete(Request $request, CategorieEvent $categorieEvent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieEvent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_event_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
    


}
