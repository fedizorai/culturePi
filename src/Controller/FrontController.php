<?php

namespace App\Controller;
use App\Entity\PUBLICATION;
use App\Form\PUBLICATIONType;
use App\Repository\PUBLICATIONRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/FRONT', name: 'app_test')]
    public function test(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    #[Route('/FRONTT', name: 'app_testt')]
    public function testt(PUBLICATIONRepository $pUBLICATIONRepository): Response
    {
        return $this->render('publication/basee.html.twig', [
            'p_u_b_l_i_c_a_t_i_o_ns' => $pUBLICATIONRepository->findAll(),
        ]);
    }
    
    #[Route('/test2')]
    public function test2(): Response
    {
        return new Response('Test Route');
    }
    
}
