<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstController extends AbstractController
{

    #[Route('/template', name: 'template')]
    public function template(): Response
    {
            return $this->render('template.html.twig');
        
       
    }

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
            return $this->render('first/index.html.twig', [
                'controller_name' => 'FirstController',
                'name'=>'idoubrahim',
                'firstname'=>'chafek'
            ]);
        
       
    }

    // #[Route('/sayHello/{name}/{firstname}', name: 'hello')]
    public function say_hello(Request $request,$name,$firstname): Response
    {

        return $this->render('first/index.html.twig',[
            'name'=>$name,
            'firstname'=>$firstname]);
    }
    #[Route('/multiplication/{n1<\d+>}/{n2<\d+>}',name:'multiplication')]
        public function multiplication($n1,$n2){
        $total=$n1*$n2;
        return new Response("
        <!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>my first controller</title>
</head>
<body>
    <h1 class='text-danger'>$total</h1>
</body>
</html
        ");
    }
}
