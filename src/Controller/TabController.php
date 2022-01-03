<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'tab')]
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

    #[Route('/tab/users/', name: 'tab_users')]
    public function users(): Response
    {
        $users=[
            ['firstname'=>'chafek','lastname'=>'idoubrahim','age'=>43],
            ['firstname'=>'jean','lastname'=>'dupont','age'=>35],
            ['firstname'=>'celine','lastname'=>'martin','age'=>35],
            ['firstname'=>'sephora','lastname'=>'idoubrahim','age'=>10]
        ];
        
        

        return $this->render('tab/users.html.twig', [
            'users'=>$users
    ]);
    }
}
