<?php

namespace App\Controller;
use App\Repository\PUBLICATIONRepository;
use App\Repository\COMMENTAIRERepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    #[Route('/back', name: 'app_back')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/BACK', name: 'app_dashboard')]
    public function test(): Response
    {
        return $this->render('back/base.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    #[Route('/BACKK', name: 'app_dashboardd')]
    public function testt(PUBLICATIONRepository $pUBLICATIONRepository,COMMENTAIRERepository $cOMMENTAIRERepository): Response
    {    $commentaires = $cOMMENTAIRERepository->findAll();

        return $this->render('publication/index2.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_ns' => $pUBLICATIONRepository->findAll(),
            'c_o_m_m_e_n_t_a_i_r_es' => $commentaires,


        ]);
    }
   

}
