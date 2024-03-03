<?php

namespace App\Controller;
use App\Entity\COMMENTAIRE;
use App\Entity\PUBLICATION;

use App\Repository\PUBLICATIONRepository;
use App\Repository\COMMENTAIRERepository;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Font\NotoSans;




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
    #[Route('/BACKK', name: 'app_dashboardd',methods: ['GET', 'POST'])]
   
    public function testt(Request $request, PUBLICATIONRepository $pUBLICATIONRepository, COMMENTAIRERepository $COMMENTAIRERepository): Response
{
    $writer = new PngWriter();
    $publications = $pUBLICATIONRepository->findAll();
    $qrCodeData = [];

    // Générer un QR code par publication
    foreach ($publications as $publication) {
        // Récupérer les commentaires associés à cette publication
        $comments = $COMMENTAIRERepository->findBy(['PUBID' => $publication->getId()]);

        // Construire le contenu du QR code avec les commentaires
        $qrCodeContent = 'Publication ID: ' . $publication->getId() . "\n";
        $qrCodeContent .= 'Contenu: ' . $publication->getCONTENUPUB() . "\n";
        $qrCodeContent .= "Commentaires:\n";
        foreach ($comments as $comment) {
            $qrCodeContent .= "- " . $comment->getCONTENUCOM() . "\n";
        }

        // Générer le QR code simple
        $qrCode = QrCode::create($qrCodeContent)
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(120)
            ->setMargin(0)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $label = Label::create('')->setFont(new NotoSans(8));

        // Associer le QR code à l'ID de la publication
        $qrCodeData[$publication->getId()] = $writer->write(
            $qrCode,
            null,
            $label->setText('Publication ' . $publication->getId())
        )->getDataUri();
        
    }

    return $this->render('publication/index2.html.twig', [
        'p_u_b_l_i_c_a_t_i_o_ns' => $publications,
        'qrCodeData' => $qrCodeData,
    ]);
}

    

    

    
    

}
