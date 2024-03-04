<?php

namespace App\Controller;

use App\Entity\COMMENTAIRE;
use App\Entity\PUBLICATION;

use App\Form\COMMENTAIREType;
use App\Repository\COMMENTAIRERepository;
use App\Repository\PUBLICATIONRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentaire')]
class COMMENTAIREController extends AbstractController
{
    #[Route('/', name: 'app_c_o_m_m_e_n_t_a_i_r_e_index', methods: ['GET'])]
    public function index(COMMENTAIRERepository $cOMMENTAIRERepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'c_o_m_m_e_n_t_a_i_r_es' => $cOMMENTAIRERepository->findAll(),
            
        ]);
    }

    #[Route('/new', name: 'app_c_o_m_m_e_n_t_a_i_r_e_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cOMMENTAIRE = new COMMENTAIRE();
        $form = $this->createForm(COMMENTAIREType::class, $cOMMENTAIRE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cOMMENTAIRE);
            $entityManager->flush();

            return $this->redirectToRoute('app_testt', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire/new.html.twig', [
            'c_o_m_m_e_n_t_a_i_r_e' => $cOMMENTAIRE,
            'form' => $form,

        ]);
    } 

    #[Route('/{id}', name: 'app_c_o_m_m_e_n_t_a_i_r_e_show', methods: ['GET'])]
    public function show(COMMENTAIRE $cOMMENTAIRE): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'c_o_m_m_e_n_t_a_i_r_e' => $cOMMENTAIRE,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_c_o_m_m_e_n_t_a_i_r_e_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, COMMENTAIRE $cOMMENTAIRE, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(COMMENTAIREType::class, $cOMMENTAIRE);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        // Récupérer l'ID de la publication associée au commentaire
        $publicationId = $cOMMENTAIRE->getPUBID();

        // Rediriger vers la route app_p_u_b_l_i_c_a_t_i_o_n_showw avec l'identifiant de la publication
        return $this->redirectToRoute('app_p_u_b_l_i_c_a_t_i_o_n_showw', ['id' => $publicationId], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('commentaire/edit.html.twig', [
        'c_o_m_m_e_n_t_a_i_r_e' => $cOMMENTAIRE,
        'form' => $form,
    ]);
}


#[Route('/{id}', name: 'app_c_o_m_m_e_n_t_a_i_r_e_delete', methods: ['POST'])]
public function delete(Request $request, COMMENTAIRE $cOMMENTAIRE, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$cOMMENTAIRE->getId(), $request->request->get('_token'))) {
        $entityManager->remove($cOMMENTAIRE);
        $entityManager->flush();
    }

    // Récupérer l'ID de la publication associée au commentaire
    $publicationId = $cOMMENTAIRE->getPUBID();

    return $this->redirectToRoute('app_p_u_b_l_i_c_a_t_i_o_n_showw', ['id' => $publicationId], Response::HTTP_SEE_OTHER);
}


    

    
}
