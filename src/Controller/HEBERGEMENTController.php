<?php

namespace App\Controller;

use App\Entity\HEBERGEMENT;
use App\Form\HEBERGEMENTType;
use App\Repository\HEBERGEMENTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class HEBERGEMENTController extends AbstractController
{
    #[Route('/afficher', name: 'app_hebergement_index', methods: ['GET'])]
    public function index(HEBERGEMENTRepository $hEBERGEMENTRepository): Response
    {
        return $this->render('hebergement/index.html.twig', [
            'hebergements' => $hEBERGEMENTRepository->findAll(),
        ]);
    }
    
   #[Route('/afficher2', name: 'app_hebergement_index2', methods: ['GET'])]
        public function index2(HEBERGEMENTRepository $hEBERGEMENTRepository): Response
        {
            return $this->render('hebergement/index2.html.twig', [
                'hebergements' => $hEBERGEMENTRepository->findAll(),
            ]);
        }


    #[Route('/test1', name: 'app_test1')]
    public function test(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    
    #[Route('/new', name: 'app_hebergement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hEBERGEMENT = new HEBERGEMENT();
        $form = $this->createForm(HEBERGEMENTType::class, $hEBERGEMENT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hEBERGEMENT);
            $entityManager->flush();

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hebergement/new.html.twig', [
            'hebergement' => $hEBERGEMENT,
            'form' => $form,
        ]);
    }

    #[Route('/{id_hebergement}', name: 'app_hebergement_show', methods: ['GET'])]
    public function show(HEBERGEMENT $hEBERGEMENT): Response
    {
        return $this->render('hebergement/show.html.twig', [
            'hebergement' => $hEBERGEMENT,
        ]);
    }

    #[Route('/{id_hebergement}/edit', name: 'app_hebergement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HEBERGEMENT $hEBERGEMENT, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HEBERGEMENTType::class, $hEBERGEMENT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hebergement/edit.html.twig', [
            'hebergement' => $hEBERGEMENT,
            'form' => $form,
        ]);
    }

    #[Route('/{id_hebergement}', name: 'app_hebergement_delete', methods: ['POST'])]
    public function delete(Request $request, HEBERGEMENT $hEBERGEMENT, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hEBERGEMENT->getId_hebergement(), $request->request->get('_token'))) {
            $entityManager->remove($hEBERGEMENT);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
}
