<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {
        $session=$request->getSession();
        if (!$session->has('todos'))
        {
            $todo=[
                'achats'=>'acheter une clef usb',
                'correction'=>'corriger mes examens',
                'cours'=>'finir mes cours php'
            ];
             $session->set('todos',$todo);
             $this->addFlash('info',"une todo list vient d'être initialisé...");
        }
        return $this->render('todo/index.html.twig');
    }


    #[Route('/add/{name?test}/{content?test}', name: 'add_todo')]
    public function addTodo(Request $request,$name,$content):RedirectResponse{
        $session=$request->getSession();
        if ($session->has('todos'))
        {
            $todos=$session->get('todos');
            if (key_exists($name,$todos))
            {
                $this->addFlash('error',"ce todo existe déjà!");
            }else
            {
                $todos[$name]=$content;
                $session->set('todos',$todos);
                $this->addFlash('success',"Enregistrement du todo '$name' réussi!");
            }
        }else
        {
            $this->addFlash('error',"Il n'existe pas de todo list");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/update/{name}/{content}', name: 'update_todo')]
    public function updateTodo(Request $request,$name,$content):RedirectResponse{
        $session=$request->getSession();
        if ($session->has('todos'))
        {
            $todos=$session->get('todos');
            if (!key_exists($name,$todos))
            {
                $this->addFlash('error',"le todo '$name' n'existe pas!");
            }else
            {
                $todos[$name]=$content;
                $session->set('todos',$todos);
                $this->addFlash('success',"Modification du todo '$name' réussi!");
            }
        }else
        {
            $this->addFlash('error',"Il n'existe pas de todo list");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/delete/{name}', name: 'delete_todo')]
    public function deleteTodo(Request $request,$name):RedirectResponse{
        $session=$request->getSession();
        if ($session->has('todos'))
        {
            $todos=$session->get('todos');
            if (!key_exists($name,$todos))
            {
                $this->addFlash('error',"le todo '$name' n'existe pas!");
            }else
            {
                //$todos[$name]=$content;
                unset($todos[$name]);
                $session->set('todos',$todos);
                $this->addFlash('success',"Suppression du todo '$name' réussi!");
            }
        }else
        {
            $this->addFlash('error',"Il n'existe pas de todo list");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/reset', name: 'reset_todo')]
    public function resetTodo(Request $request):RedirectResponse{
        $session=$request->getSession();
        $session->remove('todos');
        $this->addFlash('success',"Suppression totale du todo  réussi!");
        return $this->redirectToRoute('todo');
    }

}
