<?php

namespace App\Controller;
use App\Repository\PUBLICATIONRepository;
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
    public function testt(PUBLICATIONRepository $pUBLICATIONRepository): Response
    {
        return $this->render('publication/index2.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_ns' => $pUBLICATIONRepository->findAll(),

        ]);
    }
   

}
