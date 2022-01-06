<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/personne')]
class PersonneController extends AbstractController
{

  #[Route('/','list_personne')]
    public function index(ManagerRegistry $doctrine):Response{
     
      $repository=$doctrine->getRepository(Personne::class);
      $listPersonne=$repository->findAll();
      return $this->render('personne/index.html.twig',[
        'personnes'=>$listPersonne
      ]);
    }

  #[Route('/alls/{page?1}/{nbre?12}','list_personne_alls')]
    public function indexAlls(ManagerRegistry $doctrine,$page,$nbre):Response{
     
      $repository=$doctrine->getRepository(Personne::class); 
      
      $nbrePersonnes=$repository->count([]);
      $nbrePages=ceil($nbrePersonnes/$nbre);
      
      $listPersonne=$repository->findby([],[],$nbre,($page-1)*$nbre);
      
      
      return $this->render('personne/index.html.twig',[
        'personnes'=>$listPersonne,
        'isPaginated'=>true,
        'nbrePages'=>$nbrePages,
        'page'=>$page,
        'nbre'=>$nbre
      ]);
    }


  #[Route('/{id<\d+>}','detail_personne')]
    public function detail(ManagerRegistry $doctrine,$id):Response{
     
      $repository=$doctrine->getRepository(Personne::class);
      $personne=$repository->find($id);
      if (!$personne) {
          $this->addFlash('error',"la personne avec l'id $id n'existe pas");
          return $this->redirectToRoute('list_personne');
      }
    
      return $this->render('personne/details.html.twig',[
        'personne'=>$personne
      ]);

    }

    #[Route('//add', name: 'personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
            $entityManager=$doctrine->getManager();
            // $personne=new Personne();
            // $personne->setName('Idoubrahim');
            // $personne->setFirstname('Chafek');
            // $personne->setAge(43);

            // $entityManager->persist($personne);
            // $entityManager->flush();
        return $this->render('personne/details.html.twig', [
          // 'personne'=>$personne
        ]);
    }
}
