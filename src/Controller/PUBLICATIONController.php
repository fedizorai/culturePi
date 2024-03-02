<?php

namespace App\Controller;

use App\Entity\PUBLICATION;
use App\Entity\COMMENTAIRE;

use App\Form\PUBLICATIONType;
use App\Form\COMMENTAIREType;
use App\Repository\PUBLICATIONRepository;
use App\Repository\COMMENTAIRERepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/publication')]
class PUBLICATIONController extends AbstractController
{
    #[Route('/', name: 'app_p_u_b_l_i_c_a_t_i_o_n_index', methods: ['GET'])]
    public function index(PUBLICATIONRepository $pUBLICATIONRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_ns' => $pUBLICATIONRepository->findAll(),
        ]);
    }
    #[Route('/1', name: 'app_p_u_b_l_i_c_a_t_i_o_n_index2', methods: ['GET'])]
    public function index2(PUBLICATIONRepository $pUBLICATIONRepository): Response
    {
        return $this->render('publication/index2.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_ns' => $pUBLICATIONRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_p_u_b_l_i_c_a_t_i_o_n_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pUBLICATION = new PUBLICATION();
        $form = $this->createForm(PUBLICATIONType::class, $pUBLICATION);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pUBLICATION);
            $entityManager->flush();

            return $this->redirectToRoute('app_testt', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/new.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_n' => $pUBLICATION,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_p_u_b_l_i_c_a_t_i_o_n_show', methods: ['GET'])]
    public function show(PUBLICATION $pUBLICATION): Response
    {
        return $this->render('publication/show.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_n' => $pUBLICATION,
        ]);
    } 
   
    #[Route('/com/{id}', name: 'app_p_u_b_l_i_c_a_t_i_o_n_showw', methods: ['GET', 'POST'])]
    public function showw(PUBLICATION $pUBLICATION, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new COMMENTAIRE();
        $commentaire->setPUBID($pUBLICATION->getId());

        $commentForm = $this->createForm(COMMENTAIREType::class, $commentaire);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_testt', [], Response::HTTP_SEE_OTHER);
        }

        // Récupérer les commentaires associés à la publication
        $commentaires = $this->getDoctrine()->getRepository(COMMENTAIRE::class)->findBy(['PUBID' => $pUBLICATION->getId()]);

        return $this->render('publication/showcompub.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_n' => $pUBLICATION,
            'c_o_m_m_e_n_t_a_i_r_es' => $commentaires,
            'commentForm' => $commentForm->createView(),
        ]);
    }
   

    #[Route('/{id}/edit', name: 'app_p_u_b_l_i_c_a_t_i_o_n_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PUBLICATION $pUBLICATION, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PUBLICATIONType::class, $pUBLICATION);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_testt', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/edit.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_n' => $pUBLICATION,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_p_u_b_l_i_c_a_t_i_o_n_delete', methods: ['POST'])]
    public function delete(Request $request, PUBLICATION $pUBLICATION, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pUBLICATION->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pUBLICATION);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_testt', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/{id}', name: 'app_p_u_b_l_i_c_a_t_i_o_n_deletee', methods: ['POST'])]
    public function deleteback(Request $request, PUBLICATION $pUBLICATION, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pUBLICATION->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pUBLICATION);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dashboardd', [], Response::HTTP_SEE_OTHER);
    }


    

    #[Route('/like/{id}', name:'like', methods:['POST'])]
   
    public function like(Request $request, Publication $publication): Response
    {
        try {
            $publication->incrementLikes();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();
    
            // Renvoyer une réponse JSON indiquant le succès
            return new JsonResponse(['message' => 'success']);
        } catch (\Exception $e) {
            // Capturer les exceptions et renvoyer une réponse d'erreur
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    #[Route('/dislike/{id}', name:'dislike', methods:['POST'])]
    
    public function dislike(Request $request, Publication $publication): Response
    {
        $publication->decrementLikes();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($publication);
        $entityManager->flush();

        return new Response('success');
    }
    
}
