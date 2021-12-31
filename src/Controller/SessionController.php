<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'session')]
    public function index(HttpFoundationRequest $request): Response
    {
        $session=$request->getSession();
        if($session->has('nbVisite')){
            $nbVisite=$session->get('nbVisite')+1;
        
        }else{
            $nbVisite=1;
        }
            $session->set('nbVisite',$nbVisite);
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController'
        ]);
    }
}
