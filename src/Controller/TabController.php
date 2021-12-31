<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb</d+>?5}', name: 'tab')]
    public function index($nb): Response
    {
        $tab=[];
        
        for ($i=0; $i <$nb ; $i++) { 
            $tab[$i]=rand(0,20);
        }

        return $this->render('tab/index.html.twig', [
            'tab'=>$tab
        ]);
    }
}
